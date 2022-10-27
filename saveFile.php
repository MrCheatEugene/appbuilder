<?php 
	header("Content-Type: application/json");
	session_start();	
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = strval(strval($_GET['proj']));
		// code...
	}
	$isasset = 0;
	if (isset($_GET['isasset'])) {
		$isasset = boolval(intval($_GET['isasset']));
		// code...
	}
	if (isset($_SESSION[$project]) == false) {
		$_SESSION[$project] = array();
	}

	if (isset($_SESSION['$projects$']) == false) {
		$_SESSION['$projects$'] = array();
	}
	if (isset($_POST['fileContents']) and isset($_POST['filename'])) {
		$_POST['filename'] = strval($_POST['filename']);
		if(in_array($_POST['filename'], $_SESSION[$project]['files']) and isset($_SESSION[$project]['files'])){
			$_SESSION[$project]['files'][$_POST['filename']]= array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents'],'isasset'=>$isasset);
			echo json_encode(array("success"=>1));
			exit();
		}else if(isset($_SESSION[$project]['files']) == false){
			$_SESSION[$project]['files'] = array($_POST['filename']=>array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents'],'isasset'=>$isasset));
			echo json_encode(array("success"=>1));
			exit();
		}else if(isset($_SESSION[$project]['files']) == true && in_array($_POST['filename'], $_SESSION[$project]['files']) == false){
			$_SESSION[$project]['files'][$_POST['filename']] = array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents'],'isasset'=>$isasset);
			echo json_encode(array("success"=>1));
			exit();
		}
			echo json_encode(array("success"=>0));
			exit();
	}
	echo json_encode(array("success"=>3));
	exit();
?>