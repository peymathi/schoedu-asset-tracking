<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $stmt = $con->prepare('SELECT CheckDays AS c FROM P_ADMINS WHERE AdminID = :admin');
    $stmt->execute(array('admin' => $admin));
    $result = $stmt->fetch()['c'];

    echo $result;
  }
?>
