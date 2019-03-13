<?
include("../include/main.php");
include("../include/tables.php"); 
include("../include/sybasecon.php");

$db = new Main(1,'Windows-1253');


$sybase = new Sybase();
$sql = "SELECT inpcodes.incd_pcode_serial,inpcodes.incd_long_description,inpcodes.incd_alternative_description,res.incd_record_code as incd_res_code
FROM inpcodes
JOIN inpcodes as res ON res.incd_pcode_serial = inpcodes.incd_ldg_reserve_group
WHERE inpcodes.incd_record_type = '19'
AND inpcodes.incd_status_flag = 'N'
AND inpcodes.incd_reserve_type = 'C'
ORDER BY inpcodes.incd_alternative_description ASC";
$res = $sybase->query($sql);

echo "\$occupations_list = \"";
while ($row = $sybase->fetch_assoc($res)) {

	echo $row["incd_pcode_serial"]."#".$row["incd_res_code"]."#".$row["incd_alternative_description"]."#".$row["incd_long_description"]."\n";

}
echo "\";";

$db->main_exit();
?>