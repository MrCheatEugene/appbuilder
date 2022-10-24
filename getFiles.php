<?php 
session_start();
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	if (isset($_SESSION[$project]) == false) {
		$_SESSION[$project] = array();
	}
	if (isset($_SESSION[$project]['files'])){
		echo json_encode($_SESSION[$project]['files']);
		exit();
	}else{
		echo "{}";
		exit();
	}
	echo "{}";
?>