<?php
class RandomObjects
{
    /**
     * @param $id
     * @return Street
     */
    static function getStreetById($id) {
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
     * Daca nu zici public, private sau protected atunci e socotit PUBLIC
     * @return House
     */
    static function getRandomHouse()
    {
        $randHouse = new House(rand(125,200));
        $randHouse->setNumber(rand(1,666));
        $randHouse->setStreet(new Street(rand(10,12)));
        $randomRoomNumber = rand(1,10);
        for($i=0; $i<=$randomRoomNumber; $i++){
            $room = new Room;
            $room->setSpace(rand(15,30));
            $room->setType(rand(1,4));
            $rooms[] = $room;
        }
        $randHouse->setRooms($rooms);
        return $randHouse;
    }

}
