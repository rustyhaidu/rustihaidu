<?php
session_start();
require 'functions.php';
require 'functions_views.php';
$con = connect();
check_empty();
check_credentials($con);
unlock_users();
$loggedIn = logged();
show($loggedIn);
?>