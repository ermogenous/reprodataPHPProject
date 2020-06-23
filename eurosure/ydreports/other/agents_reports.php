<?php
include("../../../include/main.php");
include("../../lib/odbccon.php");
include("../../../tools/export_data.php");
$db = new Main();
$sybase = new ODBCCON();

if ($_POST["action"] == "show") {
	
	$select = "inag_group_code as Group_Code
	,MAX(inag_long_description)as Agent_Description \n";
	$where = "inag_agent_type = 'A'\n";
	$group_by = "inag_group_code \n";
	
	if ($_POST["group_code_from"] != "" && $_POST["group_code_to"] != "") {
		$where .= "AND inag_group_code BETWEEN '".$_POST["group_code_from"]."' AND '".$_POST["group_code_to"]."' \n";
	}
	
	if ($_POST["hide_inactive"] == 1) {
		$where .= "AND inag_status_flag <> 'I' \n";
	}
	if ($_POST["show_birthdays"] == 1) {
		
		$select .= ",inag_birth_date as _DATE_Agent_Birthdate \n";
		$group_by .= ",inag_birth_date \n";
		if ($_POST["no_birthday_hide"] == 1) {
			$where .= "AND inag_birth_date is not null \n";
		}
	}
	
	
	$sql = "
	SELECT
	".$select."
	FROM
	inagents
	WHERE
	".$where."
	
	GROUP BY
	".$group_by."
	
	ORDER BY 
	inag_group_code ASC";
	
	//echo $db->prepare_text_as_html($sql);

}

$db->show_header();
?>

<form action="" method="post">
<table width="600" border="0" cellspacing="0" cellpadding="0" class="row_table_border" align="center">
  <tr class="row_table_head">
    <td colspan="2" align="center">Agents Reports</td>
    </tr>
  <tr>
    <td width="139">Group Codes</td>
    <td width="461">From
      <input name="group_code_from" type="text" id="group_code_from" size="8" value="<?php echo $_POST["group_code_from"];?>">
      To
      <input name="group_code_to" type="text" id="group_code_to" size="8" value="<?php echo $_POST["group_code_to"];?>">
      Hide inactive agents
      <input name="hide_inactive" type="checkbox" id="hide_inactive" value="1" <?php if ($_POST["hide_inactive"] == 1) echo "checked";?>></td>
  </tr>
  <tr>
    <td>Show Birthdays</td>
    <td><input name="show_birthdays" type="checkbox" id="show_birthdays" value="1" <?php if ($_POST["show_birthdays"] == 1) echo "checked";?>>
      Hide agents with no birthday
      <input name="no_birthday_hide" type="checkbox" id="no_birthday_hide" value="1" <?php if ($_POST["no_birthday_hide"] == 1) echo "checked";?>></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="submit" name="button" id="button" value="Submit"></td>
  </tr>
</table>
<p align="center">*Both from/to agent code must have value to filter.</p>
</form>
<div id="print_view_section_html">
<?php
if ($_POST["action"] == "show") {
	echo "<BR>".export_data_html_table($sql,'sybase',"align=\"center\" class=\"row_table_border\"",0);
}
?>
</div>
<?php
$db->show_footer();
?>