<?php
	include_once 'API_and_processing/include.inc';

	$show_subtopics = new SelectQuestions_Page("Choose Questions");
	
	//create the content for the core element of the page
	$text = "<h2>Load up some questions</h2>\n";

	$show_subtopics->addJavascriptFile(siteLocation."javascript/common_functions.js");
	$show_subtopics->addJavascriptFile(siteLocation."javascript/class_JSObjectForAPI.js");
	$show_subtopics->addJavascriptFile(siteLocation."javascript/class_AJAXrequest.js");
	
	$text .= $show_subtopics->getTopicSubtopicLevelSelectors();
	$text .= "<br><br>";
	$text .= "<div id='CookieJar'><table id='tablecontents'><tr><th>Questions</th><th>Answers</th></tr></table></div>";
	$show_subtopics->setcontent("core",$text);

	$show_subtopics->addJavascriptFile(siteLocation."javascript/choose_questions.js");
	
	$show_subtopics->printPage();
?>