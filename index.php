<?php
		include 'includes/functions.php';
		
		$filename="templates/index.html";
		$handle = fopen($filename, "r");
		$content = fread($handle, filesize($filename));
		$content = str_replace('@MAINCONTENT',"TESTCONTENT",$content);
		$content = str_replace('@LOGINBOX',loginbox(),$content);
		echo $content;
?>