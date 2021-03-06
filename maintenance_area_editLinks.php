<?php
	include_once 'API_and_processing/include.inc';

	$maintenance_area = new maintenancePage("Edit Links");
	$sourcesOfProblems = array('errors', 'missing');
	foreach ($sourcesOfProblems as $source) {
		if(isset($_SESSION[$source])){
			print "<h1>" . $source . "</h1>";
			foreach ($_SESSION[$source] as $key => $message) {
				print "<p>" . $message . "</p>";
			}
		}
		unset($_SESSION[$source]);		
	}
	$text = '<h1>Three ways to edit links:</h1>';
	$text .= '<div class="centered">';
	$buttons = array(	'Add_Links' 	=> 'Add Links',
						'Delete_Links'	=> 'Delete Links',
						'Update_Links'	=> 'Update Links');
	foreach ($buttons as $id => $buttonText) {
		$text .= '<button class="chooseFunctionality" id="' . $id . '">' . $buttonText . '</button>';
	}
	$text .= '</div>';
	$text .= '<br><div id=Functionality></div>';
	$maintenance_area->setcontent("core",$text);
	$maintenance_area->printPage();

?>