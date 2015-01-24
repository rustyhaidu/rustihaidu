<?php
include 'autoload.php';
connect();
?>
<html>
	<head>
		<script src="js/main.js" type="application/javascript"></script>
	</head>
	<body>
<?php
$array_date = current_day_month_year();
$day        = $array_date['day'];
$month      = $array_date['month'];
$year       = $array_date['year'];

display_calendar($month,$year);

if (isset($_GET['add'])) {
	$title = isset($_POST['txttitle'])?$_POST['txttitle']:null;
	$detail = isset($_POST['txtdetail'])?$_POST['txtdetail']:null;
	$result = insert_event($day, $month, $year, $title, $detail);
	if($result) {
		echo "</br>Event added successfully";
	} else {
		"</br>Event failed to be added";
	}
}

if (isset($_GET['v'])) {
	if (isset($_GET['f'])) {
		event_form($day,$month,$year);
	}
	echo "<a href='".$_SERVER['PHP_SELF']."?month=".$month."&day=".$day."&year=".$year."&v=true&f=true'>Add Event</a>";
	echo '</br>List events</br>';
}
?>
	</body>
</html>	