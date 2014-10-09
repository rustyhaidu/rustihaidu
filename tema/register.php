<html>
<body>
<head>
<title>Register</title>
</head>
<form method = "post" action = "register.php">
<table>
	<tr>
		<td>Username:</td> 
		<td><input type = "text" name="userreg"></td> 
	</tr>	
	<tr>	
		<td>Password: </td>
		<td><input type="password" name="passreg"></td> 
	</tr>
	<tr>	
		<td>Repeat Password :</td> 
		<td><input type="password" name = "repeatpassword"></td> 
	</tr>	
<tr><td><input type="submit" value = "register" name="register">
	<a href="index.php">Login</a>
	</td></tr>
</form>


</form>

</body>
</html>
<?php
require 'functions_for_register.php';
check_fields();
