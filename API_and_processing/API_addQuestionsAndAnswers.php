<?php
	//From googling simple API in PHP
	//https://www.leaseweb.com/labs/2015/10/creating-a-simple-rest-api-in-php/
	//includes the following
	// get the HTTP method, path and body of the request
	
	require_once('include.inc');

	$json = file_get_contents('php://input');
	//the true below is inserted to help access this as an associative array.  Don't really understand how 
	$json_post = json_decode($json,true);
	$title = "'" . $json_post['title'] . "'";
	$question = "'" . $json_post['question'] . "'";
	$answer = "'" . $json_post['answer'] . "'";
	
	$selectQuery = new Query_Select();
	$what1 = array('question_id');
	$where1 = array ('title' => $title);
	$selectResult1 = $selectQuery->runQuery('question_title', $what1, $where1);
	if (count($selectResult1)!=0){
		$questionID = $selectResult1[0]['question_id'];
		$proceed = true;
	}else{
		$proceed = false;
		$text = $selectQuery->getSql();
	}
	if($proceed){
//SELECT if(max(question_number) is null, 1, max(question_number)+1) AS nextQuestionNumber 
//FROM `questions_and_answers` 
//WHERE question_id=49
		$what2 = array('if(max(question_number) is null, 1, max(question_number)+1) AS nextQuestionNumber');
		$where2 = array('question_id' => $questionID);
		$selectResult2 = $selectQuery->runQuery('questions_and_answers', $what2, $where2);	
		if (count($selectResult2)!=0){
			$questionNumber = $selectResult2[0]['nextQuestionNumber'];
			$proceed = true;
		}else{
			$proceed = false;
			$text = $selectQuery->getSql();
		}
	}
	if($proceed){
		$insertQuery = new Query_Insert();
		$what3 = array('question_id' => $questionID, 'question_number' => $questionNumber, 'question' => $question, 'answer' => $answer);
		$insertQuery->runQuery("questions_and_answers", $what3);
		//select question_number, question, answer from questions_and_answers where question_id = 49;
		$what5 = array('question_number',  'question', 'answer');
		$where5 = array('question_id' => $questionID);
		$selectResult5 = $selectQuery->runQuery('questions_and_answers', $what5, $where5);			
		
		//$stringResponse = '{ "insertQuery" : "' . $insertQuery->getSql() . '" , "selectQuery" : "' . $selectQuery->getSql() . '"}';
		$stringResponse = '{ "queryResult" : ' . json_encode($selectResult5) . ' }';			
	}else{
		$stringResponse = '{ "faliedtoLoadQuestions" : "' . $text . '"}';	
	}
	
	echo $stringResponse;
?>