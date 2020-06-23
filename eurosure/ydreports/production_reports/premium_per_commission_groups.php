<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$_GET["layout_action"] = "printer";
$db->show_header();


if ($_POST["action"] == "update") {


}//if action == show
?>

<form name="comm_groups" id="comm_groups" method="POST" action="">
  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
    <tr class="row_table_head">
      <td colspan="2" align="center"><strong>Arrange Grouping of commissions for insurance types</strong></td>
    </tr>
    <tr>
      <td width="133">&nbsp;</td>
      <td width="417">&nbsp;</td>
    </tr>
    <tr>
      <td>Name</td>
      <td><input name="name" type="text" id="name" /></td>
    </tr>
    <tr>
      <td>Insurance Type </td>
      <td><select name="insurance_type_1" id="insurance_type_1">
	  	<option id="">NONE</option>
	  <?
	  $sql = "SELECT * FROM ininsurancetypes WHERE inity_status_flag = 'N'";
	  $res_it = $sybase->query($sql);
	  while ($itype = $sybase->fetch_assoc($res_it)) {
	  ?>
	  	<option id="<? echo $itype["inity_insurance_type_serial"];?>"><? echo $itype["inity_insurance_type"]."-".$itype["inity_long_description"];?></option>
	  <?
	  }
	  ?>
      </select>
      <input type="button" name="Button" value="Insert" /></td>
    </tr>
    <tr>
      <td colspan="2"><hr /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<?
$db->show_footer();
?>
