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
<body >
    <div id="header" class="container">
        <div id="logo">
            <img border="0" src="images/pizzaguy.gif" alt="pizza" width="150" height="150">
            <h1><a href="index.html">Home of Pizza</a></h1>
        </div>
        <div id="menu">
            <ul>
                <?php
                $homepage      = ($menuItem == 'homepage')      ? 'current_page_item':'';
                $autentificate = ($menuItem == 'autentificare') ? 'current_page_item':'';
                ?>
                <li class="<?php echo $homepage;?>">
                    <a href="index.php">Homepage</a>
                </li>
                <li class="<?php echo $autentificate;?>">
                    <a href="login.php">Autentificare</a>
                </li>
                <li class="">
                    <a href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="content" class="wrapper-style1">
       <?php echo $content;?>
    </div>
    <div id='footer' align="center">
        <p> &copy; 2013 Sitename.com. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a>.</p>
    </div>
</body>
</html>
