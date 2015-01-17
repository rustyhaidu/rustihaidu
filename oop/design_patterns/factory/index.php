<?php

abstract class Object {
    var $id;
    var $name;
    public function setId($id) {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId(){
        return $this->id;
    }
}

class Car extends Object
{
    var $name = 'car';
}

class Apple extends Object
{
    var $name = 'apple';
}

class Factory
{
    static function build($name, $properties = array())
    {
        if (class_exists($name)) {
            $newObject = new $name();
            if (isset($properties['id'])) {
                $newObject->setId($properties['id']);
            }
            return $newObject;
        } else {
            throw new Exception('There is no such class: '.$name);
        }
    }
}
try{
    $car1   = Factory::build('Car');
    $apple1 = Factory::build('Apple',array('id'=>123));
    $apple1 = Factory::build('Crapa');
} catch (Exception $e) {
    echo $e->getMessage();
}


var_dump($car1);
var_dump($apple1);