<?php
function get_message($messageNumber) {
    switch($messageNumber) {
        case 1:
            $message = 'User is locked';
            break;
    }
    return $message;
}

function view_show_message($errorMessage) {
    $message = get_message($errorMessage);
    echo $message;
}

function show($user)
{
	if (isset($_GET['message'])) {
        view_show_message($_GET['message']);
    }
    if ($user) {
        echo '<table width="510" border="0" align="center"> <td>Welcome ' .$user['username']."</td></table>";
        echo '<form id="form1" name="form1" method="post" action="logout.php">
            <table width="510" border="0" align="center">
            <td><input type="submit" name="button" id="button" value="logout" /></td>
            </table>
            </form>';
        echo "<a href='logout.php'>Logout</a>";
    } else {
        echo '
        <form id="form1" name="form1" method="post" action="index.php">
        <table width="510" border="0" align="center">
        <tr>
        <td>Username</td>
        <td><input type="text" name="username" id="username" /></td>
        </tr>
        <tr>
        <td>Password</td>
        <td><input type="password" name="password" id="password" /></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button_login" id="button" value="Login" />
        <a href="register.php">Register</a>
        </td>
        </tr>
        </table>
        </form>';
    }
}

