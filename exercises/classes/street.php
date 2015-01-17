<?php
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