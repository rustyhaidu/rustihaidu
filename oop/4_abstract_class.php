<?php
/**
 * Implement class animal, Dog, Cat (with methods: getSound, gentName)
 *
 */

abstract class test{
    const user = 'test';              //constants
    protected $name;                  //variable can be defined
    abstract function doSomething();  //same as an interface
    public function doSomethingElse(){ //but can have implementations
        echo test::pass;
    }
}

class x extends  test{
    public function doSomething()
    {
        echo testInterface::pass;
    }

}

class y extends test{
    public function doSomething()
    {
        echo testInterface::user;
    }

}