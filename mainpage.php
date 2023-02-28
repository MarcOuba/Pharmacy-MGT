<?php



session_start();

if(!isset($_SESSION['username']) || !isset($_SESSION['type']) ) 
{
     header("Location:error.php"); //Do not allow him to access.
     exit;
}

include "./includes/DAL.class.php";







$db=new DAL();
$categoriesRows=$db->getData("select * from categories");
$itemRows=$db->getData("SELECT * FROM `items` WHERE `item_status`=1");



for($i=1;$i<=count($categoriesRows);$i++){
${'cat'.$i}=$categoriesRows[$i-1]["cat_name"];


}



function updateCategories(){

  $db=new DAL();
  $categoriesRows=$db->getData("select * from categories");
  for($i=0;$i<count($categoriesRows);$i++){
    $catid=$categoriesRows[$i]["cat_id"];
   $sql="UPDATE categories SET categories.cat_item_name=(SELECT group_concat(items.item_name) from items where items.item_cat_id='$catid' AND items.item_status=1) WHERE categories.cat_id='$catid'";
   $db->ExecuteQuery($sql);
    
    }
  
    $sql2="UPDATE categories SET categories.cat_status=0 WHERE categories.cat_item_name=''";
    $db->ExecuteQuery($sql2);
    $sql3="UPDATE categories SET categories.cat_status=1 WHERE categories.cat_item_name!=''";
    $db->ExecuteQuery($sql3);
  
  }
  
  
  updateCategories();

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
    <link rel="stylesheet" href="./CSS/mainpage.css">
    <script src="./JS/bootstrap-3.4.1-dist/js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./JS/jquery.js"></script>
    <script src="./JS/index.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
   
</head>


<body id="body">

<div id="blur-background"></div>

<input type="hidden" class="userType" value="<?php echo $_SESSION["type"]?>">
<input type="hidden" class="userId" value="<?php echo $_SESSION["uid"]?>">
<input type="hidden" class="orderId" value="<?php

 if(isset($_SESSION["oid"]))
 {
  echo $_SESSION["oid"];

}
  
 
 ?>">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <img class="navbar-brand" src="./IMG/pharmacy-logo.png"></img>
          </div>
          <ul class="nav navbar-nav">
            <li  class="active"><a href="#">Home</a></li>
            <li><a href="./aboutUs.php">About Us</a></li>
            <li><a class="admin-buttons" href="./users.php">Users</a></li>
            <li><a class="admin-buttons"  href="./products.php">Products</a></li>
        <li><a class="admin-buttons"  href="./categories.php">Categories</a></li>
        <li><a class="admin-buttons"  href="./reports.php">Reports</a></li>
     
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a class="user-name" href="#"><?php echo "Welcome " .$_SESSION["username"]." !" ?></a></li>
            <li><a id="sign-out" href="./index.php"><span class=" glyphicon glyphicon-user"></span> Sign Out</a></li>
          </ul>
        </div>
      </nav>
      


      <div  class="dropdown">
<div id="catDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnCat" type="button" data-toggle="dropdown">Categories
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li class="active"><a id="All" class="categories" href="#">All</a></li>
    <li class="divider"></li>
    <?php 
    for($i=0;$i<count($categoriesRows);$i++) {
      if($categoriesRows[$i]["cat_item_name"]!=""){
    ?>
    <li><a id="<?php echo $categoriesRows[$i]["cat_name"]; ?>" class="categories" href="#">
    
    
    <?php
   
      echo $categoriesRows[$i]["cat_name"]; ?>
     
     </a></li>
    <li class="divider"></li>
   
    <?php 
      }
    }
	?>
    
  </ul>
  </div>
</div>




<input  id="searchForProductMainpage" placeholder="Search by name" type="text">
<div class="cart-img-container">
<button id="shopping-btn"><a href="./shoppingCart.php">
  <img id="shopping-img" src="./IMG/shoppingCart.png" alt="Cart"></a>
  <div class="item-number">
   <p id="cart-item-count"></p> 
  </div>
</button>
</div>
      
      <div class="components-container">
      
</div>







 <!-- Modal for shopping Cart-->
 <div class="modal fade" id="cart-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button id="close-modal" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="cart-text" class="modal-title"></h4>
        </div>
        

        
        <div class="modal-footer">
        
            <input type="hidden" name="id" id="getIdCart">
          <button data-dismiss="modal"   type="button" class="btn btn-default" id="continue-shopping">Continue shopping</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" id="view-cart"> View Cart</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>


 


  



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