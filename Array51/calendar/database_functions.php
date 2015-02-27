<?php

function connect()
{
    global $connection;
    $hostname = "localhost";
    $username= "root";
    $password = "";
    $dbname = "calendar";
    $connection = mysqli_connect($hostname, $username, $password,$dbname);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
}

function insert_event($day,$month,$year, $title, $detail)
{
    global $connection;
    $eventdate = $day."/".$month."/".$year;
    $sqlinsert = "insert into events (id,Title,Details,EventDate) values ('','".$title."','".$detail."','".$eventdate."')";
    return mysqli_query($connection,$sqlinsert);
}

function show_events($day,$month,$year)
{
global $connection;
$query = 'Select id,title, details, eventdate,addedevent from events where eventdate = "'.$day.'/'.$month.'/'.$year.'" order by eventdate';
			$result = mysqli_query($connection, $query);
			echo "<table border='1'>";
			if($result)
			{
				foreach ($result as $value)
				{
					echo "<tr>
								<td>".$value['id']."</td>
								<td>".$value['title']."</td>
								<td>".$value['details']."</td>
								<td>".$value['eventdate']."</td>
								<td>".$value['addedevent']."</td>
								<td><a href='".$_SERVER['PHP_SELF']."?edit=true&id=".$value['id']."'>
									<input style='height:50px' type ='button' value='EDIT' name ='edit'>
									</td>
								<td><a href='".$_SERVER['PHP_SELF']."?delete=true&id=".$value['id']."'>
									<input style='height:50px' type ='button' value='DELETE' name ='delete'>
									</td>	
						 </tr>";
				}
				echo "</table>";
			}
			echo "</table>";
}
		
//echo "<a href='".$_SERVER['PHP_SELF']."?month=".$month."&day=".$day."&year=".$year."&v=true&f=true'>Add Event</a>";
function delete_event($day,$month,$year)
{
	global $connection;
	//$query = 'Delete from events where eventdate = "'.$day.'/'.$month.'/'.$year.'"';
	  $query = "Delete from events where id=".$_GET['id'];
		echo $query;
			mysqli_query($connection,$query);
			
}
function edit_event_form($day,$month,$year)
{
	$id = $_GET['id'];
	global $connection;
	$query = 'Select id,title, details, eventdate,addedevent from events where id ='.$id;
			$result = mysqli_query($connection, $query);
			
			foreach ($result as $value)
			{
				$title_event = $value['title'];
				$event_details = $value['details'];							
			}
	
	echo '<form name="eventform" method = "post" action ='.$_SERVER['PHP_SELF'].'?edit=true&id='.$id.'>
		<table width="400px">
			<tr>
				<td width="50px">Title</td>
				<td width="350px"><input type="text" name="edittitle" value='.$title_event.'></td>
			</tr>
			<tr>
				<td width="150px">Detail</td>
				<td><textarea  name="editdetail">'.$event_details.'</textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				<input type="submit" name="btnedit" value="Edit Event" </td>

			</tr>
		</table>
	</form>';
	return $id;
}
	
function update_event($id)
{
	global $connection;
	$update = 'Update events set addedevent = now(), title="'.$_POST['edittitle'].'",details="'.$_POST['editdetail'].'" where id='.$id;
	//echo $update;
	$result_update = mysqli_query($connection,$update);
	if ($result_update)
	{
		echo "Event Updated Successfully. Please Refresh";
	}
	else
	{
		echo "event not updated";
	}
}