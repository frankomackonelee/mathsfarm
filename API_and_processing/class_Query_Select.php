<?php
 
class Query_Select extends DatabaseUtilities{
	/*
	 * The idea of the methods in this class is it takes parameters for a query
	 * returns a numbered array containing associative arrays of this form:
	 * array(	array('columnTitle1'=>'value1', 'columnTitle2'=>'value1',....),
	 * 			array('columnTitle1'=>'value2', 'columnTitle2'=>'value2'....)
	 * )
	 */
	
	public function runQuery($from, $what, $where, $limit=null)
	{
		$this->makeLists($what, ", ", TRUE);
		$sql = "SELECT ";
		$sql .= $this->_valueList;
		
		$sql .= " FROM $from ";
		
		if($where!=null){
			$sql .= "WHERE ";
			//taking a risk and changing this to an OR
			$this->makeOrConditions($where, " AND ");
			$sql .= $this->_conditionList;
		}
		
		if($limit!=null){
			$sql .= " LIMIT " .  $limit;
		}
		
		$result = $this->queryDatabase($sql);
		$this->_sql = $sql;
		if ($result==false || $result->num_rows==0){
		   $this->_errorLog[] = "0 results returned from: $sql<br>Potentially error executing query";		   
		} else {
		   $this->_queryLog[] = array('sql' => $sql, 'count' => $result->num_rows);
		}	
		
		if($result){
			$row = $result->fetch_assoc();
			$arrayResult = array();
			while (!is_null($row)){
				$arrayResult[] = $row;
				$row = $result->fetch_assoc();
			}
			return $arrayResult;
		}else{
			return false;
		}
	}

	public function runQuerySQL($sql)
	{
		$result = $this->queryDatabase($sql);
		if ($result->num_rows==0){
		   $this->_errorLog[] = "0 results returned from: $sql<br>Potentially error executing query";		   
		} else {
		   $this->_queryLog[] = array('sql' => $sql, 'count' => $result->num_rows);
		}			
		return $result;		
	}
	
	private function makeOrConditions($arr, $setNotation)
	{
		$count = 0;
		$this->_conditionList = "";
		foreach ($arr as $key => $value) {
			//TODO need to escape column and value carefully
			$spacer = ($count===0 ? "" : $setNotation);
			$this->_conditionList .= $spacer.$key." IN ( " . $value . " ) ";
			$count++;
		}		
	}
}

?>