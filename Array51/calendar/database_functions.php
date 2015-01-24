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
