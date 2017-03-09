<?php
	require_once ('include.inc');
	if (empty($_POST)){
		die(header("Location: ../maintenance_area_editLinks.php"));
	}
	$fieldNames = array('url', 'icon', 'alt', 'accompanyingText');
	foreach ($fieldNames as $name) {
		$newData[$name] = "'".$_POST[$name]."'";
	}
	$where['linkNumber']=$_POST['linkNumber'];
	
	$query= new Query_Update();
	//($table, $what, $where)
	$query->runQuery("pageinfo_links" ,$newData, $where);
	if($query->getSuccess()){
		unset($query);
		die(header("Location: ../general_links.php"));
	}else{
		//TODO: Create a page to report on controled errors
		var_dump($query->printErrorLog);
		unset($query);
	}
?>