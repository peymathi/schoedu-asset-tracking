
<?php
	require_once "dbconnect.php";


	$name = $_GET['n'];
	$items = $_GET['i'];
	$formID = $_GET['f'];
	$serials = explode("+", $_GET['s']);
	$outDate = $_GET['o'];
	$inDate = $_GET['in'];


	for($c = 0; $c < count($serials); $c++)
	{
		$sql = $con->prepare("select AssetID from P_ASSETS where SerialNumber = ?");
		$sql->execute(array($serials[$c]));
		$id = $sql->fetchAll()[0];


		$sql = $con->prepare("insert into P_RENTAL_FORMS (AssetID, FormID, Name, outDate, inDate) values (?, ?, ?, ?, ?)");
		$sql->execute(array($id['AssetID'], $formID, $name, $outDate, $inDate));


	}

?>