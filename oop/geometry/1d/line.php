<?php
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