<?php 

	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	if (isset($_GET['fn'])) {
		$fn = $_GET['fn'];
		// code...
	}
//header("Content-Type: application/json");
session_start();
$_SESSION_KEYS = array_keys($_SESSION);
foreach ($_SESSION['$projects$'] as $value) {
	if ($project == $value and in_array($value, $_SESSION_KEYS)) {
//		var_dump($_SESSION[$value]);
		if (count($_SESSION[$value]) ==  0) {
			die('{"success":0}');
		}
		for ($i=0; $i < count($_SESSION[$value]['files']); $i++) { 	
	 	if($fn == $_SESSION[$value]['files'][$i]['filename']){
	 		die(json_encode(array('success'=>1,'code'=>$_SESSION[$value]['files'][$i]['fileContents'])));
	 	}
		}
	 } 
}
die('{"success":0}');