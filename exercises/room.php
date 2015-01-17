<?php

/**
 * Implement Room class
 * Implement Immobil abstract class, Casa, Apartament,Garsoniera, Vila class
 * Implement Street class (has many Immobil)
 */

class Street
{
  private  $estates;
  private  $name;
  private  $numbers;
  private  $id;

    function __construct($id)
    {
         $this->id = $id;
         $this->estates = array();
         $this->numbers = array();
    }

    /**
     * Linia 1 : $this   - Instanta curenta
     * @param Estate $addestates
     */
    public function addEstate(Estate $addestates)
    {
        $addestates->setStreet($this);
        $this->addNumber($addestates->getNumber());
        $this->estates[] = $addestates;
    }
    public function getEstates()
    {
        return $this->estates;
    }
    public function setName ($setName)
    {
        $this->name = $setName;
    }
    public function getName ()
    {
        return $this->name;
    }

    private function addNumber ($number)
    {
        $this->numbers[] = $number;
    }
    public function getId()
    {
        return $this->id;
    }

    public function isEstateOnStreet(Estate $es)
    {
        return $this->getId() == $es->getStreet()->getId();
    }

}

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
    private $street;

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

class House extends Estate
{
    public function __construct($id = null){
        $this->setType(Estate::ES_HOUSE);
        parent::__construct($id);
    }
}

class Villa extends Estate
{
    public function __construct($id = null){
        $this->setType(Estate::ES_VILLA);
        parent::__construct($id);
    }
}

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
