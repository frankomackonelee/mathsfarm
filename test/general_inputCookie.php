<?php
	include_once '../include.inc';

	$home_page = new General_Page("Feed Cookies Here");
	
	$home_page->addJavascriptFile("general_inputCookie.js");
	
	//create the content for the core element of the page
	$text = "<h1>Form</h1>\n";
	$text .= "<p>The is a form below</p>\n";
	$text .= "<form id='input'>
					<div id='panel'>
						<input id='firstName' type='text'><br>
						<input id='lastName' type='text'>
						<input id='myButton' type='button' value='myButton'>
					</div>
				</form>";
	
	$home_page->setcontent("core",$text);
	
	$home_page->printPage();

?>