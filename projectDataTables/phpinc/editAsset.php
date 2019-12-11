<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    echo $_POST['surplus'];

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

    $surplus = $_POST['surplus'] == "true";
    //echo $surplus;
    $surplusStmt = $con->prepare("UPDATE P_ASSETS SET IsSurplus = :surplus WHERE AssetID = :asset");
    $surplusStmt->bindValue(':surplus', $surplus, PDO::PARAM_BOOL);
    $surplusStmt->bindValue(':asset', $_POST['asset']);
    $surplusStmt->execute();
    //$surplusStmt->execute(array('surplus' => ($_POST['surplus'] ? "b'1'" : "b'0'"), 'asset' => $_POST['asset']));
  }
?>
