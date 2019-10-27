<?php
  require_once 'dbconnect.php';

  $key = filter_var($_GET['key'], FILTER_VALIDATE_INT);
  $type = $_GET['type'];
  // get admin from session -Taylor
  $admin = 1;

  // you cant prepare a statement with variable tables so this is a little repetitive
  if($type == 'model') {
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
  }
?>
