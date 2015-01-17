<?php

function connect()
{
    $con = mysqli_connect("localhost", "root", "", "xxs");
    if (mysqli_connect_errno()) {
        echo "Failed to connect: ".mysqli_connect_error();
    }
    return $con;
}

function store_sessions()
{
    if (empty($_SESSION[$_POST['username']])) {
        $_SESSION[$_POST['username']] =1;
    } else {
        $_SESSION[$_POST['username']]=$_SESSION[$_POST['username']]+1;
    }
}

function check_empty()
{
    if (isset($_POST['button_login']))
    {
        if (empty($_POST['username']) or empty($_POST['password']))
        {
            echo "Empty username or password <br />";
        }
    }
}

function logged($con)
{
    $query11 = "Select username from users where logged = 1";
    $result11 = mysqli_query($con,$query11);
    $numrows = mysqli_num_rows($result11);
    if ($numrows == 1) {
        foreach ($result11 as $value) {
            return $value;
        }
    } else {
        return false;
    }
}

function set_session_zero()
{
    if (empty($_SESSION[$_POST['username']])) {
        $_SESSION[$_POST['username']] = 0;
    }
}

function update_date_1st_wrong_login($con)
{
    $query6 = "Update users set last_activity = ".'"'.date('Y-m-d H:i:s').'"'." where username = ".'"'.$_POST['username'].'"';
    mysqli_query($con,$query6);
}

function update_locked_user($con)
{
    $query7 = "Update users set locked = 1 where username = ".'"'.$_POST['username'].'"';
    mysqli_query($con,$query7);
}

function unlock_users($con)
{
    $query9 = "select last_activity from users ";
    $result9 = mysqli_query($con,$query9);
    foreach ($result9 as $value)
    {
        $date = date_create($value['last_activity']);
        date_add($date,date_interval_create_from_date_string('5 minutes'));
        $date_increased = date_format($date, 'Y-m-d H:i:s');
        if ($date_increased < date('Y-m-d H:i:s'))
        {
            $now = date_create(date('Y-m-d H:i:s'));
            date_add($now,date_interval_create_from_date_string('-5 minutes'));
            $now_decreased = date_format($now, 'Y-m-d H:i:s');
            $query10 = "Update users set locked = 0 where last_activity <".'"'.$now_decreased.'"';
            mysqli_query($con,$query10);
        }
    }
}

function update_logged_in($con)
{
    $query12 = "Update users set logged = 1 where username = ".'"'.$_POST['username'].'"';
    mysqli_query($con,$query12);
}

function redirectTo($url) {
    header('Location: '.$url);
}

function update_logged_out($con)
{
    $query13 = "Update users set logged = 0 where logged = 1";
    mysqli_query($con,$query13);
}

function check_credentials($con)
{
    set_session_zero();
    $query = "Select username,locked from users where username = ".'"'.$_POST['username'].'"';
    $result = mysqli_query($con,$query);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 1 && ($_SESSION[$_POST['username']] < 4 )) {
        $query2 = "Select username from users where username = ".'"'.$_POST['username'].'"'." and password = ".'"'.$_POST['password'].'"' ;
        $result2 = mysqli_query($con,$query2);
        $numrows2 = mysqli_num_rows($result2);
        foreach ($result as $value) {
            $locked = $value['locked'];
        }
        if ($numrows2 ==1 && $locked == 0) {
            update_logged_in($con);
            $_SESSION[$_POST['username']] = 0;
            return true;
        } else if ($locked == 1) {
            return 1;
        } else {
            store_sessions();
            update_date_1st_wrong_login($con);
            return 2;
        }
    } else if ($numrows ==0) {
        echo "User does not exist!";
        return 3;
    } else if ($_SESSION[$_POST['username']] > 3) {
        return 4;
        echo "login attempt excided <br />";
        $_SESSION[$_POST['username']] = 0;
        update_locked_user($con);
    }
}
?>