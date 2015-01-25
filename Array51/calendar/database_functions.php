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
    $eventdate = $month."/".$day."/".$year;
    $sqlinsert = "insert into events (id,Title,Details,EventDate) values ('','".$title."','".$detail."','".$eventdate."')";
    return mysqli_query($connection,$sqlinsert);
}

function show_events($day,$month,$year)
{
global $connection;
$query = 'Select title, details, eventdate,addedevent from events where eventdate = "'.$day.'/'.$month.'/'.$year.'"';
			$result = mysqli_query($connection, $query);
			echo '<table border="1">';
			foreach ($result as $value)
			{
				echo '<tr>
							<td>'.$value['title'].'</td>
							<td>'.$value['details'].'</td>
							<td>'.$value['eventdate'].'</td>
							<td>'.$value['addedevent'].'</td>
							<td><input style="height:50px" type="submit" type ="button" value="EDIT" name ="edit">
								</td>
				     </tr>';
			}
			echo '</table>';
}		
