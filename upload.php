<?php 
	header("Content-Type: application/json");
	session_start();
	if (isset($_POST['fileContents']) and isset($_POST['filename'])) {
		if (is_array($_SESSION['files']) == false) {
			$_SESSION['files'] = array(array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents']));
			echo json_encode(array("success"=>1));
		}else if(in_array($_POST['filename'], $_SESSION['files']) == false){
			array_push($_SESSION['files'], array($_POST['filename']=> array('filename'=> $_POST['filename'], 'fileContents' => $_POST['fileContents'])));
			echo json_encode(array("success"=>1));
		}else{
			echo json_encode(array("success"=>0));
		}
	}
	echo json_encode(array("success"=>0));
?>