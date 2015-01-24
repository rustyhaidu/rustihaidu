<?php

function current_day_month_year()
{
	if (isset($_GET['day'])) {
		$day = $_GET['day'];
	}
	else {
		$day = date("j");
	}
	if (isset($_GET['month'])) {
		$month = $_GET['month'];
	} else {
		$month = date("n");
	}
	if (isset($_GET['year'])) {
		$year = $_GET['year'];
	} else {
		$year = date("Y");
	}
	$array = array();
	$array['day'] = $day;
	$array['month'] = $month;
	$array['year']= $year;
	return $array;
}
			
function get_month_name($month)
{
	$currentTimeStamp = strtotime("01-$month-2000");
	$monthName = date("F",$currentTimeStamp);
	return $monthName;
}

function get_num_days($month,$year)
{
	$currentTimeStamp = strtotime("01-$month-$year");
	$numDays = date("t",$currentTimeStamp);
	return $numDays;
}

function display_calendar($month,$year)
{
	calendar_header($month,$year);
	get_first_day($month,$year);
}
