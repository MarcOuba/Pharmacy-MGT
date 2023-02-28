<?php
require("DAL.class.php");

class item{

	private $db;
	private $_item_id;
	private $_item_name;
	private $_item_cat_id;
	private $_item_price;
	private $_item_img_path;
	private $_item_branch;
	private $_item_status;
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	
	public function getItemID()
	{
		return $this->_item_id;
	}
	
	public function getName()
	{
		return $this->_item_name;
	}
	
	public function getCatId()
	{
		return $this->_item_cat_id;
	}

	public function getActiveItems($search)
	{
		
			$sql="select * from items";
		
		

		if(!is_null($search))
		
			$sql.=" where item_name like '$search%' AND `item_status`=1";
		
		try
		{
			$data=$this->db->getData($sql);
			
		
			//No data
			if(is_null($data))			
				return 0;
			else
				return $data;
		}catch(Exception $e) {	
			throw $e;
		}
	}

	

	public function getAllItems()
	{
		
			$sql="SELECT items.item_id, categories.cat_name,items.item_name,items.item_price,items.item_img_path,items.item_branch,items.item_status 
			FROM items INNER JOIN categories ON items.item_cat_id = categories.cat_id";

	
		
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

	

	public function getSpecificItems($name)
	{
		
			$sql="SELECT items.item_id,categories.cat_name,items.item_name,items.item_price,items.item_img_path,items.item_branch,items.item_status
			 FROM items INNER JOIN categories ON items.item_cat_id = categories.cat_id AND categories.cat_name='$name'";

	
		
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


	public function addItem($name,$price,$img,$cat,$branch,$status)
	{
		try
		{
			$sql="insert into items (item_name,item_price,item_img_path,item_cat_id,item_branch,item_status) values ('$name','$price','$img','$cat','$branch','$status')";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}


	public function updateItem($id,$name,$cat_id,$price,$imgPath,$branch,$status)
	{
		try
		{
			$sql="UPDATE items SET `item_name`='$name', `item_cat_id`='$cat_id',`item_price`='$price',`item_img_path`='$imgPath',`item_branch`='$branch',`item_status`='$status' WHERE `item_id`='$id'";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}

	public function deactivateItem($id)
	{
		try
		{
			$sql="update items set item_status=0 where item_id=$id";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}

	public function activateItem($id){
		try
		{
			$sql="update items set item_status=1 where item_id=$id";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}
	

	
	


}

?>