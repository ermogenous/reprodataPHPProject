<?
//include the customs insured_amounts_function
include("1712_insured_amounts_function.php");


//shows the tables for each section (item)
//the name of the field is OQIT_ITEMS_ID"_"FIELD_NAME
function OQ1712_section_1_fire_theft() {
global $db,$items_data,$qitem_data;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="qt_main_small_text">
  <tr>
    <td width="200" height="25"><? show_quotation_text("Επάγγελμα","Occupation");?></td>
    <td><select name="4_oqqit_insured_amount_1" id="4_oqqit_insured_amount_1" style="width:350px"><? 
//include("occupations.php");
//$occup = explode("\n",$occupations_list);
//foreach($occup as $occupation) {
//	$occup = explode("#",$occupation);

if ($_SESSION["oq_quotations_language"] == 'en') {
	$sort = 'regi_value1 ASC';	
}
else {
	$sort = 'regi_value2 ASC';
}
$sql = "SELECT * FROM registry_vault 
WHERE regi_section = 'occupations' 
AND regi_active = 1 
AND regi_value4 = 'C' 
ORDER BY ".$sort;
$result = $db->query($sql);
while ($occ = $db->fetch_assoc($result)) {
?>
	<option value="<? echo $occ["regi_registry_vault_serial"];?>" <? if ($qitem_data["oqqit_insured_amount_1"] == $occ["regi_registry_vault_serial"]) echo "selected=\"selected\"";?>><? show_quotation_text($occ["regi_value2"],$occ["regi_value1"]); 
	echo "&nbsp;&nbsp;[".$occ["regi_value6"]."-".$occ["regi_value7"]."]"?></option>
<?
}//for each occupation
?></select></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Κατηγορία Κατασκευής","Construction Category");?></td>
    <td><select name="4_oqqit_insured_amount_2" id="4_oqqit_insured_amount_2" style="width:350px">
      <option value="1" <? if ($qitem_data["oqqit_insured_amount_2"] == 1) echo "selected=\"selected\"";?>><? show_quotation_text("Σκελετός: Μπετόν/Τούβλα, Οροφή: Μπετόν, Μπετόν με κεραμίδι","Building: Concrete, Bricks , Roof: Concrete, Concrete with tiles");?></option>
      <option value="2" <? if ($qitem_data["oqqit_insured_amount_2"] == 2) echo "selected=\"selected\"";?>><? show_quotation_text("Σκελετός: Μπετόν/Τούβλα, Οροφή: Ξύλινη με κεραμίδι η άλλο υλικό","Building: Concrete, Bricks , Roof: Tiles");?></option>
      <option value="3" <? if ($qitem_data["oqqit_insured_amount_2"] == 3) echo "selected=\"selected\"";?>><? show_quotation_text("Σκελετός: Προκατασκευασμένη Κατασκευή ή Μεταλλική Κατασκευή, Οροφή: Ξύλινη με κεραμίδι η άλλο υλικό","Building: Prefabricated or Metal Construction , Roof: Tiles");?></option>
      <option value="4" <? if ($qitem_data["oqqit_insured_amount_2"] == 4) echo "selected=\"selected\"";?>><? show_quotation_text("Σκελετός: Πλιθάρη ή Πέτρα, Οροφή: Ξύλινη ή Ξύλινη με Κεραμίδι","Building: Mud Bricks or Stone , Roof: Timber or Tiles");?></option>
    </select>
    </td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Κτίρια / Διακόσμηση και Βελτιώσεις","Building / Decorations & Improvements");?></td>
    <td><input name="4_oqqit_insured_amount_3" type="text" id="4_oqqit_insured_amount_3" value="<? echo $qitem_data["oqqit_insured_amount_3"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Έπιπλα, Μηχανήματα και Εξοπλισμός","Furniture & Machinery");?></td>
    <td><input name="4_oqqit_insured_amount_4" type="text" id="4_oqqit_insured_amount_4" value="<? echo $qitem_data["oqqit_insured_amount_4"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Γυαλιά και Είδη Υγιεινής","Glass & Sanitary Ware");?></td>
    <td><input name="4_oqqit_insured_amount_5" type="text" id="4_oqqit_insured_amount_5" value="<? echo $qitem_data["oqqit_insured_amount_5"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Προσωπικά Αντικείμενα","Personal Possessions");?></td>
    <td><input name="4_oqqit_insured_amount_6" type="text" id="4_oqqit_insured_amount_6" value="<? echo $qitem_data["oqqit_insured_amount_6"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Αποθέματα Εμπορευμάτων και/ή Πρώτων Υλών","Stock");?></td>
    <td><input name="4_oqqit_insured_amount_7" type="text" id="4_oqqit_insured_amount_7" value="<? echo $qitem_data["oqqit_insured_amount_7"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Άλλα","Other Contents");?></td>
    <td><input name="4_oqqit_insured_amount_8" type="text" id="4_oqqit_insured_amount_8" value="<? echo $qitem_data["oqqit_insured_amount_8"];?>" /></td>
  </tr>
  <tr>
    <td height="25"><? show_quotation_text("Αμοιβές Αρχιτεκτόνων & Επημετρητών","Architect Fees");?></td>
    <td><input name="4_oqqit_insured_amount_9" type="text" id="4_oqqit_insured_amount_9" value="<? echo $qitem_data["oqqit_insured_amount_9"];?>" /></td>
  </tr>
  <tr>
    <td><? show_quotation_text("Απομάκρυση Ερειπίων","Debris Removal");?></td>
    <td><input name="4_oqqit_insured_amount_10" type="text" id="4_oqqit_insured_amount_10" value="<? echo $qitem_data["oqqit_insured_amount_10"];?>" /></td>
  </tr>
  <tr>
    <td><? show_quotation_text("Εξωτερικές Τέντες, Προσαρτήματα & Πινακίδες","Signs and other outdoor equipment");?></td>
    <td><input name="4_oqqit_insured_amount_11" type="text" id="4_oqqit_insured_amount_11" value="<? echo $qitem_data["oqqit_insured_amount_11"];?>" /></td>
  </tr>
