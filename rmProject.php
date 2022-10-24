<?php 
	header("Content-Type: application/json");

session_start();
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	
	//array_search(needle, haystack)
	if (isset($_SESSION['$projects$'])) {
		if(in_array($project,$_SESSION['$projects$'])){
		unset($_SESSION['$projects$'][array_search($project,$_SESSION['$projects$'])]);
		echo '{"success":1}';
		}else{
			echo '{"success":0}';
		}
	}else{
		echo '{"success":3}';
	}