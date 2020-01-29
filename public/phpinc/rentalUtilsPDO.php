<?php
	require_once "dbconnect.php";

	$c = $_GET['c'];//category name
	$m = $_GET['m'];//mode
	$b = $_GET['b'];//brand name


	//get category id
	$sql = $con->prepare("select CategoryID from P_CATEGORIES where Name = ?");
	$sql->execute(array($c));
	$catID = $sql->fetch(PDO::FETCH_ASSOC);


	//get manufacturer ids
	$sql = $con->prepare("select distinct ManufacturerID from P_MODELS where CategoryID = ?");
	$sql->execute(array($catID['CategoryID']));
	$brandID = $sql->fetchAll();

	if($m == 'brand')//generate brand names
	{
		if(sizeof($brandID) > 0)
		{				
			foreach ($brandID as $row)
			{
				//get manufacturer ids
				$sql = $con->prepare("select Name from P_MANUFACTURERS where ManufacturerID = ?");
				$sql->execute(array($row['ManufacturerID']));
				$name = $sql->fetch(PDO::FETCH_ASSOC);

		
				print "<option>".$name['Name']."</option>";

			}
		}
		else
		{
			print '<option>No matches found</option>';
		}
	}
	else if($m == 'model')//generate model numbers
	{
		//get manufacturer id
		$sql = $con->prepare("select ManufacturerID from P_MANUFACTURERS where Name = ?");
		$sql->execute(array($b));
		$brand = $sql->fetch(PDO::FETCH_ASSOC);


		//get model names
		$sql = $con->prepare("select Name from P_MODELS where ManufacturerID = ? and CategoryID = ?");
		$sql->execute(array($brand['ManufacturerID'], $catID['CategoryID']));
		$model = $sql->fetchAll(PDO::FETCH_ASSOC);

		
		if(sizeof($model) > 0)
		{				
			foreach ($model as $row)
			{
				print "<option>".$row['Name']."</option>";
			}
		}
		else
		{
			print '<option>No matches found</option>';
		}
	}
	else //generate serial numbers
	{	
		$hint="";
		$m=strtolower($m); 
		$len=strlen($m);
		$mod = $_GET['mod'];


		//get model id
		$sql = $con->prepare("select ModelID from P_MODELS where Name = ?");
		$sql->execute(array($mod));
		$modelID = $sql->fetch(PDO::FETCH_ASSOC);


		//get serial numbers
		$sql = $con->prepare("select distinct SerialNumber from P_ASSETS where ModelID = ?");
		$sql->execute(array($modelID['ModelID']));
		$a = $sql->fetchAll(PDO::FETCH_ASSOC);

		
	    foreach($a as $row)
	    { 
	    	if($len == 0)
	    	{
	    		$hint .= "<option>". $row['SerialNumber']."</option>";
	    	}

			else if (stristr($m, substr($row['SerialNumber'],0,$len))) //test if $a matches with the first few characters of the same length in the SerialNumber
	      	{ 
				if ($hint=="")
	       		{ 
					$hint = "<option>". $row['SerialNumber']."</option>";
	 			}
	        	else
	        	{ 	
					$hint .= "<option>". $row['SerialNumber']."</option>";
				}
	      	}
	    }

		print $hint;
	}
			
?>

