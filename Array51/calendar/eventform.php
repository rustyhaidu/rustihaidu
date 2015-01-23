<?php

echo '<form name="eventform" method = "$_POST" action = $_SERVER["PHP_SELF"]>
		<table width="400px">
			<tr>
				<td width="150px">Title</td>
				<td width="250px"><input type="text" name="txttile"></td>
			</tr>
			<tr>
				<td width="150px">Detail</td>
				<td><textarea name="txtdetail"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="btnadd" value="Add Event" </td>
				
			</tr>
		</table>
	</form>';