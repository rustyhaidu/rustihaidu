<?php
//include "machine.php";
include "money.php";
include "produs.php";
include "recipe.php";

class Machine
{
	var $array_de_money = array(Money);
	var $recipes = array(Recipe);
	//var Recipe $recipes = array();
	//Produs $test;
	
	static $total_produse = array(Produs);
	
	static function add_produse_to_the_vending_machine(Produs $produs)
	{
		$total_produse[] = $produs;
	}
	
	function get_produse()
	{
		return $total_produse;
	}
	
	function comanda(Recipe $recipe)
	{
		for ($i = 0;$i<sizeof($total_produse);$i++)
		{
			if ($total_produse[i]->id == $recipe->id)
			{
				echo ("A fost comandat produsul ".$total_produse[i]->nume);
				unset($total_produse[i]);
			}
		}
	}
	//$foo = new Foo; 
	
}

//$prod1 = new Produs("cireasa",3,1); 

$prod1 = new Produs("cireasa",3,1);
$prod2 = new Produs("pruna",2,1);

$machine = new Machine();
$machine->add_produse_to_the_vending_machine($prod1);
$machine->add_produse_to_the_vending_machine($prod2);

$suma1 = new Money();
$suma2 = new Money();

echo $suma1->get_total();

$comanda1 = new Recipe(1,$suma1->get_total());
comanda($comanda1);

echo $prod1->price;
$change = $suma1->total_sum - $prod1.price;
echo "Ti-au mai ramas ".$change." unitati";









