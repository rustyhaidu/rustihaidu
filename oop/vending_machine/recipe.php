<?php

	class Recipe
	{
		var	$id;
		var	$price;	
		
		function __construct($id, $price)
		{
			$this->id = $id;
			$this->price = $price;
		}
	}
	