<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$sql = "SELECT
incl_identity_card,
LIST(DISTINCT(incl_account_code))as clo_accounts
,COUNT()as clo_total
FROM
inclients
WHERE 
incl_identity_card <> ''

GROUP BY 
incl_identity_card
HAVING 
clo_total > 3
";
$result = $sybase->query($sql);
//first group all the identities
$i=0;
while($row = $sybase->fetch_assoc($result)) {
	$i++;
	$data[$i]["id"] = $row["incl_identity_card"];
	$accounts = explode(",",$row["clo_accounts"]);
	foreach($accounts as $value) {
		$data[$i]["accounts"][] = $value;
	}
}
print_r($data);
$db->show_header();

?>


<?
$db->show_footer();
?>