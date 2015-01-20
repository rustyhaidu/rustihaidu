<?php
/**
 * Implement Room class
 * Implement Immobil abstract class, Casa, Apartament,Garsoniera, Vila class
 * Implement Street class (has many Immobil)
 */
require_once '../../oop/geometry/autoload.php';
//se incarca toate clasele

$square = new Square(11);
echo "<br>Name :".$square->getName();
echo "<br>Area (line=11) is: ".$square->area();
echo "<br>Angle #1:".$square->getAngle(1);
echo "<br>Nr of angles:".$square->getAngleCount();
echo "<br>Linia #1:";
var_dump($square->getLine(1));
echo "<br>Linia #2:";
var_dump($square->getLine(2));
$square->getLine(1)->setLength(10);
echo "<br>Area (line=10) is: ".$square->area();