<?php

require_once '../../oop/immobiliar/autoload.php';
require_once 'functions.php';

//$randHouse
$house = RandomObjects::getRandomHouse();

/*echo '<pre>';
var_dump($house->getRooms());
echo '</pre>'; *s/

/* casele grupate intr-un array - modifcat clasa de house si estate (fara street, villa si room)

numar tipuri de camere si numar patrati

var_dump($livings) returneaza numarul de livinguri si metri patrati
var_dump($kitchen)

*/
function getRoom_by_type($type, $rooms)
{
    $array_rooms_by_type = array();
    foreach ($rooms as $room)
    {
        if ($room->getType() == $type)
        {
            $array_rooms_by_type[] = $room;
        }
    }
    return $array_rooms_by_type;
}

function getRoom_by_type_ex($rooms)
{
    foreach ($rooms as $room)
    {
        $room->setSpace(100);
    }
}

function getRoom_by_type_ex_arr($array)
{
    foreach ($array['elements'] as $key=>$elem)
    {
        $array['elements'][$key] = $elem+1;
    }
}

function group_room_by_type($rooms)
{
    foreach ($rooms as $room)
    {
        //echo '<pre>';
        $array_of_types[$room->getType()][] = $room;
        //echo '</pre>';
    }
    return $array_of_types;

}


/*$rooms   = group_room_by_type($house->getRooms());

$rooms     = $house->getRooms();
$bathrooms = $house->getRooms(Room::BATHROOM);
*/
echo '<pre>';

$arr = array('elements'=>array(5,6));

var_dump($arr);
    getRoom_by_type_ex_arr($arr);
var_dump($arr);

var_dump($house->getRooms());
    getRoom_by_type_ex($house->getRooms());
var_dump($house->getRooms());

//print_r($rooms);
//print_r($bathrooms);
echo '</pre>';

