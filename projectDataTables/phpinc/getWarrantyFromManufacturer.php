<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $manufacturer = $_GET['manufacturer'];
    $stmt = $con->prepare("SELECT Warranty FROM P_MANUFACTURERS WHERE P_MANUFACTURERS.ManufacturerID = :manufacturer");
    $stmt->execute(array('manufacturer' => $manufacturer));
    $result = $stmt->fetch();

    $response = new stdClass();
    $response->warranty = $result['Warranty'];

    $json = json_encode($response);

    echo $json;
  }
?>
