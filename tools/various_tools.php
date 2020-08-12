<?php

function get_last_day_of_the_month($year,$month) {

	if ($month == 2) {
	
		if ($year % 4 == 0) {
			$out = 29;
		}
		else {
			$out = 28;
		}
	
	}
	
	switch($month) {
		case 1: $out = 31; break;
		case 3: $out = 31; break;
		case 4: $out = 30; break;
		case 5: $out = 31; break;
		case 6: $out = 30; break;
		case 7: $out = 31; break;
		case 8: $out = 31; break;
		case 9: $out = 30; break;
		case 10: $out = 31; break;
		case 11: $out = 30; break;
		case 12: $out = 31; break;
		
	
	}//switch
return $out;

}


//gives the name of the band based on the $band var.
function get_bands($start_band,$band_step,$value) {

	if ($value < $start_band && $start_band <> 0) {
		return "0-".$start_band;
	}

	for ($i=$start_band; $i<=$value; $i += $band_step) {
	
		//echo $i." - ".($i+$band)." => ".$value."<br>";
		if ($value >= $i && $value < ($i+$band_step)) {
			if ($i==0) {
				$return_a = $i;
			}
			else {
				$return_a = $i+1;
			}
			$return = $return_a."-".($i+$band_step);
			return $return;
			break;
		}
	
	}
return 'Outside of boundaries';
}

?>