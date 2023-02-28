<?php 



session_start();
include "./includes/DAL.class.php";

if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin') 
{
     header("Location:error.php"); //Do not allow him to access.
     exit;
}

$db=new DAL();
$categoriesRows=$db->getData("select * from categories");


for($i=1;$i<=count($categoriesRows);$i++){
${'cat'.$i}=$categoriesRows[$i-1]["cat_name"];


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
    <script src="./JS/categories.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
    <link rel="stylesheet" href="./JS/bootstrap-3.4.1-dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="./CSS/users.css">
</head>
<body>





<input type="hidden" class="categoriesCount" value="<?php echo count($categoriesRows)?>">
<input type="hidden" class="userType" value="<?php echo $_SESSION["type"]?>">



    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <img class="navbar-brand" src="./IMG/pharmacy-logo.png"></img>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="./mainpage.php">Home</a></li>
        <li><a href="./aboutUs.php">About Us</a></li>
        <li><a class="admin-buttons" href="./users.php">Users</a></li>
        <li ><a class="admin-buttons" href="./products.php">Products</a></li>
        <li class="active"><a class="admin-buttons"  href="./categories.php">Categories</a></li>
        <li><a class="admin-buttons"  href="./reports.php">Reports</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li><a class="user-name" href="#"><?php echo "Welcome " .$_SESSION["username"]." !" ?></a></li>
            <li><a href="./index.php"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li>
          </ul>
        </div>
      </nav>

      <div  class="dropdown">
<div id="categoriesDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnCategories" type="button" data-toggle="dropdown">Show all categories
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li class="active"><a id="showAllCategories" class="categories" href="#">Show all categories</a></li>
    <li class="divider"></li>

    <li><a id="showActiveCategories" class="categories" href="#">Show enabled categories</a></li>
    <li class="divider"></li>

    <li><a id="showInactiveCategories" class="categories" href="#">Show disabled categories</a></li>
    <li class="divider"></li>

    
  </ul>
  </div>
</div>
      


      <div id="input-container">
        <input style="color:black; height:33px; margin-right: 10px; position:relative; top:-50px;" id="searchByNameCategories" placeholder="Search by name"  type="text"/>
        
        <button style="position:relative; top:-50px;" data-toggle="modal" data-target="#add-category-modal" id="add-category" class="btn btn-success admin-buttons">Add Category</button>
        
      </div>
     
     


     
<div style="margin-bottom:500px;" id="table-container">
      <table  id="table-categories">
        <thead>
          <tr>
            <th>Category Name</th>
            <th>Category items</th>
            <th>Category status</th>
            <th width="500px">Operations</th>
          </tr>
        </thead>
        <tbody id="tbodyCategories">

   
  

        </tbody>
      </table>
      
    </div>



    
<!-- Modal for update-->
<div class="modal fade" id="update-category-modal" role="dialog">
  <div style="width:650px;" class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Category:</h4>
      </div>
     
      <div class="modal-body" id="edit-category-modal-body">
      <input type="hidden" name="id" id="getIdUpdateOfCategory">
      <input id="validationCategory" type="hidden" name="">
      
     
      <p class="error" id="edit-cat-name-error"></p>
      <label for="name">Category Name :</label> <input class="modal-input"  name="name" type="text" id="category-name-edit" placeholder="Category Name"  ><br><br>
     
       
       
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btn-update-category">Modify this category</button>
      </div>
      
    </div>
  
  </div>
</div>


<!-- Modal for delete-->
<div class="modal fade" id="delete-category-modal" role="dialog">
  <div style="width:650px;" class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="delete-category-modal-title"></h4>
      </div>
     
     
      <input type="hidden" name="id" id="getIdDeleteOfCategory">
         
       
       
    
      <div class="modal-footer">
      <button data-dismiss="modal"  type="button" class="btn btn-default" id="yes-delete-category">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" id="no-delete-category">No</button>
      </div>
      
    </div>
  
  </div>
</div>







<!-- Modal for add-->
<div class="modal fade" id="add-category-modal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div style="width:650px;" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Category specifications:</h4>
      </div>
      
      <div class="modal-body">
        <p class="error" id="add-cat-name-error"></p>
        <input  class="modal-input" style="width:100%;" placeholder="Category Name" type="text" id="add-category-name"><br><br>
        
      </div>
      <div class="modal-footer">
        <button name="insertCategory" type="button" class="btn btn-default" id="modal-add-category-btn">Add Category</button>
      </div>
      
    </div>
  
  </div>
</div>

  

    </body>