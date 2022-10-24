<?php 
//header("Content-Type: application/json");
  if (isset($_GET['proj'])) {
  	$project = $_GET['proj'];
  }
  if (isset($_GET['assets'])) {
  	$assets = $_GET['assets'];
  }
  include 'config.php';
  chdir($projects_path);
  chdir($project);
  function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
  deleteDirectory("www");
  mkdir("www");

function recurseCopy(
    string $sourceDirectory,
    string $destinationDirectory,
    string $childFolder = ''
): void {
    $directory = opendir($sourceDirectory);

    if (is_dir($destinationDirectory) === false) {
        mkdir($destinationDirectory);
    }

    if ($childFolder !== '') {
        if (is_dir("$destinationDirectory/$childFolder") === false) {
            mkdir("$destinationDirectory/$childFolder");
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true) {
                recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            } else {
                copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            }
        }

        closedir($directory);

        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$sourceDirectory/$file") === true) {
            recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
        else {
            copy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
    }

    closedir($directory);
}
chdir($projects_path."\\".$project);
recurseCopy($assets,'./www');
$out = "";
$succ = false;
$file = "unknown";
$waitForAPK = false;
exec($cordova_path." build -- --jvmargs='-Xmx1G'",$out);
foreach ($out as $key => $value) {
    if((strpos($value,"BUILD SUCCESSFUL")=== false)== false){
        $succ = true;
        $waitForAPK = false;
    }else if((strpos($value,"Built the following apk(s):")=== false)==false){
        $waitForAPK = true;
    }else if($waitForAPK){
        $file = trim($value);
        $waitForAPK = false;
    }
}
//var_dump($out);
//putenv("PATH");
if ($succ == false) {
    $file = false;
}
echo json_encode(array("file"=>$file,"success"=>$succ));
?>