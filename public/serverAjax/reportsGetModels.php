<?php

require_once "../phpinc/dbconnect.php";

// File to handle the ajax request for getting a list of models formatted to be used
//as options in a select element from a given manufacturer

// Get the input from request

$man = $_REQUEST['q'];
$response = "";

// Check if man is '- -'
if ($man == '- -')
{
  // Get all model names
  $sql = "SELECT Name FROM P_MODELS";
  $query = $con->prepare($sql);
  $query->execute(array($man));
  $models = $query->fetchAll(PDO::FETCH_NUM);

  // Add base option
  $response .= '<option>- -</option>';

  // Loop through each model given and format it accordingly
  foreach($models as $model)
  {
    $response .= '<option>';
    $response .= $model[0];
    $response .= '</option>';
  }
}

else
{
  // Get model names that only have the manufacturer given
  $sql = "
  SELECT Name FROM P_MODELS
  WHERE ManufacturerID IN
  (
    SELECT ManufacturerID FROM P_MANUFACTURERS
    WHERE Name = ?
  )
  ";
  $query = $con->prepare($sql);
  $query->execute(array($man));
  $models = $query->fetchAll(PDO::FETCH_NUM);

  // Add base option
  $response .= '<option>- -</option>';

  // Loop through each model given and format it accordingly
  foreach($models as $model)
  {
    $response .= '<option>';
    $response .= $model[0];
    $response .= '</option>';
  }
}

// Send the response to the client
echo $response;
?>
