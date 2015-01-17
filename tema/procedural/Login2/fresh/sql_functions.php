<?php

function connect()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$my_db = "fresh";

	$con=mysqli_connect("$servername","$username","$password","$my_db");
		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		  else
		  
		mysqli_select_db($con,"$my_db");
			return $con;
}
function register_user($con)
{		
		echo "INSERT INTO Users (User,Password) VALUES ('".$_POST['user']."','".$_POST['password']."')";
		
		mysqli_query($con,"INSERT INTO Users (User,Password) VALUES ('".$_POST['user']."','".$_POST['password']."')");
		mysqli_close($con);
}

function check_user($con)
{
		
		$query2='';
		$result2='';
		$query2= "Select user, password from users where user = '".$_POST['user']."' and password = '".$_POST['password']."'";		
		$result2 = mysqli_query($con,$query2);
		
		
		if ($result2)
		{
			echo 'welcome '.$_POST['user'];
			$_SESSION['logged']=1;
			//echo $_SESSION[$_POST['user']];
		}
		else
		{
			echo 'not welcome';
		}
		
}
function welcome()
{
	if (empty($_SESSION['logged']))
	{
		login_form();
		
	}
		else
		{
			var_dump($_SESSION);
			echo 'welcome';
			logout_button();
		}
	
}
function logout2()
{
	if (isset($_POST['Logout']))
	{
		echo 'apasat';
		session_destroy();
		redirectTo('index.php');
	}
}
