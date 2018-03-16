<?php
	switch($_REQUEST['state'])
    {
        case "TAS":
        $cities = array('Hobart', 'Launceston', 'Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney');
        break;
		
        case "WA":
        $cities = array('Adelaide', 'Brisbane', 'Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney');
        break;
		
        case "VIC":
        $cities = array('Brisbane', 'Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney');
        break;
		
        case "SA":
        $cities = array('Canberra', 'Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney');
        break;
		
        case "QLD":
        $cities = array('Darwin', 'Hobart', 'Melbourne', 'Perth', 'Sydney');
        break;
		
        case "NT":
        $cities = array('Melbourne', 'Perth', 'Sydney');
        break;
		
        case "NSW":
        $cities = array('Perth', 'Sydney');
        break;
		
        case "ACT":
        $cities = array('Geelong', 'Sydney');
        break;
         
        default :
        $cities = false;
        break;
    }

    if(!$cities) 
		echo "";
    else{
		echo "<td class='label'>* City</td><td>";
		
		echo "<select name='city' id='cities'><option value='' selected='selected'>Please Select City</option><option>".implode('</option><option>', $cities)."</option></select>";
		echo "</td>";
}
?>
