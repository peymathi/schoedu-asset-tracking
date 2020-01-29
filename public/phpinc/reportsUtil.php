<?php

/* Utility functions and classes for reports.php */
require_once "dbconnect.php";

/* Class to handle form data in reports.php */
class ReportsForm
{

  private $queryData;
  private $con;
  private $man;
  private $cat;
  private $mod;
  private $loc;
  private $u;
  private $net;
  private $sur;
  private $exp;

  public function __construct($con, $man = '- -', $cat = '- -', $mod = '- -', $loc = '- -', $u = '- -', $net = '- -', $sur = False, $exp = False)
  {
    $this->con = $con;
    $this->man = $man;
    $this->cat = $cat;
    $this->mod = $mod;
    $this->loc = $loc;
    $this->u = $u;
    $this->net = $net;
    $this->sur = $sur;
    $this->exp = $exp;
  }

  public function queryDB()
  {
    $isFilters = False;
    $sqlArray = array();

    // Query the data base with the data given and store the query in queryData
    // Variable to hold sql to be prepared
    $sql = "SELECT * FROM PV_ASSET_REPORTS WHERE ";

    // Hide surplus unless showing surplus is needed
    if (!$this->sur)
    {
      $sql .= "IsSurplus = FALSE AND ";
    }

    // Add more where conditions onto the sql statements based on the variables inputted
    if ($this->man != '- -')
    {
      $sql .= "ManufacturerName = ? AND ";
      array_push($sqlArray, $this->man);
    }

    if ($this->cat != '- -')
    {
      $sql .= "CategoryName = ? AND ";
      array_push($sqlArray, $this->cat);
    }

    if ($this->mod != '- -')
    {
      $sql .= "ModelName = ? AND ";
      array_push($sqlArray, $this->mod);
    }

    if ($this->loc != '- -')
    {
      $sql .= "LocationName = ? AND ";
      array_push($sqlArray, $this->loc);
    }

    if ($this->u != '- -')
    {
      $sql .= "UserName = ? AND ";
      array_push($sqlArray, $this->u);
    }

    if ($this->net != '- -')
    {
      $sql .= "NetworkName = ? AND ";
      array_push($sqlArray, $this->net);
    }

    if ($this->exp)
    {
      $sql .= "DATEDIFF(WarrantyEnd, now()) <= 0 AND ";
    }

    $sql = substr_replace($sql, "", -4);
    $sql = trim($sql);

    $query = $this->con->prepare($sql);
    $query->execute($sqlArray);
    $this->queryData = $query->fetchAll(PDO::FETCH_ASSOC);
  }

  // Gets raw data based on query
  public function getRaw()
  {
    return $this->queryData;
  }

  // Gets data based on query and formats it to be put into the data table.
  // Optional parameter to take in a data query
  public function getTableData($dataQuery = NULL)
  {
    // Check if $dataQuery is not null
    if ($dataQuery != NULL)
    {
      $this->queryData = $dataQuery;
    }

    $tableData = "";

    // Loop through all of the records
    foreach($this->queryData as $record)
    {
      $tableData .= "<tr>";

      // Serial Number
      $tableData .= '<td>';
      $tableData .= $record['SerialNumber'];
      $tableData .= '</td>';

      // Network Name
      $tableData .= '<td>';
      if(trim($record['NetworkName']) != '') $record['NetworkName'];
      else $tableData .= 'None';
      $tableData .= '</td>';

      // Category
      $tableData .= '<td>';
      $tableData .= $record['CategoryName'];
      $tableData .= '</td>';

      // Manufacturer
      $tableData .= '<td>';
      $tableData .= $record['ManufacturerName'];
      $tableData .= '</td>';

      // Model
      $tableData .= '<td>';
      $tableData .= $record['ModelName'];
      $tableData .= '</td>';

      // Location
      $tableData .= '<td>';
      $tableData .= $record['LocationName'];
      $tableData .= '</td>';

      //Purchase Date
      $tableData .= '<td>';
      $tableData .= $record['PurchaseDate'];
      $tableData .= '</td>';

      // Add the user to the data table (6)
      $tableData .= "<td>";
      $tableData .= $record['UserName'];
      $tableData .= "</td>";

      // Format the surplus boolean (7)
      $tableData .= "<td>";

      if ($record['IsSurplus'])
      {
        $tableData .= "Y";
      }

      else
      {
        $tableData .= "N";
      }

      $tableData .= "</td>";

      // Decide whether the warranty has expired or not (8)
      $tableData .= "<td>";

      if ($record['WarrantyEnd'] != NULL)
      {
        $warrantyDate = date_create($record['WarrantyEnd']);
        $currentDate = date_create();
        $diff = date_diff($warrantyDate, $currentDate);
        $diff = $diff->format("%a");

        if($diff <= 0)
        {
            $tableData .= "Y";
        }

        else
        {
          $tableData .= "N";
        }
      }

      else
      {
        $tableData .= "N/A";
      }

      $tableData .= "</td>";


      $tableData .= "</tr>";
    }

    return $tableData;
  }
}

