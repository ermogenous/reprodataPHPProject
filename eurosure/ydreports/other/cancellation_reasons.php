<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

if ($_POST["action"] == "show") {

	if ($_POST["agent"] != "")
		$extra_sql = "AND inag_agent_code = '".$_POST["agent"]."' ";

	if ($_POST["deleted_date_from"] != "" && $_POST["deleted_date_to"] != "")
		$extra_sql .= "AND inpol_starting_date BETWEEN '".$_POST["deleted_date_from"]."' AND '".$_POST["deleted_date_to"]."' ";

$sql = "SELECT 
IF inped_endorsement_serial = inpol_last_cancellation_endorsement_serial 
	THEN IF inpol_status = 'A' 
	AND inpol_replaced_by_policy_serial = 0 
	AND inpol_cancellation_date IS NOT NULL 
	THEN 'C' 
	ELSE 'L' 
	ENDIF 
	ELSE inpol_process_status ENDIF as clo_process_status
	
,inpol_policy_number
,inpol_comment
,inag_agent_code
,inpol_confirmed_by
,inpol_starting_date
FROM inpolicies
JOIN inagents ON inag_agent_serial = inpol_agent_serial
JOIN inpolicyendorsement ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_policy_serial
WHERE clo_process_status = 'C'
AND inpol_policy_number LIKE '".$_POST["product"]."'

".$extra_sql."

ORDER BY inpol_policy_number ASC";
	
if ($_POST["export_file"] == "delimited") {
	export_data_delimited($sql,'sybase','#',"'",'download','
','SQL','Cancellation Reasons');
}
else if ($_POST["export_file"] == "no") {
	$table_data = export_data_html_table($sql,'sybase',"border='1' align='center'");
}

//export_download_variable($xml->export,$_POST["year"]."-".$_POST["month"]."-".$_POST["section"].".xml");

}//if action show



$db->show_header();
?>
<form action="" method="post"><table width="577" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Per Section Report </td>
    </tr>
  <tr>
    <td width="132">Section</td>
    <td width="429"><select name="product" id="product">
	  <option value="%%" <? if ($_POST["product"] == '%%') echo "selected=\"selected\"";?>>ALL</option>
      <option value="10%" <? if ($_POST["product"] == '10%') echo "selected=\"selected\"";?>>10 P.A</option>
      <option value="16%" <? if ($_POST["product"] == '16%') echo "selected=\"selected\"";?>>16 Goods In Transit</option>
      <option value="17%" <? if ($_POST["product"] == '17%') echo "selected=\"selected\"";?>>17 Fire</option>
      <option value="19%" <? if ($_POST["product"] == '19%') echo "selected=\"selected\"";?>>19 Motor</option>
      <option value="21%" <? if ($_POST["product"] == '21%') echo "selected=\"selected\"";?>>21 Marine</option>
      <option value="22%" <? if ($_POST["product"] == '22%') echo "selected=\"selected\"";?>>22 P.L</option>
    </select>    </td>
  </tr>
  
  <tr>
    <td>Deleted Date </td>
    <td>From
      <input name="deleted_date_from" type="text" id="deleted_date_from" size="8" value="<? echo $_POST["deleted_date_from"];?>">
      To 
      <input name="deleted_date_to" type="text" id="deleted_date_to" size="8" value="<? echo $_POST["deleted_date_to"];?>"> 
      YYYY-MM-DD </td>
  </tr>
  <tr>
    <td>Agent</td>
    <td><input name="agent" type="text" id="agent" size="9" value="<? echo $_POST["agent"];?>" />
      New Codes Only </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>EXTRAS</strong></td>
    </tr>
  
  <tr>
    <td>Export File </td>
    <td><input name="export_file" type="radio" value="no" <? if ($_POST["export_file"] == "no" || $_POST["export_file"] == "") echo "checked=\"checked\"";?> />
No
  <input name="export_file" type="radio" value="delimited" <? if ($_POST["export_file"] == "delimited") echo "checked=\"checked\"";?> />
Delimited (#)</td>
  </tr>
  
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="Submit" value="Submit"></td>
  </tr>
</table>
</form>

<?
echo $table_data;
$db->show_footer();
?>