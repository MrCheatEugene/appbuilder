<?php
	header("Content-Type: application/json");
	session_start();	
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	if (isset($_SESSION[$project]) == true) {
		include 'config.php';
	 	foreach ($_SESSION[$project]['files'] as $key => $value) {
	 		if (file_exists($tmp_path."$slash$project$slash") == false) {
	 			mkdir($tmp_path."$slash$project$slash");
	 		}
	 	 	file_put_contents($tmp_path."/$project/".$value['filename'], $value['fileContents']);
	 	 }
	 	 file_put_contents($tmp_path."$slash$project$slash.assetsfolder", '1');
	 	 echo json_encode(array("folder"=>$tmp_path."$slash$project$slash","success"=>1));
	 	 exit;
	}
	echo json_encode(array("success"=>0));
	exit;
?>