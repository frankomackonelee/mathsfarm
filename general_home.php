<?php
	include_once 'API_and_processing/include.inc';

	$home_page = new General_Page("Home");
	
	//create the content for the core element of the page
	$text = "<h1>Welcome to the Maths Farm</h1>\n";
	$text .= "<p>The mission of this website is to make it easy for maths teachers to present the right questions to their classes in fun engaging formats</p>\n";
	$text .= "<p>On the farm you can do the following:
				<ul>
				<li>Turn a list of quesions and answers into a whole class activity at a click</li>
				<li>Changes these quesions into any one of 6 other resource types</li>
				<li>Search your own quesions as well as everyone else's for other related quesions</li>
				<li>Copy someone else's quesions and tweek them to get the content and level just right for your class</li>
				</ul></p>\n";
		$text .= "<p>You can see example resources at the click of a button, but you'll need to sign up to make the most of what's on offer.</p>\n";
	$home_page->setcontent("core",$text);
	
	$home_page->printPage();

?>