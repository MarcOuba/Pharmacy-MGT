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

<div id="success-icon" class="swal2-icon swal2-success swal2-animate-success-icon" style="display:flex;position:absolute;left:30vw;visibility:hidden; ">
 
 <span class="swal2-success-line-tip"></span>
 <span class="swal2-success-line-long"></span>
 <div class="swal2-success-ring"></div> 
 
 
</div>



   <div id="form-container">

        <div class="form">
          

       
          <p class="error" id="usernameErrorInRegister"></p>
        <div class="input-group col-xs-999">
        
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-user"></i></span>
         
          <input id="usernameRegister" type="text" class="form-control " name="username" placeholder="Username">
        </div>
        <br>
        <p class="error" id="passwordErrorInRegister"></p>

        <div class="input-group col-xs-999">
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-lock"></i></span>
          <input id="passwordRegister" type="password" class="form-control" name="password" placeholder="Password">
          
        </div>
       
        
        <br>
        <p class="error" id="emailErrorInRegister"></p>
        <div class="input-group col-xs-999">
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-envelope"></i></span>
          <input id="emailRegister" type="text" class="form-control" name="email" placeholder="Email">
          
        </div>
        
        <br>
        <p class="error" id="phoneErrorInRegister"></p>
        <div style="margin-bottom:10px;" class="input-group col-xs-999">
          <span class="input-group-addon"><i class="login-icon glyphicon glyphicon-phone"></i></span>
          <input  id="phoneRegister" type="number" class="form-control" name="phone" placeholder="Phone Number">
          
        </div>
        <a id="loginLink" href="./index.php">Login</a>
        <br>
      
   
     

        <button class="btn btn-primary" id="register"  value="Register"  >Register</button>
        
      
        <br>
</div>
</div>
        


     

       
      
</body>
</html>