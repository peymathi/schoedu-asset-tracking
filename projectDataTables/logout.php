<?php  

session_start();
session_destroy();
	
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asset Management Logout</title>
  <link rel="stylesheet" href="css/logInStyle.css">
  
</head>
<body>

<div class="login-page">
  <div class="form">
   	<h2>You have been logged out</h2>
	<a href="login.php">Click here to return to login page</a>
  </div>
</div>
</body>
</html>