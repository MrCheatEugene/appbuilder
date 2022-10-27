<?php 
session_start();
$success = "";
if (isset($_GET['proj']) && isset($_POST['fn']) && isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
	if (in_array(strval($_GET['proj']),$_SESSION['$projects$'])) {
		if (isset($_SESSION[strval($_GET['proj'])]['files']) == false) {
			$_SESSION[strval($_GET['proj'])]['files'] = array();
		}
		if (isset($_SESSION[strval($_GET['proj'])]['files'])) {
		$_SESSION[strval($_GET['proj'])]['files'][strval($_POST['fn'])]=array("filename"=>strval($_POST['fn']),"fileContents"=>base64_encode(file_get_contents($_FILES['file']['tmp_name'])),"isasset"=>true);
		$success = '
<script>
	window.top.openProj(\''.strval($_GET['proj']).'\');
	window.top.Swal.fire("Success!");
</script>
		';
		}	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Upload asset</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="editor-incl/bootstrap5.css">
	<script src="sweetalert2.min.js"></script>
</head>
<body>
	<div class="container" style="width:90vw; margin:auto; ">
	<form enctype="multipart/form-data" method="POST">
  <div class="form-group"style="margin-bottom: 1vh;">
    <label for="assetFileName">Filename</label>
    <input type="text" name="fn" class="form-control" id="assetFileName" placeholder="main.wasm">
  </div>
  <div class="form-group" style="margin-bottom: 2vh;">
    <label for="assetFile">Asset file</label>
    <input type="file" name="file" class="form-control" id="assetFile">
  </div>
  <button type="submit" class="btn btn-primary">Upload</button>
</form>
</div>
<?php echo $success; ?>
</body>
</html>