<?php
		include 'includes/functions.php';

		$replacestring = '';
		$mainpath="templates/index.html";
		$registertemp="templates/register.html";
		$handle = fopen($mainpath, "r");
		$maincontent = fread($handle, filesize($mainpath));
			
		if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['phonenumber']) && isset($_POST['confirmpass'])){
			$confirmpass = $_POST['confirmpass'];
			$password = $_POST['password'];
			
			if($password != $confirmpass){
				$replacestring = "<center>Passwords Don't Match</center>";
				header( "refresh:2;url=register.php" );				
			}
			else{
				$username = mysql_real_escape_string($_POST['username']);	
				$firstname = mysql_real_escape_string($_POST['firstname']);
				$lastname = mysql_real_escape_string($_POST['lastname']);
				$phonenumber = mysql_real_escape_string($_POST['phonenumber']);
				if(registerUser($username,$password,$firstname,$lastname,$phonenumber)){
					$replacestring = "Registration Sucessful!";
					$maincontent = str_replace('@MAINCONTENT',$replacestring,$maincontent);
				}
				setcookie("userid", "", time()-3600);
				login($username,MD5($password));
			}
		}
		else{
			$handle = fopen($registertemp, "r");
			$registercontent = fread($handle, filesize($registertemp));
			$replacestring = $registercontent;
			$maincontent = str_replace('@MAINCONTENT',$registercontent,$maincontent);

		}
		$maincontent = str_replace('@MAINCONTENT',$replacestring,$maincontent);
		$maincontent = str_replace('@LOGINBOX',loginbox(),$maincontent);
		echo $maincontent;
?>