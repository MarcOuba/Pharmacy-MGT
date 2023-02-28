<?php
	
	session_start();
    require_once('user.class.php');
	$user = new user();
	

	
	
	
	

	
	 if(isset($_GET["op"]))
	{


			//op 9 for registering user

			if($_GET["op"]==8){
				$username=$_GET["uname"];
				$password=$_GET["upass"];
				$email=$_GET["uemail"];			
				$phone=$_GET["uphone"];
		
		try {
			$result = $user->registerUser($username,$password,$email,$phone);
					 
			
			echo $result;
		}
		catch(Exception $e) {	
			echo -1;
		}
		
			}


		//op 7 for checking if user exist

		if($_GET["op"]==7){
			$username=$_GET["uname"];
			$email=$_GET["uemail"];
			
			$phone=$_GET["uphone"];
	
	try {
		$result = $user->checkIfUserExist($username,$email,$phone);
		 		
		
		echo $result;
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}
		

		//op 6 for activate

		if($_GET["op"]==6){
			$id=$_GET["idActivate"];
	
	try {
		$result = $user->activateUser($id);
		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}

		//op 5 for login

		if($_GET["op"]==5){
			$username=$_GET["uname"];
	$password=$_GET["upwd"];
	
	try {
		$result = $user->getLogin($username,$password);
		$_SESSION["username"]=$username;
		


		header("Content-type:application/json"); 
			
		
	

		        $type=$result[0]['u_type'];
				$_SESSION["type"]=$type;

				$uid=$result[0]["u_id"];
                $_SESSION["uid"]=$uid;
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
	
		}

		//op 4 for displaying users
		if($_GET["op"]==4){
			$name=$_GET["name"];
	
if(isset($_GET["name"])){
	try {
		$result = $user->getUsers($name);

		header("Content-type:application/json"); 		
		
		echo json_encode($result);
	}
	catch(Exception $e) {	
		echo -1;
	}
}
		}

		//op=1 for delete
		if($_GET["op"]==1)
		{			
			$id=$_GET["id"];

			try {
				$result = $user->deactivateUser($id);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}

		//op=2 for update
		else if($_GET["op"]==2)
		{			
			$id=$_GET["id"];
			$username=$_GET["uname"];
			$email=$_GET["uemail"];
			$phone=$_GET["uphone"];
			$utype=$_GET["utype"];
			$status=$_GET["ustatus"];

			try {
				$result = $user->updateUser($id,$username,$email,$phone,$utype);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}
		
		//insert user
		else if($_GET["op"]==3){
			
			$username=$_GET["uname"];
			$password=$_GET["upass"];
			$email=$_GET["uemail"];
			$phone=$_GET["uphone"];
			$utype=$_GET["utype"];
			$status=$_GET["ustatus"];

			try {
				$result = $user->addUser($username,$password,$email,$phone,$utype,$status);
		
				header("Content-type:application/json"); 		
				
				echo json_encode($result);
			}
			catch(Exception $e) {	
				echo -1;
			}
		}
		else{}
		
	
	}
	

	
	



?>
