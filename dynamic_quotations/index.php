<?php
include("../include/main.php");
$db = new Main();

//$db->admin_more_head .= "<meta http-equiv=\"refresh\" content=\"10;url=http://www.google.com\">";

$db->show_header();

?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="links_style">
  <tr>
    <td width="272" align="center"><img src="images/new_icon.jpg" width="128" height="128"></td>
    <td width="228" align="center"><a href="quotations.php"><img src="images/search_icon.jpg" width="128" height="128" border="0"></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>Create New Quotation </strong></td>
    <td align="center"><strong>View All  Quotations </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> - <a href="quotations_modify.php?quotation_type=1">Maxisafe Home 1702</a> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="quotations_modify.php?quotation_type=3">Maxisafe Home ELITE 1703 New Rates </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="quotations_modify.php?quotation_type=2">Maxisafe Business 1712 </a></td>
    <td><?php  if ($db->user_data["usr_user_rights"] <= 1) { ?><a href="quotations/index.php">Administration</a><?php  } ?>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="quotations_modify.php?quotation_type=4">Multicover Business 1713 </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="../online_timologisi/jsquotation_v2014_01_01/motor_private.php">- Motor Quotation After 01/2014 </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="../online_timologisi/jsquotation_v2017_06_15/motor_private.php">- Motor Quotation After 15/06/2017 </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>-  <a href="quotations_modify.php?quotation_type=5">Iasis Medical Expenses 1101 </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="medical_group/medical_group.php">Iasis Medical Group Quotation</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="quotations_modify.php?quotation_type=6">4Star Maxi Cover 4U 1002</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="quotations_modify.php?quotation_type=7">Υδροπρόληψις - Πρ.Ατυχήματα 1001</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
$db->show_footer();
?>