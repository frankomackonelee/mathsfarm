<?php
	include_once('API_and_processing/include.inc');
	
	$page = new Resource_Page("Bingo");
	$page->addCssFile(siteLocation."css/resource_bingo.css");	
	$page->addJavascriptFile(siteLocation."javascript/resource_bingo.js");
		
	$text = "<br><table>
				<tbody>
					<tr><td rowspan='2' id='questionNumber'>Question</td><td rowspan='2' id='questionBox'>Question Goes Here</td><td><button id='previousButton'>Previous Question</button></td></tr>
					<tr><td><button id='nextButton'>Next Question</button></td></tr>
					<tr><td></td><td rowspan='2' id='answerBox' class='invisibleText'>Answer Goes Her</td><td><button id='showAnswer'>Show Answer</button></td></tr>
				</tbody>
			</table>";

	$page->setContent("core", $text);
	
	$page->printPage();


?>