</table>


<?
}//section 1 building

function OQ1712_section_2_public_liability() {
global $db,$items_data,$qitem_data;
?>
<input name="5_oqqit_insured_amount_15" id="5_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Καλυψη Αστικής Ευθύνης","Public Liability Cover");?></td>
    <td><input name="5_oqqit_insured_amount_1" id="5_oqqit_insured_amount_1" type="checkbox" value="1" <? if ($qitem_data["oqqit_insured_amount_1"] == '1') echo "checked=\"checked\"";?> /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?
}//section 2 public Liability

//section 3 E.L
function OQ1712_section_3_employers_liability() {
global $db,$items_data,$qitem_data;
?>
<input name="6_oqqit_insured_amount_15" id="6_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Καλυψη Ευθύνης Εργοδότη","Employers Liability Cover");?></td>
    <td><input name="6_oqqit_insured_amount_1" id="6_oqqit_insured_amount_1" type="checkbox" value="1" <? if ($qitem_data["oqqit_insured_amount_1"] == '1') echo "checked=\"checked\"";?> /> 
    <? show_quotation_text("(Μέχρι ετήσιες απολαβές &#8364;35.000)","Up to yearly emoluments &#8364;35.000");?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}//section 3 EL

function OQ1712_section_4_money() {
global $db,$items_data,$qitem_data;
?>
<input name="7_oqqit_insured_amount_15" id="7_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Καλυψη Χρήματα","Money Cover");?></td>
    <td><input name="7_oqqit_insured_amount_1" id="7_oqqit_insured_amount_1" type="checkbox" value="1" <? if ($qitem_data["oqqit_insured_amount_1"] == '1') echo "checked=\"checked\"";?> /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}//section 4 money

