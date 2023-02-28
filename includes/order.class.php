<?php
require("DAL.class.php");
session_start();

class order{

	private $db;
	
	
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	
	

   

    
	public function getActiveOrders($uid){

		
       

		$sql = "SELECT * FROM `orders` WHERE `order_user_id`='$uid' AND `order_status`=\"pending\"";

	
       
		
		try
		{
			$data=$this->db->getData($sql);

			
		
			//No data
			if(is_null($data))			
				return 0;
			else{
				return $data;
				
			}
		}catch(Exception $e) {	
			throw $e;
		}



	}
   public function updateOrderStatus(){

		
      $uid=$_SESSION["uid"];

		$sql = "UPDATE `orderdetails` SET `od-status`='completed' where `od_user_id`='$uid' and `od-status`='pending'";

	
       
		
		try
		{
			$data=$this->db->ExecuteQuery($sql);

			
		
			//No data
			if(is_null($data))			
				return 0;
			else{
				return $data;
				
			}
		}catch(Exception $e) {	
			throw $e;
		}



	}



   public function updateOrderTable(){

		
      $uid=$_SESSION["uid"];

		$sql = "SELECT * FROM `orderdetails` WHERE `od_user_id`='$uid' AND `od-status`='pending'";
    

      $data=$this->db->getData($sql);
       
      if(count($data)>0){
         $date = date('Y-m-d H:i:s');
		try
		{
			

			
		
			
		
            $totalamt=0;
for($i=0;$i<count($data);$i++){


   $totalAmtInRow=$data[$i]["od_total_amount"];

   $intNumber=str_replace(".","",$totalAmtInRow);


$totalamt+=$intNumber;


}

$totalamtfloat=number_format((float)$totalamt, 0, '.', '.'); 

$sql2="UPDATE `orders` SET `order_date`='$date',`order_total_amount`='$totalamtfloat LL',`order_status`='completed' WHERE `order_user_id`='$uid' AND `order_status`='pending'";
$data2=$this->db->ExecuteQuery($sql2);
return $data2;

         }		
				
					
			
		catch(Exception $e) {	
			throw $e;
		}

   }

	}


    
	
	
	public function sendOrder($uid){

        $date = date('Y-m-d H:i:s');


      

        
        $sql2 = "SELECT * FROM `orders` WHERE `order_user_id`='$uid' AND `order_status`=\"pending\"";

        $data2=$this->db->getData($sql2);
        if (count($data2)===0){
		
            $host = "p:localhost"; /* Host name */
            $user = "root"; /* User */
            $password = ""; /* Password */
            $dbname = "pharmacy"; /* Database name */
            
            $con = mysqli_connect($host, $user, $password,$dbname);
            // Check connection
            if (!$con) {
               die("Connection failed: " . mysqli_connect_error());
            }
            
            // Insert query 
            $query = "insert into orders (order_user_id,order_date,order_total_amount,order_status) values ('$uid','$date','0','pending')"; 
            
            if(mysqli_query($con,$query)){ 
            
               // Get last insert id 
               $lastid = mysqli_insert_id($con); 
            
               $oid=$lastid; 
               $_SESSION["oid"]=$oid;
            }	
			
    }
    
    else{
       $data=$this->db->getData($sql2);
       $oid=$data[0]["order_id"];
       $_SESSION["oid"]=$oid;
    }



	}






	public function getOrderDetailsTotal(){

		
		$uid=$_SESSION["uid"];
  
		  $sql = "SELECT * FROM `orderdetails` WHERE `od_user_id`='$uid' AND `od-status`='pending'";
	  
  
		$data=$this->db->getData($sql);
		 
		if(is_countable($data)){
		  
		  try
		  {
			  
  
			  
		  
			  
		  
			  $totalamt=0;
  for($i=0;$i<count($data);$i++){
  
  
	 $totalAmtInRow=$data[$i]["od_total_amount"];
  
	 $intNumber=str_replace(".","",$totalAmtInRow);
	 $noL= substr($intNumber, 0, -3);
  
  
  $totalamt=$totalamt+(int)$noL;
  
  
  }
  
  
  

 
  return $totalamt;
  
		   }		
				  
					  
			  
		  catch(Exception $e) {	
			  throw $e;
		  }
  
	 }

	 else{
		return 0;
	 }
  
	  }

	


	

	
	


}

?>