<?php session_start();
	require_once "dbconnect.php";


$q=$_REQUEST["q"]; 
$name=$_REQUEST["n"]; 

$hint="";

$sql = $con->prepare("select distinct Phone from P_USERS where Name = ?");
$sql->execute(array($name));
$a =$sql->fetchAll();


// lookup all hints from array if $q is different from "" 
if ($q !== "")
{ 	
	$q=strtolower($q); 
	$len=strlen($q);

	
    	foreach($a as $name)
    	{ 

		if (stristr($q, substr($name['Phone'],0,$len)))
      		{ 
			if ($hint==="")
       		{ 
				$hint = "<option>". $name['Phone']."</option>";
 			}
        		else
        		{ 	
			$hint .= "<option>". $name['Phone']."</option>";
			}
      		}
    	}
}


print $hint;
?>