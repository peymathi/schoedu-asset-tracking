<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $response = new stdClass();

    try {
      if(!isset($_GET['name']) || !isset($_GET['type'])) {
        throw new Exception("fields");
      }

      $name = $_GET['name'];
      $type = $_GET['type'];

      $tablename = "";

      if($type == "category") {
        $tablename = "P_CATEGORIES";
      } else if($type == "manufacturer") {
        $tablename = "P_MANUFACTURERS";
      } else if($type == "model") {
        $tablename = "P_MODELS";
      } else if($type == "user") {
        $tablename = "P_USERS";
      } else if($type == "location") {
        $tablename = "P_LOCATIONS";
      }

      if($tablename == "") {
        throw new Exception("table");
      }

      $stmt = $con->prepare("SELECT 1 FROM ".$tablename." WHERE Name = :name");
      $stmt->execute(array("name" => $name));
      $exist = $stmt->rowCount() == 1;

      $response->status = "success";
      $response->exists = $exist;
    } catch(Exception $e) {
      $response->status = "error";
      $response->message = $e->getMessage();
    }

    echo json_encode($response);
  }

?>
