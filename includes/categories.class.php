<?php
require("DAL.class.php");

class categories{

	private $db;
	private $_cat_id;
	private $_cat_name;
	private $_cat_item_name;
	private $_cat_status;
	
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	
	public function getCatID()
	{
		return $this->_cat_id;
	}
	
	public function getName()
	{
		return $this->_cat_name;
	}
	
	public function getItemName()
	{
		return $this->_cat_item_name;
	}

	

	public function getCategories()
	{
		
			$sql="SELECT * from categories";

	
		
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

	public function addCategory($name)
	{
		
			$sql="INSERT INTO categories (cat_name,cat_status) values ('$name','0')";

	
		
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

	public function editCategory($name,$id)
	{
		
			$sql="UPDATE categories SET `cat_name`='$name' WHERE `cat_id`='$id'";

	
		
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

	public function deleteItemsInsideCategory($name)
	{
		
			$sql="UPDATE items SET `item_status`='0' WHERE `item_name`='$name'";

	
		
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

	

	
	


}

?>