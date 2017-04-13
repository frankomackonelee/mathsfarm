<?php
	require_once ('include.inc');

	$fieldNames = array('url', 'icon', 'alt', 'accompanyingText');
	$val = new Pos_Validator($fieldNames, 'POST');
	//set the validations
	$val->isURL('url');
	$val->matches('icon', '([^\s]+(\.(?i)(jpg|png))$)');
	$val->checkTextLength('alt', 3, 50);
	$val->noFilter('alt');
	$val->checkTextLength('accompanyingText', 5, 60);
	$val->noFilter('accompanyingText');
	//validate the data and get the results
	$val->validateInput();
	$missing = $val->getMissing();
	$errors = $val->getErrors();
	$filtered = $val->getFiltered();
	
	if ($missing || $errors){
		$_SESSION['missing'] = $missing;
		$_SESSION['errors'] = $errors;
		die(header("Location: ../maintenance_area_editLinks.php"));
	}

	$query= new Query_Update();
	foreach ($fieldNames as $name) {
		$newData[$name] = "'" . $query->escapeMe($_POST[$name]) . "'";	
		//$newData[$name] = "'" . $_POST[$name] . "'";
	}
	$where['linkNumber'] = $query->escapeMe($_POST['linkNumber']);

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