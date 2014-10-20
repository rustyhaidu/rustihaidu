<?php
$con=mysqli_connect("localhost", "root", "","pizza");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
mysqli_query($con,"INSERT INTO comenziplasate (id_comanda, comanda, descriere)
VALUES ('3', 'Griffin','text')");



mysqli_close($con);
?>
Comanda a fost adaugata!