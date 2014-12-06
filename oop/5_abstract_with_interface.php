<?php
/**
 * Implement Room class
 * Implement Immobil abstract class, Casa, Apartament,Garsoniera, Vila class
 * Implement Street class (has many Immobil)
 */

abstract class Shape implements ShapeInterface {
    protected $name = '';
    protected $angles = array();
    public function getAngle($index){
        if(isset($this->angles[$index])) {
            return $this->angles[$index];
        }
    }
    public function getAngleCount(){
        return count($this->angles);
    }
    public function getName() {
        return $this->name;
    }
}

abstract class TwoDimentionShape extends Shape {
    abstract function area();
}

interface ShapeInterface {
    public function getAngle($index);
    public function getAngleCount();
}

class Line extends Shape {
    public function __construct($length = 0) {
        $this->name ='line';
        $this->length = $length;
    }
    public function getLength(){
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }
}

interface Lines {
    public function getLine($index);
}

class Square extends TwoDimentionShape implements Lines{
    var $lineNumber = 4;
    public function __construct($lineLength = 0){
        $this->name ='square';
        $this->lines[1] = new Line($lineLength);
        $this->angles = array(90,90,90,90);
    }
    public function area() {
        return $this->lines[1]->getLength() * $this->lines[1]->getLength();
    }
    public function getLine($index){
        return $this->lines[1];
    }
}


$square = new Square(11);
echo "<br>Name :".$square->getName();
echo "<br>Area (line=11) is: ".$square->area();
echo "<br>Angle #1:".$square->getAngle(1);
echo "<br>Nr of angles:".$square->getAngleCount();
echo "<br>Linia #1:";
var_dump($square->getLine(1));
echo "<br>Linia #2:";
var_dump($square->getLine(2));
$square->getLine(1)->setLength(10);
echo "<br>Area (line=10) is: ".$square->area();