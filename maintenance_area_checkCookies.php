<?php
	include_once 'API_and_processing/include.inc';

	$check_cookie_page = new maintenancePage("Check Cookies");
	
	//create the content for the core element of the page
	$text = "<h1>What do the cookies say</h1>\n";
	$text .= "<p>There is a div below this p where cookies should go:</p>\n";
	$text .= "<button id='deleteCookies'>Delete Cookies</button>";
	$text .= "<div id='cookieJar'>
				</div>";
	
	$check_cookie_page->setcontent("core",$text);
	$check_cookie_page->printPage();
	unset($check_cookie_page);
?>