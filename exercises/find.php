<?php
/**
 * Implement Room class
 * Implement Immobil abstract class, Casa, Apartament,Garsoniera, Vila class
 * Implement Street class (has many Immobil)
 */

require_once 'classes/estate.php';
require_once 'classes/street.php';
require_once 'classes/villa.php';
require_once 'classes/house.php';

/**
 * @param $id
 * @return Street
 */
function getStreetById($id){
    $st = new Street($id);
    $st->setName('Observatorului');

    for ($i=1;$i<=3;$i++)
    {
        $h = new House(rand(125,300));
        $h->setNumber(rand(1,123));
        $st->addEstate($h);
    }
    return $st;
}

/**
 * @return House
 */
function getRandomHouse()
{
    $randHouse = new House(rand(125,200));
    $randHouse->setNumber(rand(1,666));
    $randHouse->setStreet(new Street(rand(10,12)));
    return $randHouse;
}

echo '<pre>';
$street = getStreetById(rand(10,15));
print_r($street);
echo '</pre>';

$house = getRandomHouse();
echo '<pre>';
print_r($house);
echo '</pre>';

var_dump($street->isEstateOnStreet($house));
var_dump($house->isStreetForEstate($street));

$estates = $street->getEstates();
$firstHouse = $estates[0];
$firstHouseStreet = $firstHouse->getStreet(); // echivalent cu " $estates[0]->getStreet(); "
echo '<br>'.$firstHouse->getId().', ' .$firstHouseStreet->getName().', '.$firstHouse->getNumber().', '.$firstHouseStreet->getId();
