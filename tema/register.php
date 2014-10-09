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
//array('Username is too short','passwords do not match');
$fields = check_error_fields($_POST);
if(!empty($fields)) {
    //display errror messaage
}
else{
    $exists = model_user_exists($user_name); //poate sa fie in check_error_fields();
    if(!$exists) {
        $success = model_insert_user($_POST);
        if(!$success)
        {
            view_error_insert($POST);
        }
        else
        {
            common_redirect_to('login.php?message=1');
        }
    } else {
        view_user_exists($_POST);
    }
}


