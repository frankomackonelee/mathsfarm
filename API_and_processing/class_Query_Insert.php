<?php
 
class Query_Insert extends DatabaseUtilities{
	/*
	 * 
	 */
	
	public function runQuery($table, $what)
	{	
		$sql = "INSERT INTO $table ";
		
		$this->makeLists($what, ", ", FALSE);
		$columns = "(" . $this->_keyList . ")";
		$values = "VALUES (" . $this->_valueList .")";
		
		$sql .= $columns.$values;
		
		if ($this->queryDatabase($sql) === TRUE ) {
		    $this->_queryLog[] = array('sql' => $sql, 'count' => mysql_affected_rows());
		} else {
		    $this->_errorLog[] = "Error executing: $sql";
		}	
	}
}

?>