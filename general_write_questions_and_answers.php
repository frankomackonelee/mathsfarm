<?php
	include_once 'API_and_processing/include.inc';
	unset($_SESSION['error']);
/*This is an example of the $_POST super global:
 * array(4) { 
 * 		["topic_list"]=> array(2) { 
 * 				[0]=> string(7) "Algebra" 
 * 				[1]=> string(4) "Data" } 
 * 		["subtopic_list"]=> array(3) { 
 * 				[0]=> string(22) "Algebraic manipulation" 
 * 				[1]=> string(15) "Collecting data" 
 * 				[2]=> string(11) "Coordinates" } 
 * 		["level_list"]=> array(3) { 
 * 				[0]=> string(1) "5" [1]=> string(1) "6" 
 * 				[2]=> string(1) "8" } 
 * 		["title"]=> string(15) "this is a title" }
 */
	$usePost = true;
	$useSession = true;
	$inputs = array( "topic_list", "subtopic_list", "level_list", "title" );
	foreach ($inputs as $key => $requiredfield) {
		if (!isset($_POST[$requiredfield]) || $_POST[$requiredfield]==""){
			$_SESSION['error'][] = $requiredfield . ' is required<br>';
			$usePost = false;
		}
		if (!isset($_SESSION['titleInfo'][$requiredfield])){
			$useSession = false;
		}
	}
	$proceed = false;
	if ($usePost){
		$using = $_POST;
		$_SESSION['titleInfo'] = $_POST;
		$proceed = true;
	}elseif($useSession){
		$using = $_SESSION['titleInfo'];
		$proceed = true;
	}
	if ($proceed) {
		$insertQuery = new Query_Insert();
		$whatQT = array('title' => "'" . $using['title'] . "'", 'user' => "'all'");
		$insertQuery->runQuery("question_title", $whatQT);
		if(!$insertQuery->_success){
			$_SESSION['error'][] = $insertQuery->printErrorLog();
			$proceed = false;
		}else{
			$uniqueID = $insertQuery->getUniqueInsertId();
			foreach ($using['level_list'] as $level) {
				$whatL = array('question_id' => $uniqueID, 'level' =>$level);
				$insertQuery->runQuery("question_difficulty", $whatL);
			}
			if(!$insertQuery->_success){
				$_SESSION['error'][] = $insertQuery->printErrorLog();
				$proceed = false;
			}else{
				$selectQuery = new Query_Select();
				foreach ($using['subtopic_list'] as $subtopic) {
					$what = array("subtopic_id");
					$where = array ('subtopic' => "'" . $subtopic . "'");
					$selectResult = $selectQuery->runQuery("subtopic_list", $what, $where, $limit=null);
					if(count($selectResult)==1){
						//$selectResult[0]['subtopic_id']
						$whatST = array('question_id' => $uniqueID, 'subtopic_id' => $selectResult[0]['subtopic_id']);
						$insertQuery->runQuery("question_subtopics", $whatST);					
						if(!$insertQuery->_success){
							$_SESSION['error'][] = $insertQuery->printErrorLog();
							$proceed = false;
						}
					}
				}
			}	
		}
	}
	if ($proceed) {
	
		$this_page = new General_Page("Write Questions");	
		//create the content for the core element of the page
		$text = "<h1>Questions with the following tags</h1>";
		foreach ($inputs as $key => $requiredfield) {
			if (is_array($using[$requiredfield])){
				$text .= $requiredfield . ': ';
				foreach ($using[$requiredfield] as $value) {
					$text .= "   " . $value;
				}
				$text .= "<br>";
			}else{
				$text .= $requiredfield . ': ' . $using[$requiredfield] . "<br>";
			}
		}		
		$text .= "TODO: Need to now add questions with question_id=" . $uniqueID;
		$text .= "<h1>Add the questions and answers for title</h1>";	
		$text .= "<div id='title'>" . $using['title'] . "</div><br>";	
		$text .= "<table id=loadedQuestionsAndAnswers>";
			$text .= "<tr><th>Question</th><th>Answer</th><th>Space for a button</th></tr>";
			$text .= 	"<tr><td><input id='questionLoad' type='text' value='write question here'></td>
						<td><input id='answerLoad' type='text' value='write answer here'></td>
						<td><button id='uploadQuestionsAndAnswers'>Click To Upload</button></td></tr>";
		$text .= "</table>";
		
		$this_page->setcontent("core",$text);
		
		$this_page->addJavascriptFile(siteLocation."javascript/common_functions.js");
		$this_page->addJavascriptFile(siteLocation."javascript/class_AJAXrequest.js");
		$this_page->addJavascriptFile(siteLocation."javascript/class_JSObjectForAPI.js");
		$this_page->addJavascriptFile(siteLocation."javascript/general_write_questions_and_answers.js");
		
		$this_page->printPage();
	}else{
		die(header("Location: general_write_title.php"));
	}
?>