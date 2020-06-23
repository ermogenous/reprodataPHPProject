<?
include("../../../include/main.php");
include("../../../include/tables.php");
include("../../../include/sybasecon.php");
include("../../../tools/export_data.php");
$db = new Main(1);
$sybase = new Sybase();

$db->show_header();

if ($_GET["lid"] != "") {
	
	$sql = "SELECT
	*
	FROM
	DMR_REPORTS 
	WHERE
	dmrp_reports_serial = ".$_GET["lid"];
	$report = $db->query_fetch($sql);
	
	
	if ($report["dmrp_rows_sql_db"] == 'intranet') {
		//$data = $db->query($report["dmrp_rows_sql"]);
		echo export_data_html_table(stripcslashes($report["dmrp_rows_sql"]),'db',"align=\"center\" border=\"1\"");
	}
	else {
		
	}
	
	
}//if lid != ""

?>

<?
$db->show_footer();
?>