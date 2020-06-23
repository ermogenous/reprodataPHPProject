<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();


$db->show_header();

?>
<form name="form1" method="post" action="">
  <table width="250" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="82">Branch</td>
      <td width="162"><select name="branch">
        <option value="3" <? if ($_POST["branch"] == "3") echo "selected=\"selected\"";?>>Direct Larnaca</option>
        <option value="4" <? if ($_POST["branch"] == "4") echo "selected=\"selected\"";?>>Direct Nicosia</option>
        <option value="128" <? if ($_POST["branch"] == "128") echo "selected=\"selected\"";?>>Direct Pafos</option>
      </select>
      </td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Show"></td>
    </tr>
  </table>
</form><br>
<br>

<?

if ($_POST["action"] == "show") {

$sql = "SELECT * FROM inclients WHERE incl_agent_serial = ".$_POST["branch"]." ORDER BY incl_agent_serial ASC";
$result = $sybase->query($sql);
?>
<table width="500" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font color="#FF0000"><strong>Name</strong></font></td>
    <td><strong><font color="#FF0000">Postal Code</font></strong></td>
    <td><strong><font color="#FF0000">Address</font></strong></td>
    <td><strong><font color="#FF0000">Address2</font></strong></td>
    <td><strong><font color="#FF0000">City</font></strong></td>
    <td><strong><font color="#FF0000">District</font></strong></td>
    <td><strong><font color="#FF0000">Country</font></strong></td>
  </tr>
<?
while ($row = $sybase->fetch_assoc($result)) {
?>
  <tr>
    <td><? echo $row["incl_salutation"]." ".$row["incl_first_name"]." ".$row["incl_long_description"];?></td>
    <td><? echo $row["incl_postal_code"];?></td>
    <td><? echo $row["incl_address_line1"]." ".$row["incl_street_no"];?></td>
    <td><? echo $row["incl_address_line2"];?></td>
    <td><? echo $row["incl_city"];?></td>
    <td><? echo $row["incl_district"];?></td>
    <td><? echo $row["incl_country"];?></td>
  </tr>
<? } ?>
</table>

<?
}//if show


$db->show_footer();
?>
