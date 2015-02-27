<?php

class Produs
{
	var $nume;
	var $price;
	var $id;
	
	function __construct($nume,$price,$id)
	{
		$this->nume = $nume;
		$this->price = $price;
		$this->id = $id;
	}
}	
	
	