<?php
	include_once 'API_and_processing/include.inc';

	$home_page = new General_Page("Home");
	
	//create the content for the core element of the page
	$text = "<h1>The farmer</h1>\n";
	$text .= "<p>The farmer is a maths teacher from Devon who's been snatching to odd hour when not marking books to learn some webdevelopment.</p>\n";
	$home_page->setcontent("core",$text);
	
	$home_page->printPage();

?>