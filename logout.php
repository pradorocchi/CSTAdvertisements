<?php
	include 'includes/functions.php';
	$replacestring = '';
	$mainpath="templates/index.html";
	$handle = fopen($mainpath, "r");
	$maincontent = fread($handle, filesize($mainpath));
	$maincontent = str_replace("@MAINCONTENT",logout(),$maincontent);
	$maincontent = str_replace("@LOGINBOX",loginbox(),$maincontent);
	echo $maincontent;
?>