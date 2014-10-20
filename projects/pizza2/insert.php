<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0035)http://localhost/pizza/Comanda.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title></title>
<meta name="keywords" content="">	
<meta name="description" content="">
<link href="default.css" rel="stylesheet" type="text/css" media="all">
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
			<li><a href="index.html" accesskey="5" title="">Inapoi</a></li>
			<li class="current_page_item"><a href="comanda.html" accesskey="1" title="">Produse</a></li>
			
		</ul>
	</div>
</div>
<div id="menuu" align="center">
<?php
$con=mysqli_connect("localhost", "root", "","pizza");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="INSERT INTO comanda (tip, aluat, sos)
VALUES
('$_POST[tip]','$_POST[aluat]','$_POST[sos]')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
echo ('<font size=12 color="red">Comanda dumneavoastra <b>a fost plasata</b></font><p>');

mysqli_close($con);
?> 



<div id="page">
	<div id="content"></div>
	<div id="sidebar"></div>
</div>
<div id="footer" class="container">
	<div>
		
	<p>© 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a>.</p>
</div>


</div></body></html>