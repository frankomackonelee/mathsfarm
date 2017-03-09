<?php
	include_once 'API_and_processing/include.inc';
	$home_page = new General_Page("Links");

	function writeLinkHTML($url, $icon, $alt, $text)
	{
		return "<a href='".$url."' target='_blank'>
					<img id='topBanner' src='".siteLocation."images/".$icon."' alt='".$alt."' height='150px' width='150px'/>
				 </a>
				<span style='position: relative; top: -60px'>".$text."</span>
				<br>";
	}
	$sql = "SELECT * FROM pageinfo_links";
	$text = "<br>";
	
	//The following code is sufficient for accessing and querying the database.
	$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DB);
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	while (!is_null($row)){ 
		$text.= writeLinkHTML($row['url'], $row['icon'], $row['alt'], $row['accompanyingText']);
		$row = $result->fetch_assoc();
	}
	//create the content for the core element of the page
						
	$home_page->setcontent("core",$text);
	$home_page->printPage();

?>