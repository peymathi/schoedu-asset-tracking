<?php 
 
	session_start();
 
	require_once "phpinc/dbconnect.php";

	$response = "";	
	$username = "";
	$password = "";
	$userid = "";

	$haveuser = FALSE;
	$havepass = FALSE;
	$match = FALSE;

if(isset($_GET['username'])){
	$username = $_GET['username'];
	$haveuser = TRUE;
}

if(isset($_GET['password'])){
	$password = $_GET['password'];
	$havepass = TRUE;
}

if($haveuser == TRUE and $havepass == TRUE){
	$stmt = $con->prepare("select count(*) as c from P_ADMINS where username = ? and salthashpass = ?");
	$stmt->execute(array($username, $password));
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$count = $row->c;
	if ($count == 1){
		$stmt = $con->prepare("Select adminid from P_ADMINS where username = ? and salthashpass = ?");
		$stmt->execute(array($username, $password));
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		$userid = $row->adminid;
		$_SESSION[userid] = $userid;
		$_SESSION[username] = $username;
		Header ("Location:index.php");
	}
	else{
		$response = "Login Unsuccessful. Please try again";
	}
}

if($haveuser == FALSE or $havepass == FALSE){
	$response = "Please enter your login credentials";
}
	
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Asset Management Log In</title>
  <link rel="stylesheet" href="css/logInStyle.css">
  
</head>
<body>

<div class="login-page">
  <div class="form">
    <?php print $response; ?>
    <form method="get" action="login.php" class="login-form">
      <input type="text" name = "username"/>
      <input type="password" name = "password"/>
      <input name="enter" class="btn" type="submit" value="Log In" />
    </form>
  </div>
</div>

</body>
</html>