<?php
	include('db_conn.php');
		
	//get the parameter from URL
	$username=$_GET["username"];
	
    $result=$mysqli->query("SELECT `Username` FROM `users` WHERE `Username` LIKE '$username'");
    $result_cnt = $result->num_rows;
	if ($result_cnt!=0) {
		echo "$username exists";
	} else {
		echo "$username available";
		if(!preg_match("#[a-zA-Z]+#", $username))
			echo " but one letter included at least .";
	}

?> 
