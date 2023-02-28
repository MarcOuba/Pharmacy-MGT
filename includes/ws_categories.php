<?php
	
	session_start();
	require_once('categories.class.php');
	$categories=new categories();

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

		//op 1 for displaying categories

		if($_GET["op"]==1){
			
	try {
		$result = $categories->getCategories();

		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}

		}

		//op 2 for adding category

		 if($_GET["op"]==2){
			
			$name=$_GET["name"];
			

			try {
				$result = $categories->addCategory($name);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}
//op 4 for edit category (name)
		else if($_GET["op"]==3){
			
			$name=$_GET["name"];
			$id=$_GET["id"];

			try {
				$result = $categories->editCategory($name , $id);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}
//op 4 for deleting items inside category
		else if($_GET["op"]==4){
			
			$items=$_GET["items"];
			

			try {
				for($i=0;$i<=count($items);$i++){

					$result = $categories->deleteItemsInsideCategory($items[$i]);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
					

					}
				
			}
			catch(Exception $e) {	
				echo -1;
			}
		}


	}
	

	
	



?>
