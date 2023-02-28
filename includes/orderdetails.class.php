

<?php
require("DAL.class.php");

class orderdetails{

	private $db;
	
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	

    public function getCartItems($uid){

        $sql="SELECT * FROM orderdetails INNER JOIN items ON items.item_id=orderdetails.od_item_id WHERE `od-status`='pending' AND `od_user_id`='$uid'";

	
		
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

	public function getItemsCount($uid){

        $sql="SELECT * FROM `orderdetails` WHERE `od_user_id`='$uid' AND `od-status`='pending'";

	
		
		try
		{
			$data=$this->db->getData($sql);
			
		
			//No data
			if(is_null($data))			
				return 0;
			else{
				return count($data);
				
			}
		}catch(Exception $e) {	
			throw $e;
		}

    }

    public function updateQty($id,$qty,$amt){

        $sql="UPDATE `orderdetails` SET `od_qty`='$qty',`od_total_amount`='$amt' WHERE `od_id`='$id'";

	
		
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


    public function deleteRow($id){

        $sql="DELETE FROM `orderdetails` WHERE `od_id`='$id'";

	
		
		try
		{
			$data=$this->db->ExecuteQuery($sql);
			
		
			//No data
			
				return $data;
				
			
		}catch(Exception $e) {	
			throw $e;
		}
    }


	public function checkIfItemExist($iid){

		$uid=$_SESSION["uid"];
        $sql="SELECT * FROM `orderdetails` WHERE `od_item_id`='$iid' AND `od_user_id`='$uid' AND `od-status`='pending'";

	
		
		try
		{
			$data=$this->db->getData($sql);
			
		
			//No data
			if(is_null($data)){
				return true;
			}			
				
			else{
				return false;
			}
		}catch(Exception $e) {	
			throw $e;
		}
    }



	public function sendOrderDetails($oid,$uid,$price,$qty,$total,$item){

		

		$sql="insert into orderdetails (`od_order_id`,`od_user_id`,`od_price`,`od_qty`,`od_total_amount`,`od_item_id`,`od-status`) values ('$oid','$uid','$price','$qty','$total','$item','pending')";
$sql2="select * from orderdetails WHERE od_user_id='$uid' AND `od_item_id`='$item' AND `od-status`='pending'";
	$rows=$this->db->getData($sql2);
		
		
if(count($rows)>0){

	$qtyForRow=$rows[0]["od_qty"];
	$idForRow=$rows[0]["od_id"];

	if(($qtyForRow+$qty)>10){

		    $totalamt=$price*10;
		    $totalamtfloat=number_format((float)$totalamt, 3, '.', '.'); 
		   
		   
		
		    $sql3 = "UPDATE `orderdetails` SET `od_qty`=10 WHERE `od_id`='$idForRow'";
			$this->db->ExecuteQuery($sql3);
		
		                  $sql4 = "UPDATE `orderdetails` SET `od_total_amount`='$totalamtfloat LL' WHERE `od_id`='$idForRow'";
		                  $this->db->ExecuteQuery($sql4);
		
		                
						  
						  
		}
		else{
		   
		    $totalqty=$qtyForRow+$qty;
		    $totalamt=$price*$qty;
		    $totalamtfloat=number_format((float)$totalamt, 3, '.', '.'); 

		    $sql3 = "UPDATE `orderdetails` SET `od_qty`='$totalqty' WHERE `od_id`='$idForRow'";
			$this->db->ExecuteQuery($sql3);
		                  $sql4 = "UPDATE `orderdetails` SET `od_total_amount`='$totalamtfloat LL' WHERE `od_id`='$idForRow'";
		                  $this->db->ExecuteQuery($sql4);
		
						 
		}
	


}

else{

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


	}

	
	

	
	


}

?>