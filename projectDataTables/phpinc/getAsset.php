<?php
  require_once "dbconnect.php";

  session_start();
  if(isset($_SESSION['userid'])) {
    $stmt = $con->prepare("CALL SP_P_GET_ASSET (:asset)");
    $stmt->execute(array('asset' => $_GET['asset']));
    $result = $stmt->fetch();

    $response = new stdClass();
    $response->asset = $result;

    $json = json_encode($response);

    echo $json;
  }
?>
