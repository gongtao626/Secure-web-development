<?php

include("db_conn.php");
include("session.php");

if(isset($_POST['submit']))
{	
	$encryped_password = MD5($_POST['Password']);

	$query = "SELECT Password FROM users where Username='$session_user'";
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	if(strcmp($row['Password'], $encryped_password) != 0)
	{
		echo '<script>';
		echo 'alert("Wrong Password !");';
		echo '</script>';
		
	}
	else
	{
		header('location: ./usermanagement.php');
	}	
}
?>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>
	<div id="header">
		<h1>Admin</h1>
	</div>
	
	<div id="nav">
		<a href="homepage.php">Home Page</a><br/>
		<?php
			if($session_user!="")
			{
				echo '<a href="myarea.php">My Area</a><br/>';
				echo '<a href="feedback.php">Student Feedback</a><br/>';
				if($access_type=="1"){
					echo '<a href="admin.php">Admin</a><br/>';
				}
			}
		?>
		<a href="contactus.php">Contact Us</a><br/>
	</div>	

<div id="signinout">
	<?php 
		if($session_user=="") {
			header('location: ./homepage.php');
		}
		else{
			  echo "<b>Welcome $session_user!</b><br/>";
			  echo "<a href='signout.php'>Logout</a>";
	}		
	?>
</div>
<div id="section">
	<form action="" method="post">
	<table id="form">
		<tr> 
			
			<td colspan="2"> Enter the password to manage user table.</td>
		</tr>
		<tr> 
			
			<td class="details">Username</td>
			<td><input name="id" value="<?php echo $session_user; ?>" disabled /></td>
		</tr>
		<tr>
			<!--password field for authenticating-->
			<td class="details">Password</td>
			<td><input name="Password" type="password"></td>
		</tr>
		<tr>
			<td class="submit" colspan="2">
				<input type="submit" name="submit" value="Submit">
			</td>
		</tr>
	</table>
	</form>
</div>

<div id="footer">
	Copyright © taog 225787
</div>
</body>
</html>
