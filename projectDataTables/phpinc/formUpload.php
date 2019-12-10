
<?php
	require_once "dbconnect.php";


	$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf");
	
	//The global $_FILES will contain all the uploaded file information. In the following examples, "file" is the user defined name of the file input object in the html page.   
	//$_FILES['file']['name']: name of the file on the client machine
	//$_FILES['file']['type']: mime type of the file
	//$_FILES['file']['size']: size of the file in bytes
	//$_FILES['file']['tmp_name']: The temporary filename of the file in which the uploaded file was stored on the server.
	//$_FILES['file']['error']: The error code associated with this file upload.
	
	$temp = explode(".", $_FILES["file"]["name"]); //get the uploaded file name, use . to seperate the name and the extension into the temp array
	$extension = end($temp); //get the last element of the array, which will be the file extension
	if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png")
		|| ($_FILES["file"]["type"] == "application/pdf"))
		&& ($_FILES["file"]["size"] < 320000)
		&& in_array($extension, $allowedExts))
  	{
  		if ($_FILES["file"]["error"] > 0)
    		{
    			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    		}
  		else
    		{
    			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    			echo "Type: " . $_FILES["file"]["type"] . "<br>";
    			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

			if (is_uploaded_file($_FILES['file']['tmp_name'])) 
			{
   					echo "File ". $_FILES['file']['name'] ." uploaded successfully.\n";
   
			} else {
   				echo "unable to upload file ";
  
			}

				$newName = date('Y-m-d H:i:s') . '.' . $extension;

				 $code = "";
		         for($i = 0; $i<15; $i++){
		             //generate a random number between 1 and 35
		             $r = mt_rand(1,35);
		             //if the number is greater than 26, minus 26 will generate a digit between 0 and 9
		             if ($r > 26) {
		                $r = $r - 26;
		                $code = $code.$r ;
		            }
		             else {    //it's between 1 and 26, generate a character

		                 $code = $code.toChar($r);
		             }

		         }
		         $newName = $code. '.' . $extension;


    			if (file_exists("../Uploads/" . $newName))
      			{
      					echo $newName . " already exists. ";
      			}
    			else
      			{
      				move_uploaded_file($_FILES["file"]["tmp_name"],
      				"../Uploads/" . $newName);


      				//add to database
      				$formID = $_GET['f'];//form num

    					$sql = $con->prepare("update P_RENTAL_FORMS set fileName = ? where FormID = ?");
    					$sql->execute(array($newName, $formID));

              $sql = $con->prepare("update P_RENTAL_FORMS set Status = ? where FormID = ?");
              $sql->execute(array('Out', $formID));


      			}
    		}
  	}
	else
  	{
  		echo "Invalid file";
  	}

header("Location: ../rental.php");




function toChar($digit){
         $char = "";
         switch ($digit){
                case 1: $char = "A"; break;
                case 2: $char = "B"; break;
                case 3: $char = "C"; break;
                case 4: $char = "D"; break;
                case 5: $char = "E"; break;
                case 6: $char = "F"; break;
                case 7: $char = "G"; break;
                case 8: $char = "H"; break;
                case 9: $char = "I"; break;
                case 10: $char = "J"; break;
                case 11: $char = "K"; break;
                case 12: $char = "L"; break;
                case 13: $char = "M"; break;
                case 14: $char = "N"; break;
                case 15: $char = "O"; break;
                case 16: $char = "P"; break;
                case 17: $char = "Q"; break;
                case 18: $char = "R"; break;
                case 19: $char = "S"; break;
                case 20: $char = "T"; break;
                case 21: $char = "U"; break;
                case 22: $char = "V"; break;
                case 23: $char = "W"; break;
                case 24: $char = "X"; break;
                case 25: $char = "Y"; break;
                case 26: $char = "Z"; break;
                default: "A";

         }
         return $char;
}


?>