	
<html>
	<head>
			<script>
					function goLastMonth(month, year)
					{
						if(month ==1) 
						{
							--year;
							month = 13;							
						}
						-- month;
						var monthstring = ""+month+""
						var monthlength = monthstring.length;
						if(monthlength <=1)
						{
							monthstring ="0"+monthstring;
						}
						document.location.href="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
						
					}
					function goNextMonth(month, year)
					{
						if(month ==12)
						{
								++year;
								month= 0;
						}
							++month;
						var monthstring = ""+month+""
						var monthlength = monthstring.length;
						if(monthlength <=1)
						{
							monthstring ="0"+monthstring;
						}
						document.location.href="<?php $_SERVER['PHP_SELF'];?>?month="+monthstring+"&year="+year;
						
					}
			</script>
	</head>
	
	<body>
		<?php
		include 'autoload.php';
		$conn = connect();
		$array_date = current_day_month_year();
			$day = $array_date['day'];
			$month = $array_date['month'];
			$year = $array_date['year'];
		$monthName=get_month_name($day,$month,$year);
		calendar_header($monthName,$month,$year);			
		
		$numDays = get_num_days($day,$month,$year);		
		
		$array = get_first_day($numDays,$day,$month,$year);
		get_add_event($day,$month,$year);
		//var_dump($_GET);
		insert_event($day,$month,$year,$conn);
		
		
				
		//add_event_form();	

			
			?>
			
	</body>
</html>	