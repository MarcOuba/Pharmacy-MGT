<?php 



session_start();

if(!isset($_SESSION['username']) || !isset($_SESSION['type']) ) 
{
     header("Location:error.php"); //Do not allow him to access.
     exit;
}
include "./includes/DAL.class.php";




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
    <link rel="stylesheet" href="./CSS/shoppingCart.css">
    <script src="./JS/bootstrap-3.4.1-dist/js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./JS/jquery.js"></script>
    <script src="./JS/index.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
   
</head>


<body id="body">


<input type="hidden" class="userType" value="<?php echo $_SESSION["type"]?>">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
          <img class="navbar-brand" src="./IMG/pharmacy-logo.png"></img>
          </div>
          <ul class="nav navbar-nav">
            <li><a  href="./mainpage.php">Home</a></li>
            <li><a href="./aboutUs.php">About Us</a></li>
        <li> <a class="admin-buttons" href="./users.php">Users</a></li>
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




  

      <section class="h-100" style="background-color: #eee;">
  <div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3><br>
        
        </div>
        <div class="cart-container">

      

        </div>
      


        <div class="card">
          <div class="card-body">
            <div style="margin-left:80%;">
            <p style="float:left;">Total amount :</p><p id="cart-total-amt" style="display: inline;float:left;margin-left:5px;">0</p>
            </div>
            <button id="placeOrder" type="button" class="btn btn-warning btn-block btn-lg">Place Order</button>
          </div>
        </div>

      </div>
     
    </div>
  </div>
</section>


 <!-- Modal for shopping Cart delete-->
 <div class="modal fade" id="delete-cart-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="close-delete-modal" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="delete-cart-text" class="modal-title"></h4>
        </div>
        

        
        <div class="modal-footer">
        
          <button data-dismiss="modal"   type="button" class="btn btn-default" id="yes-delete-orderdetail">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" > No</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>



   <!-- Modal for shopping Cart order-->
 <div class="modal fade" id="order-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="close-order-modal" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="order-text" class="modal-title">Are you sure you want to place this order?</h4>
        </div>
        

        
        <div class="modal-footer">
        
          <button data-dismiss="modal"   type="button" class="btn btn-default" id="yes-place-order">Yes</button>
          <button id="no-place-order" type="button" class="btn btn-default" data-dismiss="modal" > No</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>
    






</body>