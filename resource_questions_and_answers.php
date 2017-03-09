<?php
	include_once('API_and_processing/include.inc');
	
	$page = new Resource_Page("Questions and Answers");
	$page->addCssFile(siteLocation."css/resource_questions_and_answers.css");	
	$page->addJavascriptFile(siteLocation."javascript/resource_questions_and_answers.js");

		
	$text = "<br><div id='panel'></div>";

	$page->setContent("core", $text);
	
	$page->printPage();


?>