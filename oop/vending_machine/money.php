<?php

class Money
{
	var $accepted_money = array(1,5,10,15);
	var $total_sum;
	
	function __construct()
	{
		
	}
	
	function add_to_total($money)
	{
			$total_money = array();
			for ($i = 0;$i<sizeof($this->accepted_money);$i++)
			{
				if ($money == $this->accepted_money[i])
				{
					$total_money[] = $money;
				}
			}
			for ($i=0;$i<sizeof($total_money);$i++)
			{
				$this->total_sum = $this->total_sum + $total_money[i];
			}		
	}
	
	function get_total()
	{
		return $this->total_sum;
	}
}	

