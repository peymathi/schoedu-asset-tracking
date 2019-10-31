<?php
  require_once 'dbconnect.php';

  session_start();
  if(isset($_SESSION['userid'])) {
    $category = filter_var($_GET['category'], FILTER_VALIDATE_INT);
    if($category == -1) {
      $category = "P_CATEGORIES.CategoryID";
    }
    $manufacturer = filter_var($_GET['manufacturer'], FILTER_VALIDATE_INT);
    if($manufacturer == -1) {
      $manufacturer = "P_MANUFACTURERS.ManufacturerID";
    }
    
    $stmt = $con->prepare("SELECT P_MODELS.ModelID
      FROM P_MODELS
      INNER JOIN P_CATEGORIES
        ON P_CATEGORIES.CategoryID = P_MODELS.CategoryID
      INNER JOIN P_MANUFACTURERS
        ON P_MANUFACTURERS.ManufacturerID = P_MODELS.ManufacturerID
      WHERE P_CATEGORIES.CategoryID = ".$category."
      AND P_MANUFACTURERS.ManufacturerID = ".$manufacturer);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $responseArray = array();
    foreach($result as $model) {
      array_push($responseArray, $model['ModelID']);
    }

    $response = new stdClass();
    $response->models = $responseArray;

    $json = json_encode($response);

    echo $json;
  }
?>
