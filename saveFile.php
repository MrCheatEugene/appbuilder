<?php 
	header("Content-Type: application/json");
	session_start();	
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	if (isset($_SESSION[$project]) == false) {
		$_SESSION[$project] = array();
	}
	if (isset($_POST['fileContents']) and isset($_POST['filename'])) {
			$_SESSION[$project]['files'] = array(array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents']));
			echo json_encode(array("success"=>1));
			exit();
		if(in_array($_POST['filename'], $_SESSION[$project]['files'])){
			$_SESSION[$project]['files'][$_POST['filename']]= array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents']);
			echo json_encode(array("success"=>1));
			exit();
		}
			echo json_encode(array("success"=>0));
			exit();
	}
	echo json_encode(array("success"=>3));
	exit();
?>