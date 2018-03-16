<?php
//starting session
session_start();

//if the session for username has not been set, initialise it
if(!isset($_SESSION['session_user'])){
	$_SESSION['session_user']="";
}
if(!isset($_SESSION['access_type'])){
	$_SESSION['access_type']="";
}
//save username and access_type in the session 
$session_user=$_SESSION['session_user'];
$access_type=$_SESSION['access_type'];
?>

