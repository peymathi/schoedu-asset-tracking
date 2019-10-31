<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $admin = $_SESSION['userid'];

    $stmt = $con->prepare('CALL SP_P_GET_ACTIVE_CATEGORIES (:admin)');
    $stmt->execute(array('admin' => $admin));

    $result = $stmt->fetchAll();

    foreach($result as $row) {
      echo '<option value="'.$row['CategoryID'].'">'.$row['Name'].'</option>';
    }
  }

?>
