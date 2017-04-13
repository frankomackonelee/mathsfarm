<?php
	/**
	 * 
	 */
	class Pos_Validator {
		protected $_inputType;
		protected $_submitted;
		protected $_required;
		protected $_filterArgs;
		protected $_filtered;
		protected $_missing;
		protected $_errors;
		protected $_booleans;
		
		public function __construct($required=array(), $inputType='POST') {
			if (!function_exists('filter_list')) {
				throw new Exception("The Pos_Validator class requires the Filter Functions in >= PHP5.2 or PECL");
			}
			if (!is_null($required) && !is_array($required)) {
				throw new Exception("The names of required fields must be an array even if only one field is required");
			}
			
			$this->_required = $required;
			$this->setInputType($inputType);
			if ($this->_required) {
				$this->checkRequired();
			}
			$this->_filterArgs = array();
			$this->_errors = array();
			$this->_booleans = array();
		}
				
		public function isEmail($fieldName)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_filterArgs[$fieldName] = FILTER_VALIDATE_EMAIL;
		}

		public function isFullURL($fieldName, $queryStringRequired = false)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_filterArgs[$fieldName] = array(
				'filter' => FILTER_VALIDATE_URL,
				'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED | FILTER_FLAG_PATH_REQUIRED
			);
			if ($queryStringRequired) {
				$this->_filterArgs[$fieldName]['flags'] |= FILTER_FLAG_QUERY_REQUIRED;
			}
		}
		
		public function isURL($fieldName, $queryStringRequired = false)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_filterArgs[$fieldName]['filter'] =  FILTER_VALIDATE_URL;
			if ($queryStringRequired) {
				$this->_filterArgs[$fieldName]['flags'] = FILTER_FLAG_QUERY_REQUIRED;
			}
		}
		
		public function isBool($fieldName, $nullOnFailure = false)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_booleans[] = $fieldName;
			$this->_filterArgs[$fieldName]['filter'] = FILTER_VALIDATE_BOOLEAN;
			if($nullOnFailure){
				$this->_filterArgs[$fieldName]['flags'] = FILTER_NULL_ON_FAILURE;
			}
		}
		
		public function matches($fieldName, $pattern)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_filterArgs[$fieldName] = array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => $pattern)
			);
		}
		
		public function checkTextLength($fieldName, $min, $max = null)
		{
			$text = trim($this->_submitted[$fieldName]);
			if (!is_string($text)) {
				throw new Exception("The checkTextLength() function can only be applied to strings; $fieldName is the wrong datatype");
			}
			if (!is_numeric($min)){
				throw new Exception("The checkTextLength() function takes a number as it's second argument (field name: $fieldName)");
			}
			if (strlen($text)<$min) {
				if (is_numeric($max)) {
					$this->_errors[] = ucfirst($fieldName) . " must be between $min and $max characters long";	
				}else{
					$this->_errors[] = ucfirst($fieldName) . " must be longer than $min characters long";	
				}		
			}
			if (is_numeric($max) && strlen($text)>$max){
				if($min == 0){
					$this->_errors[] = ucfirst($fieldName) . " must be no more than $max characters long";					
				}else{
					$this->_errors[] = ucfirst($fieldName) . " must be between $min and $max characters long";	
				}
			}
		}
		
		public function noFilter($fieldName, $isArray = false, $encodeAmp = false)
		{
			$this->checkDuplicateFilter($fieldName);
			$this->_filterArgs[$fieldName]['filter'] = FILTER_UNSAFE_RAW;
			$this->_filterArgs[$fieldName]['flags'] = 0;
			if ($isArray) {
				$this->_filterArgs[$fieldName]['flags'] |= FILTER_REQUIRE_ARRAY;
			}
			if ($encodeAmp){
				$this->_filterArgs[$fieldName]['flags'] |= FILTER_FLAG_ENCODE_AMP;
			}
		}
		
    public function validateInput()
    {
        // Initialize an array for required items that haven't been validated
        $notFiltered = array();
        // Get the names of all fields that have been validated
        $tested = array_keys($this->_filterArgs);
        // Loop through the required fields
        // Add any missing ones to the $notFiltered array
        foreach ($this->_required as $field) {
            if (!in_array($field, $tested)) {
                $notFiltered[] = $field;
            }
        }
        // If any items have been added to the $notFiltered array, it means a
        // required item hasn't been validated, so throw an exception
        if ($notFiltered) {
            throw new Exception('No filter has been set for the following required item(s): ' . implode(',', $notFiltered));
        }
        // Apply the validation tests using filter_input_array()
        $this->_filtered = filter_input_array($this->_inputType, $this->_filterArgs);
        foreach ($this->_filtered as $key => $value) {
            // Skip items that used the isBool() method or that are either missing or not required
            if (in_array($key, $this->_booleans) || in_array($key, $this->_missing) || !in_array($key, $this->_required)) {
                continue;
            } elseif ($value === false) {
                // If the filtered value is a boolean false, it failed validation,
                // so add it to the $errors array
                $this->_errors[$key] = ucfirst($key) . ': invalid data supplied';
            }
        }
        // Return the validated input as an array
        return $this->_filtered;
    }

		public function getMissing()
		{
			return $this->_missing;
		}
		
		public function getFiltered()
		{
			return $this->_filtered;
		}
		
		public function getErrors()
		{
			return $this->_errors;
		}
		
		protected function setInputType($type)
		{
			switch (strtolower($type)) {
				case 'post':
					$this->_inputType = INPUT_POST;
					$this->_submitted = $_POST;
					break;

				case 'get':
					$this->_inputType = INPUT_GET;
					$this->_submitted = $_GET;
					break;
										
				default:
					throw new Exception('Invalid input type. Valid types are  "post" and "get". "' . $type .' was passed');
					break;
			}
		}
		
		protected function checkRequired()
		{
			$OK = array();
			foreach ($this->_submitted as $name => $value) {
				$value = is_array($value) ? $value : trim($value);
				if (!empty($value)) {
					$OK[] = $name;
				}
			}
			$this->_missing = array_diff($this->_required, $OK);
		}
		
		protected function checkDuplicateFilter($fieldName)
		{
			if(isset($this->_filterArgs[$fieldName])){
				throw new Exception('A filter has already been set for the field name "' . $fieldName . '"');
			}
		}
		
	}
	

?>
