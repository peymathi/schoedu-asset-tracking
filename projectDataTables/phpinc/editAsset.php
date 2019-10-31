<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $stmt = $con->prepare("CALL SP_P_EDIT_ASSET (:model, :user, :serial, :network, :location, :purchase, :warranty, :notes, :asset)");
    $stmt->execute(array(
      'model' => $_POST['model'],
      'user' => $_POST['user'],
      'serial' => $_POST['serial'],
      'network' => $_POST['network'],
      'location' => $_POST['location'],
      'purchase' => $_POST['purchase'],
      'warranty' => $_POST['warranty'],
      'notes' => $_POST['notes'],
      'asset' => $_POST['asset']
    ));
  }
?>
