<?php
//include the file session.php
include("session.php");
//database connection
include("db_conn.php");

if(isset($_POST['submit']))
{
	
	$Gender=$_POST['Gender'];
	$State=$_POST['state'];
	$City=$_POST['city'];
	$Satisfaction=$_POST['Satisfaction'];
	//var_dump($_POST);
	$error="";
	if($Gender=="")
	{
		$error .= "Please select your gender. <BR/>";
	}
	if($State=="")
	{
		$error .= "Please select your state. <BR/>";
	}
	if($City=="")
	{
		$error .= "Please select your city. <BR/>";
	}
	if($Satisfaction=="")
	{
		$error .= "Please select your satisfaction. <BR/>";
	}
	if($error==""){
			//query for inserting
			$insertquery="INSERT INTO `feedback`(`ID`, `Gender`, `State`, `City`, `Satisfaction`) VALUES ('', '$Gender','$State','$City','$Satisfaction')";
			//execute the insert query
			$mysqli->query($insertquery);
			
			echo "<div id='section'>You have successfully submit your feedback!. <BR/></div>";
	}
}
?>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Student Feedback</title>
	<link rel="stylesheet" href="./css/styles.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	  
      function update_city(){
         //assigns the selected state to state variable.
		 
         var state = $('#state').val();
		 //get_city.php performs when the state is selected.
         //call the function(show_city) when the data is returned from get_cities.php.
         $.post('get_city.php?state='+state,show_city);
      }
      
      function show_city(city){
         //returned data from get_city.php is assigned to city
	     //change the field(drop down list)
         $('#city').html(city);
		}
	</script>
</head>

<body>

	<div id="header">
	<h1>Student Feedback</h1>
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
	<form action="#" method="post">
	<table id="form">
		<tr>	
   			<td class="label">* Gender</td>
      		<td>
				<input type="radio" name="Gender" value="female">Female
				<input type="radio" name="Gender" value="male">Male</td>
      	</tr>

		<tr>	
   			<td class="label">* State</td>
            <td>
               <select name="state" id="state" onchange="update_city()">
					<option value="" selected="selected">Please Select State</option>
					<option value="TAS">Tasmania</option>
					<option value="WA">Western Australia</option>
					<option value="VIC">Victoria</option>
					<option value="SA">South Australia</option>
					<option value="QLD">Queensland</option>
					<option value="NT">Northern  Territorry</option>
					<option value="NSW">New South Wales</option>
					<option value="ACT">Australian Capital Territory</option>
				</select>
            </td>
		</tr>
        <tr id="city">
		</tr>
		<tr>	
   			<td class="label">* Satisfaction</td>
      		<td>
				<input type="radio" name="Satisfaction" value="satisfied">satisfied
				<input type="radio" name="Satisfaction" value="not satisfied">not satisfied
			</td>
      	</tr>
    	<!--row for submit button.-->
    	<tr>
        	<td colspan="2" class="submit">
			<input type="submit" name="submit" value="Submit">
			<input type="reset" name="reset" value="Reset"></td>
    	</tr>
    	
    	<!--show error message if there is any.-->
    	<tr>
    		<td colspan="2">
    		<?php    		
			if (isset($error)) {
    			echo $error; 
			} 
			else echo "* Theses fields must be filled.";
			?></td>
    	</tr>
	</table>
	</form>
	</div>
</body>
</html>
