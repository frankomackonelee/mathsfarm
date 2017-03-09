<?php
 
class Query_Update extends DatabaseUtilities{
	/*
	UPDATE `pageinfo_links` 
	 * SET url='google.com',icon='default.jpg',alt='whatever',accompanyingText='this has been changed' 
	 * WHERE linkNumber=17
	 */
	
	public function runQuery($table, $what, $where)
	{
		$sql = "UPDATE $table ";
		
		$sql .= "SET ";
		if($what!=null){
			$this->makeConditions($what, ", ");
			$sql .= $this->_conditionList;
		}else{
			$sql .= "Dummy Condition To Prevent Disaster";
		}
		
		if($where!=null){
			$sql .= "WHERE ";
			$this->makeConditions($where, ", ");
			$sql .= $this->_conditionList;
		}else{
			$sql .= "Dummy Condition To Prevent Disaster";
		}		
		
		if ($this->queryDatabase($sql) === TRUE ) {
		    $this->_queryLog[] = array('sql' => $sql, 'count' => mysql_affected_rows());
		} else {
		    $this->_errorLog[] = "Error executing: $sql";
		}	
	}
}

?>