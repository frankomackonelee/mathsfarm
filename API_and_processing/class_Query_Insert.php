<?php
 
class Query_Insert extends DatabaseUtilities{
	/*
	 * 
	 */
	private $_uniqueID;
	
	public function runQuery($table, $what)
	{
		//what needs to be an array where the values are stings which include single quotes at either end.
		$sql = "INSERT INTO $table ";
		
		$this->makeLists($what, ", ");
		$columns = "(" . $this->_keyList . ") ";
		$values = "VALUES (" . $this->_valueList .")";
		
		$sql .= $columns . $values;
		
		if ($this->queryDatabase($sql) === TRUE ) {
		    $this->_success = TRUE;
		    $this->_queryLog[] = array('sql' => $sql, 'count' => mysqli_affected_rows(self::$mysqli));
			$this->_uniqueID = mysqli_insert_id(self::$mysqli);
		} else {
			$this->_success = FALSE;
		    $this->_errorLog[] = "Error executing: $sql";
			$this->_errorLog[] = mysqli_error(self::$mysqli);
		}	
	}
	
	public function getUniqueInsertId()
	{
		return $this->_uniqueID;
	}
}

?>