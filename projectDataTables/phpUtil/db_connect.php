<?php

/* File to be included anywhere that requires connection to DB */
/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'tmhorne';

/*** mysql password ***/
$password = 'tmhorne';

try {
      $con = new PDO("mysql:host=$hostname;dbname=tmhorne_db", $username, $password);
    }

catch(PDOException $e)
    {
      echo $e->getMessage();
    }

?>
