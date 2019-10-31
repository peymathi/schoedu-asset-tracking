<?php
	require_once "dbconnect.php";

	
	$res = "";
	global $con;
	$sql = $con->prepare("select Name from P_CATEGORIES order by Name");
	$sql->execute();
	$result = $sql->fetchAll();

	foreach ($result as $row)
	{ 
		$res = $res.'<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';

	}

	print $res;
?>