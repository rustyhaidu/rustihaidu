<?php

/**
 * Implement class interface Furniture (getValue)
 * Implement class Chair,Table (constructor with $value)
 * O interfata dicteaza metodele publice care trebuie implementate in clase, dar clasa poate avea metode in plus
 * O interfata poate sa detina constante
 * O interfata nu poate fi instantiata
 */
define('name','admin');
echo name;
interface testInterface{
    const user = 'admino';            //constants can be defined, variables not
    //illegal: protected $name;
    public function doSomething(); //define method to be implemented
}

class test implements testInterface{
    public function doSomething() {
        echo testInterface::user;
    }
}

class test1 implements testInterface{
    public function doSomething() {
        echo testInterface::user;
    }
}
echo '<br>interface:'.testInterface::user;
interface Furniture{
    public function getValue();
}

class chair implements Furniture{

    private $variabila;

    public function __construct($var)
    {
        $this->variabila = $var;
    }
    public function getValue(){

        return $this->variabila;
    }
}
 $c1 = new chair(12) ;

echo $c1->getValue();
//echo $c1->variabila;

class Table implements Furniture{
    private $masa;

    public function __construct($variabil)
    {
        $this->masa = $variabil;
    }
    public function getValue()
    {
       return $this->masa;
    }
}
$c1 = new Table(12) ;

echo $c1->getValue();