<?php
	include_once 'include.inc';

	$home_page = new General_Page("Links");
	
	//add any required links to $linkInformation
	$linkInformation = array
	  (
		  array('url'=>"https://www.youtube.com/watch?v=pVo6szYE13Y",
		  		'icon'=>siteLocation."/images/pythagoras.jpg",
		  		'alt'=>"Mathematics on a whiteboard",
		  		'text'=>"A one minute proof of Pythagoras Theorem"),
		  array('url'=>"https://www.youtube.com/watch?v=-HchPhg4x10",
		  		'icon'=>siteLocation."/images/archimedes_sphere.png",
		  		'alt'=>"Mathematics on a whiteboard",
		  		'text'=>"Archimedes nails the forumala for the surface area of a sphere"),
		  array('url'=>"https://www.mrbartonmaths.com/",
		  		'icon'=>siteLocation."/images/MrBarton.jpg",
		  		'alt'=>"Mr Barton Maths",
		  		'text'=>"Mr Barton Maths"),
	  );
	
	$text = "<br>";
	foreach($linkInformation as $link) {
		$text .= "<a href='".$link['url']."' target='_blank'>
					<img id='topBanner' src='".$link['icon']."' alt='".$link['alt']."' height='150px' width='150px'/>
				 </a>
				<span style='position: relative; top: -60px'>".$link['text']."</span>
				<br>";
	}
	//create the content for the core element of the page
						
	$home_page->setcontent("core",$text);
	
	$home_page->printPage();

?>