<?php

require_once '../../oop/immobiliar/autoload.php';
require_once 'functions.php';

$randomGen = new RandomObjects;

$house = $randomGen->getRandomHouse();

var_dump($house->getRooms());


/**
var_dump($livings);
var_dump($kitchens);
 */