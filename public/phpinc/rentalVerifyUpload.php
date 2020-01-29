<?php 
	require_once "dbconnect.php";

	$f = $_GET['f'];

	$sql = $con->prepare("select distinct FormID from P_RENTAL_FORMS where FormID = ?");
	$sql->execute(array($f));
	$a =$sql->fetchAll();


	if(count($a) == 0)
	{
		echo '0';
	}
	else
	{
		echo '1';
	}



?>