<?php


session_start();

if(!isset($_SESSION['username']) || !isset($_SESSION['type']) ) 
{
     header("Location:error.php"); //Do not allow him to access.
     exit;
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
    <link rel="stylesheet" href="./JS/bootstrap-3.4.1-dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="./CSS/aboutUs.css">
    <script src="./JS/bootstrap-3.4.1-dist/js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./JS/jquery.js"></script>
    <script defer src="./JS/index.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
   
</head>

<body>
<input type="hidden" class="userType" value="<?php echo $_SESSION["type"]?>">

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <img class="navbar-brand" src="./IMG/pharmacy-logo.png"></img>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="./mainpage.php">Home</a></li>
        <li  class="active"><a href="./aboutUs.php">About Us</a></li>
        <li><a class="admin-buttons" href="./users.php">Users</a></li>
        <li><a class="admin-buttons"  href="./products.php">Products</a></li>
        <li><a class="admin-buttons"  href="./categories.php">Categories</a></li>
        <li><a class="admin-buttons"  href="./reports.php">Reports</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a class="user-name" href="#"><?php echo "Welcome " .$_SESSION["username"]." !" ?></a></li>
        <li><a href="./index.php"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li>
      </ul>
    </div>
  </nav>
         <br>

         <div class="aboutus-container">
             <p>Our Branches:</p><br>
             <ul id="locations">
                 <li> <span class="glyphicon glyphicon-map-marker"></span> Hamra <a href="https://www.google.com/maps/place/Hamra,+Beirut/@33.8955838,35.4825535,17.98z/data=!4m5!3m4!1s0x151f17283e7e3ced:0x740bcfc330ca9eb0!8m2!3d33.8966196!4d35.4823007" target="_blank" class="google-maps">View on Google Maps</a></li>
                 <li> <span class="glyphicon glyphicon-map-marker"></span> Jbeil <a href="https://www.google.com/maps/place/Byblos/@34.1235829,35.6503832,16.99z/data=!4m5!3m4!1s0x151f5ca814ab769b:0xbe47735b265d616e!8m2!3d34.1230021!4d35.6519282" target="_blank" class="google-maps">View on Google Maps</a></li>
                 <li> <span class="glyphicon glyphicon-map-marker"></span> Jounieh <a href="https://www.google.com/maps/place/Jounieh/@33.9840986,35.6324145,15.98z/data=!4m5!3m4!1s0x151f40c4257f7eb9:0x622d4edf2e7a984!8m2!3d33.9842691!4d35.6344491" target="_blank" class="google-maps">View on Google Maps</a></li>
                 <li> <span class="glyphicon glyphicon-map-marker"></span> Kaslik  <a href="https://www.google.com/maps/place/Kaslik/@33.9814348,35.6194388,16.99z/data=!4m5!3m4!1s0x151f408e5e7a920d:0x5a72d81d335b773e!8m2!3d33.9831069!4d35.6180569" target="_blank" class="google-maps">View on Google Maps</a></li>
             </ul>
             <br>
             <p>Contact us on phone: <span style="color:red;">70 288 767 or 70 613 925 or 71 819 116</span><br>
                Or by email: <span style="color:red;">MarcOuba1@gmail.com or EZ1@gmail.com or Paul1@gmail.com</span>
            </p><br>
            
            

         </div>
         <br>
        
         <footer class="social">
            <p style="margin:40px ">Star pharmacy 2019-2022. Copyright <span>&#169;</span> all rights reserved.</p>
              <p style="margin: 40px">Visit Us On:</p>
             
              <ul id="social-list"> 
                
        <li><a target="_blank" href="https://www.facebook.com/marc.ouba.58/"><i class="fa fa-lg fa-facebook"></i></a></li>
        <li><a target="_blank" href="https://www.instagram.com/marc_ouba/"><i class="fa fa-lg fa-instagram"></i></a></li>
        <li><a target="_blank" href="https://www.linkedin.com/in/marc-ouba-4544691b9/"><i class="fa fa-lg fa-linkedin"></i></a></li>
          
              </ul>
          
          </footer>
        </body>