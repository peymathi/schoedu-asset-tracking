<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $model = $_GET['model'];
    $stmt = $con->prepare("SELECT P_CATEGORIES.CategoryID, P_MANUFACTURERS.ManufacturerID
      FROM P_MODELS
      INNER JOIN P_CATEGORIES
        ON P_CATEGORIES.CategoryID = P_MODELS.CategoryID
      INNER JOIN P_MANUFACTURERS
        ON P_MANUFACTURERS.ManufacturerID = P_MODELS.ManufacturerID
      WHERE P_MODELS.ModelID = :model");
    $stmt->execute(array('model' => $model));
    $result = $stmt->fetch();

    $response = new stdClass();
    $response->category = $result['CategoryID'];
    $response->manufacturer = $result['ManufacturerID'];

    $json = json_encode($response);

    echo $json;
  }
?>
