<?php

	session_start();

	require_once "phpinc/dbconnect.php";

	$response = "";
	$username = "";
	$password = "";
	$userid = "";
	$hash = "";

	$haveuser = FALSE;
	$havepass = FALSE;

if(isset($_POST['username'])){
	$username = $_POST['username'];
	if ($username != ""){
		$haveuser = TRUE;
	}
}

if(isset($_POST['password'])){
	$password = $_POST['password'];
	if ($password != ""){
		$havepass = TRUE;
	}

}

if($haveuser == TRUE and $havepass == TRUE){
	$stmt = $con->prepare("select salthashpass from P_ADMINS where username = ?");
	$stmt->execute(array($username));
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$hash = $row->salthashpass;
	if(password_verify($password, $hash)){
		$stmt = $con->prepare("Select adminid from P_ADMINS where username = ? and salthashpass = ?");
		$stmt->execute(array($username, $hash));
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asset Management Log In</title>
  <link rel="stylesheet" href="css/logInStyle.css">
</head>
<body>

<div class="login-page">
  <div class="form">
    <?php print $response; ?>
    <form method="post" action="login.php" class="login-form">
      <input type="text" name = "username"/>
      <input type="password" name = "password"/>
      <input name="enter" class="btn" type="submit" value="Log In" />
    </form>
  </div>
</div>

</body>
</html>
