<?php
	if(!isset($_SESSION)){
		session_start();
	}
	require_once('constants.inc');

	require_once('class_Page.php');
	require_once('class_General_Page.php');
	require_once('class_Resource_Page.php');
	require_once('class_SelectQuestions_Page.php');
	require_once('class_maintenancePage.php');
	require_once('class_DatabaseUtilities.php');
	require_once('class_Query_Insert.php');
	require_once('class_Query_Select.php');
	require_once('class_Query_Delete.php');
	require_once('class_Query_Update.php');
	require_once('class_Validator.php');
?>