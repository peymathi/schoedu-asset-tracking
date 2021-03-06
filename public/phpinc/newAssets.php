<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $response = new stdClass();

    try {
      $request = json_decode(file_get_contents("php://input"));
      if(!isset($request->model)
        || !isset($request->user)
        || !isset($request->location)
        || !isset($request->warranty)
        || !isset($request->purchase)
        || !isset($request->details)) {

        throw new Exception("fields");
      }
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


      $response->status = "success";
    } catch(Exception $e) {
      $response->status = "error";
      $response->message = $e->getMessage();
    }

    echo json_encode($response);
  }
?>
