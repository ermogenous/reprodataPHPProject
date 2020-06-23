<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

$sql = "SELECT * FROM inagents";
$result = $sybase->query($sql);
while ($row = $sybase->fetch_assoc($result)) {

	echo $row["inag_agent_code"];
	$sql = "SELECT * FROM ap_agents WHERE ap_agents_code = '".$row["inag_agent_code"]."'";
	$res = $db->query_fetch($sql);
	echo " -> FOUND ---------------->".$res["ap_name"]." <br>";

} 

?>

<?
$db->show_footer();
?>