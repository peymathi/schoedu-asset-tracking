<?php
  require_once 'dbconnect.php';

  //get the admin id from session of some sort
  $admin = 1;

  $stmt = $con->prepare('SELECT CheckDays AS c FROM P_ADMINS WHERE AdminID = :admin');
  $stmt->execute(array('admin' => $admin));
  $result = $stmt->fetch()['c'];

  echo $result;
?>
