<?php
class House extends Estate
{
    public function __construct($id = null){
        $this->setType(Estate::ES_HOUSE);
        parent::__construct($id);
    }
}