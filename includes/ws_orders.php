<?php
	

    require_once('order.class.php');
   

	$order = new order();
	

	
	
	
	

	
	 if(isset($_GET["op"]))
	{


       

		if($_GET["op"]==1){
			$uid=$_GET["uid"];
	
	try {

        $result1=$order->getActiveOrders($uid);

		$result = $order->sendOrder($uid);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}



		if($_GET["op"]==2){

	
	try {

        $result=$order->updateOrderStatus();


		header("Content-type:application/json"); 		

		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}


		if($_GET["op"]==3){

	
			try {
		
				$result=$order->updateOrderTable();
		
		
				header("Content-type:application/json"); 		
		
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
			
				}

				if($_GET["op"]==4){

	
					try {
				
						$result=$order->getOrderDetailsTotal();
				
				
						header("Content-type:application/json"); 		
				
						echo json_encode($result);
					}
					catch(Exception $e) {	
						echo -1;
					}
					
						}



	
	
	}
	

	
	



?>
