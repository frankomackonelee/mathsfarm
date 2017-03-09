<?php
	require_once ('../include.inc');
	
	$ResourcePage = new Resource_Page("Example resource page");
	
	$ResourcePage->addCssFile("http://localhost/learning/mathsfarm/mathsfarm/css/bottomLinks.css");
	
	$ResourcePage->printPage();
	
?>