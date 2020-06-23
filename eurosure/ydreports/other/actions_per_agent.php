<?
ini_set("memory_limit","128M");
set_time_limit(600);
include("../../include/main.php");
$db = new Main(1);
$db->admin_more_head = "<script language=\"JavaScript\" type=\"text/javascript\" src=\"../../include/jscripts.js\"></script>";
include("../../include/sybasecon.php");
include("../../include/libraries/excel_xml/xmltoexcel.lib.php");
include("../../tools/export_data.php");
$sybase = new Sybase();
$inqueries = new insurance_queries();

if ($_POST["action"] == "show") {

	if ($_POST["action_date_from"] != "" && $_POST["action_date_to"] != "") {
		$extra_sql .= "AND inact_action_date >='".$db->convert_date_format($_POST["action_date_from"],'dd/mm/yyyy','yyyy-mm-dd')."'\n";
		$extra_sql .= "AND inact_action_date <='".$db->convert_date_format($_POST["action_date_to"],'dd/mm/yyyy','yyyy-mm-dd')."'\n";
	}//action dates
	
	if ($_POST["product"] != "%%") {
		$extra_sql .= "AND clo_target_number LIKE '".$_POST["product"]."'\n";
	}//product
	
	if ($_POST["agent_from"] != "" && $_POST["agent_to"] != "") {
		$extra_sql .= "AND inag_agent_code >= '".$_POST["agent_from"]."'\n";
		$extra_sql .= "AND inag_agent_code <= '".$_POST["agent_to"]."'\n";
	}//agents range
	
	if ($_POST["policy_period_from"] != "" && $_POST["policy_period_to"] != "" && $_POST["policy_period_year"] != "") {
		$extra_sql .= "AND inpol_policy_year = '".$_POST["policy_period_year"]."'\n";
		$extra_sql .= "AND inpol_policy_period >= '".$_POST["policy_period_from"]."'\n";
		$extra_sql .= "AND inpol_policy_period <= '".$_POST["policy_period_to"]."'\n";
	}//policy period
	
	if ($_POST["status_executed"] != "" || $_POST["status_outstanding"] != "" || $_POST["status_inactive"] != "") {
		if ($_POST["status_executed"] != "") {
			$action_statuses = ",'E'";
		}//status executed
	
		if ($_POST["status_outstanding"] != "") {
			$action_statuses .= ",'O'";
		}//status outstanding
	
		if ($_POST["status_inactive"] != "") {
			$action_statuses .= ",'I'";
		}//status inactive
		$extra_sql .= "AND inact_action_status IN (''".$action_statuses.")\n"; 
	}//actions statuses
	
	if ($_POST["action_type"] != "BOTH") {
		$extra_sql .= "AND inact_target_flag = '".$_POST["action_type"]."'\n";
	}//action type
	
	if ($_POST["user"] != "") {
		$extra_sql .= "AND inact_action_user = '".$_POST["user"]."'\n";
	}//user

	//sorting
	//first sort must set for the rest to apply
	if ($_POST["sort1"] != '0') {
		$sort = "ORDER BY \n".$_POST["sort1"]." ASC";
		
		if ($_POST["sort2"] != '0') {
			$sort .= ",\n".$_POST["sort2"]." ASC";
			
			if ($_POST["sort3"] != '0') {
				$sort .= ",\n".$_POST["sort3"]." ASC";
				
					if ($_POST["sort4"] != '0') {
						$sort .= ",\n".$_POST["sort4"]." ASC";
						
				}//sort 2
			}//sort 3
		}//sort 2
	}//sort1

$sql = "
SELECT  
inagents.inag_agent_code ,           
inactions.inact_target_flag ,           
inactioncodes.incd_record_code ,           
inactioncodes.incd_long_description ,           
inactions.inact_action_days ,           
inactions.inact_warning_days ,           
inactions.inact_action_required ,           
inactions.inact_before_after_confirmation ,           
inactions.inact_user_defined_action ,           
inactions.inact_action_status ,           
inactions.inact_executed_by ,           
inactions.inact_executed_on ,           
inactions.inact_action_date ,           
inactions.inact_action_user ,           
IF inact_target_flag = 'TP' THEN inpol_policy_number ELSE inclm_claim_number ENDIF as clo_target_number,           
inactions.inact_description ,           
inactions.inact_target_serial ,           
inagents.inag_agent_code ,
inpolicies.inpol_policy_period,
inpolicies.inpol_policy_year, 
IF inact_target_flag = 'TP' THEN inpol_agent_serial ELSE (SELECT a.inpol_agent_serial FROM inpolicies a WHERE a.inpol_policy_serial = inclaims.inclm_policy_serial) ENDIF as clo_agent_serial     

FROM inactions  
LEFT OUTER JOIN inclaims  ON inactions.inact_target_serial = inclaims.inclm_claim_serial
LEFT OUTER JOIN inpolicies  ON inactions.inact_target_serial = inpolicies.inpol_policy_serial,          
inactioncodes ,           
inagents    

WHERE ( inactioncodes.incd_pcode_serial = inactions.inact_action_serial ) 
and          ( ( inagents.inag_agent_serial = clo_agent_serial ) )   

".$extra_sql."
".$sort;


}//if action show

