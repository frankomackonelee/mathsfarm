<?php
	/**
	 * A class to hold the database connection and functions to assist with any error reporting
	 * for queries etc which might be needed
	 */
	class DatabaseUtilities {
		protected $_queryLog = array();
		protected $_errorLog = array();
		protected $_sql;
		protected $_keyList;
		protected $_valueList;
		protected $_conditionList;
		protected static $mysqli;
		private $_success = TRUE;
	
		function __construct() {
			self::$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DB);
			if (self::$mysqli->connect_error) {
			    $this->$_success = FALSE;
				$this->_errorLog[] = "Problem connecting to database";
			}
		}
	
		public function printQueryLog()
		{
			$text = "";
			foreach ($this->_queryLog as $loggedItem) {
				$text .= "sql: ".$loggedItem['sql']."<br> count: ".$loggedItem['count']."<br>";
			}
			return $text;
		}
		
		public function printErrorLog()
		{
			$text = "";
			foreach ($this->_errorLog as $loggedItem) {
				$text .= "<br>error: ".$loggedItem;
			}
			return $text;
		}
	
		public function getSql()
		{
			return $this->_sql;
		}
	
		public function getSuccess()
		{
			return $this->_success;
		}		
		
		protected function makeLists($arr, $valueSpacer)
		{
			$this->_keyList = "";
			$this->_valueList = "";
			$count = 0;
			foreach ($arr as $key => $value) {
				//TODO need to escape column and value carefully
				$spacer = ($count===0 ? "" : $valueSpacer);
				$this->_keyList .= $spacer.$key;
				$this->_valueList .= $spacer.$value;
				$count++;
			}		
		}
	
		protected function makeConditions($arr, $setNotation)
		{
			$count = 0;
			$this->_conditionList = "";
			foreach ($arr as $key => $value) {
				//TODO need to escape column and value carefully
				$spacer = ($count===0 ? "" : $setNotation);
				$this->_conditionList .= $spacer.$key."=" . $value;
				$count++;
			}		
		}	
		
		protected function queryDatabase($sql)
		{
			return self::$mysqli->query($sql);	
		}
	}

?>