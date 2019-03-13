<?php
include("../include/main.php");
include("../include/tables.php"); 
$db = new Main();



$db->show_header();


if ($_GET["price_id"] != "") {
	$data = $db->query_fetch("SELECT 
	oqq_insureds_name
	,oqq_quotations_ID
	,oqq_quotations_type_ID
	,(oqq_fees + oqq_stamps + oqq_premium)as clo_total_price 
	,oqqt_print_layout
	FROM 
	oqt_quotations 
	JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
	WHERE 
	oqq_quotations_ID = ".$_GET["price_id"]);

}

?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr class="row_table_head">
    <td colspan="3" align="center"><strong>Your quotation has been saved succesfully </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="93" height="27"><strong>Name</strong></td>
    <td width="397"><?php  echo $data["oqq_insureds_name"];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="27"><strong>Total Price </strong></td>
    <td>€<?php  echo $data["clo_total_price"];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Print View </strong></td>
    <td><a target="_blank" href="<?php  echo $data["oqqt_print_layout"];?>?quotation=<?php  echo $data["oqq_quotations_ID"];?>"><img src="images/printer_icon_medium.jpg" width="64" height="64" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="3"><hr /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="33%" align="center"><a href="quotations_modify.php?quotation_type=<?php  echo $data["oqq_quotations_type_ID"];?>&quotation=<?php  echo $data["oqq_quotations_ID"];?>"><img src="images/edit_icon_medium.jpg" width="64" height="64" border="0" /><br />
        Edit Quotation </a></td>
        <td width="34%" align="center"><a href="index.php"><img src="images/home-icon_medium.jpg" width="64" height="64" border="0" /><br />
        Quotations Home </a></td>
        <td width="33%" align="center"><a href="quotations.php"><img src="images/search_icon.jpg" width="64" height="64" border="0" /><br />
          All Quotations </a></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
$db->show_footer();
?>