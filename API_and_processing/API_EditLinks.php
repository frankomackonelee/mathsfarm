<?php 
	//From googling simple API in PHP
	//https://www.leaseweb.com/labs/2015/10/creating-a-simple-rest-api-in-php/
	//includes the following
	// get the HTTP method, path and body of the request
	
	require_once('include.inc');

	$json = file_get_contents('php://input');
	//the true below is inserted to help access this as an associative array.  Don't really understand how 
	$json_post = json_decode($json,true);
	$fetching = $json_post['seeking'];
	
	switch ($fetching) {
		//SELECT url, icon, alt, accompanyingText, linkNumber FROM pageinfo_links
		case 'linksDetails':
			$from = "pageinfo_links";
			$what = array('url', 'icon', 'alt', 'accompanyingText', 'linkNumber');;
			$where = null;
			break;
			
		case 'updateLink':	
 
			break;
		
		case 'deleteLink':

			break;
	}
		
	$query = new Query_Select();
	$arrayResults = $query->runQuery($from, $what, $where);
	$rowsCount = count($arrayResults);
	$stringResponse = '{"rowsReturned":"' . $rowsCount . '", "data":[';
	$spacer = "";
	foreach ($arrayResults as $key => $row) {
		$stringResponse .= $spacer . "{ ";
		$spacer = "";
		foreach ($row as $column => $value) {
			$stringResponse .= $spacer. '"' . $column . '":"' . $value .'"';	
			$spacer = ", ";				
		}
		$stringResponse .= "} ";
	}
	$stringResponse .= ']}';
	
	echo $stringResponse;

?>