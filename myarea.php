<?php

include("db_conn.php");
include("session.php");

?>
<html>
<head>
	<title>MyArea</title>
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	  
      function update_month(){
         //assigns the selected year to year variable.
		 //assigns the default month to month variable.
         var year = $('#year').val();
		 var month="";
		 //get_month.php performs when the year is selected.
         //call the function(show_months) when the data is returned from get_cities.php.
         $.post('get_month.php?year='+year,show_months);
		 $.post('get_day.php?year='+year+'&month='+month, show_days);
      }
      
      function show_months(month){
         //returned data from get_cities.php is assigned to cities
	     //change the field(drop down list)
         $('#month').html(month);
		}
	
       function update_days(){
		   var month=$('#monthselect').val();
		   var year =  $('#year').val();
		   $.post('get_day.php?year='+year+'&month='+month, show_days);
	   }
	   function show_days(days){
		   $('#day').html(days);
	   }
    </script>

</head>

<body>
	<div id="header">
	<h1>My Area</h1>
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
<?php
if(isset($_POST['submit'])){

	$Username=$_SESSION['session_user'];
	$Name=$_POST['Name'];
	
	$year=$_POST['year'];
	if($year!="")
	{
		$month=$_POST['months'];
		$day=$_POST['days'];
		if($day=="")
			$day="01";
		if($month=="")
			$month="01";
		$DOB="$year-$month-$day";
	}
	else{
		$DOB=$_POST['DOB'];
	}
		
	$Email=$_POST['Email'];
  
    //setting the error message
    $error="";
        
    //name validation
	if($Name==""){
    	$error.="* Please type your First name and Last name"."<br/>";
    }
	elseif(!preg_match("#[ ]+#", $Name)){
    	//if the Name does not include any space
    	$error.="* Name must contain a space with your first name and last name!<br/>";
	}
	
	if($DOB==""){
		$error.="* Please select your date of birth."."<br/>";
	}
	//email validation
	if($Email==""){}
	elseif(filter_var($Email,FILTER_VALIDATE_EMAIL)==FALSE){
		//if the email is not proper..(format)
			$error.="* Please type the correct format of email address"."<br/>";
    }
    
    if($error==""){
    	//encrypt password
    	$date_field=date('Y-m-d',strtotime($DOB));
    	//query for inserting
		$updatequery="UPDATE `users` SET `Name`='$Name', `DOB`='$DOB', `Email`='$Email' where `Username`='$Username'";
		
		//execute the insert query
		$mysqli->query($updatequery);

		echo "<div id='section'>You have successfully renew your information!<BR/></div>";
	}
?>
	
	<form action="#" method="post">
	<table id="form">
		<tr>	
   			<td class="label">* Username</td>
      		<td><input name="Username" value="<?php echo $_SESSION['session_user']; ?>" disabled /></td>
      	</tr>
		<tr>	
   			<td class="label">* Name</td>
      		<td><input type="text" name="Name" value="<?php if(isset($Name)) echo $Name; ?>" /></td>
      	</tr>
		<tr>	
   			<td class="label">* Date Of Birth</td>
      		<td><input type="text" name="DOB" value="<?php if(isset($DOB)) echo $DOB; ?>" /></td>
            <td>
               <select name="year" id="year" onchange="update_month()">
                <option value="" selected="selected">Please Select New Year</option>
			<?php     
				for ($i = 2016; $i >1109; $i--)
				{
					echo "<option value='".$i."'>".$i."</option>";
				}
			?>
               </select>
            </td>
            <td id="month"></td>
			<td id="day"></td>			
      	</tr>
		<tr>
			<td class="label">  Email</td>
      		<td><input type="text" name="Email" value="<?php if(isset($Email)) echo $Email; ?>"></td>
   		</tr>
   		 	
    	<!--row for submit button.-->
    	<tr>
        	<td colspan="2" class="submit"><input type="submit" name="submit" value="Submit"><input type="reset" name="reset" value="Reset"></td>
    	</tr>
    	
    	<!--show error message if there is any.-->
    	<tr>
    		<td colspan="2">
    		<?php    		
			if (isset($error)) {
    			echo $error; 
			} 
			else echo "* Theses fields must be filled. <BR/>";
			?></td>
    	</tr>
	</table>
	</form>
		<?php
		
}
else
{
if(!isset($_POST['submitauth']))
{
?>

<form action="" method="post">
<table id="form">
	<tr> 
		
    	<td colspan="2"> Enter the password to renew your details.</td>
  	</tr>
	<tr> 
      	<td class="details">Username</td>
     	<td><input name="Username" value="<?php echo $_SESSION['session_user']; ?>" disabled /></td>
    </tr>
    <tr>
    	<!--password field for authenticating-->
    	<td class="details">Password</td>
      	<td><input name="password" type="password"></td>
    </tr>
    <tr>
   		<td class="submit" colspan="2">
   			<input type="submit" name="submitauth" value="Submit">
      	</td>
    </tr>
</table>
</form>


<?php	
}
else if(isset($_POST['submitauth']))  
{
	$session_user = $_SESSION['session_user'];
	$access_type = $_SESSION['access_type'];
	
	$password = $_POST['password'];
	
	$encryped_password=MD5($password);

	$result=$mysqli->query("SELECT * FROM `users` WHERE `Username` like '$session_user'");

	$row = $result->fetch_array(MYSQLI_ASSOC);
	$row_password = $row['Password'];
	
	if(strcmp($row_password, $encryped_password) != 0)
	{
		echo '<script>';
		echo 'alert("Wrong Password !");';
		echo '</script>';
?>
	
<form action="" method="post">
<table id="form">
	<tr> 
		
    	<td colspan="2"> Enter the password to renew your details.</td>
  	</tr>
	<tr> 
      	<td class="details">Username</td>
     	<td><input name="Username" value="<?php echo $_SESSION['session_user']; ?>" disabled /></td>
    </tr>
    <tr>
    	<!--password field for authenticating-->
    	<td class="details">Password</td>
      	<td><input name="password" type="password"></td>
    </tr>
    <tr>
   		<td class="submit" colspan="2">
   			<input type="submit" name="submitauth" value="Submit">
      	</td>
    </tr>
</table>
</form>

<?php	
	}
	else
	{
		$query="select * from users where Username='$session_user'";
		$result = $mysqli->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$Name = $row['Name'];
		$DOB = $row['DOB'];
		$Email = $row['Email'];
?>

	<form action="#" method="post">
	<table id="form">
		<tr>	
   			<td class="label">* Username</td>
      		<td><input name="Username" value="<?php echo $_SESSION['session_user']; ?>" disabled /></td>
      	</tr>
		<tr>	
   			<td class="label">* Name</td>
      		<td><input type="text" name="Name" value="<?php if(isset($Name)) echo $Name; ?>" /></td>
      	</tr>
		<tr>	
   			<td class="label">* Date Of Birth</td>
      		<td><input type="text" name="DOB" value="<?php if(isset($DOB)) echo $DOB; ?>" /></td>
            <td>
               <select name="year" id="year" onchange="update_month()">
                <option value="" selected="selected">Please Select New Year</option>
			<?php     
				for ($i = 2016; $i >1109; $i--)
				{
					echo "<option value='".$i."'>".$i."</option>";
				}
			?>
               </select>
            </td>
            <td id="month"></td>
			<td id="day"></td>			
      	</tr>
		<tr>
			<td class="label">  Email</td>
      		<td><input type="text" name="Email" value="<?php if(isset($Email)) echo $Email; ?>"></td>
   		</tr>
   		 	
    	<!--row for submit button.-->
    	<tr>
        	<td colspan="2" class="submit"><input type="submit" name="submit" value="Submit"><input type="reset" name="reset" value="Reset"></td>
    	</tr>
    	
    	<!--show error message if there is any.-->
    	<tr>
    		<td colspan="2">
    		<?php    		
			if (isset($error)) {
    			echo $error; 
			} 
			else echo "* Theses fields must be filled. <BR/>";
			?></td>
    	</tr>
	</table>
	</form>
<?php
	}	
}
}
?>
</div>

	
	<div id="footer">
		Copyright © taog 225787
	</div>
</body>
</html>
