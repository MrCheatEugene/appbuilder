<?php 
session_start();
	$project = 'default';
	function newProj(){
	//	session_start();
	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
		// code...
	}   
		if(in_array($project,$_SESSION['$projects$']) == false){
		include 'config.php';
		chdir($projects_path);
		$out;
		$code = 0;
		exec($cordova_path." create ".$project." com.appbuilder.".$project." ".$project,$out,$code);
		if ($code == 0) {
			chdir($project);
			exec($cordova_path." platform add android",$out,$code);
			if ($code == 0) {
				array_push($_SESSION['$projects$'],$project);
				echo '{"success":true}';
			}else{
				echo '{"success":false}';	
			}
		}else{
			echo '{"success":false}';
		}
		}else{
			echo '{"success":false}';
		}
	}
	if (isset($_SESSION['$projects$']) == true) {
		newProj();
	}else{
		$_SESSION['$projects$'] = array();
		newProj();
	}