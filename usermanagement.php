<?php

include("db_conn.php");
include("session.php");
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
			if($access_type=="2")
			{
				header('location: ./homepage.php');
			}
		}		
	?>
</div>
<?php
if(isset($_POST['submit']))
{
	$query="SELECT Username FROM  users";
	$result=$mysqli->query($query);
	
	while($row = $result->fetch_row())
	{
		$user=$_POST["$row[0]"];
		$mysqli->query("UPDATE users SET Access='$user' where Username='$row[0]'");
	}
	echo "<div id='sector'>You have successfully update all of the user's previlege.</div>";
}
?>

<div id="sector">
	<h1>User Management Table :</h1>
	<hr/>
	<form action="" method="post">
	<table id="form">
	<tr>
		<th>ID</th>
		<th>Username</th>		
		<th>Name</th>
		<th>DOB</th>
		<th>Email</th>
		<th>Access</th>
	</tr>
	 <?php
	$query="SELECT * FROM  users";
	$result=$mysqli->query($query);
	
	while($row = $result->fetch_row())
	{
		echo "<tr>";
		echo "<td>$row[0]</td><td>$row[1]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td>";
		echo "<td><select name='$row[1]' id=''>";
		if($row[6]=='1'){
			echo "<option value='$row[6]' selected='selected'>Admin</option>
					<option value='2'>General</option></td>";
		}else{
			echo"<option value='$row[6]' selected='selected'>General</option>
					<option value='1'>Admin</option></td>";
		}
		echo "<tr>";
	}
	?>

	<tr>
		<td class="submit" colspan="6">
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