<?php
//include the file session.php
include("session.php");
//database connection
include("db_conn.php");
if($session_user!="") {
	header('location: ./myarea.php');
}
?>
<html>
<head>
<title>Sign Up</title>
<link rel="stylesheet" href="./css/styles.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
     	
     	// make button not submit a form (if type is not submit)
     	$('button[type!=submit]').click(function(){
        	// code to cancel changes
        	return false;
    	});

	    // when user clicks the check button id='check', execute the following function
	    $("#check").click( function () {
	      	
	      		// get the value of username field and assign as username.
	     		var username = $("#Username").val();
	      		
	      		// send the data 'username' as username to checker.php and execute the following function (if the data sending is successful)
	      		$.get( "checker.php", { username: username} )
				  .done(function( data ) {
				  		// print the data (output of checker.php) as a label for 'username' id='output'
					    $("#output").html(data);
				});     	
	    });       
     });
</script>
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
	<h1>Sign Up</h1>
	</div>
	
	<div id="nav">
		<a href="homepage.php">Home Page</a><br/>
		<a href="contactus.php">Contact Us</a><br/>
	</div>	
<?php    
if(isset($_POST['submit'])){
	$Username=$_POST['Username'];
    $Password=$_POST['Password'];
	$Retype_Password=$_POST['Retype_Password'];
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
        
    //Username validation
    if($Username==""){
    	$error.="* Please type your username"."<br/>";
    }
	elseif(!preg_match("#[a-zA-Z]+#", $Username)){
 		//if the Username does not include any letter
		$error.="* Username must include at least one letter!<br/>";
	}else
	{
		$result=$mysqli->query("SELECT `Username` FROM `users` WHERE `Username` LIKE '$Username'");
		$result_cnt = $result->num_rows;
		
		if ($result_cnt!=0){
			$error.="* Username exists. Please reselect your username"."<br/>";
		}	
	}
	
    //password validation
    if($Password==""){
    	$error.="* Please type the password"."<br/>";
    }
    elseif(strlen($Password)<8){
    	//if the password is under 8 characters
    	$error.="* The password must contain at least 8 characters"."<br/>";
    }
    elseif(preg_match("#[ ]+#", $Password)){
    	//if the password include any space
    	$error.="* Password must not contain any space!<br/>";
	}
	
	if($Retype_Password!=$Password){
		$error.="* Retype_Password is not exactly same as Password!"."<br/>";
	}
	
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
    	$encrypt_password=MD5($Password);
    	$date_field=date('Y-m-d',strtotime($DOB));

    	//query for inserting
    	$insertquery="INSERT INTO `users`(`ID`, `Username`, `Password`, `Name`, `DOB`, `Email`, `Access`) VALUES ('', '$Username','$encrypt_password','$Name','$date_field','$Email', '2')";
    	//execute the insert query
    	$mysqli->query($insertquery);
		$_SESSION['session_user']=$Username;
		$_SESSION['access_type']='2';
		$session_user=$_SESSION['session_user'];
		$access_type='2';
		echo "You have successfully signed up! Redirecting to your area.</br>";
		$newpage="./myarea.php";
    	//automatically go to myarea.php
        header("REFRESH: 2; URL=$newpage");
    }
}
?>


	<div id="section">   
	
	<form action="" method="post">
	
	<table id="form">
		<!--row for username field (required field).-->
		<tr>	
   			<td class="label">* Username</td>
      		<td><input type="text" id="Username" name="Username" value="<?php if(isset($Username)) echo $Username; ?>" /></td>
			<td><button id="check">Check</button> <label id="output" for="Username"></label></td>
      	</tr>
      	
		<!--row for password field (required field). -->
		<tr>
			<td class="label">* Password</td>
			<td><input name="Password" type="password"></td>
		</tr>
		<!--row for password field (required field). -->
		<tr>
			<td class="label">* Re-type Password</td>
			<td><input name="Retype_Password" type="password"></td>
		</tr>
		<!--row for Name field -->
		<tr>	
   			<td class="label">* Name</td>
      		<td><input type="text" name="Name" value="<?php if(isset($Name)) echo $Name; ?>" /></td>
      	</tr>
		<tr>	
   			<td class="label">* Date Of Birth</td>
			<td><input type="text" name="DOB" value="<?php if(isset($DOB)) echo $DOB; ?>" /></td>
      		
            <td>
               <select name="year" id="year" onchange="update_month()">
                <option value="" selected="selected">Please Select Year</option>
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
		
		<!--row for email field (required field).-->
		<tr>
			<td class="label">  Email</td>
      		<td><input type="text" name="Email" value="<?php if(isset($Email)) echo $Email; ?>"></td>
   		</tr>
   		 	
    	<!--row for submit button.-->
    	<tr>
        	<td colspan="2" class="submit"><input type="submit" name="submit" value="Sign Up"><input type="reset" name="reset" value="Reset"></td>
    	</tr>
    	
    	<!--show error message if there is any.-->
    	<tr>
    		<td colspan="2">
    		<?php    		
			if (isset($error)) {
    			echo $error; 
			} 
			else echo "* Theses fields must be filled <BR/>
			Password must contain at least 8 characters which must not include
			<BR/> any spaces (all other characters are acceptable).";
			?></td>
    	</tr>
	</table>
	</form>
	</div>
	
	<div id="footer">
	Copyright © taog 225787
	</div>
</body>
</html>