if ($_POST["export_file"] == "delimited") {
export_data_delimited($sql,'sybase','#',"'",'download','
','SQL','Actions Per Agent');
}//if to export delimited

if ($_POST["export_file"] != "show_clear" ){

$db->show_header();
?>
<script language="JavaScript" type="text/javascript">
function validate_form() {
if (!ValidateDate('action_date_from',1))
	return false;
if (!ValidateDate('action_date_to',1))
	return false;


}
</script>
<form action="" method="post" onsubmit="return validate_form();"><table width="676" border="1" align="center">
  <tr>
    <td colspan="2" align="center">Claims Per Section Report </td>
    </tr>
  <tr>
    <td width="132">Section</td>
    <td width="528"><select name="product" id="product">
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
    <td>Actions Dates </td>
    <td>From
      <input name="action_date_from" type="text" id="action_date_from" size="8" value="<? echo $_POST["action_date_from"];?>">
      To 
      <input name="action_date_to" type="text" id="action_date_to" size="8" value="<? echo $_POST["action_date_to"];?>"> 
      DD/MM/YYYY</td>
  </tr>
  <tr>
    <td>Agent</td>
    <td>From
      <input name="agent_from" type="text" id="agent_from" size="9" value="<? echo $_POST["agent_from"];?>" />
      To 
      <input name="agent_to" type="text" id="agent_to" size="9" value="<? echo $_POST["agent_to"];?>" />
      New Codes Only </td>
  </tr>
  <tr>
    <td>Policy Period </td>
    <td>From 
      <input name="policy_period_from" type="text" id="policy_period_from" size="8" value="<? echo $_POST["policy_period_from"];?>" />
      To
      <input name="policy_period_to" type="text" id="policy_period_to" size="8" value="<? echo $_POST["policy_period_to"];?>" /> 
      Year
      <input name="policy_period_year" type="text" id="policy_period_year" size="8" value="<? echo $_POST["policy_period_year"];?>" /></td>
  </tr>
  <tr>
    <td>Action Status </td>
    <td>Executed
      <input name="status_executed" type="checkbox" id="status_executed" value="1" <? if ($_POST["status_executed"] == 1 || $_POST["action"] != "show") echo "checked=\"checked\"";?> /> 
      Outstanding
      <input name="status_outstanding" type="checkbox" id="status_outstanding" value="1" <? if ($_POST["status_outstanding"] == 1  || $_POST["action"] != "show") echo "checked=\"checked\"";?> /> 
      Inactive 
      <input name="status_inactive" type="checkbox" id="status_inactive" value="1" <? if ($_POST["status_inactive"] == 1  || $_POST["action"] != "show") echo "checked=\"checked\"";?> /></td>
  </tr>
  <tr>
    <td>Type Of Actions</td>
    <td><select name="action_type" id="action_type">
      <option value="BOTH" <? if ($_POST["action_type"] == 'BOTH') echo "selected=\"selected\"";?>>Both</option>
      <option value="TP" <? if ($_POST["action_type"] == 'TP') echo "selected=\"selected\"";?>>Policy</option>
      <option value="TC" <? if ($_POST["action_type"] == 'TC') echo "selected=\"selected\"";?>>Claims</option>
    </select>    </td>
  </tr>
  <tr>
    <td>User</td>
    <td><input name="user" type="text" id="user" size="15" value="<? echo $_POST["user"];?>"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>SORTING</strong></td>
    </tr>
  <tr>
    <td>Sort By </td>
    <td><select name="sort1" id="sort1">
      <option value="0" <? if ($_POST["sort1"] == "0") echo "selected=\"selected\"";?>>None</option>
      <option value="inag_agent_code" <? if ($_POST["sort1"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent</option>
      <option value="inact_action_user" <? if ($_POST["sort1"] == "inact_action_user") echo "selected=\"selected\"";?>>User</option>
      <option value="clo_target_number" <? if ($_POST["sort1"] == "clo_target_number") echo "selected=\"selected\"";?>>Policy Number</option>
      <option value="inact_target_flag" <? if ($_POST["sort1"] == "inact_target_flag") echo "selected=\"selected\"";?>>Type Of Actions</option>
    </select>
      <select name="sort2" id="sort2">
        <option value="0" <? if ($_POST["sort2"] == "0") echo "selected=\"selected\"";?>>None</option>
        <option value="inag_agent_code" <? if ($_POST["sort2"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent</option>
        <option value="inact_action_user" <? if ($_POST["sort2"] == "inact_action_user") echo "selected=\"selected\"";?>>User</option>
        <option value="clo_target_number" <? if ($_POST["sort2"] == "clo_target_number") echo "selected=\"selected\"";?>>Policy Number</option>
        <option value="inact_target_flag" <? if ($_POST["sort2"] == "inact_target_flag") echo "selected=\"selected\"";?>>Type Of Actions</option>
      </select>
      <select name="sort3" id="sort3">
        <option value="0" <? if ($_POST["sort3"] == "0") echo "selected=\"selected\"";?>>None</option>
        <option value="inag_agent_code" <? if ($_POST["sort3"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent</option>
        <option value="inact_action_user" <? if ($_POST["sort3"] == "inact_action_user") echo "selected=\"selected\"";?>>User</option>
        <option value="clo_target_number" <? if ($_POST["sort3"] == "clo_target_number") echo "selected=\"selected\"";?>>Policy Number</option>
        <option value="inact_target_flag" <? if ($_POST["sort3"] == "inact_target_flag") echo "selected=\"selected\"";?>>Type Of Actions</option>
      </select>
      <select name="sort4" id="sort4">
        <option value="0" <? if ($_POST["sort4"] == "0") echo "selected=\"selected\"";?>>None</option>
        <option value="inag_agent_code" <? if ($_POST["sort4"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent</option>
        <option value="inact_action_user" <? if ($_POST["sort4"] == "inact_action_user") echo "selected=\"selected\"";?>>User</option>
        <option value="clo_target_number" <? if ($_POST["sort4"] == "clo_target_number") echo "selected=\"selected\"";?>>Policy Number</option>
        <option value="inact_target_flag" <? if ($_POST["sort4"] == "inact_target_flag") echo "selected=\"selected\"";?>>Type Of Actions</option>
      </select></td>
  </tr>
  <tr>
    <td>New Page </td>
    <td><select name="new_page" id="new_page">
      <option value="no" <? if ($_POST["new_page"] == "no") echo "selected=\"selected\"";?>>No Break</option>
      <option value="agent" <? if ($_POST["new_page"] == "agent") echo "selected=\"selected\"";?>>Agent</option>
      <option value="user" <? if ($_POST["new_page"] == "user") echo "selected=\"selected\"";?>>User</option>
    </select>
    </td>
  </tr>
  
  
  <tr>
    <td colspan="2" align="center"><strong>EXTRAS</strong></td>
    </tr>
  
  <tr>
    <td>Export File </td>
    <td><input name="export_file" type="radio" value="show_clear" <? if ($_POST["export_file"] == "show" || $_POST["export_file"] == "") echo "checked=\"checked\"";?> />
Show Clear
  <input name="export_file" type="radio" value="show" <? if ($_POST["export_file"] == "show" || $_POST["export_file"] == "") echo "checked=\"checked\"";?> />
Show 
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
}//
if ($_POST["export_file"] == "show" || $_POST["export_file"] == "show_clear"){
	$result = $sybase->query($sql);
?>
<style type="text/css">
<!--
.table_border {
	border: 1px solid #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-decoration: none;

}
.table_border2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-decoration: none;
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.plain_text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
}
HR {
page-break-after: always;
}

-->
</style>


<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="4" align="center" class="table_border"><strong>USER ACTIONS</strong></td>
  </tr>
</table>
<?
$num =0;
while ($row = $sybase->fetch_assoc($result,1)) {
$num++;
if (($row["clo_target_number"] != $previous_policy && $previous_policy != "") || $num == 1) {
?>
</table>
<? 
if ($row["inag_agent_code"] != $previous_agent && $previous_agent != "" && $_POST["new_page"] == 'agent') {
?>
<HR color="#FFFFFF" width="1" align="center" noshade="noshade">
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="4" align="center" class="table_border"><strong>USER ACTIONS</strong></td>
  </tr>
</table>
<? 
} 
if ($row["inact_action_user"] != $previous_user && $previous_user != "" && $_POST["new_page"] == 'user') {
?>
<HR color="#FFFFFF" width="1" align="center" noshade="noshade">
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="4" align="center" class="table_border"><strong>USER ACTIONS</strong></td>
  </tr>
</table>
<? } ?>

<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="2" width="240" class="table_border2">Policy:&nbsp;&nbsp;<? echo $row["clo_target_number"];?></td>
    <td width="240" class="table_border2">Agent:&nbsp;&nbsp;<? echo $row["inag_agent_code"];?></td>
    <td width="240" class="table_border">User:&nbsp;&nbsp;<? echo $row["inact_action_user"]?></td>
  </tr>
<? } ?>
  <tr>
    <td colspan="4" class="plain_text"><? echo $row["incd_record_code"]."&nbsp;&nbsp;".$row["incd_long_description"];?></td>
  </tr>
<? 
$previous_policy = $row["clo_target_number"];
$previous_agent = $row["inag_agent_code"];
$previous_user = $row["inact_action_user"];
} 
?>
</table>

<?
	if ($_POST["export_file"] == "show_clear" ){$db->main_exit();}
}//if to show

if ($_POST["export_file"] != "show_clear" ){

$db->show_footer();
}//show the form
?>