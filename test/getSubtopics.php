<?php
	include_once '../include.inc';

	$show_subtopics = new Resource_Page("Topic Choices");
	
	$show_subtopics->addJavascriptFile(siteLocation."test/getSubtopics.js");
	
	$text = "<h2>Testing a GET method</h2>\n";
	$text .= "<p>On change of the topic selector there is a GET call to a php file which returns a JSON object which updates the subtopic dropdown.  Not plugged into mysql though</p>";
	$text .= "<select id='topic_select'>\n";
	$topics = array("Algebra","Number","Shape","Data");
	foreach ($topics as $topic) {
		$text .= "<option value='$topic'>$topic</option>\n";
	}
	$text .= "</select>";
	
	$text .= "<select id='subtopic_select'><option value='Other'>Other</option></select>";
	
	$show_subtopics->setcontent("core",$text);
	
	$show_subtopics->printPage();
?>