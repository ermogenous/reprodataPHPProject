<?php
include("../include/main.php");
$db = new Main();


$db->show_header();

?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="links_style">
  <tr>
    <td width="250" align="center"><img src="images/new_icon.jpg" width="128" height="128"></td>
    <td width="250" align="center"><a href="quotations.php"><img src="images/search_icon.jpg" width="128" height="128" border="0"></a></td>
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
    <td>- <a href="quotations_modify.php?quotation_type=2">Maxisafe Business 1712 </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>- <a href="../online_timologisi/jsquotation/motor_private.php">Motor Quotation </a></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
$db->show_footer();
?>
