<?php
  require_once 'dbconnect.php';

  $modelStmt = $con->prepare('CALL SP_P_GET_USERS_HIDE (:admin)');
  // needs the actual admin id -Taylor
  $modelStmt->execute(array('admin' => 1));
  $modelResult = $modelStmt->fetchAll();

  foreach($modelResult as $row) {
    echo '<option value="'.$row['UserID'].'">'.$row['Name'];
    echo ($row['RuleID'] == NULL ? ' (shown)' : ' (hidden)');
    echo '</option>';
  }
?>
