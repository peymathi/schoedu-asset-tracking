<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $type = $_POST['type'];

    if($type == 'category') {
      $categoryStmt = $con->prepare('INSERT INTO P_CATEGORIES (Name, UpdatedAt) VALUES (:name, NOW())');
      $categoryStmt->execute(array('name' => $_POST['name']));
    } else if($type == 'manufacturer') {
      $manufacturerStmt = $con->prepare('INSERT INTO P_MANUFACTURERS (Name, Warranty, UpdatedAt) VALUES (:name, :warranty, NOW())');
      $manufacturerStmt->execute(array('name' => $_POST['name'], 'warranty' => $_POST['warranty']));
    } else if($type == 'model') {
      $modelStmt = $con->prepare('INSERT INTO P_MODELS (Name, ManufacturerID, CategoryID, UpdatedAt) VALUES (:name, :manufacturer, :category, NOW())');
      $modelStmt->execute(array('name' => $_POST['name'], 'manufacturer' => $_POST['manufacturer'], 'category' => $_POST['category']));
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
  }
?>
