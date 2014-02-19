<?php
	include 'includes/functions.php';
	
	if($_POST["username"]==""){
		header( 'Location: index.php' );
	}
	if($_POST["password"]==""){
		header( 'Location: index.php' );
	}
	
	$user=mysql_real_escape_string($_POST["username"]);
	$password=mysql_real_escape_string(md5($_POST["password"]));

	$replacestring = '';
	$mainpath="templates/index.html";
	$handle = fopen($mainpath, "r");
	$maincontent = fread($handle, filesize($mainpath));
	$maincontent = str_replace("@MAINCONTENT",login($user,$password),$maincontent);
	$maincontent = str_replace("@LOGINBOX",loginbox(),$maincontent);
	echo $maincontent;

	

?>