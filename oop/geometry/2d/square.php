<?php

class Square extends TwoDimentionShape implements Lines{
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
