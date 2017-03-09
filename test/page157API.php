<?php
	$json = file_get_contents('php://input');
	$json_post = json_decode($json);
	//v simple API.  Possible to send text which doesn't form JSON structure and hence the check below
	if(is_null($json_post)){
		$response['status'] = array(
				'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
			    'type' => 'Error',
			    //'value' => 'No JSON value set but some things work <br>$_SERVER["REQUEST_METHOD"]'.$_SERVER['REQUEST_METHOD'].' <br>and file_get_contents("php://input"): '.file_get_contents('php://input').'<br>isset($_REQUEST["json"]): '.isset($_REQUEST['json']),
			    'value' => 'json_decode returned null',
			  );
		$response['original'] = array(
				'name' => 'was not set properly',
				'email' => array(
							'first' => 'unknown',
							'pleased' => 'probably',
								),
				'sex' => array(
							'second' => 'indeterminate',
							'pleased' => 'probably',
								),
		);
	}else{
		$response['status'] = array(
					'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
				    'type' => 'Success',
				    //'value' => 'No JSON value set but some things work <br>$_SERVER["REQUEST_METHOD"]'.$_SERVER['REQUEST_METHOD'].' <br>and file_get_contents("php://input"): '.file_get_contents('php://input').'<br>isset($_REQUEST["json"]): '.isset($_REQUEST['json']),
				    'value' => 'All fine',
				  );
		$response['original'] = $json_post[0];
	}
	
	$encoded = json_encode($response);
	header('Content-type: application/json');
	exit($encoded);
	//echo $encoded;
	//exit(file_get_contents('php://input'));
	//exit('{"original":{"name":"API_still_not_working","email":2,"sex":3} }')
?>