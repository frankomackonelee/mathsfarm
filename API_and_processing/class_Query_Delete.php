<?php
 
class Query_Delete extends DatabaseUtilities{
	/*

	 */
	
	public function runQuery($from, $where)
	{
		$sql = "DELETE";
		$sql .= " FROM $from ";
		
		if($where!=null){
			$sql .= "WHERE ";
			$this->makeConditions($where, " AND ");
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