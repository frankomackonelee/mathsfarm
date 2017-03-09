<?php
	include_once 'API_and_processing/include.inc';

	$maintenance_area = new maintenancePage("Error Report");
	
	//create the content for the core element of the page
	$text = "<h1>Error Report</h1>\n";
	var_dump($_SESSION["info"]);
	$maintenance_area->setcontent("core",$text);
	$maintenance_area->printPage();

?>