<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];
    $modelStmt = $con->prepare('CALL SP_P_GET_MODELS_HIDE (:admin)');
    // needs the actual admin id -Taylor
    $modelStmt->execute(array('admin' => $admin));
    $modelResult = $modelStmt->fetchAll();

    foreach($modelResult as $row) {
      echo '<option value="'.$row['ModelID'].'">'.$row['Manufacturer'].' '.$row['Model'];
      echo ($row['RuleID'] == NULL ? ' (shown)' : ' (hidden)');
      echo '</option>';
    }
  }
?>
