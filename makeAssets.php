<?php
	header("Content-Type: application/json");
	session_start();	
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
		// code...

		include 'makeAssetsAPI.php';
		echo json_encode(proj($project));
	}
?>