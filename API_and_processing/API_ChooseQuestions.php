<?php
	//From googling simple API in PHP
	//https://www.leaseweb.com/labs/2015/10/creating-a-simple-rest-api-in-php/
	//includes the following
	// get the HTTP method, path and body of the request
	require_once('include.inc');

	$json = file_get_contents('php://input');
	$json_post = json_decode($json);

	$requiredReturn = $json_post->seeking;	
	$topics = arrayToString($json_post->topics);
	$subtopics = $json_post->subtopics;
	$levels = $json_post->levels;
	$titles = $json_post->titles;
	
	/* Next line lines add this sort of thing to JSON
		"{ "selectors": ["subtopics","titles"] , 
	*/	
	$stringResponse = '{ "selectors": ' . json_encode($requiredReturn) . ' , ';

	$arraySpacer = "";
	foreach ($requiredReturn as $key => $selector) {
			
			//Next 3 lines specify the sql then run the query outputted as an array
			$textForSql = new sqlTextMaker($selector,$topics,$subtopics,$levels,$titles) ;
			$query = new Query_Select();
			//This is to stop the query returning a ridiculous number of lines
			$limit = ($selector=="titles" ? 10 : 29);
			$arrayResults = $query->runQuery($textForSql->from, $textForSql->what, $textForSql->where, $limit);
			/*The next line adds elements like this to the JSON return message:
			 *  "subtopics":	[
			 * 						{"myList":"Decimals"},
			 * 						{"myList":"Estimating and accuracy"},
			 * 						{"myList":"Fractions"},
			 * 					]
			 */
			$stringResponse .= $arraySpacer . '"' . $selector . '":' . json_encode($arrayResults);	
			/*The next line adds the sql to the query
			 *	"sql_for_subtopics" : "SELECT DISTINCT subtopic AS myList FROM subtopic_list WHERE topic='Algebra'" , 
			 */			
			$stringResponse .= ', "sql_for_' . $selector . '" : "' . $query->getSql() . '"';

			$arraySpacer = " , ";
	}
	$stringResponse .= '}';
	//TODO; When there's a problem:
	//$stringResponse .= var_dump($query->getSql());
	echo $stringResponse;
	
	function arrayToString($stringInput){
		if(is_array($stringInput)){
			$output = "";
			$spacer = "";
			foreach ($stringInput as $strValue) {
				$output .= $spacer . "'" . $strValue . "'" ;
				$spacer = " , ";
			}
			return $output;
		}else{
			return "'" . $stringInput . "'";
		}
	}
	
	/**
	 * 
	 */
	class sqlTextMaker {
		public $from;
		public $what;
		public $where;
		function __construct($selector,$topics,$subtopics,$levels,$titles) {
			switch ($selector) {
				case 'subtopics':
					//not sure if the DISTINCT should be here
					$this->from = "subtopic_list";
					$this->what[] = "DISTINCT subtopic AS myList";
					if($topics!="'Any'"){
						$this->where["topic"] = $topics;}
					break;
					
				case 'titles':	
					$this->from = "question_title AS qt INNER JOIN question_subtopics AS qs ON qs.question_id = qt.question_id INNER JOIN subtopic_list AS sl ON sl.subtopic_id = qs.subtopic_id INNER JOIN question_difficulty as qd ON qd.question_id = qt.question_id";
					$this->what[] = "DISTINCT qt.title AS myList";
					//Added in below:
					if($topics!="'Any'"){
						$this->where["sl.topic"] = $topics;}
					if($subtopics!="Any"){
						$this->where["sl.subtopic"] = "'".$subtopics."'";}
					if($levels!="Any"){
						$this->where["qd.level"] = $levels;}		 
					break;
				
				case 'questions':
					$this->from = "questions_and_answers AS qa INNER JOIN question_title AS qt ON qt.question_id = qa.question_id";
					$this->what[] = "question";
					$this->what[] = "answer";
					$this->where["qt.title"] = "'".$titles."'";
					break;
			}
		}
	}
?>