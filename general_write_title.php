<?php
	include_once 'API_and_processing/include.inc';
	//this is to make sure that the POST data ends up being processed as the $_SESSION data is used to help store
	unset($_SESSION['titleInfo']);

	$this_page = new General_Page("Write Questions");
	
	//create the content for the core element of the page
	$text = "<h1>Choose relevant info for your questions</h1>\n";
	if(isset($_SESSION['error'])){
		foreach ($_SESSION['error'] as $error) {
			$text .= $error;
		}
		unset($_SESSION['error']);
	}
	
	$text .= "<form action='" . siteLocation . "general_write_questions_and_answers.php' method='POST'>";
	
	$text .= "<h2>Choose Topics</h2>\n";
		$text .= "<div id='topic_section'></div>\n";
		$text .= "<ul class='checkbox-grid'>";
		$topics = array('Algebra' => 'Algebra', 'Data' => 'Data', 'Number' => 'Number', 'Shape' => 'Shape');
		foreach ($topics as $name => $topic) {
			$text .= "<li><input type='checkbox' class='topic_list' name='topic_list[]' value='$name'>$topic</li>"; 
		}
		$text .= "</ul>";
		$text .= "<hr>\n";
		
	$text .= "<h2>Choose Subtopics</h2>\n";
		$text .= "<div id='subtopic_section'></div>\n";
		$text .= "<hr>";
		
	$text .= "<h2>Choose Levels</h2>\n";
		$text .= "<div id='level_section'>";
		$text .= "<ul class='checkbox-grid'>";
		for ($i=1; $i < 11; $i++) { 
			$text .= "<li><input type='checkbox' class='level_list' name='level_list[]' value='$i'>$i</li>";	
		}
		$text .= "</ul>";
		$text .= "</div>\n";
		$text .= "<hr>";
		
	$text .= "<h2>Write a title</h2>\n";
		$text .= "<div id='title_section'><p>When topics, subtopics and levels chosen write a title here</p>";
		$text .= "<input id='title' type='text' name='title'><input type='submit'>";
		$text .= "</div>\n";
	
	$text .= "</form>";
	
	$this_page->setcontent("core",$text);
	
	$this_page->addJavascriptFile(siteLocation."javascript/common_functions.js");
	$this_page->addJavascriptFile(siteLocation."javascript/class_AJAXrequest.js");
	$this_page->addJavascriptFile(siteLocation."javascript/class_JSObjectForAPI.js");
	//$this_page->addJavascriptFile(siteLocation."javascript/browser_event_control.js");
	$this_page->addJavascriptFile(siteLocation."javascript/general_write_questions.js");
	$this_page->addCssFile(siteLocation."css/general_write_questions.css");
	
		
	$this_page->printPage();

?>