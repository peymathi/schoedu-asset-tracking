<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];
    $stmt = $con->prepare("SELECT HideSurplus FROM P_ADMINS WHERE AdminID = :admin");
    $stmt->execute(array('admin' => $admin));
    $result = $stmt->fetch();

    $response = new stdClass();
    $response->hide = $result['HideSurplus'];

    $json = json_encode($response);

    echo $json;
  }
?>
