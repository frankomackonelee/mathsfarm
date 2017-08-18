<?php
	include_once 'API_and_processing/include.inc';

	$home_page = new General_Page("Home");
	
	//create the content for the core element of the page
	$text = "<h1>Mathsfarm</h1>\n";
	$text .= "<p>I am a maths teacher from Devon who has been snatching to odd hour when not marking books to learn some webdevelopment.</p>\n";
	$home_page->setcontent("core",$text);
	
	$home_page->printPage();

?>