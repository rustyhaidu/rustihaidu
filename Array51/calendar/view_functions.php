<?php

function calendar_header($monthName,$month,$year)
{
	echo '<table border = "1">
			<tr>
				<td><input style="width:50px" type = "button" value="<" name = "previousbutton" onclick="goLastMonth('.$month.','.$year.')" ></td>
				<td colspan="5" >'.$monthName.', '.$year.'</td>
				<td><input style="width:50px" type = "button" value=">" name = "nextbutton" onclick="goNextMonth('.$month.','.$year.')" ></td>
				
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

