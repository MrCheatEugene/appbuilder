<?php 
if (isset($_GET['id'])) {
	$id = htmlspecialchars($_GET['id']);
}
if (isset($_GET['fn'])) {
	$fn = htmlspecialchars($_GET['fn']);
}

if (isset($_GET['proj'])) {
	$proj = htmlspecialchars(strval($_GET['proj']));
}

?>
<head>
	<link rel="stylesheet" href="editor-incl/all.css">
	<link rel="stylesheet" href="editor-incl/bootstrap-cosmo.css">
	<link rel="stylesheet" href="editor-incl/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="editor-incl/index.css">
	<script src="editor-incl/bootstrap.min.js"></script>
    <script src="editor-incl/jquery-1.9.1.min.js"></script>
	<script src="editor-incl/bootstrap-select.min.js"></script>
	<script src="editor-incl/loader.js"></script>
	<script src="editor-incl/editor.main.css"></script>
    <script src="editor-incl/require.js"></script>
    <script src="index.js.php?id=<?php echo $id;?>&fn=<?php echo $fn;?>&proj=<?php echo $proj;?>"></script>
</head>
<body>
<div> 
<section class="try">
		<div class="container">
			<div class="editor">
				<div class="span9">
					<div class="row">
						<div class="span4">
							<label class="control-label">Language</label>
							<select class="language-picker">
							</select>
						</div>
						<div class="span4">
							<label class="control-label">Theme</label>
							<select class="theme-picker">
								<option>Visual Studio</option>
								<option>Visual Studio Dark</option>
								<option>High Contrast Dark</option>
							</select>
						</div>
					</div>
					<div class="editor-frame">
						<div class="loading editor" style="display: none;">
							<div class="progress progress-striped active">
								<div class="bar"></div>
							</div>
						</div>
						<div id="editor"></div>
					</div>
				</div>
			</div>
   </div>
   </section>
</div>
</body>