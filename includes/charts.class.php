<?php
require("DAL.class.php");

class chart{

	private $db;
	
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	
	

	

	public function getOrderQty(){
		$_SESSION["items"]=[];
		$_SESSION["itemsId"]=[];
	


		
		$sql="SELECT * FROM items";
		$data=$this->db->getData($sql);
		$chart_data = '';
		$zero=0;
		for($i=0;$i<count($data);$i++){
			
			array_push($_SESSION["items"],$data[$i]["item_name"]);
			array_push($_SESSION["itemsId"],$data[$i]["item_id"]);
			
$itemid=$data[$i]["item_id"];

			$sql2="SELECT SUM(od_qty) as qty FROM orderdetails WHERE od_item_id='$itemid' AND orderdetails.`od-status`='completed' UNION ALL SELECT items.item_name from items WHERE items.item_id='$itemid'";
			
	
		
		$data2=$this->db->getData($sql2);
		if($data2[0]["qty"] == "" && count($data2)==1){
			
		}
		else if($data2[0]["qty"] == "" && count($data2)==2){
			$chart_data .= '{ "label":"'.$data2[1]["qty"].'", "value":'.$zero.'}, ';
		}
		else{

		
		$chart_data .= '{ "label":"'.$data2[1]["qty"].'", "value":'.$data2[0]["qty"].'}, ';
		}
		
			
			

		}
		$chart_data = substr($chart_data, 0, -2);
		$chart_data = "[".$chart_data."]";
		return $chart_data;
	
	

	}

	


	public function getNetWorth(){


		$item=$_SESSION["items"];
		$itemId=$_SESSION["itemsId"];

$chart_data = '';



$zero=0;
	

for($i=0;$i<count($item);$i++){
	
	
	$itemid=$itemId[$i];
	
	$sql="SELECT `od_total_amount` FROM `orderdetails` WHERE `od-status`='completed' AND `od_item_id`='$itemid'";

	$data=$this->db->getData($sql);
	
	if($data[0]['od_total_amount']!=0){
		$z=[];
	$totalamt=0;
	for($j=0;$j<count($data);$j++){
	$x =$data[$j]['od_total_amount'];
	array_push($z,$x);
	
	}

	for($a=0;$a<count($data);$a++){
		$first=$z[$a];
		$toNumb=str_replace(".","",$first);
		$toNumb2=(int)substr($toNumb, 0, -3);
		
		$totalamt+=$toNumb2;
		$totalamtfloat=number_format((float)$totalamt, 0, '.', '.'); 
		}

		$chart_data .= '{"label":"'.$item[$i].'", "value":'.$totalamt.' }, ';
}
else{
	$chart_data .= '{"label":"'.$item[$i].'", "value":'.$zero.' }, ';
}








	
	

}
$chart_data = substr($chart_data, 0, -2);
$chart_data = "[".$chart_data."]";
return $chart_data;

	
	}





	public function getUsersNetWorth(){


	$users="SELECT * FROM users";
	$usersData=$this->db->getData($users);

$chart_data = '';



$zero=0;
	

for($i=0;$i<count($usersData);$i++){
	
	
	$userId=$usersData[$i]["u_id"];
	
	$sql="SELECT `od_total_amount` FROM `orderdetails` WHERE `od-status`='completed' AND `od_user_id`='$userId'";

	$data=$this->db->getData($sql);
	
	if($data[0]['od_total_amount']!=0){
		$z=[];
	$totalamt=0;
	for($j=0;$j<count($data);$j++){
	$x =$data[$j]['od_total_amount'];
	array_push($z,$x);
	
	}

	for($a=0;$a<count($data);$a++){
		$first=$z[$a];
		$toNumb=str_replace(".","",$first);
		$toNumb2=(int)substr($toNumb, 0, -3);
		
		$totalamt+=$toNumb2;
		$totalamtfloat=number_format((float)$totalamt, 0, '.', '.'); 
		}

		$chart_data .= '{"label":"'.$usersData[$i]["u_username"].'", "value":'.$totalamt.' }, ';
}
else{
	$chart_data .= '{"label":"'.$usersData[$i]["u_username"].'", "value":'.$zero.' }, ';
}








	
	

}
$chart_data = substr($chart_data, 0, -2);
$chart_data = "[".$chart_data."]";
return $chart_data;

	
	}

	
	

	
	


}

?>