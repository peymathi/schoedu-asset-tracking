<?php
  require_once "dbconnect.php";

  session_start();
  if(isset($_SESSION['userid'])) {
    $type = $_GET['type'];
    $key = $_GET['key'];
    $name = $_GET['name'];

    $tables = array('category' => 'P_CATEGORIES', 'manufacturer' => 'P_MANUFACTURERS', 'model' => 'P_MODELS', 'user' => 'P_USERS', 'location' => 'P_LOCAITONS');
    $ids = array('category' => 'CategoryID', 'manufacturer' => 'ManufacturerID', 'model' => 'ModelID', 'user' => 'UserID', 'location' => 'LocationID');

    if(array_key_exists($type, $tables)) {
      $stmt = $con->prepare('UPDATE '.$tables[$type].' SET Name = :name WHERE '.$ids[$type].' = :key');
      $stmt->execute(array('name' => $name, 'key' => $key));
    }
  }
?>
