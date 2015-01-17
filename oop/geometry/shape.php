<?php
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