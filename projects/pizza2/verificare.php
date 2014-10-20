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
			
			
		</ul>
	</div>
</div>
<div id="menuu">
		<?php
			$n = $_REQUEST["numeletau"];
			$p = $_REQUEST["parolata"];
				mysql_connect("localhost", "root", "") or die ("Nu ma pot conecta la server");
				mysql_select_db("pizza") or die ("Nu pot selecta baza de date");
					$interogare = "SELECT * from admin";
					$rezultat = mysql_query($interogare) or die (mysql_error());
					$gasit = false;
						while ($row = mysql_fetch_array($rezultat))
						{
							if (($n)==$row["user"] && ($p==$row["parola"]))
							{
								echo "<font face=\"Comic Sans Ms\" size=4 color=\"#075507\">";
								echo "<center><h2>Sunteti autorizat </h2></font>";
								echo "<form method=\"post\" action=\"comanda.html\">";
								echo "<input type=\"submit\" name=\"submit\" value=\"Produse\">";
								
								echo "</form></center>";
								$gasit = true;
								break;
							}
						}
						if(!$gasit)
						{
							echo "<center><font face=\"ARIAL\" size=16>";
							echo "AUTENTIFICARE ESUATA</font>";
							echo "<form><input type=button value=\"Mai incearca\" onClick=\"location.href='login.html'\"></form></center>";
						}
		?>
	</div>
	

	<div class="title">
		
		
	</div>
<div id="page">
	<div id="content"></div>
	<div id="sidebar"></div>
</div>
	<div id="footer" class="container">
	<div>
		
	<p>&copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a>.</p>
</div>
</body>
</html>
