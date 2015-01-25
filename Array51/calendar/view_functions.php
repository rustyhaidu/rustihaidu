<?php

function calendar_header($month,$year)
{
	$monthName  = get_month_name($month);
	echo '<table border = "1">
			<tr>
				<td><input style="width:50px" type = "button" value="<" name = "previousbutton" onclick="goLastMonth(\''.$_SERVER['PHP_SELF'].'\','.$month.','.$year.')" ></td>
				<td colspan="5" >'.$monthName.', '.$year.'</td>
				<td><input style="width:50px" type = "button" value=">" name = "nextbutton" onclick="goNextMonth(\''.$_SERVER['PHP_SELF'].'\','.$month.','.$year.')" ></td>
				
			</tr>
			<tr>
				<td width="50px">Mon</td>
				<td width="50px">Tue</td>
				<td width="50px">Wed</td>
				<td width="50px">Thu</td>
				<td width="50px">Fri</td>
				<td width="50px">Sat</td>
				<td width="50px">Sun</td>
			</tr>';
}

function get_first_day($month,$year)
{
	$numDays = get_num_days($month,$year);
	echo '<tr>';
	$counter = 0;
	for($i = 1;$i < $numDays+1; $i++,$counter++) {
		$timeStamp = strtotime("$i-$month-$year");
		//echo '</br>'.$timeStamp;
		if($i == 1) {
			$firstDay = date("w",$timeStamp);
			for ($j = 1;$j <$firstDay; $j++, $counter++) {
				echo "<td>&nbsp; </td>";
			}
		}
		if ($counter % 7 == 0) {
			echo "</tr><tr>";
		}
		$monthstring = $month;
		$monthlength = strlen($monthstring);
		$daystring = $i;
		$daylength = strlen($daystring);
		if($monthlength<=1) {
			$monthstring = "0".$monthstring;
		}
		if($daylength <=1) {
			$daystring = "0".$daystring;
		}
		echo "<td align='center'><a href='".$_SERVER['PHP_SELF']."?month=".$monthstring."&day=".$daystring."&year=".$year."&v=true'>".$i."</a></td>";
	}
	echo '</tr>';
	echo '</table>';
}

function event_form($day,$month,$year, $id = 0)
{
	if($id>0) {

	}
	echo '<form name="eventform" method = "post" action ='.$_SERVER["PHP_SELF"].'?month='.$month.'&day='.$day.'&year='.$year.'&v=true&add=true>
		<table width="400px">
			<tr>
				<td width="50px">Title</td>
				<td width="350px"><input type="text" name="txttitle"></td>
			</tr>
			<tr>
				<td width="150px">Detail</td>
				<td><textarea  name="txtdetail"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="btnadd" value="Add Event" </td>

			</tr>
		</table>
	</form>';
}

