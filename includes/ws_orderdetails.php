<?php
	
	session_start();
    require_once('orderdetails.class.php');
	$orderdetails = new orderdetails();
	


    
	
	

	
	 if(isset($_GET["op"]))
	{
       

		if($_GET["op"]==1){
			$oid=$_SESSION["oid"];
            $uid=$_SESSION["uid"];
            $price=$_GET["price"];
            $qty=$_GET["qty"];
            $total=$_GET["total"];
            $itemid=$_GET["itemid"];
            
	
	try {
		$result = $orderdetails->sendOrderDetails($oid,$uid,$price,$qty,$total,$itemid);




		header("Content-type:application/json"); 		
		
		echo json_encode($result);

        // removeDuplicates();
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}		


        if($_GET["op"]==2){
			
            $uid=$_SESSION["uid"];
            
	
	try {
		$result = $orderdetails->getCartItems($uid);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}		


        if($_GET["op"]==3){
			
           $qty=$_GET["qty"];
           $id=$_GET["id"];
           $total=$_GET["total"];
            
	
	try {
		$result = $orderdetails->updateQty($id,$qty,$total);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}		


        if($_GET["op"]==4){
			
            
            $id=$_GET["id"];
            
             
     
     try {
         $result = $orderdetails->deleteRow($id);
         header("Content-type:application/json"); 		
         
         echo json_encode($result);
     }
     catch(Exception $e) {	
         echo -1;
     }
     
         }		


         if($_GET["op"]==5){
			        
            $uid=$_SESSION["uid"];  
     
     try {
         $result = $orderdetails->getItemsCount($uid);
         header("Content-type:application/json"); 		
         
         echo json_encode($result);
     }
     catch(Exception $e) {	
         echo -1;
     }
     
         }		

         if($_GET["op"]==6){
			        
       
     
     try {
        session_unset();
        session_destroy();
     }
     catch(Exception $e) {	
         echo -1;
     }
     
         }		

         if($_GET["op"]==7){
            $id=$_GET["id"];
       
     
            try {

                $result = $orderdetails->checkIfItemExist($id);
		header("Content-type:application/json"); 			
		echo json_encode($result);
               
            }
            catch(Exception $e) {	
                echo -1;
            }
            
                }		
	
	}
	

	
	



?>