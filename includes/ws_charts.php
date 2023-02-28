<?php
	
	session_start();
	require_once('charts.class.php');
	$chart=new chart();

	

	  
	  


	
	 if(isset($_GET["op"]))
	{

//quantity chart

		if($_GET["op"]==1){
			

	try {
		$result = $chart->getOrderQty();
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}

        //new worth chart

		else if($_GET["op"]==2){
			

            try {
                $result = $chart->getNetWorth();
                header("Content-type:application/json"); 		
                
                echo json_encode($result);
            }
            catch(Exception $e) {	
                echo -1;
            }
            
                }

				else if($_GET["op"]==3){
			

					try {
						$result = $chart->getUsersNetWorth();
						header("Content-type:application/json"); 		
						
						echo json_encode($result);
					}
					catch(Exception $e) {	
						echo -1;
					}
					
						}
                


	
	}
	

	
	



?>
