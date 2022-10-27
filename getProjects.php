<?php
header("Content-Type: application/json"); 
session_start();

	if (isset($_SESSION['$projects$']) == false) {
		$_SESSION['$projects$'] = array();
	}
echo json_encode($_SESSION['$projects$']);