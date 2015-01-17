<?php

function login_form()
{
	echo '<form action="login.php" method="post">
	User:<br> <input type="text" name="user"><br>
	Password:<br> <input type="password" name="password"><br>
	<input type="submit" value="Login" name="Login">
	</form>
	<a href="registration_form.php">Registration</a>';
}

function registration_form()
{
	echo '<form action="register_user.php" method="post">
	User:<br> <input type="text" name="user"><br>
	Password:<br> <input type="password" name="password"><br>
	<input type="submit" value="Register">
</form>';
}

function logout()
{
	echo '<br><a href="logout.php">Click here to Logout</a><br>';
}
function logout_button()
{
	echo '<form  method="post">
	<input type="submit" value="Logout" name = "Logout">
	</form>';
	
}

function redirectTo($url) {
header('Location: '.$url);
}