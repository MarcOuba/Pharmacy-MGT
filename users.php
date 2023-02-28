<?php 






include "./includes/ws_users.php";

if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin') 
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
    <script src="./JS/jquery.js"></script>
    <script src="./JS/users.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="./JS/jqueryUI.js"></script>
    <link rel="stylesheet" href="./JS/bootstrap-3.4.1-dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="./CSS/users.css">
</head>
<body>

<input type="hidden" class="userType" value="<?php echo $_SESSION["type"]?>">


    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
          <img class="navbar-brand" src="./IMG/pharmacy-logo.png"></img>
          </div>
          <ul class="nav navbar-nav">
            <li><a  href="./mainpage.php">Home</a></li>
            <li><a href="./aboutUs.php">About Us</a></li>
        <li class="active"> <a class="admin-buttons" href="./users.php">Users</a></li>
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
      <div id="input-container">

     


        <input id="search" placeholder="Search by username"  type="text"/>
        <button data-toggle="modal" data-target="#add-modal" class="btn btn-success" id="add-user">Add User</button>
      </div>



      <div  class="dropdown">
<div id="searchUsersDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnSearchUsers" type="button" data-toggle="dropdown">Search by username
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li class="active"><a id="searchByUsername" class="searchUsers" href="#">Search by username</a></li>
    <li class="divider"></li>

    <li><a id="searchByEmail" class="searchUsers" href="#">Search by email</a></li>
    <li class="divider"></li>

    <li><a id="searchByPhone" class="searchUsers" href="#">Search by phone</a></li>
    <li class="divider"></li>
 
    
  </ul>
  </div>
</div>

        <div  class="dropdown">
<div id="usersDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnUsers" type="button" data-toggle="dropdown">Show all users
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li class="active"><a id="showAllUsers" class="users" href="#">Show all users</a></li>
    <li class="divider"></li>

    <li><a id="showActiveUsers" class="users" href="#">Show active users</a></li>
    <li class="divider"></li>

    <li><a id="showInactiveUsers" class="users" href="#">Show inactive users</a></li>
    <li class="divider"></li>

    <li><a id="showAdmins" class="users" href="#">Show admins</a></li>
    <li class="divider"></li>

    <li><a id="showUsers" class="users" href="#">show normal users</a></li>
    <li class="divider"></li>
 
    
  </ul>
  </div>
</div>
        
      


      
     

    
     
<div style="width: 50%;" id="table-container">
      <table id="table-users">
        <thead>
          <tr>
            <th style="width: 20%;">Username    <img style="height:20px;width:20px;cursor:pointer;" onclick="sortTableUsers(0)"  src="./IMG/sortAlphabetically.png"/></th>
            <th>Email    <img style="margin-left:30px;height:20px;width:20px;cursor:pointer;" onclick="sortTableUsers(1)"  src="./IMG/sortAlphabetically.png"/></th>
            <th>Phone Number</th>
            <th>Type</th>
            <th>Status</th>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody id="tbodyUsers">

       
        </tbody>
      </table>
      <br> <br> <br> <br> <br>
    </div>



    <!-- Modal for update-->
  <div class="modal fade" id="update-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter information:</h4>
        </div>
        
        <div class="modal-body">
        <input type="hidden" name="id" id="getIdUpdate">
        <p class="error" id="edit-user-name-error"></p>
       <label for="username">Username: </label>   <input  name="username" type="text" placeholder="Username" id="username-input" class="modal-input"> <br><br>  
       <p class="error" id="edit-user-email-error"></p>      
        <label for="email">Email:</label>  <input  name="email" type="text" placeholder="email" id="email-input" class="modal-input"><br><br> 
        <p class="error" id="edit-user-phone-error"></p>
         <label for="phoneNumber">Phone: </label> <input  name="phoneNumber" type="text" placeholder="Phone Number" id="phoneNumber-input" class="modal-input"><br><br>
         <p class="error" id="edit-user-utype-error"></p> 
         <p>Please select the user type:</p>
         <input type="radio" name="u_type-edit" id="admin-edit" value="admin">
         <label for="active">Admin</label><br>
         <input type="radio" name="u_type-edit" id="user-edit" value="user" checked="checked">
         <label for="active">User</label>
        
        </div>
        <div class="modal-footer">
          <button  name="btn-update" type="button" class="btn btn-default" id="btn-update">Update</button>
        </div>
        
      </div>
    
    </div>
  </div>

  

  <!-- Modal for add-->
  <div class="modal fade" id="add-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter user information:</h4>
        </div>

       
        <div class="modal-body">     
          <p class="error" id="add-user-name-error"></p>
         <input  name="username-add" type="text" placeholder="Username" id="username-input-add" class="modal-input"> <br><br>     
         <p class="error" id="add-user-password-error"></p>
          <input  name="password-add" type="text" placeholder="Password" id="password-input-add" class="modal-input"> <br><br>      
          <p class="error" id="add-user-email-error"></p>
          <input  name="email-add" type="text" placeholder="email" id="email-input-add" class="modal-input"><br><br>  
          <p class="error" id="add-user-phone-error"></p>
          <input  name="phoneNumber-add" type="text" placeholder="phoneNumber" id="phoneNumber-input-add" class="modal-input"><br><br> 
          <p>Please select the user type:</p>
         <input type="radio" name="u_type" id="admin" value="admin">
         <label for="active">Admin</label><br>
         <input type="radio" name="u_type" id="user" value="user" checked="checked">
         <label for="active">User</label>
          <p>Please select the user Status:</p>
         <input type="radio" name="status" id="active" value="Active" checked="checked">
         <label for="active">Active</label><br>
         <input type="radio" name="status" id="inactive" value="Inactive">
         <label for="active">Inactive</label>
          
        </div>
        <div class="modal-footer">
          <button name="insertData" type="button" class="btn btn-default" id="btn-add">Add this user</button>
          <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>
    
    </div>
  </div>


  <!-- Modal for delete-->
  <div class="modal fade" id="delete-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="delete-text" class="modal-title">Are you sure you want to delete?</h4>
        </div>
        

        
        <div class="modal-footer">
        
            <input type="hidden" name="id" id="getIdDelete">
          <button data-dismiss="modal" name="yes-delete"  type="button" class="btn btn-default" id="yes-delete">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" id="no-delete">No</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>


  <!-- Modal for activate-->
  <div class="modal fade" id="activate-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="activate-text" class="modal-title">Are you sure you want to activate?</h4>
        </div>
        

        
        <div class="modal-footer">
        
            <input type="hidden" name="id" id="getIdActivate">
          <button data-dismiss="modal" name="yes-delete"  type="button" class="btn btn-default" id="yes-activate">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" id="no-activate">No</button>
         
          
          
        </div>
        
      </div>
    
    </div>
  </div>


  

    </body>
