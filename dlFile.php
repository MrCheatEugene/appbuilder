<?php
 $fn = "unknown";
 if (isset($_GET['path'])) {
 	$fn = trim($_GET['path']);
 }
 if (file_exists($fn) == true && file_get_contents($fn) !== false && pathinfo($fn)['extension'] == 'apk') {
 	$quoted = sprintf('"%s"', addcslashes(basename($fn), '"\\'));
$size   = filesize($fn);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile($fn);
 	exit;	
 }
 echo 'Unable to download file.';
var_dump($fn);
var_dump(file_exists($fn));