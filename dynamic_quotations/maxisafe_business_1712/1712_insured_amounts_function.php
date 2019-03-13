<?
include_once("occupations.php");

function insured_amount_custom_rates ($array,$values,$quotation_id) {
$rates = iacr_get_fire_theft_rate($values[4][1]["amount"]);
	foreach ($array as $item_id => $qitems_array) {
		
		foreach($qitems_array as $section_id => $premium) {
			
			//Section 1 building construction class
			if ($item_id == 4 && $section_id == 3) {
				$array = iacr_sec1_building_construction_class($array,$values,$rates);
			}
			else if ($item_id == 4 && $section_id == 4) {
				$array = iacr_sesc1_all_contents($array,$values,$rates,4);
			}
			else if ($item_id == 4 && $section_id == 5) {
				$array = iacr_sesc1_all_contents($array,$values,$rates,5);
			}
			else if ($item_id == 4 && $section_id == 6) {
				$array = iacr_sesc1_all_contents($array,$values,$rates,6);
			}
			else if ($item_id == 4 && $section_id == 7) {
				$array = iacr_sesc1_all_contents($array,$values,$rates,7);
			}
			else if ($item_id == 4 && $section_id == 8) {
				$array = iacr_sesc1_all_contents($array,$values,$rates,8);
			}
			
			
			//section 3 E.L.
			else if ($item_id == 6 && $section_id == 1) {
				$array = iacr_sesc3_employers_liability($array,$values,$rates);
			}
			//section 5 Business Interuption.
			
			else if ($item_id == 8 && $section_id == 15 ) {
				$array = iacr_sesc5_business_interuption($array,$values,$rates);
			}

			
		}//foreach all the sections of the item
	
	}//foreach in all items

	//check all the sections for the correct pricing.
	//If a section is selected do not include in the pricing.
	//fix construction class value. This amount is not to be added to the total;
	$array[4][2] = 0;
	
	//fix public liability
	if ($values[5][15]["amount"] != 1) {
		$array[5][1] = 0;
	}
	if ($values[6][15]["amount"] != 1) {
		$array[6][1] = 0;
	}
	//clear money if section closed
	if ($values[7][15]["amount"] != 1) {
		$array[7][1] = 0;
	}
	if ($values[8][15]["amount"] != 1) {
		$array[8][1] = 0;
		$array[8][2] = 0;
		$array[8][3] = 0;
		$array[8][4] = 0;
		$array[8][5] = 0;
	}
	if ($values[9][15]["amount"] != 1) {
		$array[9][1] = 0;
	}
	if ($values[10][15]["amount"] != 1) {
		$array[10][1] = 0;
	}
	if ($values[11][15]["amount"] != 1) {
		$array[11][1] = 0;
	}




return $array;
}

function iacr_get_fire_theft_rate($occupation_selected) {
global $db,$occupation_fire_rates,$occupation_theft_rates;

$occupation_details = $db->query_fetch("SELECT * FROM registry_vault WHERE regi_registry_vault_serial = ".$occupation_selected);

$return["fire_class"] = $occupation_details["regi_value6"];
$return["theft_class"] = $occupation_details["regi_value7"];
$return["fire_rate"] = $occupation_fire_rates[$occupation_details["regi_value6"]];
$return["theft_rate"] = $occupation_theft_rates[$occupation_details["regi_value7"]];

return $return;
}

function iacr_sec1_building_construction_class($array,$values,$rates) {
global $result_amount_values;
	

	$array[4][3] = quotation_price_calculation_Get_rate_sum('*'.$rates["fire_rate"],$values[4][3]["amount"]);
	$building = $array[4][3];
	$extra_rate = quotation_price_calculation_Get_rate_sum($values[4][2]["rate"],$building);
	$array[4][3] += $extra_rate;

	//updates the detailed price records
	$result_amount_values[4][3]["rate"] = $rates["fire_rate"] . '['.$building.']+' . $values[4][2]["rate"] .'%['.($building * $extra_rate).']';

return $array;
}

function iacr_sesc1_all_contents($array,$values,$rates,$section) {
global $result_amount_values;

	//first get the fire rate
	$fire = quotation_price_calculation_Get_rate_sum('*'.$rates["fire_rate"],$values[4][$section]["amount"]);
	$theft = quotation_price_calculation_Get_rate_sum('*'.$rates["theft_rate"],$values[4][$section]["amount"]);
	
	//get the loading construction class
	$loading = quotation_price_calculation_Get_rate_sum($values[4][2]["rate"],($fire));
	
	$array[4][$section] = $fire + $theft + $loading;
	$result_amount_values[4][$section]["rate"] = ($rates["fire_rate"] + $rates["theft_rate"]). '[('.$fire.'|'.$theft.' -> '.($fire + $theft).']+' . $values[4][2]["rate"] .'%['.($loading).']';


return $array;
}

function iacr_sesc3_employers_liability($array,$values,$rates){
global $result_amount_values;
//echo $rates["fire_class"]."<hr>";
//echo $values[6][1]["all_rates"]."<hr>";
	$sel = explode('||',$values[6][1]["all_rates"]);
	$array[6][1] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$rates["fire_class"]);
	//echo $array[6][1]." -> ".$sel[$rates["fire_class"]-1];

return $array;
}

function iacr_sesc5_business_interuption($array,$values,$rates){
global $result_amount_values;

	//Loss of profit
	$sel = explode('||',$values[8][1]["all_rates"]);
	$result_amount_values[8][1]["rate"] = $sel[($rates["fire_class"] - 1)];
	$array[8][1] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$values[8][1]["amount"]);
	
	//Rent
	$sel = explode('||',$values[8][2]["all_rates"]);
	$result_amount_values[8][2]["rate"] = $sel[($rates["fire_class"] - 1)];
	$array[8][2] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$values[8][2]["amount"]);

	//Salaries
	$sel = explode('||',$values[8][3]["all_rates"]);
	$result_amount_values[8][3]["rate"] = $sel[($rates["fire_class"] - 1)];
	$array[8][3] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$values[8][3]["amount"]);

	//Acountants Expenses
	$sel = explode('||',$values[8][4]["all_rates"]);
	$result_amount_values[8][4]["rate"] = $sel[($rates["fire_class"] - 1)];
	$array[8][4] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$values[8][4]["amount"]);

	//Other
	$sel = explode('||',$values[8][5]["all_rates"]);
	$result_amount_values[8][5]["rate"] = $sel[($rates["fire_class"] - 1)];
	$array[8][5] = quotation_price_calculation_Get_rate_sum($sel[($rates["fire_class"] - 1)],$values[8][5]["amount"]);
return $array;
}

?>