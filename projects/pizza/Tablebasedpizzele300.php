<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />	
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<!--[if IE 6]>
<link href="default_ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
<div id="header" class="container">
	<div id="logo">
	<img border="0" src="images/pizzaguy.gif" alt="pizza" width="150" height="150">
		<h1><a href="index.html">Home of Pizza</a></h1>
	</div>
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="index.html" accesskey="1">Homepage</a></li>
			<li><a href="login.html" accesskey="5">Autentificare</a></li>
		</ul>
	</div>
</div>

		<?php  
		mysql_connect("localhost", "root", "") or die ("Nu ma pot conecta la server");
		mysql_select_db("pizza") or die ("Nu pot selecta baza de date");

		// Build the sql command string 
		$interogate = "SELECT * from mica";
							
		$query = mysql_query($interogate) or die (mysql_error()); 
		// Output the data here using a while loop, the loop will return all members 
		while ($row = mysql_fetch_array($query)) { 
			// Gather all $row values into local variables for easier usage in output 
			$id = $row["id_gramaj"]; 
			$title = $row["tip"]; 
			$description = $row["Ingrediente"];   
			
			// echo the output to browser 
			echo  "Numar curent = $id 
			<br />Nume = $title
			<br />Ingrediente = $description
			<br /><br />
			<hr />"; 
			
			$_SESSION["id"] = $id;
			$_SESSION["title"] = $title;
			$_SESSION["description"] = $description;
			
			$id_session = $_SESSION["id"];
			$title_session = $_SESSION["title"];
			$description_session = $_SESSION["description"];
			
			echo "<center><form><input type=button value=\"Comanda!\" onClick=\"location.href='inserare.php'\"></form></center>
			<br />";
		} 
		// Free the result set if it is large 
		mysql_free_result($query);  
		// close mysql connection 
		mysql_close(); 
		?>



<div id="page">
	<div id="content"></div>
	<div id="sidebar"></div>
</div>
	<div>
		
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a>.</p>
</div>
</body>
</html>

