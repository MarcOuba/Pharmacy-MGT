<?php 

session_start();
include "./includes/DAL.class.php";
$db=new DAL();

if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin') 
{
     header("Location:error.php"); //Do not allow him to access.
     exit;
}

$rows=$db->getData("select * from items");
$categoriesRows=$db->getData("select * from categories");

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
   $db-> ExecuteQuery($sql2);
    $sql3="UPDATE categories SET categories.cat_status=1 WHERE categories.cat_item_name!=''";
   $db-> ExecuteQuery($sql3);

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
    
    <script src="./JS/products.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
    <link rel="stylesheet" href="./JS/bootstrap-3.4.1-dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="./CSS/users.css">
</head>
<body>




<input type="hidden" class="categoriesCount" value="<?php 
for($i=0;$i<count($categoriesRows);$i++){
  echo $categoriesRows[$i]["cat_id"];
  }
?>">
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
        <li class="active"><a class="admin-buttons"  href="./products.php">Products</a></li>
        <li><a class="admin-buttons"  href="./categories.php">Categories</a></li>
        <li><a class="admin-buttons"  href="./reports.php">Reports</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li><a class="user-name" href="#"><?php echo "Welcome " .$_SESSION["username"]." !" ?></a></li>
            <li><a href="./index.php"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li>
          </ul>
        </div>
      </nav>


      <div  class="dropdown">
<div id="productsDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnProducts" type="button" data-toggle="dropdown">Show all products
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li class="active"><a id="showAllProducts" class="products" href="#">Show all products</a></li>
    <li class="divider"></li>

    <li><a id="showActiveProducts" class="products" href="#">Show enabled products</a></li>
    <li class="divider"></li>

    <li><a id="showInactiveProducts" class="products" href="#">Show disabled products</a></li>
    <li class="divider"></li>

    
  </ul>
  </div>
</div>



<div  class="dropdown">
<div id="categoriesDropdownInProductsPage">
  <button class="btn btn-primary dropdown-toggle" id="btnCategoriesInProductsPage" type="button" data-toggle="dropdown">Show all categories
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    
  <li class="active"><a id="allCatLinkInProductsPage"  href="#">Show all categories</a></li>
    <li class="divider"></li>
    <?php 
    for($i=0;$i<count($categoriesRows);$i++) {
      
    ?>
    <li><a class="categoriesInProductsPage" href="#">
    
    
    <?php
   
      echo $categoriesRows[$i]["cat_name"]; ?>
     
     </a></li>

    <li class="divider"></li>
   
    <?php 
      
    }
	?>
    
  </ul>
  </div>
</div>



     


      <div id="input-container">
        <input style="color:black; height:33px; margin-right: 10px; position:relative; top:-50px;" id="searchByName" placeholder="Search by name"  type="text"/>
        
        <button style="position:relative; top:-50px;" data-toggle="modal" data-target="#add-product-modal" id="add-product" class="btn btn-success admin-buttons">Add Product</button>
        
      </div>
    


     
<div style="width:60%;" style="margin-bottom:500px;" id="table-container">
      <table   id="table-products">
        <thead>
          <tr>
            <th style="width:15%;">Name   <img style="margin-left:30px;height:20px;width:20px;cursor:pointer;" onclick="sortTableProducts(0)"  src="./IMG/sortAlphabetically.png"/></th>
            <th style="width:15%;">price<img style="margin-left:30px;height:20px;width:20px;cursor:pointer;" onclick="sortByPrice(1)"  src="./IMG/sortNumerical.png"/></th>
            <th style="width:20%;">branch</th>
            <th>img path</th>
            <th>Item Category</th>
            <th>Status</th>
            <th width="500px">Operations</th>
          </tr>
        </thead>
        <tbody id="tbodyProducts">

        </tbody>
      </table>
      
    </div>



    
