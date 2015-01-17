<?php
session_start();
require 'functions.php';
require 'functions_views.php';
$con = connect();
check_empty();
$user = FALSE;
if (isset($_POST['username']) && (!empty($_POST['username'])) && isset($_POST['password']) && (!empty($_POST['password'])) ) {
    $user = check_credentials($con);
}
unlock_users($con);
$user = logged($con);
show($user);