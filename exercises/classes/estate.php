<?php
abstract class Estate
{
    const ES_HOUSE=1;
    const ES_VILLA=2;
    protected $id;
    private $number;
    private $type;

    /**
     * @var Street $street
     */
    protected $street;

    protected $rooms;

    /**
     * @return mixed
     */
    public function getRooms($nonType = TRUE)
    {
        if($nonType){
            return $this->rooms;
        }
        $array_rooms_by_type = array();
        foreach ($this->rooms as $room)
        {
            if ($room->getType() == $nonType)
            {
                $array_rooms_by_type[] = $room;
            }
        }
        return $array_rooms_by_type;
    }

    /**
     * @param mixed $rooms
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

    }

    public function __construct($id = null){
        if(is_integer($id)) {
            $this->setId($id);
        }
    }
    public function setNumber($setNumber)
    {
        $this->number = $setNumber;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setStreet(Street $street)
    {
        $this->street = $street;
    }

    /**
     * @return Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    public function getType()
    {
        return $this->type;
    }

    protected function setType($setType)
    {
        $this->type = $setType;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isStreetForEstate(Street $st)
    {
        $currentStreet = $this->getStreet();
        return $currentStreet->getId() == $st->getId();
    }
}