<?php 

	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
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
		foreach($_SESSION[$value]['files'] as $key=>$val){
		//for ($i=0; $i < count($_SESSION[$value]['files']); $i++) { 	
	 	if($fn == $_SESSION[$value]['files'][$key]['filename']){
	 		die(json_encode(array('success'=>1,'code'=>$_SESSION[$value]['files'][$key]['fileContents'])));
	 	}
		}
	 } 
}
die('{"success":0}');