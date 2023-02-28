
<?php

if (session_status() !== PHP_SESSION_NONE) {
  session_unset();
session_destroy();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  
  <link rel="shortcut icon" href="./IMG/pharmacy-logo.png" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Pharmacy</title>
    <script src="./JS/jquery.js"></script>
    <script src="./JS/index.js"></script>
   
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./JS/bootstrap-3.4.1-dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
   <div id="form-container">

        <div class="form">
          

        <p class='error' id="wrongCredentials"></p><br>
           <p class='error'></p>
           
        <div class="input-group col-xs-999">
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-user"></i></span>
          <input id="username" type="text" class="form-control " name="username" placeholder="Username">
        </div>
        <br>
        <p class='error'></p>

        <div class="input-group col-xs-999">
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-lock"></i></span>
          <input id="password" type="password" class="form-control" name="password" placeholder="Password">
          
        </div>
        <a id="registerLink" href="./register.php">No account? Register</a>
        <br>
      
       

        <input id="login" type="submit" value="Login" />
      
        <br>
</div>
</div>
        


     

       
      
</body>
</html>