<?php
//include the file session.php
include("session.php");
//include the file db_conn.php
include("db_conn.php");

//receive the username data from the form
$user=$_POST['Username'];

//receive the password data from the form
$password=MD5($_POST['Password']);

$result=$mysqli->query("SELECT * FROM `users` WHERE `Username` like '$user'");
$result_cnt = $result->num_rows;
if($result_cnt==0) {
	echo "Username does not exist. Please sign up";
	header('Location: ./homepage.php?usernameerror=Invalid username');
}else {
	$row=$result->fetch_array(MYSQLI_ASSOC);
	//if the username from table/database is not same as the username data from the form
	if($row['Username']!=$user || $user=="")
	{
	//automatically go back to homepage and pass the error message
		header('Location: ./homepage.php?usernameerror=Invalid username');
	}//if the username is same as the username data from the form 
	else{
		//if the password from table/database is same as the password data from the form
		if($row['Password']==$password) {
			//save the username in the session
			$session_user=$row['Username'];
			$_SESSION['session_user']=$session_user;
			$_SESSION['access_type']=$row['Access'];
			//automatically go to myarea.php
			
			header('Location: ./myarea.php');
		}//if the password from table/database does not match with the password data from the signin form
		else{
			//automatically go back to homepage and pass the error message
			header('Location: ./homepage.php?passworderror=Invalid_password');
		}
	}
}
?>