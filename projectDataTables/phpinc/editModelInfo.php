<?php
  require_once "dbconnect.php";

  session_start();
  if(isset($_SESSION['userid'])) {
    $model = $_GET['model'];
    $category = $_GET['category'];
    $manufacturer = $_GET['manufacturer'];

    $stmt = $con->prepare('UPDATE P_MODELS SET CategoryID = :category, ManufacturerID = :manufacturer WHERE ModelID = :model');
    $stmt->execute(array('model' => $model, 'category' => $category, 'manufacturer' => $manufacturer));
  }
?>
