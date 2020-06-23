<?
include("../../include/main.php");
$db = new Main(1);
include("../../include/sybasecon.php");
$sybase = new Sybase();
include("../../tools/export_data.php");

$db->include_js_file("../../include/jscripts.js");
$db->enable_jquery();
$db->enable_jquery_ui('dot-luv');

if ($_POST["action"] == "show") {

	$agents = $_POST["agents"];


}//if action == show

$db->show_header();
?>
<script>

$(document).ready(function() {

$("#as_at_date").datepicker({dateFormat: 'yy-mm-dd'});

});

</script>

<?
//init
if ($_POST["as_at_date"] == "") {
	$as_at = date("Y-m-d");	
}
else {
	$as_at = $_POST["as_at_date"];	
}
?>
<form name="form1" method="POST" action="" >
  <table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Sum Insured Amounts for Clients </strong></td>
    </tr>
    <tr>
      <td width="147" height="28">Policy Status</td>
      <td width="629"><select name="policy_status" id="policy_status">
        <option value="active" <? if ($_POST["policy_status"] == 'active') echo "selected";?>>Only clients with active policies</option>
        <option value="inactive" <? if ($_POST["policy_status"] == 'inactive') echo "selected";?>>Only clients with NOT Active policies</option>
        <option value="all" <? if ($_POST["policy_status"] == 'all') echo "selected";?>>All clients active policies or not active</option>
      </select></td>
    </tr>
    <tr>
      <td height="28">As At Date</td>
      <td><input type="text" name="as_at_date" id="as_at_date" value="<? echo $as_at;?>" /></td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="28">Group By</td>
      <td><select name="group_1" id="group_1">
      </select>
        <select name="group_2" id="group_2">
      </select>
        <select name="group_3" id="group_3">
      </select></td>
    </tr>
    <tr>
      <td height="28">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="28">Agents</td>
      <td><select name="agents[]" size="10" multiple="multiple" id="agents[]">
      <?
	  $sql = "SELECT inag_agent_code,inag_long_description FROM inagents WHERE inag_status_flag = 'N' AND inag_agent_type = 'A' ORDER BY inag_agent_code ASC";
	  $result = $sybase->query($sql);
	  while($agent = $sybase->fetch_assoc($result)) {
	  ?>
        <option value="<? echo $agent["inag_agent_code"];?>"><? echo $agent["inag_agent_code"]." - ".$agent["inag_long_description"];?></option>
      <? } ?>
      </select></td>
    </tr>
    <tr>
      <td height="28"><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
echo $table_data;
$db->show_footer();
?>