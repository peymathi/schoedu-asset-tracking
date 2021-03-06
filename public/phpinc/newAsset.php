<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $stmt = $con->prepare("CALL SP_P_CREATE_ASSET (:admin, :model, :user, :serial, :network, :location, :purchase, :warranty, :notes)");
    $stmt->execute(array(
      'admin' => $admin,
      'model' => $_POST['model'],
      'user' => $_POST['user'],
      'serial' => $_POST['serial'],
      'network' => $_POST['network'],
      'location' => $_POST['location'],
      'purchase' => $_POST['purchase'],
      'warranty' => $_POST['warranty'],
      'notes' => $_POST['notes']
    ));
  }
?>
