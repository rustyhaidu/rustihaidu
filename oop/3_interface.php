<?php

/**
 * Implement class interface Furniture (getValue)
 * Implement class Chair,Table (constructor with $value)
 */

interface testInterface{
    const user = 'test';            //constants can be defined, variables not
    //illegal: protected $name;
    public function doSomething(); //define method to be implemented
}

class test implements testInterface{
    public function doSomething() {
        echo testInterface::pass;
    }
}

class test1 implements testInterface{
    public function doSomething() {
        echo testInterface::user;
    }
}