// Function for writing a CSV based on a data query string
function printCSV($data, $location)
{

  // Delete a file at that location if there already is one
  if (file_exists($location))
  {
    unlink($location);
  }

  // Open a new file at the location in write mode
  $file = fopen($location, "w");

  // Print a line with the list of column names
  $formatString = "SerialNumber, NetworkName, Category, Manufacturer, Model, Location, PurchaseDate, User, IsSurplus, WarrantyEnd";
  $formatString .= PHP_EOL;

  // Loop through the data query and format each record to be added to the format string
  foreach($data as $record)
  {
    // Loop until the user name comes up
    foreach($record as $column)
    {
      if ($column === $record['UserName']) break;
      if(trim($column) === '') $formatString .= 'N/A' . ',';
      else $formatString .= $column . ',';
    }
    $formatString .= $record['LocationName'] . ',';
    $formatString .= $record['PurchaseDate'] . ',';
    $formatString .= '"' . $record['UserName'] . '"' . ',';
    $formatString .= $record['IsSurplus'] . ',' . $record['WarrantyEnd'] . PHP_EOL;
  }

  // Write the data to the file
  fwrite($file, $formatString);

  // Close the file
  fclose($file);
}

//Function to get the list of categories from the DB that are not hidden
function getCategories($con)
{
  $sql =
  "
  SELECT Name FROM P_CATEGORIES
  WHERE CategoryID NOT IN
  (
    SELECT CategoryID FROM P_HIDE_CATEGORY_RULES
    )
  ";
  $query = $con->prepare($sql);
  $query->execute();
  $categories = $query->fetchAll(PDO::FETCH_NUM);

  // Convert the 2d array to 1d
  $catArr = array();
  foreach($categories as $cat)
  {
    array_push($catArr, $cat[0]);
  }

  return $catArr;
}

// Function to get the list of manufacturers from the DB where manufacturer is not hidden
function getManufacturers($con)
{
  $sql =
  "
  SELECT Name FROM P_MANUFACTURERS
  WHERE ManufacturerID NOT IN
  (
    SELECT ManufacturerID FROM P_HIDE_MANUFACTURER_RULES
    )
  ";

  $query = $con->prepare($sql);
  $query->execute();
  $manufacturers = $query->fetchAll(PDO::FETCH_NUM);

  $manArr = array();

  // Convert the 2d array to 1d
  foreach($manufacturers as $man)
  {
      array_push($manArr, $man[0]);
  }

  return $manArr;
}

// Function to get the list of model names that belong to a category and manufacturer
// and are not hidden
function getModels($con, $category, $manufacturer)
{
  $sql = "
  SELECT Name FROM P_MODELS
  WHERE CategoryID IN
  (
    SELECT CategoryID FROM P_CATEGORIES
    WHERE Name = ?
    )
  AND ManufacturerID IN
  (
    SELECT ManufacturerID FROM P_MANUFACTURERS
    WHERE Name = ?
    )
  AND ModelID NOT IN
  (
    SELECT ModelID FROM P_HIDE_MODEL_RULES
    )
  ";

  $query = $con->prepare($sql);
  $query->execute(array($category, $manufacturer));
  $models = $query->fetchAll(PDO::FETCH_NUM);

  // Convert the 2d array to 1d
  $modArr = array();

  foreach($models as $mod)
  {
    array_push($modArr, $mod[0]);
  }

  return $modArr;
}

// Function to get a count from a category name
function countCategory($con, $category)
{
  $sql =
  "
  SELECT count(*) as c FROM PV_ASSET_REPORTS
  WHERE IsSurplus = 0
  AND CategoryName = ?
  ";

  $query = $con->prepare($sql);
  $query->execute(array($category));
  $count = $query->fetch(PDO::FETCH_OBJ);
  return $count->c;
}

// Function to get a count based on category name and manufacturer name
function countCatMan($con, $category, $manufacturer)
{
  $sql = "
  SELECT count(*) as c FROM PV_ASSET_REPORTS
  WHERE IsSurplus = 0
  AND CategoryName = ?
  AND ManufacturerName = ?
  ";

  $query = $con->prepare($sql);
  $query->execute(array($category, $manufacturer));
  $count = $query->fetch(PDO::FETCH_OBJ);
  return $count->c;
}

// Function that counts the number of assets of a given model
function countModels($con, $model)
{
  $sql = "
  SELECT count(*) as c FROM PV_ASSET_REPORTS
  WHERE IsSurplus = 0 AND ModelName = ?
  ";

  $query = $con->prepare($sql);
  $query->execute(array($model));
  $count = $query->fetch(PDO::FETCH_OBJ);
  return $count->c;
}

// Function that counts the number of assets out of warranty for a given category
function countCategoriesOW($con, $category)
{
  $sql = "
  SELECT count(*) as c FROM PV_ASSET_REPORTS
  WHERE IsSurplus = 0
  AND DATEDIFF(WarrantyEnd, now()) <= 0
  AND CategoryName = ?
  ";
  $query = $con->prepare($sql);
  $query->execute(array($category));
  $count = $query->fetch(PDO::FETCH_OBJ);
  return $count->c;
}

// Function to query with multiple of one filter. $filterArr is an array containing
// the value of each filterType to query for. $filterType contains the actual filterType.
// Returns a
function filterMulti($con, $filterArr, $filterType)
{
  // Add name to filter type
  $filterType = $filterType . 'Name';
  $sql =
  "
  SELECT * FROM PV_ASSET_REPORTS
  WHERE
  ";

  // Prepare sql based on how many elements are in the filter array
  foreach($filterArr as $item)
  {
    $sql .= $filterType . ' = ? OR ';
  }

  // Remove the last OR from sql
  $sql = substr_replace($sql, "", -3);
  $sql = trim($sql);

  // Prepare sql statement
  $query = $con->prepare($sql);
  $query->execute($filterArr);

  // Return result
  return $query->fetchAll(PDO::FETCH_ASSOC);
}

?>
