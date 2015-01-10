<?php
/**
 * Implement class animal, Dog, Cat (with methods: getSound, getName)
 * ------------------------------------------------------------------------
 *
 * O clasa abstracta nu se instantiaza (e.g. fara new test)
 * are variabile de clasa fata de interfata (protected, public)
 * are metode gata "implementate"
 * Ca si interfata obliga programatorul sa defineasca metodele(abstracte)  in clasa care o extinde (e.g. clasa x)
 * si sa o implementeze
 *
 */



abstract class test{
    const user = 'test';              //constants
    protected $name;                  //variable can be defined
    abstract function doSomething();  //same as an interface
    public function doSomethingElse(){ //but can have implementations
        echo test::user;
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


abstract class animal{
    const dog = 'dog';
    const cat = 'cat';
    abstract public function walk();
    protected $sound;
    protected $name;
    public function getSound(){
       return $this->sound;
    }
    public function getName()
    {
        return $this->name;
    }

}

class Dog extends animal{

    public function __construct($sound)
    {
        $this->sound = $sound;
        $this->name = animalInterface::dog;
    }

    public function walk(){
        //un fel
    }
}

class Cat extends animal{
    public function __construct($sound)
    {
        $this->sound = $sound;
        $this->name = animalInterface::cat;
    }

    public function walk(){//alt fel
    }

}



class testClass{
    public function getSound(){ return 'errorClass';}
}
class View{
    function showGetSoundGeneric($obiect){
        echo $obiect->getSound();
    }

    function showGetSoundAnimal(animal $obiect){
        echo $obiect->getSound();
    }

    function showGetSoundCat(Cat $obiect){
        echo $obiect->getSound();
    }
}

class user{

}
$view = new View();

$dog = new Dog('wof');
$dog->getSound();  //wof
$dog->getName();   //dog

$cat = new Cat('miau');
$cat->getSound(); //miau
$cat->getName();  //cat
$view->showGetSoundGeneric($cat);
$view->showGetSoundCat($cat);
$view->showGetSoundAnimal($cat);

$test = new testClass();
$view->showGetSoundGeneric($test);
//$view->showGetSoundCat($test);    //fatala ca asteapta obiect de tip Cat
//$view->showGetSoundAnimal($test); //fatala ca asteapta obiect care extinde clasa abstracta animal






