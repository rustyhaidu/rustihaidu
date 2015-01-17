<?php
/**
 * Implement Room class
 * Implement Immobil abstract class, Casa, Apartament,Garsoniera, Vila class
 * Implement Street class (has many Immobil)
 */

require_once 'include_classes.php';
require_once 'functions.php';

echo '<pre>';
$street = RandomObjects::getStreetById(rand(10,15));
print_r($street);
echo '</pre>';

$house = RandomObjects::getRandomHouse();
echo '<pre>';
print_r($house);
echo '</pre>';

var_dump($street->isEstateOnStreet($house));
var_dump($house->isStreetForEstate($street));

$estates = $street->getEstates();
$firstHouse = $estates[0];
$firstHouseStreet = $firstHouse->getStreet(); // echivalent cu " $estates[0]->getStreet(); "
echo '<br>'.$firstHouse->getId().', ' .$firstHouseStreet->getName().', '.$firstHouse->getNumber().', '.$firstHouseStreet->getId();
