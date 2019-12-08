
<?php
	require_once "dbconnect.php";


	$formID = $_GET['f'];

	$sql = $con->prepare("update P_RENTAL_FORMS set Status = ? where FormID = ?");
    $sql->execute(array('Complete', $formID));


?>