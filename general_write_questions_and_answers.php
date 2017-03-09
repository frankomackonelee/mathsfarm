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
				$text .= $requiredfield . ': ' . $using[$requiredfield];
			}
		}		
		$text .= "<h1>Add the questions and answers here:</h1>\n";		
		$text .= "<form action='" . siteLocation . "/API_and_processing/general_write_questions_and_answers-process.php' method='POST'>";
			$text .= "<table>";
			$text .= "<tr><th>Question</th><th>Answer</th><th>Space for a button</th></tr>";
			$text .= 	"<tr><td><input id='question0' class='question unlocked' type='text' name='question0'></td>
						<td><input id='answer0' class='answer unlocked' type='text' name='answer0'></td>
						<td><button>Click To Upload</button></td></td>";
			$text .= "</table>";
		$text .= "</form>";
		
		$this_page->setcontent("core",$text);
		
		$this_page->addJavascriptFile(siteLocation."javascript/common_functions.js");
		//$this_page->addJavascriptFile(siteLocation."javascript/class_AJAXrequest.js");
		//$this_page->addJavascriptFile(siteLocation."javascript/class_JSObjectForAPI.js");
		//$this_page->addJavascriptFile(siteLocation."javascript/browser_event_control.js");
		//$this_page->addJavascriptFile(siteLocation."javascript/general_write_questions.js");
		//$this_page->addCssFile(siteLocation."css/general_write_questions.css");
		
		$this_page->printPage();
	}else{
		die(header("Location: general_write_title.php"));
	}
?>