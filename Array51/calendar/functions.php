<?php
function add_event_form($day,$month,$year)
{
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


function current_day_month_year()
{

		if (isset($_GET['day']))
		{
			$day = $_GET['day'];
		}
		else
		{
			$day = date("j");
		}
		if (isset($_GET['month']))
		{
			$month = $_GET['month'];
		}
		else
		{
			$month = date("n");
		}
		if (isset($_GET['year']))
		{
			$year = $_GET['year'];
		}
		else
		{
			$year = date("Y");
		}
		$array = array();
		
		$array['day'] = $day;
		$array['month'] = $month;
		$array['year']= $year;
		
		return $array;
}		
			
function get_month_name($day,$month,$year)
{	
			
	$currentTimeStamp = strtotime("$day-$month-$year");
			//$currentTimeStamp = strtotime("$year-$month-$day");
			
	$monthName = date("F",$currentTimeStamp);
				return $monthName;
}			
function get_num_days($day,$month,$year)
{
			
	$currentTimeStamp = strtotime("$day-$month-$year");
			//$currentTimeStamp = strtotime("$year-$month-$day");
			
	//$monthName = date("F",$currentTimeStamp);
	$numDays = date("t",$currentTimeStamp);
	
	return $numDays;
}			

function get_first_day($numDays,$day,$month,$year)
{
	echo '<tr>';
		$counter = 0;
				
				for($i = 1;$i < $numDays+1; $i++,$counter++)
				{
					$timeStamp = strtotime("$i-$month-$year");
					//echo '</br>'.$timeStamp;
					if($i == 1)
					{
						$firstDay = date("w",$timeStamp);
						//echo '</br>'.$firstDay;
						for ($j = 1;$j <$firstDay; $j++, $counter++)
						{
							//blank
							echo "<td>&nbsp; </td>";
						}
					}
					if ($counter % 7 == 0)
					{
						echo "</tr><tr>";
					}
					$monthstring = $month;
					$monthlength = strlen($monthstring);
					$daystring = $i;
					$daylength = strlen($daystring);
					
					if($monthlength<=1)
					{
						$monthstring = "0".$monthstring;
					}
					if($daylength <=1)
					{
						$daystring = "0".$daystring;
					}
					echo "<td align='center'><a href='".$_SERVER['PHP_SELF']."?month=".$monthstring."&day=".$daystring."&year=".$year."&v=true'>".$i."</a></td>";
				}
				echo '</tr>';
			echo '</table>';	
				
				
		$array = array();
		$array['firstDay']= $firstDay;
		$array['timeStamp'] = $timeStamp;
		return $array;
}
function get_add_event($day,$month,$year)
{
				
	if (isset($_GET['v']))
		{
			echo '</br>tralalalal</br>';
			echo "<a href='".$_SERVER['PHP_SELF']."?month=".$month."&day=".$day."&year=".$year."&v=true&f=true'>Add Event</a>";
		if (isset($_GET['f']))
		{			
			add_event_form($day,$month,$year);
		}
	}
}
function connect()
{
$hostname = "localhost";
	$username= "root";
	$password = "";
	$dbname = "calendar";
	$error="Cannot connect to database";
	
	
// Create connection
	$conn = mysqli_connect($hostname, $username, $password,$dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";
	return $conn;
}	
function insert_event($day,$month,$year,$conn)
{
	if (isset($_GET['add']))
	{
		
		$title = $_POST['txttitle'];
		$detail = $_POST['txtdetail'];
		
		$eventdate = $month."/".$day."/".$year; 
		$sqlinsert = "insert into events (id,Title,Details,EventDate,addedEvent) values ('','".$title."','".$detail."','".$eventdate."',now())";
		//echo $sqlinsert.'</br>';
		$resultinsert = mysqli_query($conn,$sqlinsert);
		
		if($resultinsert)
		{
			echo "</br>Event added successfully";
		}
		else
		{
			"</br>Event failed to be added";
		}
	}	
}		 
			