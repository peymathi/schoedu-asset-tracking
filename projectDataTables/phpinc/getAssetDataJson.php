<?php
  require_once 'dbconnect.php';

  // check for auth
  $admin = 1;

  $draw = $_GET['draw'];
  $start = (int)$_GET['start'];
  $length = (int)$_GET['length'];
  $search = $_GET['search']['value'];

  $order = "NULL";

  $assetStmt = $con->prepare("SELECT
    P_ASSETS.AssetID,
    P_ASSETS.SerialNumber,
    P_CATEGORIES.Name AS Category,
    P_MANUFACTURERS.Name AS Manufacturer,
    P_MODELS.Name AS Model,
    P_LOCATIONS.Name AS Location,
    P_USERS.Name AS User
  FROM P_ASSETS
  INNER JOIN P_MODELS
    ON P_MODELS.ModelID = P_ASSETS.ModelID
  INNER JOIN P_CATEGORIES
    ON P_CATEGORIES.CategoryID = P_MODELS.CategoryID
  INNER JOIN P_MANUFACTURERS
    ON P_MANUFACTURERS.ManufacturerID = P_MODELS.ManufacturerID
  INNER JOIN P_LOCATIONS
    ON P_LOCATIONS.LocationID = P_ASSETS.LocationID
  INNER JOIN P_USERS
    ON P_USERS.UserID = P_ASSETS.UserID
  LEFT JOIN P_HIDE_CATEGORY_RULES
    ON P_HIDE_CATEGORY_RULES.CategoryID = P_CATEGORIES.CategoryID
    AND P_HIDE_CATEGORY_RULES.AdminID = :admin
  LEFT JOIN P_HIDE_LOCATION_RULES
    ON P_HIDE_LOCATION_RULES.LocationID = P_LOCATIONS.LocationID
    AND P_HIDE_LOCATION_RULES.AdminID = :admin
  LEFT JOIN P_HIDE_MANUFACTURER_RULES
    ON P_HIDE_MANUFACTURER_RULES.ManufacturerID = P_MANUFACTURERS.ManufacturerID
    AND P_HIDE_MANUFACTURER_RULES.AdminID = :admin
  LEFT JOIN P_HIDE_MODEL_RULES
    ON P_HIDE_MODEL_RULES.ModelID = P_MODELS.ModelID
    AND P_HIDE_MODEL_RULES.AdminID = :admin
  LEFT JOIN P_HIDE_USER_RULES
    ON P_HIDE_USER_RULES.UserID = P_USERS.UserID
    AND P_HIDE_USER_RULES.AdminID = :admin
  WHERE
    (
      P_HIDE_CATEGORY_RULES.RuleID IS NULL
      AND P_HIDE_LOCATION_RULES.RuleID IS NULL
      AND P_HIDE_MANUFACTURER_RULES.RuleID IS NULL
      AND P_HIDE_MODEL_RULES.RuleID IS NULL
      AND P_HIDE_USER_RULES.RuleID IS NULL
    )
    AND
    (
      P_ASSETS.SerialNumber LIKE CONCAT( :search , '%' )
      OR P_CATEGORIES.Name LIKE CONCAT( :search , '%' )
      OR P_MANUFACTURERS.Name LIKE CONCAT( :search , '%' )
      OR P_MODELS.Name LIKE CONCAT( :search , '%' )
      OR P_LOCATIONS.Name LIKE CONCAT( :search , '%' )
      OR P_USERS.Name LIKE CONCAT( :search , '%' )
    )
  LIMIT :length
  OFFSET :startindex"); // order has to be generated/stored outside pdo

  $assetStmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
  $assetStmt->bindValue(':startindex', (int)$start, PDO::PARAM_INT);
  $assetStmt->bindValue(':admin', $admin);
  $assetStmt->bindValue(':search', $search);
  $assetStmt->execute();
  $result = $assetStmt->fetchAll();

  $totalStmt = $con->prepare("SELECT
    COUNT(*) AS c FROM P_ASSETS
    INNER JOIN P_MODELS
      ON P_MODELS.ModelID = P_ASSETS.ModelID
    INNER JOIN P_CATEGORIES
      ON P_CATEGORIES.CategoryID = P_MODELS.CategoryID
    INNER JOIN P_MANUFACTURERS
      ON P_MANUFACTURERS.ManufacturerID = P_MODELS.ManufacturerID
    INNER JOIN P_LOCATIONS
      ON P_LOCATIONS.LocationID = P_ASSETS.LocationID
    INNER JOIN P_USERS
      ON P_USERS.UserID = P_ASSETS.UserID
    LEFT JOIN P_HIDE_CATEGORY_RULES
      ON P_HIDE_CATEGORY_RULES.CategoryID = P_CATEGORIES.CategoryID
      AND P_HIDE_CATEGORY_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_LOCATION_RULES
      ON P_HIDE_LOCATION_RULES.LocationID = P_LOCATIONS.LocationID
      AND P_HIDE_LOCATION_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_MANUFACTURER_RULES
      ON P_HIDE_MANUFACTURER_RULES.ManufacturerID = P_MANUFACTURERS.ManufacturerID
      AND P_HIDE_MANUFACTURER_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_MODEL_RULES
      ON P_HIDE_MODEL_RULES.ModelID = P_MODELS.ModelID
      AND P_HIDE_MODEL_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_USER_RULES
      ON P_HIDE_USER_RULES.UserID = P_USERS.UserID
      AND P_HIDE_USER_RULES.AdminID = :admin
    WHERE
      (
        P_HIDE_CATEGORY_RULES.RuleID IS NULL
        AND P_HIDE_LOCATION_RULES.RuleID IS NULL
        AND P_HIDE_MANUFACTURER_RULES.RuleID IS NULL
        AND P_HIDE_MODEL_RULES.RuleID IS NULL
        AND P_HIDE_USER_RULES.RuleID IS NULL
      )");

  $totalStmt->execute(array('admin' => $admin));
  $total = $totalStmt->fetch()['c'];

  $countStmt = $con->prepare("SELECT COUNT(*) AS c
    FROM P_ASSETS
    INNER JOIN P_MODELS
      ON P_MODELS.ModelID = P_ASSETS.ModelID
    INNER JOIN P_CATEGORIES
      ON P_CATEGORIES.CategoryID = P_MODELS.CategoryID
    INNER JOIN P_MANUFACTURERS
      ON P_MANUFACTURERS.ManufacturerID = P_MODELS.ManufacturerID
    INNER JOIN P_LOCATIONS
      ON P_LOCATIONS.LocationID = P_ASSETS.LocationID
    INNER JOIN P_USERS
      ON P_USERS.UserID = P_ASSETS.UserID
    LEFT JOIN P_HIDE_CATEGORY_RULES
      ON P_HIDE_CATEGORY_RULES.CategoryID = P_CATEGORIES.CategoryID
      AND P_HIDE_CATEGORY_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_LOCATION_RULES
      ON P_HIDE_LOCATION_RULES.LocationID = P_LOCATIONS.LocationID
      AND P_HIDE_LOCATION_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_MANUFACTURER_RULES
      ON P_HIDE_MANUFACTURER_RULES.ManufacturerID = P_MANUFACTURERS.ManufacturerID
      AND P_HIDE_MANUFACTURER_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_MODEL_RULES
      ON P_HIDE_MODEL_RULES.ModelID = P_MODELS.ModelID
      AND P_HIDE_MODEL_RULES.AdminID = :admin
    LEFT JOIN P_HIDE_USER_RULES
      ON P_HIDE_USER_RULES.UserID = P_USERS.UserID
      AND P_HIDE_USER_RULES.AdminID = :admin
    WHERE
      (
        P_HIDE_CATEGORY_RULES.RuleID IS NULL
        AND P_HIDE_LOCATION_RULES.RuleID IS NULL
        AND P_HIDE_MANUFACTURER_RULES.RuleID IS NULL
        AND P_HIDE_MODEL_RULES.RuleID IS NULL
        AND P_HIDE_USER_RULES.RuleID IS NULL
      )
      AND
      (
        P_ASSETS.SerialNumber LIKE CONCAT( :search , '%' )
        OR P_CATEGORIES.Name LIKE CONCAT( :search , '%' )
        OR P_MANUFACTURERS.Name LIKE CONCAT( :search , '%' )
        OR P_MODELS.Name LIKE CONCAT( :search , '%' )
        OR P_LOCATIONS.Name LIKE CONCAT( :search , '%' )
        OR P_USERS.Name LIKE CONCAT( :search , '%' )
      )");

  $countStmt->execute(array('admin' => $admin, 'search' => $search));
  $count = $countStmt->fetch()['c'];

  $formattedResult = array();

  foreach($result as $row) {
    $formattedRow = array($row['AssetID'], $row['SerialNumber'], $row['Category'], $row['Manufacturer'], $row['Model'], $row['Location'], $row['User']);
    array_push($formattedResult, $formattedRow);
  }

  $response = new stdClass();
  $response->draw = $draw;
  $response->recordsTotal = $total;
  $response->recordsFiltered = $count;
  $response->data = $formattedResult;

  $json = json_encode($response);

  echo $json;
?>
