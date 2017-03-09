<?php
	require_once ('include.inc');
	if (empty($_POST)){
		die(header("Location: ../maintenance_area_editLinks.php"));
	}
	
	$whereArray['linkNumber'] = $_POST['linkNumber'];
		
	$query= new Query_Delete();
	$query->runQuery("pageinfo_links" ,$whereArray);
	if($query->getSuccess()){
		unset($query);
		die(header("Location: ../general_links.php"));
	}else{
		//TODO: Create a page to report on controled errors
		var_dump($query->printErrorLog);
		unset($query);
	}
?>