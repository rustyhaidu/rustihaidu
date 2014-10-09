<?php
session_start();
require 'functions.php';

if (logged() == 0)
{
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
else if (logged() == 1 )
{
echo '<form id="form1" name="form1" method="post" action="logout.php">
	<input type="submit" name="button" id="button" value="logout" /></td>
	
	</form>';
if (isset($_POST['button']))
	{
	session_destroy();
	update_logged_out();
	}
}	

connect();
check_empty();
check_credentials();
unlock_users();


?>








