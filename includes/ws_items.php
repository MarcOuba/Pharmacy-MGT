<?php
	
	session_start();
	require_once('item.class.php');
	$item=new item();

	
	
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
	
	

	
	 if(isset($_GET["op"]))
	{



		




		//op 8 for displaying items in cart

		if($_GET["op"]==8){
			$id=$_GET["id"];
	
	try {
		$result = $item->getActiveItems($id);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}
		

		//op 7 for displaying items based on categories

		if($_GET["op"]==7){
			$name=$_GET["name"];
	
	try {
		$result = $item->getSpecificItems($name);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}

		
//op  for activating item

		if($_GET["op"]==6){
			$id=$_GET["idActivate"];
	
	try {
		$result = $item->activateItem($id);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}

//op 1 for displaying activated items

		if($_GET["op"]==1){
			$name=$_GET["name"];
	
if(isset($_GET["name"])){
	try {
		$result = $item->getActiveItems($name);

		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
}
		}

//op 2 for displaying all items inside the table

		if($_GET["op"]==2){
			$name=$_GET["name"];
	
if(isset($_GET["name"])){
	try {
		$result = $item->getAllItems($name);
		

		header("Content-type:application/json"); 		
		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
}
		}

// op 3 for deactivate item
		if($_GET["op"]==3)
		{			
			$id=$_GET["id"];

			try {
				$result = $item->deactivateItem($id);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}

		else if($_GET["op"]==4)
		{			
			$id=$_GET["id"];
			$name=$_GET["name"];
			$price=$_GET["price"];
			$img=$_GET["img"];
			$branch=$_GET["branch"];
			$status=$_GET["status"];
			$cat=$_GET["cat"];

			try {
				$result = $item->updateItem($id,$name,$cat,$price,$img,$branch,$status);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}

		else if($_GET["op"]==5){
			
			$name=$_GET["name"];
			$price=$_GET["price"];
			$img=$_GET["img"];
			$cat=$_GET["cat"];
			$branch=$_GET["branch"];
			$status=$_GET["status"];

			try {
				$result = $item->addItem($name,$price,$img,$cat,$branch,$status);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}

		


	
		
	
		else{}	
	
	}
	

	
	



?>
