<?php
include("../../include/main.php");
$db = new Main();

if ($_POST["action"] == "insert") {
	
	$db->db_tool_insert_row('oqt_quotations',$_POST,'tbl_');
	header("Location: quotations.php?info=New Quotation created");
	exit();

}
else if ($_POST["action"] == "update") {
	
	$db->db_tool_update_row('oqt_quotations',$_POST,"`oqqt_quotations_ID` = ".$_POST["lid"],$_POST["lid"],'tbl_');
	header("Location: quotations.php?info=Quotation updated");
	exit();

}

if ($_GET["lid"] != "") {
	$data = $db->query_fetch("SELECT * FROM `oqt_quotations` WHERE `oqqt_quotations_ID` = ".$_GET["lid"]);
}

$db->show_header();
?>
<form name="form1" method="post" action="">
  <table width="496" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td height="30" colspan="2" align="center"><strong>Quotations</strong></td>
    </tr>
    <tr>
      <td width="151" height="25"><strong>Name</strong></td>
      <td width="345"><input name="tbl_oqqt_name" type="text" id="tbl_oqqt_name" value="<?php  echo $data["oqqt_name"];?>" size="40"></td>
    </tr>
    <tr>
      <td height="25"><strong>Quotation Label GR </strong></td>
      <td><textarea name="tbl_oqqt_quotation_label_gr" cols="40" rows="3" id="tbl_oqqt_quotation_label_gr"><?php  echo $data["oqqt_quotation_label_gr"];?></textarea></td>
    </tr>
    <tr>
      <td height="25"><strong>Quotation Label EN </strong></td>
      <td><textarea name="tbl_oqqt_quotation_label_en" cols="40" rows="3" id="tbl_oqqt_quotation_label_en"><?php  echo $data["oqqt_quotation_label_en"];?></textarea></td>
    </tr>
    <tr>
      <td height="25"><strong>Insurance Type</strong></td>
      <td><select name="tbl_oqqt_type" id="tbl_oqqt_type">
<?php
$sql = "SELECT * FROM `registry_vault` WHERE `regi_section` = 'oqt_insurance_type'";
$result = $db->query($sql);
while ($row=$db->fetch_assoc($result)) {
?>
		<option value="<?php  echo $row["regi_registry_vault_serial"];?>" <?php  if ($row["regi_registry_vault_serial"] == $data["otid_type"]) echo "selected=\"selected\"";?>><?php  echo $row["regi_value1"]." - ".$row["regi_value2"];?></option>
<?php  } ?>
      </select></td>
    </tr>
    
    <tr>
      <td height="25"><strong>Class</strong></td>
      <td><select name="tbl_oqqt_class" id="tbl_oqqt_class">
	  	<option value=""></option>
        <option value="NonMotor" <?php  if ($data["oqqt_class"] == "NonMotor") echo "selected=\"selected\"";?>>Non Motor</option>
      </select>      </td>
    </tr>
    
    <tr>
      <td height="25"><strong>Functions File URL </strong></td>
      <td><input name="tbl_oqqt_functions_file" type="text" id="tbl_oqqt_functions_file" size="40" value="<?php  echo $data["oqqt_functions_file"];?>" /></td>
    </tr>
    <tr>
      <td height="25"><strong>Fees</strong></td>
      <td><input name="tbl_oqqt_fees" type="text" id="tbl_oqqt_fees" value="<?php  echo $data["oqqt_fees"];?>" /></td>
    </tr>
    <tr>
      <td height="25"><strong>Stamps</strong></td>
      <td><input name="tbl_oqqt_stamps" type="text" id="tbl_oqqt_stamps" value="<?php  echo $data["oqqt_stamps"];?>" /></td>
    </tr>
    <tr>
      <td height="25"><strong>Premium Rounding </strong></td>
      <td><select name="tbl_oqqt_premium_rounding" id="tbl_oqqt_premium_rounding">
        <option value="NoRounding" <?php  if ($data["oqqt_premium_rounding"] == 'NoRounding') echo "selected=\"selected\"";?>>No Rounding</option>
        <option value="RoundUpFees" <?php  if ($data["oqqt_premium_rounding"] == 'RoundUpFees') echo "selected=\"selected\"";?>>To Fees Round UP</option>
        <option value="RoundDownFees" <?php  if ($data["oqqt_premium_rounding"] == 'RoundDownFees') echo "selected=\"selected\"";?>>To Fees Round Down</option>
      </select>      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="action" type="hidden" id="action" value="<?php  if ($_GET["lid"] == "") echo "insert"; else echo "update";?>">
      <input name="lid" type="hidden" id="lid" value="<?php  echo $_GET["lid"];?>">      <input type="submit" name="Submit" value="Save Quotation">
      <a href="quotations_types.php">Back</a></td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
$db->show_footer();
?>