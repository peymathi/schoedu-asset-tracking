<?php
  require_once 'dbconnect.php';

  //get the admin from somewhere -Taylor
  $admin = 1;

  $stmt = $con->prepare('CALL SP_P_GET_ACTIVE_MANUFACTURERS (:admin)');
  $stmt->execute(array('admin' => $admin));

  $result = $stmt->fetchAll();

  foreach($result as $row) {
    echo '<option value="'.$row['ManufacturerID'].'">'.$row['Name'].'</option>';
  }
?>
