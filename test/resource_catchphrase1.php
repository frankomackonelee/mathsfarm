<?php
	include_once('../include.inc');
	
	$page = new Resource_Page("Catch Phrase");
	
	$page->addJavascriptFile(siteLocation."test/resource_catchphrase2.js");

	$text = "<p>Choose your topic and make sure that the questions are suitably hard below<p>";
	$text .= "<form><input type='text' id='key_phrase'><button type='button' id='myButton'>Make Resources</button></form><br>";
	$text .= "<div id='questions'><table id='tablecontents'><tr><th>Questions</th><th>Answers</th></tr></table></div>";
	$page->setContent("core", $text);
	
	$page->printPage();

?>