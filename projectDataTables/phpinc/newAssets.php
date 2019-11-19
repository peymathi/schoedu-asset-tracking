<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $request = json_decode(file_get_contents("php://input"));
    $model = $request->model;
    $user = $request->user;
    $location = $request->location;
    $warranty = $request->warranty;
    $purchase = $request->purchase;
    $details = $request->details;

    $stmt = $con->prepare("CALL SP_P_CREATE_ASSET (:admin, :model, :user, :serial, :network, :location, :purchase, :warranty, :notes)");

    foreach($details as $detail) {
      $network = $detail->network;
      $serial = $detail->serial;
      $notes = $detail->notes;

      $stmt->execute(array(
        'admin' => $admin,
        'model' => $model,
        'user' => $user,
        'serial' => $serial,
        'network' => $network,
        'location' => $location,
        'purchase' => $purchase,
        'warranty' => $warranty,
        'notes' => $notes
      ));
    }

  }
?>