function OQ1712_section_5_interruption_of_business() {
global $db,$items_data,$qitem_data;
?>
<script language="JavaScript" type="text/javascript">

function section_8_show_total_amount() {
total = 0;
	total = document.getElementById('8_oqqit_insured_amount_1').value * 1;
	total += document.getElementById('8_oqqit_insured_amount_2').value * 1;
	total += document.getElementById('8_oqqit_insured_amount_3').value * 1;
	total += document.getElementById('8_oqqit_insured_amount_4').value * 1;
	total += document.getElementById('8_oqqit_insured_amount_5').value * 1;
	document.getElementById('label_section_8_total_amount').innerHTML = total;

}

</script>
<input name="8_oqqit_insured_amount_15" id="8_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" height="25"><? show_quotation_text("Απώλεια Κερδών","Loss of Profit");?></td>
    <td><input name="8_oqqit_insured_amount_1" id="8_oqqit_insured_amount_1" type="text" value="<? echo $qitem_data["oqqit_insured_amount_1"];?>" onkeyup="section_8_show_total_amount();" /></td>
  </tr>
  <tr>
    <td width="200" height="25"><? show_quotation_text("Ενοίκια","Rent");?></td>
    <td><input name="8_oqqit_insured_amount_2" id="8_oqqit_insured_amount_2" type="text" value="<? echo $qitem_data["oqqit_insured_amount_2"];?>" onkeyup="section_8_show_total_amount();" /></td>
  </tr>
  <tr>
    <td width="200" height="25"><? show_quotation_text("Μισθοί","Salaries");?></td>
    <td><input name="8_oqqit_insured_amount_3" id="8_oqqit_insured_amount_3" type="text" value="<? echo $qitem_data["oqqit_insured_amount_3"];?>" onkeyup="section_8_show_total_amount();" /></td>
  </tr>
  <tr>
    <td width="200" height="25"><? show_quotation_text("Έξοδα Λογιστών","Accountants Expenses");?></td>
    <td><input name="8_oqqit_insured_amount_4" id="8_oqqit_insured_amount_4" type="text" value="<? echo $qitem_data["oqqit_insured_amount_4"];?>" onkeyup="section_8_show_total_amount();" /></td>
  </tr>
  <tr>
    <td width="200" height="25"><? show_quotation_text("Άλλα","Other");?></td>
    <td><input name="8_oqqit_insured_amount_5" id="8_oqqit_insured_amount_5" type="text" value="<? echo $qitem_data["oqqit_insured_amount_5"];?>" onkeyup="section_8_show_total_amount();" /> 
    Total Cover <strong>&#8364;<label id="label_section_8_total_amount"></label></strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2"><? show_quotation_text("Τα πιο πάνω ποσά αναφέρονται σε ετήσια βάση.","The above figures refer to yearly base.");?></td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript">
section_8_show_total_amount();
</script>
<?
}//section 8 business interuption

function OQ1712_section_6_accidental_breakage_glass() {
global $db,$items_data,$qitem_data;
?>
<input name="9_oqqit_insured_amount_15" id="9_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Ασφαλισμένο Ποσό","Insured Amount");?></td>
    <td><input name="9_oqqit_insured_amount_1" id="9_oqqit_insured_amount_1" type="text" value="<? echo $qitem_data["oqqit_insured_amount_1"];?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?
}//section 6accidental damage of glass

function OQ1712_section_7_goods_in_transit() {
global $db,$items_data,$qitem_data;
?>
<input name="10_oqqit_insured_amount_15" id="10_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Ετήσιος Κύκλος Μεταφορών","Yearly Turnover");?></td>
    <td><input name="10_oqqit_insured_amount_1" id="10_oqqit_insured_amount_1" type="text" value="<? echo $qitem_data["oqqit_insured_amount_1"];?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?
}//section 7 Goods In Transit

function OQ1712_section_8_refrigirated_stock() {
global $db,$items_data,$qitem_data;
?>
<input name="11_oqqit_insured_amount_15" id="11_oqqit_insured_amount_15" type="hidden" value="<? echo $qitem_data["oqqit_insured_amount_15"];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><? show_quotation_text("Ασφαλισμένο Ποσό","Insured Amount");?></td>
    <td><input name="11_oqqit_insured_amount_1" id="11_oqqit_insured_amount_1" type="text" value="<? echo $qitem_data["oqqit_insured_amount_1"];?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?
}//section 8 Refrigirated Stock

?>