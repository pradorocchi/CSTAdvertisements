<?php
class User{
   public $id;
   public $username;
   public $password;
   public $firstname;
   public $lastname;
}

function getUserObj($id){
	$id = mysql_real_escape_string($id);
	$sqlquery="SELECT firstname,lastname FROM users WHERE id='$id'";
	$conn=mysqli_connect(HOSTNAME,DBUSER ,DBPASS,DATABASE);
	$result = $conn->query($sqlquery);
	$data = mysqli_fetch_array($result);
	
	$userObj = new User($id);
	$userObj->firstname = $data['firstname'];
	$userObj->lastname = $data['lastname'];
	return $userObj;
}

?>