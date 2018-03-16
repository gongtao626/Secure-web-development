<?php
//include the file session.php
include("session.php");
//include the file db_conn.php
include("db_conn.php");


?>


<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="./css/styles.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
	<div id="header">
	<h1>Secure Web Programming</h1>
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
	?>
	<a href="signup.php">Create your account</a><table>
	<h2>Please login to the system</h2>
    <form action="./signin_engine.php" method="post">
    	<tr>
    		<td><font color="#FF0000">*</font>	Username:</td>
    		<td><input name="Username" type="text" id="username" size="20" style="border:1px #333333 solid;width:100px;height:20px;"></td>
			<td><?php
				//if there is any received error message 
				if(isset($_GET['usernameerror']))
				{
					$errormessage=$_GET['usernameerror'];
					//show error message
					echo "<b>$errormessage</b><br/>";
				}
				?>
			</td>
 		</tr>
 		<tr>
 	    	<td><font color="#FF0000">*</font>	Password:</td>
 	    	<td><input name="Password" type="password" id="password" size="20" style="border:1px #333333 solid;width:100px;height:20px;"></td>
			<td><?php
				//if there is any received error message 
				if(isset($_GET['passworderror']))
				{
					$errormessage=$_GET['passworderror'];
					//show error message
					echo "<b>$errormessage</b><br/>";
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="submit" colspan="2"><input type="submit" name="login" value="Login">
     	</tr>
	</form>
	</table>
	
<?php
	}else
	{
		  echo "<b>Welcome $session_user!</b><br/>";
		  echo "<a href='signout.php'>Logout</a>";
	}		
?>
</div>


	<div id="section">
	<h2>Introduction</h2>
	<p>Welcome to Secure Web Programming. You can find information about this course.</p>

	<h2>Availabe user access levels</h2>
	<p>	<ol>
		  <li>Public User</li><br/>
		  <li>Enrolled Student</li><br/>
		  <li>Lecturer (Administrator)</li>
		</ol>
	<p>
	
	<h2>Staff</h2>
	<?php
		$admin_query = "select * from `users` where `Access`='1' order by Name";
		$admin_result=$mysqli->query($admin_query);
		echo "<ul id='stafflist'>";
		$index=0;
		while($row=$admin_result->fetch_array(MYSQLI_ASSOC))
		{
			echo "<li>".$row["Name"]."</li>";
			echo "<p id='detail".$row["ID"]."'> Date of Birth: ".$row['DOB']."<br/>Email: ".$row['Email']."<br/>";
			
			echo "<script>";
			echo "$(document).ready(function(){
					$('#detail".$row["ID"]."').hide();"." $('ul li:eq(".$index.")').click(function(){ "."$('#detail".$row["ID"]."').toggle();}) });";
			echo "</script>";
			$index++;
		}
		echo "</ul>";
	?>
	
	<h2>Assignment Due</h2>
	<p>Details of Assignment: 11 April 2016</p>

	<h2>Social BBQ</h2>
	<p>We will go to city for a BBQ.</p>

	<h2>Other Activity</h2>
	<p>Tutorial discussion at 26 May 2016.</p>
	<br/>
	<?php 
		echo "Time: ".date('l jS \of F Y h:i:s A');
	?>
	<br/>
	</div>

	<div id="footer">
	Copyright © taog 225787
	</div>
</body>
</html>
