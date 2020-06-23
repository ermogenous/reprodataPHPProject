<?
include("../../include/main.php");
$db = new Main();

$sql = "SELECT * FROM ap_asci_complete WHERE 
(
	year1 = '2009' AND month1 >= '1'   
	AND month1 <= '9'
) AND `category` = 'NON' AND `policy` LIKE '117%' 
AND policy <> '1171004524' AND policy <> '1174009407'  AND katigoria_kindinou = 'B'
";
$title = 'Total';

$result = $db->query($sql);

while ($row = $db->fetch_assoc($result)) {

	if ($row["logistikos_klados"] == '1729' || $row["logistikos_klados"] == '1701' || $row["logistikos_klados"] == '1612' || $row["logistikos_klados"] == '1736' || $row["etos_isxis"] == -10) {
		$data[$row["policy"]]["insured_amount"] += $row["kefalaio"];
	}
	$data[$row["policy"]][$row["logistikos_klados"]]["premium"] += $row["premium"];
	$data[$row["policy"]]["total_premium"] += $row["premium"];
	//$data[$row["policy"]]["insured_amount"] += $row["kefalaio"];
	//$data[$row["policy"]]["insured_amount"] += $row["kefalaio"];
	$log[$row["logistikos_klados"]] = 1;
	$policies[$row["policy"]] = 1;


}

foreach($policies as $policy => $value) {

	if ($data[$policy]["insured_amount"] <= 100000) {
		$bands["1"]["insured_amount"] += $data[$policy]["insured_amount"];
		$bands["1"]["total_premium"] += $data[$policy]["total_premium"];
		$bands["1"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
		$bands["1"]["fire_premium"] += $data[$policy][1701]["premium"];
		$bands["1"]["total_policies"] += 1;
		if ($data[$policy]["insured_amount"] == 0)
		echo $policy." Insured Amount -> ".$data[$policy]["insured_amount"]." Premium -> ".$data[$policy]["total_premium"]."<hr>";
	}
	

}

$db->main_exit();

?>