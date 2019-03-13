<?
include("../../include/main.php");
include("occupations.php");
$db = new Main(1);

$sql = "SELECT
*
FROM
oqt_quotations
JOIN oqt_quotations_items ON oqqit_quotations_ID = oqq_quotations_ID AND oqqit_items_ID = 4
WHERE
oqq_quotations_type_ID = 2
AND oqqit_quotations_items_ID NOT IN (241,255)";
$result = $db->query($sql);
while ($row = $db->fetch_assoc($result)) {
$i++;
	//find the correct occupation
	$sql = "SELECT * FROM registry_vault WHERE
	regi_section = 'occupations'
	AND regi_value3 = ".$row["oqqit_insured_amount_1"];
	$data = $db->query_fetch($sql);
	echo $sql;
	print_r($data);
	echo "\n\n";
	
	//fix sql
	$sql_fix = "UPDATE
	oqt_quotations_items 
	SET oqqit_insured_amount_1 = ".$data["regi_registry_vault_serial"]."
	WHERE
	oqqit_quotations_items_ID = ".$row["oqqit_quotations_items_ID"]." LIMIT 1";
	echo $sql_fix."\n\n\n\n<hr>----------------------------------------------\n\n";

	if ($data["regi_registry_vault_serial"] != "") {
		echo "OK<br>\n";
		//$db->query($sql_fix);
	}else {
		echo "ERROR<br>\n";	
	}
	
	if ($i> 1) {
	//	exit();	
	}
	
}


$db->main_exit();
?>