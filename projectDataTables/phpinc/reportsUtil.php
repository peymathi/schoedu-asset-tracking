<?php

/* Utility functions and classes for reports.php */
require_once "phpinc/dbconnect.php";

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
  private $sur;
  private $exp;

  public function __construct($con, $man = '- -', $cat = '- -', $mod = '- -', $loc = '- -', $u = '- -', $sur = False, $exp = False)
  {
    $this->con = $con;
    $this->man = $man;
    $this->cat = $cat;
    $this->mod = $mod;
    $this->loc = $loc;
    $this->u = $u;
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

    if ($this->exp)
    {
      $sql .= "DATEDIFF(WarrantyEnd, now()) <= 0 AND ";
    }

    $sql = substr_replace($sql, "", -4);
    $sql = trim($sql);

    $query = $this->con->prepare($sql);
    $query->execute($sqlArray);
    $this->queryData = $query->fetchAll();
  }

  // Gets raw data based on query
  public function getRaw()
  {
    return $this->queryData;
  }

  // Gets data based on query and formats it to be put into the data table
  public function getTableData()
  {
    $tableData = "";

    // Loop through all of the records
    foreach($this->queryData as $record)
    {
      $tableData .= "<tr>";

      // Loop through the data in the record that can be formatted easily
      for ($i = 0; $i < 5; $i++)
      {
        $tableData .= "<td>";
        $tableData .= $record[$i];
        $tableData .= "</td>";
      }

      // Format the days last checked (5)
      $tableData .= "<td>";
      $checkedDate = date_create($record[5]);
      $currentDate = date_create();
      $diff = date_diff($currentDate, $checkedDate);
      $tableData .= $diff->format("%a");

      $tableData .= "</td>";

      // Add the user to the data table (6)
      $tableData .= "<td>";
      $tableData .= $record[6];
      $tableData .= "</td>";

      // Format the surplus boolean (7)
      $tableData .= "<td>";

      if ($record[7])
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

      if (!$record[8])
      {
        $warrantyDate = date_create($record[8]);
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
  $formatString = "SerialNumber, Category, Manufacturer, Model, Location, DateLastChecked, User, IsSurplus, WarrantyEnd";
  $formatString .= PHP_EOL;

  // Loop through the data query and format each record to be added to the format string
  foreach($data as $record)
  {
    // Loop until the user name comes up
    for($i = 0; $i < 6; $i++)
    {
      $formatString .= $record[$i] . ',';
    }

    $formatString .= '"' . $record[7] . '"';
    $formatString .= $record[8] . PHP_EOL;
  }

  // Write the data to the file
  fwrite($file, $formatString);

  // Close the file
  fclose($file);
}

// Function for writing a PDF based on a data query string.
function printPDF($data, $location)
{
  // Delete a file at that location if there already is one
  if (file_exist($location))
  {
    unlink($location);
  }

  // Open a new file at the location in write mode
  $file = fopen($location, "w");
}


?>
