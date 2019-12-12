<?php session_start();
	require_once "dbconnect.php";


// Fill up array with names

$sql = $con->prepare("select distinct P_USERS.Name from P_USERS left join P_HIDE_USER_RULES on P_HIDE_USER_RULES.UserID = P_USERS.UserID where P_HIDE_USER_RULES.RuleID is NULL");
$sql->execute(array());
$a =$sql->fetchAll();



// get the q parameter from URL
$q=$_REQUEST["q"]; 

$hint="";

// lookup all hints from array if $q is different from "" 
if ($q !== "")
{ 	
	$q=strtolower($q); 
	$len=strlen($q);

	
    	foreach($a as $name)
    	{ 

			if (stristr($q, substr($name['Name'],0,$len)))
      		{ 
				if ($hint==="")
	       		{ 
					$hint = "<option>". $name['Name']."</option>";
	 			}
	        	else
	        	{ 	
					$hint .= "<option>". $name['Name']."</option>";
				}
      		}
    	}
}


print $hint;
?>