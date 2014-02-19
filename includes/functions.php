<?php
include 'userclass.php';

define('HOSTNAME',"localhost");
define('DBUSER',"root");
define('DBPASS',"");
define('DATABASE',"project");

function dbquery($querystring){
	$conn=mysqli_connect(HOSTNAME,DBUSER ,DBPASS,DATABASE);
	$result = $conn->query($querystring);
	mysqli_close($conn);
	return $result;
}


function login($user,$password){
	
	if(isset($_COOKIE['userid'])){
	echo "<center>You are already logged in</center>";
	header( "refresh:2;url=../index.php" );
	}
	
	$sqlquery="SELECT id,firstname,lastname FROM users WHERE username='$user' AND password='$password'";
	$rows = mysqli_num_rows(dbquery($sqlquery));
	$data = mysqli_fetch_array(dbquery($sqlquery));
	
	
	if($rows==1){
		setcookie('userid',$data['id'],time()+3600);
		header( "refresh:2;url=../index.php" );
		return "<center>Sucessfully logged in as ".getUserObj($data['id'])->firstname." ".getUserObj($data['id'])->lastname."...<br> Redirecting!</center>";
	}
	else{
		if(!checkuser($user) && !checkpassword($password)){
			return "<center>Username and Password is incorrect!</center>";
		}
		else if(!checkuser($user) || !checkpassword($password)){
			if(!checkuser($user)){
				return "<center>Username is incorrect!</center>";
			}
			if(!checkpassword($password)){
				return "<center>Password is incorrect!</center>";
			}
		}
		header( "refresh:2;url=../index.php" );
	}

}

function logout(){
	if(isset($_COOKIE['userid'])){
	setcookie("userid", "", time()-3600);
	header( "refresh:2;url=../index.php" );
	return "<center>Thank You... Redirecting!</center>";
	}
	else return "<center> You aren't logged in... Redirecting</center>";
}

function checkuser($user){
	$sqlquery = "SELECT id FROM users WHERE username='$user'";
	$rows = mysqli_num_rows(dbquery($sqlquery));
	if($rows == 1) return TRUE;
	else return FALSE;
}

function checkpassword($password){
	$sqlquery = "SELECT id FROM users WHERE password='$password'";
	$rows = mysqli_num_rows(dbquery($sqlquery));
	if($rows == 1) return TRUE;
	else return FALSE;
}

function registerUser($username,$password,$firstname,$lastname,$phonenumber){
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$firstname = mysql_real_escape_string($firstname);
	$lastname = mysql_real_escape_string($lastname);
	$phonenumber = mysql_real_escape_string($phonenumber);
	
	if(checkuser($username)){
		echo "<center>The username already exists</center>";
		exit;
	}
	$sqlquery = "INSERT INTO users (username, password, firstname, lastname, mobile) VALUES ('$username',MD5('$password'),'$firstname','$lastname','$phonenumber')";
	$result = dbquery($sqlquery);
	if($result){
		return TRUE;
	}
	else{
		return FALSE;
	}
}


function loginbox(){
		$filename="templates/loginbox.html";
		$handle = fopen($filename, "r");
		$content = fread($handle, filesize($filename));
		fclose($handle);
		if(isset($_COOKIE['userid'])){
			$replacestring = getUserObj($_COOKIE['userid'])->firstname.' '.getUserObj($_COOKIE['userid'])->lastname."!";
			$content = str_replace('@USERNAME',$replacestring,$content);
			$content = str_replace('@ACTION',"logout.php",$content);
			$content = str_replace('@ACTNAME',"Log Out",$content);
			$start = strpos($content,'<logged>');
			$end = strpos($content,'</logged>')+9;
			$tmpcontent = substr($content,$start,$end-$start);
			$content = str_replace($tmpcontent,'',$content);
		}
		else{
			$content = str_replace('@USERNAME',"Guest!",$content);
			$content = str_replace('@ACTION',"register.php",$content);
			$content = str_replace('@ACTNAME',"Register",$content);
		}
		return $content;

}
?>
