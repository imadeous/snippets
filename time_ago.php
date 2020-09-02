<?php
function time_ago($time) {
	$now = time();					//current time (change timezone accordingly)
	$period = $now - $time;			//get the time difference
	$refs = [
		'year' 		=> '31553280',	// (365+365+365+365+365)/5 * 24 * 60 * 60
		'month' 	=> '2629440',	// ((365+365+365+365+365)/5/12) * 24 * 60 * 60
		'week' 		=> '604800',	// 7 * 24 * 60 * 60
		'day' 		=> '86400',		// 24 * 60 * 60
		'hour' 		=> '3600',		// 60 * 60
		'minute' 	=> '60',		// 1 * 60
		'second' 	=> '1'			// 1
	];

	foreach ($refs as $ref => $value) {
		$ago = $period / $value;	//convert each reference to seconds
			if($ago >= 1) { 		//all positive numbers
				$ago = floor($ago); //round down the value
				$str =  $ago . " " . $ref . ($ago > 1 ? 's' : '') . " ago";
				$data[] = $str;
			} else if ($ago == 0) { //exception for 0 which is unlikely
				$data[] = "Just now";
			} else if ($ago < 0){ 				//negative time is only possible with time travel
				$data[] = "Error";
			}
	}
	echo $data[0];
}


if(isset($_POST['sumbit'])) {
	$time = strtotime($_POST['time']);
	$check_time = time_ago($time);
} else {
	$check_time = "Select a time and click Submit";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TIME AGO</title>
</head>
<body>
	<h1>Time Ago Function at work</h1>
	<form action="" method="POST">
		<label for="time">Check Date(date and time):</label>
		<input type="datetime-local" id="time" name="time">
		<input type="submit" name="submit" value="Submit">
	</form>
	<div><?php echo $check_time?></div>
</body>
</html>