<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();

if ($_POST["year"] == "")
	$_POST["year"] = date("Y");
if ($_POST["period_start"] == "")
	$_POST["period_start"] = date("m")-1;
if ($_POST["period_end"] == "")
	$_POST["period_end"] = date("m")-1;


?>
<form name="form1" method="post" action="">
  <table width="350" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Period Production Report </td>
    </tr>
    <tr>
      <td width="88">Year</td>
      <td width="262"><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
    </tr>
    <tr>
      <td>Period</td>
      <td><input name="period_start" type="text" id="period_start" size="5" maxlength="2" value="<? echo $_POST["period_start"];?>">
        UpTo
        <input name="period_end" type="text" id="period_end" size="5" maxlength="2" value="<? echo $_POST["period_end"];?>"></td>
    </tr>
    
    <tr>
      <td><input name="action" type="hidden" id="action" value="submit"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>
<?
//=============================================================================================================

if ($_POST["action"] == "submit") {

?>
<br><br>
<table width="458" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126"><strong>Agent Code</strong></td>
    <td width="152" align="center"><strong>Cymenu</strong></td>
  </tr>
<?
$sql = "SELECT aaf_agent,
SUM(ap_asci_full.aaf_premium) as total
FROM
ap_asci_full
WHERE
ap_asci_full.aaf_year =  '".$_POST["year"]."' 
AND ap_asci_full.aaf_month >= '".$_POST["period_start"]."'
AND ap_asci_full.aaf_month <= '".$_POST["period_end"]."'
GROUP BY aaf_agent
ORDER BY aaf_agent ASC
";
$result = $db->query($sql);
while ($row = $db->fetch_assoc($result)) {
$total += $row["total"];
?>
  <tr>
    <td><? echo $row["aaf_agent"];?></td>
	<td align="center"><? echo round($row["total"],2); ?></td>
  </tr>
<? } ?>
  <tr>
    <td colspan="2"><strong>Totals For Year:<? echo  $_POST["year"];?> Period:<? echo $_POST["period_start"]."/".$_POST["period_end"]." -> ".round($total,2);?></strong></td>
  </tr>
</table>


<?
}//if action= submit



$db->show_footer();
?>
