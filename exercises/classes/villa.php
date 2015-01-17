<?php


class Villa extends Estate
{
    public function __construct($id = null){
        $this->setType(Estate::ES_VILLA);
        parent::__construct($id);
    }
}