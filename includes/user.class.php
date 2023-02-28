<?php
require("DAL.class.php");


class user{

	private $db;
	private $_uId;
	private $_name;
	private $_type;
	private $_active;
	
	public function __construct() {
   		$this->db = new DAL();
	}	
	
	public function __destruct(){
	
		$this->db=null;
	}
	
	public function getUID()
	{
		return $this->_uId;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getType()
	{
		return $this->_type;
	}

	public function getUsers($search)
	{
		
		$sql="select * from users";
	
		if(!is_null($search))
			$sql.=" where u_username like '$search%'";
		
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
	

	

	public function activateUser($id){
		try
		{
			$sql="update users set u_status=1 where u_id=$id";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}
	
	
	
	
	public function getLogin($username,$password)
	{


  

  
// Store the cipher method
$ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
  
// Store the encryption key
$encryption_key = "Marc";
  
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($password, $ciphering,
            $encryption_key, $options, $encryption_iv);
  

  


		$sql="select * from users where u_username='$username' and u_password='$encryption' and u_status=1";
	
		
		try
		{
			$data=$this->db->getData($sql);
		
			//user credentials are not valid or user is not active
			if(is_null($data))			
				return 0;			
			else//user credentials are valid and user is active
			{
				
				
				return $data;
			}
		}catch(Exception $e) {	
			throw $e;
		}
	}
	
	
	
	public function addUser($uname,$pwd,$email,$phone,$type,$status)

	
	{

		// Store the cipher method
$ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
  
// Store the encryption key
$encryption_key = "Marc";
  
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($pwd, $ciphering,
            $encryption_key, $options, $encryption_iv);
  

		try
		{
			$sql="insert into users (u_username,u_password,u_email,u_phone,u_type,u_status) values ('$uname','$encryption','$email','$phone','$type','$status')";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}
	
	
	public function updateUser($id,$username,$email,$phone,$utype)
	{
		try
		{
			$sql="UPDATE users SET `u_username`='$username', `u_email`='$email',`u_phone`='$phone',`u_type`='$utype' WHERE `u_id`='$id'";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}
	
	public function deactivateUser($id)
	{
		try
		{
			$sql="update users set u_status=0 where u_id=$id";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		
	}

	public function registerUser($username,$password,$email,$phone){


		// Store a string into the variable which

   
// Store the cipher method
$ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
  
// Store the encryption key
$encryption_key = "Marc";
  
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($password, $ciphering,
            $encryption_key, $options, $encryption_iv);
  

  


  


		try
		{
			$sql="INSERT INTO `users`( `u_username`, `u_password`, `u_email`, `u_phone`,`u_status`,`u_type`) VALUES ('$username','$encryption','$email','$phone',1,'user')";
			
			$result=$this->db->ExecuteQuery($sql);
			
			return $result;
			
		}catch(Exception $e) {	
			throw $e;
		}		

	}

	public function checkIfUserExist($username,$email,$phone){

		$sql="SELECT * FROM `users` WHERE `u_username`='$username' ";		
			$result=$this->db->getData($sql);

			
			$sql3="SELECT * FROM `users` WHERE `u_email`='$email' ";		
			$result3=$this->db->getData($sql3);

			$sql4="SELECT * FROM `users` WHERE `u_phone`='$phone' ";		
			$result4=$this->db->getData($sql4);

		try
		{
			if(is_countable($result)){
				return "usernameError";
			}
			
			else if(is_countable($result3)){
				return "emailError";
			}
			else if(is_countable($result4)){
				return "phoneError";
			}
			else{
				return "noError";
			}
			
			
			
			
		}catch(Exception $e) {	
			throw $e;
		}		

	}




}

?>