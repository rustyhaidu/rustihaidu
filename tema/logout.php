<?php
session_start();
require 'functions.php';

//if (logged() == 1)
//{
echo '<form id="form1" name="form1" method="post" action="index.php">
	<table width="510" border="0" align="center">
	
	<td><input type="submit" name="button" id="button" value="logout" /></td>
	
	</table>
	</form>';
//}	
		
	session_destroy();
	update_logged_out();

	