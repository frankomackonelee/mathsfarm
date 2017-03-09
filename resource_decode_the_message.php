<?php
	include_once('API_and_processing/include.inc');
	
	$page = new Resource_Page("Decode the Message");
	$page->addCssFile(siteLocation."css/resource_decode_the_message.css");
	$page->addJavascriptFile(siteLocation."javascript/resource_decode_the_message.js");
	$text = "<br><form><input type='text' id='HiddenMessage' value='Default Text'/>
				<button type='button' id='MakeResource'>Make Resource</button>
			</form>
			<br>";
	$text .= "<div id='panel'></div>";
	$page->setContent("core", $text);
	
	$page->printPage();

?>