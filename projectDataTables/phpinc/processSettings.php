<?php
  require_once 'dbconnect.php';

  //some kind of auth check needs to happen here
  $admin = 1;

  $type = $_POST['type'];

  if($type == 'manufacturer') {
    $manufacturerStmt = $con->prepare('INSERT INTO P_MANUFACTURERS (Name, UpdatedAt) VALUES (:name, NOW())');
    $manufacturerStmt->execute(array('name' => $_POST['name']));
  } else if($type == 'model') {
    // ui has no way to select category, default to desktop
    $modelStmt = $con->prepare('INSERT INTO P_MODELS (Name, ManufacturerID, CategoryID, UpdatedAt) VALUES (:name, :manufacturer, 2, NOW())');
    $modelStmt->execute(array('name' => $_POST['name'], 'manufacturer' => $_POST['manufacturer']));
  } else if($type == 'location') {
    $locationStmt = $con->prepare('INSERT INTO P_LOCATIONS (Name, UpdatedAt) VALUES (:name, NOW())');
    $locationStmt->execute(array('name' => $_POST['name']));
  } else if($type == 'user') {
    $userStmt = $con->prepare('INSERT INTO P_USERS (Name, UpdatedAt) VALUES (:name, NOW())');
    $userStmt->execute(array('name' => $_POST['name']));
  } else if($type == 'daysChecked') {
    $daysStmt = $con->prepare('UPDATE P_ADMINS SET CheckDays = :days WHERE AdminID = :admin');
    $daysStmt->execute(array('days' => $_POST['days'], 'admin' => $admin));
  }
?>
