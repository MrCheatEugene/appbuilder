<?php 
	header("Content-Type: application/json");

session_start();
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
		// code...
	}
	
	$fn = 'default';
	if (isset($_GET['fn'])) {
		$fn = $_GET['fn'];
		// code...
	}
	
	//array_search(needle, haystack)
	if (isset($_SESSION['$projects$'])) {
		if(in_array($project,$_SESSION['$projects$'])){
			$project = $_SESSION['$projects$'][array_search($project,$_SESSION['$projects$'])];
			if(isset($_SESSION[$project]['files']) == true){
			for ($i=0; $i < count($_SESSION[$project]['files']); $i++) { 	
		 	if($fn == $_SESSION[$project]['files'][$i]['filename']){
		 		unset($_SESSION[$project]['files'][$i]);
		 		die('{"success":1}');
		 	}
		 	}
			echo '{"success":0}';
			exit;
			}else{
				echo '{"success":0}';	
			}
		}else{
			echo '{"success":4}';
		}
	}else{
		echo '{"success":3}';
	}