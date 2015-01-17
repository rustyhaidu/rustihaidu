<?php
abstract class Autovehicle {
    protected $wheels = 2;
    public abstract function getWheels();
    public function ccc() {}
}

class Car extends Autovehicle {
    protected $wheels=4;      //suprascri
    private $doors = 4;       //nu se mosteneste la copii, poate fi apelata din interior ($car->doors //fatala,
                                                //nu vreau sa mosteneasca numarul usilor)
    public $color = 'red';    //se mosteneste si poate fi accesat direct $car->color;
    protected $name ='aa';    //se mosteneste dar nu poate fi accesat direct, $c->name;
    static $smth ='smth val'; //poate fi apelat static  Car::smth fara o instanta
    private $passengers = array();

    public function __construct() {
        $this->wheels = 4;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassengerIds() {
        $ids = array();
        //if(!empty($this->passengers)) {
        foreach($this->passengers as $pass) {
            $ids[]=$pass->id;
        }
        //}
        return $ids;
    }

    static function checkVariables($car) {
        $name = $car->getName();
        if(empty($name)){
            return false;
        }
    }

    private function getDoors(){
        return $this->doors;
    }

    public function getWheels() { return $this->wheels;}
}

class Ww extends Car{
    private $doors = 2;

    private function getDoors() {
        return $this->doors;
    }

    public function showDoors()
    {
        echo '<br>Doors :' . $this->getDoors();
    }
}

final class Beattle extends Car{
    private $doors = 3;

    private function getDoors() {
        return $this->doors;
    }

    public function showDoors() {
        echo '<br>Doors :'.$this->getDoors();
    }
}

//FATAL
/**
class B1 extends Beattle
{

}
 **/

echo Car::$smth;
$car = new Car();
echo $car->color;
$car->color = 'green';
echo $car->color;

Car::checkVariables($car);

$wwObj = new Ww();
echo '<br>'.$wwObj->showDoors();
$wwObj = new Beattle();
echo '<br>'.$wwObj->showDoors();

class DateGenerator {
//............(existing methods)...........//
    static function getMonth($month) {
        switch($month){
            case 1:
                return 'January';
                break;
        }
    }

    public function getMonth2($month) {
        switch($month){
            case 1:
                return 'January';
                break;
        }
    }
}

$dateGeneratorObject = new DateGenerator();
$dateGeneratorObject->getMonth2(1);
//  OR Better !!!!
DateGenerator::getMonth(1);

abstract class one{
    private $wheels = 4;
}

class two extends one{
    private $wheels = 2;
    public function getWh(){
        return $this->wheels;
    }
}

$x = new two();
echo $x->getWh();