<!-- Modal for update-->
<div class="modal fade" id="update-product-modal" role="dialog">
  <div style="width:650px;" class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Product:</h4>
      </div>
     
      <div class="modal-body" id="edit-product-modal-body">
      <input type="hidden" name="id" id="getIdUpdateOfProduct">
      <input id="validationProducts" type="hidden" name="">
      <p id="edit-product-img-error" class="error"></p>
      <label for="img">Product Image Source :</label>  <input class="modal-input"  name="img" type="text" id="product-img-edit" placeholder="Product Image"  ><br><br>
      <p id="edit-product-name-error" class="error"></p>
      <label for="name">Product Name :</label> <input class="modal-input"  name="name" type="text" id="product-name-edit" placeholder="Product Name"  ><br><br>
      <p id="edit-product-price-error" class="error"></p>
      <label for="price">Product Price :</label> <input  class="modal-input"  name="price" type="text" id="product-price-edit"  placeholder="Product Price" ><br><br>  
      <p id="edit-product-branch-error" class="error"></p>

      <p>Please select the product branches:</p>
        <input class="checkbox-edit-products" type="checkbox" name="HamraEdit" id="HamraEdit" value="Hamra">
         <label for="HamraEdit">Hamra</label><br>
         <input class="checkbox-edit-products" type="checkbox" name="KaslikEdit" id="KaslikEdit" value="Kaslik">
         <label for="KaslikEdit">Kaslik</label><br>
         <input class="checkbox-edit-products"  type="checkbox" name="JbeilEdit" id="JbeilEdit" value="Jbeil" >
         <label for="JbeilEdit">Jbeil</label><br>
         <input class="checkbox-edit-products" type="checkbox" name="JouniehEdit" id="JouniehEdit" value="Jounieh">
         <label for="JouniehEdit">Jounieh</label><br>

         <p>Please select the product status:</p>
         <input type="radio" name="statusEdit" id="activeProductEdit" value="Active">
         <label for="statusEdit">Active</label><br>
         <input type="radio" name="statusEdit" id="inactiveProductEdit" value="Inactive">
         <label for="statusEdit">Inactive</label>

      
         <p>Please select the product category:</p>
         <?php 
          for($i=0;$i<count($categoriesRows);$i++){
            
  ?>
            
           
         <input type="radio" name="categoryEdit" id="<?php echo $categoriesRows[$i]["cat_name"]  ?>" value="<?php echo $categoriesRows[$i]["cat_id"]  ?>">
         <label for="categoryEdit"><?php echo $categoriesRows[$i]["cat_name"] ?></label><br>
         
      <?php  
        }
         
        ?>
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btn-update-product">Modify this product</button>
      </div>
      
    </div>
  
  </div>
</div>



 <!-- Modal for delete-->
 <div class="modal fade" id="delete-product-modal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="delete-product-text" class="modal-title"></h4>
      </div>
      
      <div class="modal-footer">
        
        <input type="hidden" id="getIdDeleteOfProduct" name="id">
        <button data-dismiss="modal" name="yes-delete-product" type="button" class="btn btn-default"  id="yes-delete-product">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="no-delete-product">No</button>
        
      </div>
    </div>
  
  </div>
</div>



<!-- Modal for add-->
<div class="modal fade" id="add-product-modal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div style="width:650px;" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product specifications:</h4>
      </div>
      
      <div class="modal-body">
        <p class="error" id="add-product-img-error"></p>
        <input  class="modal-input" style="width:100%;" placeholder="Image Source Link ex:  ./IMG/Panadol.jfif" name="product-img-src" type="text" id="product-img-src"><br><br>
        <p class="error" id="add-product-name-error"></p>
        <input  class="modal-input" style="width:100%;" placeholder="Product Name ex: Panadol" name="product-name" type="text" id="product-name"><br><br>
        <p class="error" id="add-product-price-error"></p>
        <input  class="modal-input" style="width:100%;" placeholder="Product price ex: 250.000 LL" name="product-price" type="text" id="product-price"><br><br>
       
        <p>Please select the product branches:</p>
        <input type="checkbox" name="Hamra" id="Hamra" value="Hamra"  checked="checked">
         <label for="Hamra">Hamra</label><br>
         <input type="checkbox" name="Kaslik" id="Kaslik" value="Kaslik">
         <label for="Kaslik">Kaslik</label><br>
         <input type="checkbox" name="Jbeil" id="Jbeil" value="Jbeil" >
         <label for="Jbeil">Jbeil</label><br>
         <input type="checkbox" name="Jounieh" id="Jounieh" value="Jounieh">
         <label for="Jounieh">Jounieh</label><br>
        
        
        <p>Please select the product status:</p>
         <input type="radio" name="status" id="activeProduct" value="Active" checked="checked">
         <label for="active">Active</label><br>
         <input type="radio" name="status" id="inactiveProduct" value="Inactive">
         <label for="active">Inactive</label>

         <p>Please select the product category:</p>
         <?php 
          for($i=0;$i<count($categoriesRows);$i++){
            
  ?>
            
           
         <input type="radio" name="category" id="<?php echo $categoriesRows[$i]["cat_name"] ?>" value="<?php echo $categoriesRows[$i]["cat_id"]  ?>" checked="checked">
         <label for="category"><?php echo $categoriesRows[$i]["cat_name"] ?></label><br>
         
      <?php  
        }
         
        ?>
      
      </div>
      <div class="modal-footer">
        <button name="insertProduct" type="button" class="btn btn-default" id="modal-add-product-btn">Add product</button>
      </div>
      
    </div>
  
  </div>
</div>


 <!-- Modal for activate-->
 <div class="modal fade" id="activate-modal-item" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="activate-text-item" class="modal-title">Are you sure you want to activate?</h4>
        </div>
        

        
        <div class="modal-footer">
        
            <input type="hidden" name="id" id="getIdActivateItem">
          <button data-dismiss="modal" name="yes-delete"  type="button" class="btn btn-default" id="yes-activate-item">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" id="no-activate-item">No</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>
  

    </body>