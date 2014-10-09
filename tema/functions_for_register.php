<?php

function connect()
{
	$con = mysqli_connect("localhost", "root", "", "xxs");
	if (mysqli_connect_errno())
	{
		echo "Failed to  connect: ".mysqli_connect_error();
	}
	return $con;
}

function check_fields()
{
	if (isset($_POST['register']))
	{
		if  (empty($_POST['userreg']) || empty($_POST['passreg']) || empty($_POST['repeatpassword']))
		{
			echo "Please Complete All Fields <br>";
		}
		else if ($_POST['passreg'] != $_POST['repeatpassword'])
		{
			echo "Passwords do not match";
		}
		else 
		{
			check_user();
		}
	}
	
	
}

function check_user()
{
	$con = mysqli_connect("localhost", "root", "", "xxs");

	if (mysqli_connect_errno())
	{

		echo "Failed to  connect: ".mysqli_connect_error();
		
	}
	
	$query1 = "Select username from users where username = ".'"'.$_POST['userreg'].'"';
	//echo $query1;
	$result1 = mysqli_query($con, $query1);
	
	$num_rows = mysqli_num_rows($result1);
	if ($num_rows >= 1)
	{
		echo "<br><h3>User already exists<h3><br>";
		return 1;
	}
	else 
	{
		insert_user();
		return 0;
	}
}
function insert_user()
{
	$con = mysqli_connect("localhost", "root", "", "xxs");

	if (mysqli_connect_errno())
	{

		echo "Failed to  connect: ".mysqli_connect_error();
		
	}
	$query1 = "Insert into users values ('',".'"'.$_POST['userreg'].'"'.",".'"'.$_POST['passreg'].'"'.",0,0,".'"'.date('Y-m-d H:i:s').'"'.")";
	echo $query1;
	$result1 = mysqli_query($con,$query1);
}


