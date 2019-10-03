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
    <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>

      <select class="select-css">
        <option>Faculty</option>
        <option>Staff</option>
      </select>

      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>


    <form method="post" action="index.php" class="login-form">
      <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
      <button>login</button>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="javascript/logInScript.js"></script>

</body>
</html>