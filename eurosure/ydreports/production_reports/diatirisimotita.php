<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 360);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

?>
<style type="text/css">
HR {
page-break-after: always;
}
</style>

<?
if ($_GET["action"] != "submit") {
?>
<form name="form1" method="GET" action="">
  <table width="468" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Diatirisimotita Report </td>
    </tr>
    <tr>
      <td>Year 1 </td>
      <td><input name="year1" type="text" id="year1" value="<? echo $_GET["year1"];?>"></td>
    </tr>
    <tr>
      <td width="88">Year 2 </td>
      <td width="380"><input name="year2" type="text" id="year2" value="<? echo $_GET["year2"];?>"></td>
    </tr>
    
    <tr>
      <td>Agents</td>
      <td>From
        <input name="agents_from" type="text" id="agents_from" value="<? echo $_GET["agents_from"];?>"> 
      To 
      <input name="agents_to" type="text" id="agents_to" value="<? echo $_GET["agents_to"];?>"></td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<?
}
//=============================================================================================================

if ($_GET["action"] == "submit") {
$queries = new insurance_queries();

	//agents
	$sql = "SELECT * FROM inagents WHERE inag_agent_code >= '".$_GET["agents_from"]."' AND inag_agent_code <= '".$_GET["agents_to"]."'";
	$resagent = $sybase->query($sql);
	while ($agent = $sybase->fetch_assoc($resagent)) {

		if ($_GET["year1"] >= 2009) {
		$sql = $queries->agent_production_per_product_periods_process_status($_GET["year1"],1,12,$agent["inag_agent_code"],'%%','LIKE','%%');
		$result = $sybase->query($sql);
			while ($row = $sybase->fetch_assoc($result)) {

				if ($row["inped_process_status"] == 'N')
					$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["new"] += $row["clo_premium"];
				
				if ($row["inped_process_status"] != 'N' && $row["inped_process_status"] != 'R')
					$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["endorsements"] += $row["clo_premium"];
				
				if ($row["inped_process_status"] == 'R')
					$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["renewals"] += $row["clo_premium"];
				
				$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["all"] += $row["clo_premium"];

			}//while results	

		}//synthesis year 1

		if ($_GET["year2"] >= 2009) {

		$sql = $queries->agent_production_per_product_periods_process_status($_GET["year2"],1,12,$agent["inag_agent_code"],'%%','LIKE','%%');
		$result = $sybase->query($sql);

			while ($row = $sybase->fetch_assoc($result)) {

				if ($row["inped_process_status"] == 'N')
					$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["new"] += $row["clo_premium"];
				
				if ($row["inped_process_status"] != 'N' && $row["inped_process_status"] != 'R')
					$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["endorsements"] += $row["clo_premium"];
				
				if ($row["inped_process_status"] == 'R')
					$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["renewals"] += $row["clo_premium"];
				
				$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["all"] += $row["clo_premium"];

			}//while results	

		}//synthesis year 2

//CYMENU
//CYMENU YEAR 1
		if ($_GET["year1"] <= '2009') {
		
			
			//if agents exists in new system
			if ($agent["inag_numeric_key1"] != 0) {
			
				$sql = "SELECT SUM(aaf_premium)as prem, aaf_typos FROM `ap_asci_full` 
						WHERE aaf_year = '".$_GET["year1"]."'
						AND aaf_agent = '".$agent["inag_numeric_key1"]."'
						GROUP BY aaf_agent,aaf_typos";
				$res = $db->query($sql);
				while ($row = $db->fetch_assoc($res)) {
					
					if ($row["aaf_typos"] == '50') 
						$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["new"] += $row["prem"];
						
					if ($row["aaf_typos"] == '51') 
						$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["endorsements"] += $row["prem"];
					
					if ($row["aaf_typos"] == '52') 
						$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["renewals"] += $row["prem"];
						
					$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["all"] += $row["prem"];
					
				}
			
			}//if agent exists in sysnthesis
		
		}//cymenu year 1

//CYMENU YEAR 1
		if ($_GET["year1"] <= '2009') {
		
			
			//if agents exists in new system
			if ($agent["inag_numeric_key1"] != 0) {
			
				$sql = "SELECT SUM(aaf_premium)as prem, aaf_typos FROM `ap_asci_full` 
						WHERE aaf_year = '".$_GET["year2"]."'
						AND aaf_agent = '".$agent["inag_numeric_key1"]."'
						GROUP BY aaf_agent,aaf_typos";
				$res = $db->query($sql);
				while ($row = $db->fetch_assoc($res)) {
					
					if ($row["aaf_typos"] == '50') 
						$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["new"] += $row["prem"];
						
					if ($row["aaf_typos"] == '51') 
						$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["endorsements"] += $row["prem"];
					
					if ($row["aaf_typos"] == '52') 
						$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["renewals"] += $row["prem"];
						
					$data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["all"] += $row["prem"];
					
				}
			
			}//if agent exists in sysnthesis
		
		}//cymenu year 1

?>
	
<table width="582" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>Agent</td>
    <td><? echo $agent["inag_agent_code"];?></td>
    <td colspan="3"><? echo $agent["inag_long_description"];?></td>
  </tr>
  <tr>
    <td width="116"><strong>Typos</strong></td>
    <td width="120"><strong>Year <? echo $_GET["year1"];?></strong></td>
    <td width="122"><strong>Year <? echo $_GET["year2"];?></strong></td>
    <td width="114"><strong>Diatirisimotita</strong></td>
    <td width="110">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>New</strong></td>
    <td align="center"><? echo $data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["new"];?></td>
    <td align="center"><? echo $data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["new"];?></td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Renewals</strong></td>
    <td align="center"><? echo $data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["renewals"];?></td>
    <td align="center"><? echo $data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["renewals"];?></td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Endorsements</strong></td>
    <td align="center"><? echo $data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["endorsements"];?></td>
    <td align="center"><? echo $data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["endorsements"];?></td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total</strong></td>
    <td align="center"><? echo $data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["all"];?></td>
    <td align="center"><? echo $data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["all"];?></td>
    <td align="center"><strong>
<? 
	if ($data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["all"] > 0) {
		echo round((($data[$_GET["year2"]][$agent["inag_agent_code"]]["premium"]["renewals"] * 100 ) /$data[$_GET["year1"]][$agent["inag_agent_code"]]["premium"]["all"]),0) ;
	}
?>%</strong></td>
    <td>&nbsp;</td>
  </tr>
</table><br>
<?
$i++;
if ($i%6 == 0 && $i >1)
	echo "<HR color=\"#FFFFFF\" width=\"1\" align=\"center\" noshade=\"noshade\">";

	}//while all agents
//print_r($data);
//SYNTHESIS
}//if action= submit



$db->show_footer();
?>
