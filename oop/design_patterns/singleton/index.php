<?php

class Clasa
{
    public function __construct(){
        echo '<br>Instanta Clasa';
    }
}


new Clasa();
new Clasa();
new Clasa();

/*
class Singleton
{
    static $instance;

    static function getInstance(){
        if(!self::$instance != null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }
    private function __construct(){
        echo '<br>Instanta Singleton';
    }
}


Singleton::getInstance();
Singleton::getInstance();
Singleton::getInstance();