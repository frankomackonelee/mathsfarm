<?php
	include_once 'API_and_processing/include.inc';

	$maintenance_area = new maintenancePage("Check Cookies");
	
	//create the content for the core element of the page
	$text = "<h1>Maintenance Areas</h1>\n";
	$text .= "<p>You've got this far so hopefully your here to make improvements</p>\n";
	$text .= "<p>TODO: make arrival here dependent on a passwork</p>\n";
	$maintenance_area->setcontent("core",$text);
	$maintenance_area->printPage();

?>