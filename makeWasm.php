<?php 
session_start();
$success = "";
if (isset($_GET['proj']) && isset($_POST['compiler']) && isset($_POST['compileropts']) && isset($_POST['compilefile']) && isset($_POST["outFile"])) {
	if (in_array(strval($_GET['proj']),$_SESSION['$projects$'])) {
		if (in_array($_POST['compilefile'],array_keys($_SESSION[strval($_GET['proj'])]['files']))) {
			if (in_array($_POST['outFile'],array_keys($_SESSION[strval($_GET['proj'])]['files'])) == false) {
					include 'config.php';
					include 'makeAssetsAPI.php';
					$folder = proj(strval($_GET['proj']));
					if ($folder ===false) {
						$success.='Swal.fire("Failed to make assets.")';
					}else{
						if ($_POST['compiler']== 'em++') {
							chdir($folder['folder']);
							$out;
							$code;
					                if($doSetPath){putenv("PATH=".$path_var);}
							exec($empp." ".$_POST['compilefile']." ".$_POST['compileropts']." ".' -o '.$_POST['outFile'],$out,$code);
							if ($code==0) {
								$success.='Swal.fire("Successfuly compiled file.")';
								$_SESSION[$_GET['proj']]['files'][$_POST['outFile']] = array("filename"=>$_POST['outFile'],"fileContents"=>base64_encode(file_get_contents($_POST['outFile'])),"isasset"=>true);
							}else{		
								$success.='Swal.fire(\'Failed to compile file, exit code \'+\"'.strval($code).'\"; Compiler log: \'+\"'.implode("\n",$out).'\")' ;
								//$success.='Swal.fire("Failed to compile file, exit code \'+\"'.strval($code).'\"; Compiler log: \"+'.implode("\\n",$out).'+''\"")';
							}
						}
					}
					//proj(strval($_GET['proj']))
			}else{
				$success.='Swal.fire("Output file already exists!")';
			}		
		}else{
			$success.='Swal.fire("File doesn\'t exist!")';
		}
	}else{
		$success.='Swal.fire("Project does\'n exist!");';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Make .WASM asset</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="editor-incl/bootstrap5.css">
	<script src="sweetalert2.min.js"></script>
</head>
<body>
	<div class="container" style="width:90vw; margin:auto; ">
	<form enctype="multipart/form-data" method="POST">
	<div class="form-group" style="margin-bottom: 2vh;">
		<label for="compiler">Compiler</label>
	<select id="compiler" class="form-select" name="compiler">
  	<option selected value="em++">em++(Emscripten for C++)</option>
  	<option value="emcc">emcc(Emscripten for C)</option>
  </select>
  </div>
  <div class="form-group" style="margin-bottom: 2vh;">
    <label for="compilerOpts">Compiler options</label>
    <input type="text" name="compileropts" class="form-control" id="compilerOpts" value="">
  </div>
  <div class="form-group" style="margin-bottom: 2vh;">
    <label for="compileFile">Compile file</label>
    <input type="text" name="compilefile" class="form-control" id="compileFile" value="<?php if(isset($_GET['compilefile'])){ echo htmlspecialchars($_GET['compilefile']); } ?>">
  </div>
  <div class="form-group" style="margin-bottom: 2vh;">
    <label for="outFile">Output file</label>
    <input type="text" name="outFile" class="form-control" id="outFile" value="<?php if(isset($_GET['compilefile'])){ echo htmlspecialchars(pathinfo(basename($_GET['compilefile']))['filename'].".wasm"); } ?>">
  </div>
  <button type="submit" class="btn btn-primary">Compile!</button>
</form>
</div>
<script>
<?php echo $success; ?>
</script>
</body>
</html>
