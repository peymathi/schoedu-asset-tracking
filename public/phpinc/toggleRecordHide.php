<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];
    $key = filter_var($_GET['key'], FILTER_VALIDATE_INT);
    $type = $_GET['type'];

    // you cant prepare a statement with variable tables so this is a little repetitive
    if($type == 'category') {
      $countStmt = $con->prepare('SELECT COUNT(*) AS c FROM P_HIDE_CATEGORY_RULES WHERE CategoryID = :key AND AdminID = :admin');
      $countStmt->execute(array('admin' => $admin, 'key' => $key));
      $count = $countStmt->fetch()['c'];
      $shown = $count == 0;

      if($shown) {
        echo 'inserting...';
        $insertStmt = $con->prepare('INSERT INTO P_HIDE_CATEGORY_RULES (AdminID, CategoryID, UpdatedAt) VALUES (:admin, :key, NOW())');
        $insertStmt->execute(array('admin' => $admin, 'key' => $key));
      } else {
        echo 'deleting...';
        $deleteStmt = $con->prepare('DELETE FROM P_HIDE_CATEGORY_RULES WHERE AdminID = :admin AND CategoryID = :key');
        $deleteStmt->execute(array('admin' => $admin, 'key' => $key));
      }
    } else if($type == 'manufacturer') {
      $countStmt = $con->prepare('SELECT COUNT(*) AS c FROM P_HIDE_MANUFACTURER_RULES WHERE ManufacturerID = :key AND AdminID = :admin');
      $countStmt->execute(array('admin' => $admin, 'key' => $key));
      $count = $countStmt->fetch()['c'];
      $shown = $count == 0;

      if($shown) {
        echo 'inserting...';
        $insertStmt = $con->prepare('INSERT INTO P_HIDE_MANUFACTURER_RULES (AdminID, ManufacturerID, UpdatedAt) VALUES (:admin, :key, NOW())');
        $insertStmt->execute(array('admin' => $admin, 'key' => $key));
      } else {
        echo 'deleting...';
        $deleteStmt = $con->prepare('DELETE FROM P_HIDE_MANUFACTURER_RULES WHERE AdminID = :admin AND ManufacturerID = :key');
        $deleteStmt->execute(array('admin' => $admin, 'key' => $key));
      }
    } else if($type == 'model') {
      $countStmt = $con->prepare('SELECT COUNT(*) AS c FROM P_HIDE_MODEL_RULES WHERE ModelID = :key AND AdminID = :admin');
      $countStmt->execute(array('admin' => $admin, 'key' => $key));
      $count = $countStmt->fetch()['c'];
      $shown = $count == 0;

      if($shown) {
        echo 'inserting...';
        $insertStmt = $con->prepare('INSERT INTO P_HIDE_MODEL_RULES (AdminID, ModelID, UpdatedAt) VALUES (:admin, :key, NOW())');
        $insertStmt->execute(array('admin' => $admin, 'key' => $key));
      } else {
        echo 'deleting...';
        $deleteStmt = $con->prepare('DELETE FROM P_HIDE_MODEL_RULES WHERE AdminID = :admin AND ModelID = :key');
        $deleteStmt->execute(array('admin' => $admin, 'key' => $key));
      }
    } else if($type == 'user') {
      $countStmt = $con->prepare('SELECT COUNT(*) AS c FROM P_HIDE_USER_RULES WHERE UserID = :key AND AdminID = :admin');
      $countStmt->execute(array('admin' => $admin, 'key' => $key));
      $count = $countStmt->fetch()['c'];
      $shown = $count == 0;

      if($shown) {
        echo 'inserting...';
        $insertStmt = $con->prepare('INSERT INTO P_HIDE_USER_RULES (AdminID, UserID, UpdatedAt) VALUES (:admin, :key, NOW())');
        $insertStmt->execute(array('admin' => $admin, 'key' => $key));
      } else {
        echo 'deleting...';
        $deleteStmt = $con->prepare('DELETE FROM P_HIDE_USER_RULES WHERE AdminID = :admin AND UserID = :key');
        $deleteStmt->execute(array('admin' => $admin, 'key' => $key));
      }
    } else if($type == 'location') {
      $countStmt = $con->prepare('SELECT COUNT(*) AS c FROM P_HIDE_LOCATION_RULES WHERE LocationID = :key AND AdminID = :admin');
      $countStmt->execute(array('admin' => $admin, 'key' => $key));
      $count = $countStmt->fetch()['c'];
      $shown = $count == 0;

      if($shown) {
        echo 'inserting...';
        $insertStmt = $con->prepare('INSERT INTO P_HIDE_LOCATION_RULES (AdminID, LocationID, UpdatedAt) VALUES (:admin, :key, NOW())');
        $insertStmt->execute(array('admin' => $admin, 'key' => $key));
      } else {
        echo 'deleting...';
        $deleteStmt = $con->prepare('DELETE FROM P_HIDE_LOCATION_RULES WHERE AdminID = :admin AND LocationID = :key');
        $deleteStmt->execute(array('admin' => $admin, 'key' => $key));
      }
    }
  }
?>
