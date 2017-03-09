<?php
	include_once('API_and_processing/include.inc');
	
	$page = new Resource_Page("Catch Phrase");
	$page->addCssFile(siteLocation."css/cphrasebuttons.css");
	$page->addCssFile(siteLocation."css/resource_catchphrase.css");
	//$page->addCssFile(siteLocation."css/question_selection_control.css");
	$page->addJavascriptFile("http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.1.min.js");
	$page->addJavascriptFile(siteLocation."javascript/resource_catchphrase.js");
	$text = "<input type='checkbox' id='bonus'>Include a bonus</input>
			<button type='button' id='updatebackground'>Change Background</button>
			<br>
			<header id='instructions' style='font-size: 150%;'>Choose a matching pair</header>
			<br>
			<table id='table1' cellspacing='0' cellpadding='0'>
			</table>
			<br>
			<hr style='width: 85%; text-align: center'>
			<div id='panel' ></div>";
	$text .= "<div id='panel'></div>";
	$page->setContent("core", $text);
	
	$page->printPage();

?>