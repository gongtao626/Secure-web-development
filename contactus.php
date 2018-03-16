<?php
include("session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Contact Us</title>
	<link rel="stylesheet" href="./css/styles.css">
</head>

<body>
	<div id="header">
	<h1>Contact Us</h1>
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
	</div>
	<div id="section">
	<h2>Contact of  State</h2>
	<ul style="list-style-type:square">
	  <li>ACT: 04 12345678 Mr. Lee</li><br/>
	  <li>NSW: 04 12345678 Mr. Lee</li><br/>
	  <li>NT:  04 12345678 Mr. Lee</li><br/>
	  <li>QLD: 04 12345678 Mr. Lee</li><br/>
	  <li>SA:  04 12345678 Mr. Lee</li><br/>
	  <li>TAS: 04 12345678 Mr. Lee</li><br/>
	  <li>VIC: 04 12345678 Mr. Lee</li><br/>
	  <li>WA:  04 12345678 Mr. Lee</li>
	</ul>
	</div>
	
	<div id="footer">
	Copyright © taog 225787
	</div>
</body>
</html>
