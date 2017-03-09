<?php
	include_once 'API_and_processing/include.inc';

	$AJAX_response_page = new maintenancePage("AJAX Response");
	//text is the text for 
	$text = $AJAX_response_page->getTopicSubtopicLevelSelectors();
	//create the content for the core element of the page
	$text .= "<br><br>";
	$text .= "<div>Details of the JSON returned from the server should show below</div><br>";
	$text .= "<div id='jsonFromServer' style='text-align:left;'>Something has gone wrong with the process</div>";
	$AJAX_response_page->setcontent("core",$text);
	
	$AJAX_response_page->printPage();
	
	unset($AJAX_response_page);
?>