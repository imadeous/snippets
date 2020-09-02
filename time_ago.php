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

$time = strtotime("2020-02-17 17:44:00");
echo time_ago($time);
?>
