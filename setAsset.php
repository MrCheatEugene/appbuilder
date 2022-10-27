<?php

	if (isset($_GET['proj'])) {
		$project = strval($_GET['proj']);
		// code...
	}

	if (isset($_GET['fn'])) {
		$fn = $_GET['fn'];
		// code...
	}
	$isasset = 0;
	if (isset($_GET['isasset'])) {
		$isasset = boolval(intval($_GET['isasset']));
		// code...
	}
	if (isset($_SESSION[$project]) and in_array($fn,$_SESSION[$project]['files'])) {
		 		$_SESSION[$project]['files'][$fn]['fileContents'] = base64_encode($_SESSION[$project]['files'][$fn]['fileContents']);
		 		$_SESSION[$project]['files'][$fn]['isasset'] = true;
		 		die('{"success":1}');
		 	}
die('{"success":0}');
