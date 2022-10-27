<?php
	//header("Content-Type: application/json");
//	session_start();	
	function proj($project){
	if (isset($_SESSION[$project]) == true) {
		include 'config.php';
	 	foreach ($_SESSION[$project]['files'] as $key => $value) {
	 		if (file_exists($tmp_path."$slash$project$slash") == false) {
	 			mkdir($tmp_path."$slash$project$slash");
	 		}
	 		if ($value['isasset'] ==0) {
	 			// code...
	 	 	file_put_contents($tmp_path."/$project/".$value['filename'], $value['fileContents']);
	 	 }else{
	 	 	file_put_contents($tmp_path."/$project/".$value['filename'], base64_decode($value['fileContents']));
	 	 }
	 	}
	 	 file_put_contents($tmp_path."$slash$project$slash.assetsfolder", '1');
	 	 return array("folder"=>$tmp_path."$slash$project$slash","success"=>1);
	 	 //exit;
	}
return false;
}