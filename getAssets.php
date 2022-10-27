<?php 
session_start();
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
		// code...
	}
	if (isset($_SESSION[$project]) == false) {
		$_SESSION[$project] = array();
	}
	if (isset($_SESSION[$project]['files'])){
		$toReturn = array();
		foreach ($_SESSION[$project]['files'] as $key => $value) {
			if (isset($value['isasset']) and $value['isasset']==true)  {
				array_push($toReturn, $value);
			}
			// code...
		}
		echo json_encode($toReturn);
		exit();
	}else{
		echo "{}";
		exit();
	}
	echo "{}";
?>