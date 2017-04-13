<?php
	require_once ('include.inc');
	if (empty($_POST)){
		die(header("Location: ../maintenance_area_editLinks.php"));
	}

	$query= new Query_Delete();	
	$whereArray['linkNumber'] = $query->escapeMe($_POST['linkNumber']);

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