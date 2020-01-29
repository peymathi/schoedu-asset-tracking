<?php
  require_once "dbconnect.php";

  session_start();
  if(isset($_SESSION['userid'])) {
    $manufacturer = $_GET['manufacturer'];
    $warranty = $_GET['warranty'];

    echo $manufacturer;
    echo " ";
    echo $warranty;

    $stmt = $con->prepare('UPDATE P_MANUFACTURERS SET Warranty = :warranty WHERE ManufacturerID = :manufacturer');
    $stmt->execute(array('manufacturer' => $manufacturer, 'warranty' => $warranty));
  }
?>
