<?php
session_start();
 $fn = "unknown";
 if (isset($_GET['fn'])) {
 	$fn = strval($_GET['fn']);
 }

 if (isset($_GET['proj'])) {
    $project = strval($_GET['proj']);
 }
 if (in_array($project,$_SESSION['$projects$']) and in_array($fn, array_keys($_SESSION[$project]['files']))) {
 $quoted = sprintf('"%s"', addcslashes(basename($fn), '"\\'));

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
echo base64_decode($_SESSION[$project]['files'][$fn]['fileContents']);
 	exit;	
}else{
 echo 'Unable to download file.';   
}