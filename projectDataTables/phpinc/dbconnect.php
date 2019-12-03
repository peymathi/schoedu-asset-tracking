<?php
/**
 * This file defines PDO database package. This file is included in any files that needs database connection
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
 * http://php.net/manual/en/pdostatement.fetch.php
  */

/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'tmhorne';

/*** mysql password ***/
$password = 'tmhorne';

try {
    $con = new PDO("mysql:host=$hostname;dbname=tmhorne_db", $username, $password);
    // $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*** echo a message saying we have connected ***/
    //echo 'Connected to database';
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }

?>
