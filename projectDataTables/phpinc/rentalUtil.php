<?php
	require_once "dbconnect.php";

	
	$res = "";
	global $con;
	$sql = $con->prepare("select Name from P_CATEGORIES order by Name");
	$sql->execute();
	$result = $sql->fetchAll();

	$res="<option hidden value='Category'>Category</option>";

	foreach ($result as $row)
	{ 
		$res = $res.'<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';

	}

	print $res;
?>