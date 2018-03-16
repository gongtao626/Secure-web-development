
<?php
    $year=$_REQUEST['year'];
	$month=$_REQUEST['month'];
	
	if(!$year ){
		echo "";
	}
	elseif(!$month){
		echo "";
	}
    else
	{
		echo "<select name='days' id='dayselect'><option value='' selected='selected'>Please	Select	Day</option>";
		$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		for($i=1; $i<=$number; $i++)
		{	
			if($i<10)
				echo "<option value='0".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
		echo "</select>";
	}
?>
