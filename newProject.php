<?php 

session_start();
	$project = 'default';
	if (isset($_GET['proj'])) {
		$project = $_GET['proj'];
		// code...
	}
	if (isset($_SESSION['$projects$'])) {
		if(in_array($project,$_SESSION['$projects$']) == false){
		array_push($_SESSION['$projects$'],$project);
		include 'config.php';
		chdir($projects_path);
		shell_exec($cordova_path." create ".$project." com.appbuilder.".$project." ".$project);
		chdir($project);
		shell_exec($cordova_path." platform add android");
		echo '{"success":true}';
		}else{
			echo '{"success":false}';
		}
	}else{
		$_SESSION['$projects$'] = array($project);
		echo '{"success":true}';
	}