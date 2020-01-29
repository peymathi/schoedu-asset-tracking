<?php

	require_once "dbconnect.php";


	$d = $_GET['d'];//datetime
	$s = $_GET['s'];//serial

	//update last checked date
	$sql = $con->prepare("update P_ASSETS set DateLastChecked = ? where SerialNumber = ?");
	$sql->execute(array($d, $s));


?>