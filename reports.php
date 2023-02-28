
<?php

session_start();

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
    <script src="./JS/reports.js"></script>
    <script src="./JS/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
          <li><a href="./mainpage.php">Home</a></li>
        <li><a href="./aboutUs.php">About Us</a></li>
        <li><a class="admin-buttons" href="./users.php">Users</a></li>
        <li ><a class="admin-buttons" href="./products.php">Products</a></li>
        <li ><a class="admin-buttons"  href="./categories.php">Categories</a></li>
        <li class="active"><a class="admin-buttons"  href="./reports.php">Reports</a></li>
            

          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li><a class="user-name" href="#"><?php echo "Welcome " .$_SESSION["username"]." !" ?></a></li>
            <li><a href="./index.php"><span class="glyphicon glyphicon-user"></span> Sign Out</a></li>
          </ul>
        </div>
      </nav>

      <div class="chartsCheckboxes">

      <input type="checkbox" id="showQtyCanvas" name="qtyCanvas" value="Qunatity of items sold Chart" >
  <label for="showQtyCanvas">Quantity of items sold </label>
  <input type="checkbox" id="showItemsCanvas" name="itemsSalesCanvas" value="Net worth of items sold" >
  <label for="showItemsCanas"> Net worth of items sold</label>
  <input type="checkbox" id="showUsersCanvas" name="usersSalesCanvas" value="Net worth of users purchasing" >
  <label for="showUsersCanvas"> Net worth of users purchasing</label>

      </div>

      <div class="chartsContainer container">

      <div class="chart-child" style="width:70vw;height:400px;">
      <canvas  id="qtyChart"></canvas>
      <div  class="dropdown">
<div id="qtyChartDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnQtyChart" type="button" data-toggle="dropdown">Show all 
  <span class="caret"></span></button>
  <ul class="dropdown-menu">

  <li class="active"><a id="showAllQtyChart" class="qtychart" href="#">Show All</a></li>
    <li class="divider"></li>

    <li><a id="showTop5QtyChart" class="qtychart" href="#">Show top 5</a></li>
    <li class="divider"></li>

    <li><a id="showTop25QtyChart" class="qtychart" href="#">Show top 25</a></li>
    <li class="divider"></li>

    <li><a id="showTop100QtyChart" class="qtychart" href="#">Show top 100</a></li>
    <li class="divider"></li>

    
  </ul>
  </div>
</div>
      </div>

      <div class="chart-child" style="width:70vw;height:400px;">
      <canvas  id="netWorthChart"></canvas>
      <div  class="dropdown">
<div id="netWorthChartDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnNetWorthChart" type="button" data-toggle="dropdown">Show all 
  <span class="caret"></span></button>
  <ul class="dropdown-menu">

  <li class="active"><a id="showAllnetWorthChart" class="netWorthchart" >Show All</a></li>
    <li class="divider"></li>

    <li><a id="showTop5netWorthChart" class="netWorthchart" >Show top 5</a></li>
    <li class="divider"></li>

    <li><a id="showTop25netWorthChart" class="netWorthchart" >Show top 25</a></li>
    <li class="divider"></li>

    <li><a id="showTop100netWorthChart" class="netWorthchart">Show top 100</a></li>
    <li class="divider"></li>

    
  </ul>
  </div>
</div>
      </div>

      <div class="chart-child"  style="width:70vw;height:400px;">
      <canvas  id="usersNetWorthChart"></canvas>
      <div  class="dropdown">
<div id="usersNetWorthChartDropdown">
  <button class="btn btn-primary dropdown-toggle" id="btnUsersNetWorthChart" type="button" data-toggle="dropdown">Show all 
  <span class="caret"></span></button>
  <ul class="dropdown-menu">

  <li class="active"><a id="showAllUsersNetWorthChart" class="netWorthchart" href="#">Show All</a></li>
    <li class="divider"></li>

    <li><a id="showTop5UsersNetWorthChart" class="usersNetWorthchart" href="#">Show top 5</a></li>
    <li class="divider"></li>

    <li><a id="showTop25UsersNetWorthChart" class="usersNetWorthchart" href="#">Show top 25</a></li>
    <li class="divider"></li>

    <li><a id="showTop100UsersNetWorthChart" class="usersNetWorthchart" href="#">Show top 100</a></li>
    <li class="divider"></li>

    
  </ul>
  </div>
</div>
      </div>

      
      </div>

    </body>
    
    <script>



    </script>