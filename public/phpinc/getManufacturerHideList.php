<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];
    $modelStmt = $con->prepare('CALL SP_P_GET_MANUFACTURERS_HIDE (:admin)');

    $modelStmt->execute(array('admin' => $admin));
    $modelResult = $modelStmt->fetchAll();

    foreach($modelResult as $row) {
      echo '<option value="'.$row['ManufacturerID'].'">'.$row['Name'];
      echo ($row['RuleID'] == NULL ? ' (shown)' : ' (hidden)');
      echo '</option>';
    }
  }
?>
