<?php
 
	//From googling simple API in PHP
	//https://www.leaseweb.com/labs/2015/10/creating-a-simple-rest-api-in-php/
	//includes the following
	// get the HTTP method, path and body of the request
	
	//the _SERVER[path info] gives the training bit after the post actual file name
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method=="GET") {
		$arr = explode('/', trim($_SERVER['PATH_INFO'],'/'));
		$request = $arr[0];
	} else {
		$request = file_get_contents('php://input');
	}
	
	$stringResponse = '{"subtopics":[';
	
	switch($request) {
	     case "Algebra":
	        $stringResponse .= '{"subtopic":"Algebraic Manpulation"}, {"subtopic":"Quadratics"}, {"subtopic":"'.$arr[1].'"}';
	        break;
	     case "Data":
	        $stringResponse .= '{"subtopic":"Processing Data"}, {"subtopic":"Collecting Data"}';
	        break;
		 case "Number":
	        $stringResponse .= '{"subtopic":"Percentages"}, {"subtopic":"Fractions"}, {"subtopic":"Decimals"}';
	        break;
		 case "Shape":
	        $stringResponse .= '{"subtopic":"Pythagoras"}, {"subtopic":"Angles"}';
			break;
	     default:
	        $stringResponse .= '{"subtopic":"Other cock up"}, {"subtopic":"Something\'s gone wrong"}'; 
	        break;
	 } 
	
	$stringResponse .= ']}';
	
	echo $stringResponse;

?>