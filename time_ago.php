<?php
function time_ago($time) {
	$now = time();				//current time (change timezone accordingly)
	$period = $now - $time;			//get the time difference
	$refs = [
		'year' 		=> '31553280',	// (365+365+365+365+365)/5 * 24 * 60 * 60
		'month' 	=> '2629440',	// ((365+365+365+365+365)/5/12) * 24 * 60 * 60
		'week' 		=> '604800',	// 7 * 24 * 60 * 60
		'day' 		=> '86400',	// 24 * 60 * 60
		'hour' 		=> '3600',	// 60 * 60
		'minute' 	=> '60',	// 1 * 60
		'second' 	=> '1'		// 1
	];

	foreach ($refs as $ref => $value) {
		$ago = $period / $value;		//convert each reference to seconds
			if($ago >= 1) { 		//all positive numbers
				$ago = floor($ago); 	//round down the value
				$str =  $ago . " " . $ref . ($ago > 1 ? 's' : '') . " ago";
				$data[] = $str;
			} else if ($ago == 0) { 	//exception for 0 which is unlikely
				$data[] = "Just now";
			} else if ($ago < 0){ 		//negative time is only possible with time travel
				$data[] = "Error";
			}
	}
	return $data[0];
}

if(isset($_POST['submit'])) {
	echo "Time Check for ";
	$time = strtotime($_POST['date']);
	echo time_ago($time);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
	<title>Document</title>
</head>
<body>
	<div class="row">
		<div class="one-third column">
			<form method="POST">
				<label for="date-input">Your Date</label>
				<input class="u-full-width" type="text" name="date" placeholder="dd/mm/yyyy hh:mm:ss">
				<input class="button-primary" type="submit" name="submit" value="Submit" id="date-input">
			</form>
		</div>
	</div>
</body>
</html>
