<?php
session_start();
include 'sql_functions.php';
include 'view_functions.php';

$con = connect();
if (isset($_POST["Login"]))
{
	check_user($con);
}

logout_button();
logout2();

echo '<br>';
var_dump($_SESSION);