<?
include("../../include/main.php");
include("../../include/tables.php"); 
include("occupations.php");
//this hides the header footer but loads the rest of html.
$_GET["layout_action"] = "printer";
$db = new Main(1,'UTF-8');
$db->include_css_file("../main_quotation_css.css");
//if no parameters then kick out.
if ($_GET["quotation"] == "") {
	header("Location: ../quotations.php");
	exit();
}

//get the quotation type and quotation data
$sql = "SELECT * 
FROM oqt_quotations 
JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
WHERE oqq_quotations_ID = ".$_GET["quotation"];
$qdata = $db->query_fetch($sql);

$db->show_header();
?>
<style type="text/css">
<!--
.print_top_headers {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000000;
	text-decoration: none;
}
.top_header_small {	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
	color: #000000;
	text-decoration: none;
}
.medium_size_font {	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #000000;
	text-decoration: none;
}
.large_size_font {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
	text-decoration: none;
}
.HR_page_break {
page-break-after: always;
}
-->
</style>
<?
if ($qdata["oqq_language"] != 'gr') {
?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr>
    <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="right" class="main_medium_title">YDROGIOS INSURANCE COMPANY (CYPRUS) LTD&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" align="left"><img src="<? echo $db->admin_layout_url;?>images/<? echo $qdata["oqq_language"];?>_address.gif"/></td>
        <td width="50%" align="right" valign="top"><img src="<? echo $db->admin_layout_url;?>images/parthenon_logo_small.gif"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="825" valign="top"><p>&nbsp;</p>
      <p>&nbsp;</p>
<?
if ($qdata["oqq_language"] == 'gr') {
?>      
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="date_div_top"></div>
          <p align="right"><? echo date("d/m/Y");?></p>
          <p>Αξιότιμοι  Κύριοι,</p>
          <p>Θέμα:  Προσφορά</p>
          <p>&nbsp;</p>
          <p align="justify">Θα θέλαμε να σας  ευχαριστήσουμε για την εμπιστοσύνη  και  την ευκαιρία που μας δίνεται να υποβάλουμε κι εμείς την δική μας προσφορά.</p>
          <p align="justify">Η προσφορά μας  αφορά ασφαλιστική περίοδο ενός έτους και έχει ισχύ τριάντα (30) ημερών από την  ημερομηνία υποβολής της.</p>
          <p align="justify">Με μοναδικό στόχο τη δημιουργία πραγματικής αξίας για τον πελάτη και τον συνεργάτη, προσφέρουμε ευέλικτα και ολοκληρωμένα προϊόντα, ξεκάθαρους όρους συμβολαίων, δίκαιη τιμολόγηση, γρήγορη και φιλική εξυπηρέτηση, ταχύτητα στις αποζημιώσεις, μαζί με την εγγύηση της άριστης συνεργασίας με μια εταιρεία που συγκαταλέγεται στις υγιέστερες της Κύπρου στην Ασφάλιση Γενικού Κλάδου.  </p>
          <p align="justify">Για τυχόν  διευκρινήσεις ή επεξηγήσεις παρακαλούμε μη διστάσετε να επικοινωνήσετε μαζί  μας.</p>
          <p>&nbsp;</p>
          <p>Με  εκτίμηση<br />
          <? echo $db->prepare_text_as_html($db->user_data["usr_signature_gr"]);?>
          </p></td>
      </tr>
    </table>
 <? } else { ?>     
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="date_div_top"></div>
          <p align="right"><? echo date("d/m/Y");?></p>
          <p>Sirs,</p>
          <p>Subject:  Quotation</p>

          <p align="justify">Thank you for your interest in Ydrogios Insurance Company (Cyprus) Ltd. We are pleased to submit our insurance quotation.</p>
          <p align="justify">Our offer is based for a period of one year and its effective (30) thirty days from the date of submission.</p>
          <p align="justify">For everything you consider important we stand beside you with integrity, reliability and sustained economic development strategy and plan the future, always aiming for customer satisfaction, creating mutual trust and respect.</p>
          <p align="justify">Aiming to create real value for the customer and partner, we offer flexible and integrated products, clear contract terms, fair prices and fast and friendly service along with the guarantee of excellent cooperation with a company that is among the healthiest in Cyprus.</p>
          <p>For any further enquiries you may have please do not hesitate to contact us.</p>
          <p>&nbsp;</p>
          <p>Regards<br />
          <? echo $db->prepare_text_as_html($db->user_data["usr_signature_en"]);?>
          </p></td>
      </tr>
    </table>
<? } ?>
</td>
  </tr>
</table>
<?
}
else {
?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr>
    <td width="750" colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="right" class="main_medium_title">ΥΔΡΟΓΕΙΟΣ ΑΣΦΑΛΙΣΤΙΚΗ ΕΤΑΙΡΕΙΑ (ΚΥΠΡΟΥ) ΛΤΔ&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" align="left"><img src="<? echo $db->admin_layout_url;?>images/<? echo $qdata["oqq_language"];?>_address.gif"/></td>
        <td width="50%" align="right" valign="top"><img src="<? echo $db->admin_layout_url;?>images/parthenon_logo_small.gif"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="825" colspan="2" valign="top"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="date_div_top"></div>
          <p align="right"><? echo date("d/m/Y");?></p>
          <p>Αξιότιμοι  Κύριοι,</p>
          <p>Θέμα:  Προσφορά</p>
          <p>&nbsp;</p>
          <p align="justify">Θα θέλαμε να σας  ευχαριστήσουμε για την εμπιστοσύνη  και  την ευκαιρία που μας δίνετε να υποβάλουμε κι εμείς την δική μας προσφορά.</p>
          <p align="justify">Η προσφορά μας  αφορά ασφαλιστική περίοδο ενός έτους και έχει ισχύ τριάντα (30) ημερών από την  ημερομηνία υποβολής της.</p>
          <p align="justify">Με μοναδικό στόχο τη δημιουργία πραγματικής αξίας για τον πελάτη και τον συνεργάτη, προσφέρουμε ευέλικτα και ολοκληρωμένα προϊόντα, ξεκάθαρους όρους συμβολαίων, δίκαιη τιμολόγηση, γρήγορη και φιλική εξυπηρέτηση, ταχύτητα στις αποζημιώσεις, μαζί με την εγγύηση της άριστης συνεργασίας με μια εταιρεία που συγκαταλέγεται στις υγιέστερες της Κύπρου στην Ασφάλιση Γενικού Κλάδου.</p>
          <p align="justify">Για τυχόν  διευκρινήσεις ή επεξηγήσεις παρακαλούμε μη διστάσετε να επικοινωνήσετε μαζί  μας.</p>
          <p>&nbsp;</p>
          <p>Με  εκτίμηση<br />
          <? echo $db->prepare_text_as_html($db->user_data["usr_signature_gr"]);?></p></td>
      </tr>
    </table>
</td>
  </tr>
</table>
<? } ?>


<HR color="#FFFFFF" width="1" align="center" noshade="noshade" class="HR_page_break">


<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
<?
if ($qdata["oqq_language"] == 'gr') {
?>
  <tr>
    <td height="106"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="right" class="main_medium_title">ΥΔΡΟΓΕΙΟΣ ΑΣΦΑΛΙΣΤΙΚΗ ΕΤΑΙΡΕΙΑ (ΚΥΠΡΟΥ) ΛΤΔ&nbsp;</td>
          </tr>
          <tr>
            <td width="50%" align="left"><img src="<? echo $db->admin_layout_url;?>images/<? echo $qdata["oqq_language"];?>_address.gif"/></td>
            <td width="50%" align="right" valign="top"><img src="<? echo $db->admin_layout_url;?>images/parthenon_logo_small.gif"/></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
<?
}
else {
?>
  <tr>
    <td height="106"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="right" class="main_medium_title">YDROGIOS INSURANCE COMPANY (CYPRUS) LTD&nbsp;</td>
          </tr>
          <tr>
            <td width="50%" align="left"><img src="<? echo $db->admin_layout_url;?>images/<? echo $qdata["oqq_language"];?>_address.gif"/></td>
            <td width="50%" align="right" valign="top"><img src="<? echo $db->admin_layout_url;?>images/parthenon_logo_small.gif"/></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
<? } ?>

  <tr class="qt_row_table_head">
    <td align="center"><? echo $qdata["oqqt_quotation_label_".$qdata["oqq_language"]];?></td>
  </tr>
  <tr>
  	<td height="5"><img src="<? echo $db->admin_layout_url;?>images/spacer.gif" /></td>
  </tr>
  <tr class="qt_row_table_head">
    <td align="center"><strong><? echo show_lang_text("Στοιχεία Προτείνοντος","Basic Information");?></strong></td>
  </tr>
  <tr>
  	<td height="5"><img src="<? echo $db->admin_layout_url;?>images/spacer.gif" /></td>
  </tr>
  <tr>
    <td height="62" valign="top"><table width="750" border="0" cellspacing="0" cellpadding="0" class="large_size_font">
          <tr>
            <td width="320">&nbsp;<? echo show_lang_text("<b>Ονοματεπώνυμο:&nbsp;</b>","<b>Name:&nbsp;</b>").$qdata["oqq_insureds_name"];?></td>
            <td width="230"><? echo show_lang_text("<b>Αρ.Ταυτότητας:&nbsp;</b>","<b>I.D.:&nbsp;</b>").$qdata["oqq_insureds_id"];;?></td>
            <td width="200"><? echo show_lang_text("<b>Τηλ.:&nbsp;</b>","<b>Tel.:&nbsp;</b>").$qdata["oqq_insureds_tel"];;?></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;<? echo show_lang_text("<b>Διεύθυνση:&nbsp;</b>","<b>Address:&nbsp;</b>").$qdata["oqq_insureds_address"]." ".$qdata["oqq_insureds_postal_code"];?></td>
        </tr>
          <tr>
            <td colspan="3">&nbsp;<? echo show_lang_text("<b>Διεύθυνση Περιουσίας:&nbsp;</b>","<b>Risk Location Address:&nbsp;</b>").$qdata["oqq_situation_address"]." ".$qdata["oqq_situation_postal_code"];?></td>
        </tr>
        </table></td>
  </tr>
  <tr class="qt_row_table_head">
    <td height="10" align="center"><? echo show_lang_text("Πληροφορίες Ασφαλιστηρίου","Policy Information");?></td>
  </tr>
  <tr>
  	<td height="5"><img src="<? echo $db->admin_layout_url;?>images/spacer.gif" /></td>
  </tr>
  <tr>
    <td valign="top">
	
<?
$start_text = "&nbsp;&nbsp;&#8226;&nbsp;";
//section 1 ========================================================================================================================================SECTION 1
$sect1 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 4");

//find construction class
/*$occup = explode("\n",$occupations_list);
foreach($occup as $occupation) {
	$occup = explode("#",$occupation);
	
	if ($occup[0] == $sect1["oqqit_insured_amount_1"]) {
		$construction_class = $occup[1];
		$occupation_gr = $occup[2];
		$occupation_en = $occup[3];
	}
}
*/
$occupation_details = $db->query_fetch("SELECT * FROM registry_vault WHERE regi_registry_vault_serial = ".$sect1["oqqit_insured_amount_1"]);

?>	
	
	  <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
          <tr>
            <td width="515"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 1 - ΒΑΣΙΚΕΣ ΚΑΛΥΨΕΙΣ (".$occupation_details["regi_value2"],"PART 1 BASIC COVERS (".$occupation_details["regi_value1"]); echo " ".$occupation_details["regi_value6"]."-".$occupation_details["regi_value7"].")"?></strong></td>
            <td colspan="2" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Κτίριο / Διακόσμηση, Προσαρτήματα και Βελτιώσεις","Building / Improvements");?></td>
            <td colspan="2" align="right">&#8364;<? echo $sect1["oqqit_insured_amount_3"] ;?></td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Γυαλιά & Είδη Υγιεινής","Glass & Sanitary Ware");?></td>
            <td width="124" align="right">&#8364;<? echo $sect1["oqqit_insured_amount_5"] ;?></td>
            <td width="96" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Επίπλωση, Μηχανήματα και Εξοπλισμός","Furniture, Machinery and Equipment");?></td>
            <td align="right">&#8364;<? echo $sect1["oqqit_insured_amount_4"] ;?></td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Αποθέματα Εμπορευμάτων","Stock");?></td>
            <td align="right">&#8364;<? echo $sect1["oqqit_insured_amount_7"] ;?></td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Προσωπικά Αντικείμενα","Personal Possession");?></td>
            <td align="right">&#8364;<? echo $sect1["oqqit_insured_amount_6"] ;?></td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Άλλου είδους Περιεχόμενο","Other Contents");?></td>
            <td align="right">&#8364;<? echo $sect1["oqqit_insured_amount_8"] ;?></td>
            <td align="right">&#8364;<? echo $sect1["oqqit_insured_amount_5"] + $sect1["oqqit_insured_amount_4"] + $sect1["oqqit_insured_amount_7"] + $sect1["oqqit_insured_amount_6"] + $sect1["oqqit_insured_amount_8"];?></td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Αρχιτεκτονικά Έξοδα","Architects Fees");?></td>
            <td colspan="2" align="right">&#8364;<? echo $sect1["oqqit_insured_amount_9"] ;?></td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Απομάκρυνση Ερειπίων","Debris Removal");?></td>
            <td colspan="2" align="right">&#8364;<? echo $sect1["oqqit_insured_amount_10"] ;?></td>
          </tr>
          <tr>
            <td><? echo $start_text.show_lang_text("Εξωτερικές Τέντες, Προσαρτήματα και Πινακίδες","Signs and other outdoor equipment");?></td>
            <td colspan="2" align="right">&#8364;<? echo $sect1["oqqit_insured_amount_11"] ;?></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΑΣΦΑΛΙΣΜΕΝΟΙ ΚΙΝΔΥΝΟΙ","INSURED PERILS");?></strong></td>
                <td width="50%">&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><? echo $start_text.show_lang_text("1. Φωτιά, Κεραυνό, Έκρηξη","1. Fire, Lightning, Explosion");?></td>
                    </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("2. Πτώση Αεροσκαφών","2. Aircraft impact");?></td>
                    </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("3. Απεργίες, εργατικές και πολιτικές αναταραχές","3. Riots, labour or political disturbances");?></td>
                    </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("4. Κακόβουλη Ζημιά","4. Malicious Damage");?></td>
                    </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("5. Καταιγίδα, Θύελλα, Πλημμύρα, σπάσιμο ή Υπερχείλιση ντεποζίτων <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;νερού, συσκευών ή σωλήνων.","5. Storm, flood, tempest, water escape");?></td>
                    </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("6. Πρόσκρουση από οποιοδήποτε όχημα ή ζώο","6. Impact");?></td>
                  </tr>
                </table></td>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><? echo $start_text.show_lang_text("7. Πτώση αντένων και ιστών τηλεόρασης","7. Falling of aerials");?></td>
                  </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("8. Σεισμός και ηφαιστιογενής έκρηξη","8. Earthquake and volcanic eruption");?></td>
                  </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("9. Διαρροή λαδιού η πετρελαίου","9. Oil and water leakage");?></td>
                  </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("10. Καπνός","10. Smoke");?></td>
                  </tr>
                  <tr>
                    <td><? echo $start_text.show_lang_text("11. Κλοπή ή απόπειρα κλοπής","11. Theft or attempted theft.");?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><hr style="color:#000000; height:1px; width:100%" /></td>
        </tr>
      </table>



<?
//P.L section 2 ========================================================================================================================================SECTION 2 / ID5
$sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 5");
?>
          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 2 - ΑΣΤΙΚΗ ΕΥΘΥΝΗ","PART 2 - PUBLIC LIABILITY");?></strong></td>
              <td width="175" align="right"><?
if ($sect2["oqqit_insured_amount_1"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect2["oqqit_insured_amount_1"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Οριο Αποζημίωσης ανά Περιστατικό","Limit of Liability per incident");?></td>
            <td align="right">&#8364;50000</td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Όριο Αποζημίωσης ανά Περίοδο Κάλυψης","Limit of Liability for every period of insurance");?></td>
            <td align="right">&#8364;100000</td>
            </tr>
<? } //hide part 2 P.L ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>
          </table>




<?
//E.L section 3 ========================================================================================================================================SECTION 3 / ID6
$sect3 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 6");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 3 - ΕΥΘΥΝΗ ΕΡΓΟΔΟΤΗ","PART 3 - EMPLOYERS LIABILITY");?></strong></td>
              <td width="175" align="right"><?
if ($sect3["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect3["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Οριο Ευθύνης για κάθε εργοδοτούμενο.","Single Employee Limit (per employee).");?></td>
            <td align="right">&#8364;160000</td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Όριο Ευθύνης για κάθε περιστατικό ή σειρά περιστατικών.","Limit of Indemnity per event or series of events.");?></td>
            <td align="right">&#8364;3415000</td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Συνολικό Όριο Ευθύνης για οποιανδήποτε περίοδο ασφάλισης.","Aggregate Limit of Indemnity for any period of insurance.");?></td>
            <td align="right">&#8364;5125000</td>
            </tr>
<? } //hide part 3 E.L ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

          </table>




<?
//MONEY section 4 ========================================================================================================================================SECTION 4 / ID7
$sect4 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 7");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 4 - ΧΡΗΜΑΤΑ","PART 4 - MONEY");?></strong></td>
              <td width="175" align="right"><?
if ($sect4["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect4["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Ασφαλισμένο Ποσό.","Insured Amount.");?></td>
            <td align="right">&#8364;1500</td>
            </tr>
<? } //hide part 5 Money ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

          </table>




<?
//MONEY section 5 ========================================================================================================================================SECTION 5 / ID8
$sect5 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 8");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 5 - ΔΙΑΚΟΠΗ ΕΡΓΑΣΙΩΝ","PART 5 - BUSINESS INTERUPTION");?></strong></td>
              <td width="175" align="right"><?
if ($sect5["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect5["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Απώλεια Κερδών.","Loss of Profit.");?></td>
            <td align="right">&#8364;<? echo $sect5["oqqit_insured_amount_1"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Ενοίκια.","Rent.");?></td>
            <td align="right">&#8364;<? echo $sect5["oqqit_insured_amount_2"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Μισθοί.","Salaries.");?></td>
            <td align="right">&#8364;<? echo $sect5["oqqit_insured_amount_3"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Έξοδα Λογιστών.","Accountants Expenses.");?></td>
            <td align="right">&#8364;<? echo $sect5["oqqit_insured_amount_4"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Άλλα.","Other.");?></td>
            <td align="right">&#8364;<? echo $sect5["oqqit_insured_amount_5"];?></td>
            </tr>
            <tr>
            <td><strong><? echo $start_text.show_lang_text("Σύνολο.","TOTAL.");?></strong></td>
            <td align="right"><strong>&#8364;<? echo $sect5["oqqit_insured_amount_1"] + $sect5["oqqit_insured_amount_2"] + $sect5["oqqit_insured_amount_3"] + $sect5["oqqit_insured_amount_4"] + $sect5["oqqit_insured_amount_5"];?></strong></td>
            </tr>
<? } //hide part 5 Money ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

          </table>




<?
//Glass Breakage section 6 ========================================================================================================================================SECTION 6 / ID9
$sect6 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 9");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 6 - ΣΠΑΣΙΜΟ ΥΑΛΟΠΙΝΑΚΩΝ","PART 6 - GLASS BREAKAGE");?></strong></td>
              <td width="175" align="right"><?
if ($sect6["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect6["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Ασφαλισμένο Ποσό.","Insured Amount.");?></td>
            <td align="right">&#8364;<? echo $sect6["oqqit_insured_amount_1"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Μέγιστο Όριο ανά Υαλοπίνακα.","Maximum amount per glass.");?></td>
            <td align="right">&#8364;1000</td>
            </tr>
<? } //hide part 6 GLASS BREAKAGE ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

          </table>




<?
//Goods in Transit section 7 ========================================================================================================================================SECTION 7 / ID10
$sect7 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 10");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="575"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 7 - ΜΕΤΑΦΕΡΟΜΕΝΑ ΕΜΠΟΡΕΥΜΑΤΑ","PART 7 - GOODS IN TRANSIT");?></strong></td>
              <td width="175" align="right"><?
if ($sect7["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect7["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Ασφαλισμένο Ποσό.","Insured Amount.");?></td>
            <td align="right">&#8364;<? echo $sect7["oqqit_insured_amount_1"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Φορτίο ανα Όχημα.","Weight per Vehicle.");?></td>
            <td align="right">&#8364;1000</td>
            </tr>
<? } //hide part 7 Goods in Transit ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

          </table>






<?
//Refrigirated Stock section 8 ========================================================================================================================================SECTION 8 / ID11
$sect8 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ".$_GET["quotation"]." AND oqqit_items_ID = 11");
?>

          <table width="735" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
            <tr>
              <td width="563"><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΜΕΡΟΣ 8 - ΦΘΟΡΑ ΚΕΤΕΨΥΓΜΕΝΟΥ ΕΜΠΟΡΕΥΜΑΤΟΣ","PART 8 - REFRIGIRATED STOCK");?></strong></td>
              <td width="172" align="right"><?
if ($sect8["oqqit_insured_amount_15"] == 1) {
	echo '';
}
else {
	echo show_lang_text("Δεν Συμπεριλαμβάνεται","Not Applicable");
}?></td>
            </tr>
<? if ($sect8["oqqit_insured_amount_15"] == 1) { ?>
            <tr>
            <td><? echo $start_text.show_lang_text("Ασφαλισμένο Ποσό.","Insured Amount.");?></td>
            <td align="right">&#8364;<? echo $sect8["oqqit_insured_amount_1"];?></td>
            </tr>
            <tr>
            <td><? echo $start_text.show_lang_text("Όριο ανα ψυκτικό θάλαμο.","Limit per freezer.");?></td>
            <td align="right">&#8364;1500</td>
            </tr>
<? } //hide part 8 Refrigirated Stock ?>
            
            <tr>
              <td colspan="2"><hr style="color:#000000; height:1px; width:100%" /></td>
            </tr>

    </table></td>
  </tr>
  <tr>
  	<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
      <tr>
        <td><strong>&nbsp;&#8226;&#8226;&nbsp;<? echo show_lang_text("ΔΕΣΜΕΥΤΙΚΟΙ ΟΡΟΙ ΚΑΙ ΡΗΤΡΕΣ:","APPLICABLE EXCESSES:");?></strong></td>
      </tr>
      <tr>
<?

$fire_class = $occupation_details["regi_value6"];
$theft_class = $occupation_details["regi_value7"];
//echo $fire_class."-".$theft_class;
$general_excess = $occupations_general_excess[$fire_class];
$malicious_excess = $occupations_malicious_damage_excess[$theft_class];
$storm_excess = $occupations_storm_tempest_excess[$fire_class];
$theft_excess = $occupations_theft_excess[$theft_class];

?>
        <td><? echo $start_text.show_lang_text("Όλοι οι κίνδυνοι που ασφαλίζονται στο παρόν ασφαλιστήριο υπόκεινται σε αφαιρετέο ποσό €".$general_excess.", εκτός των ακολούθων:","All perils insured under this policy are subject to excess amount €".$general_excess." , except of the following:");?></td>
      </tr>
      <tr>
        <td><? echo $start_text.show_lang_text("4. Κακόβουλη Ζημιά €".$malicious_excess,"4. Malicious Damage €".$malicious_excess);?></td>
      </tr>
      
      <tr>
        <td><? echo $start_text.show_lang_text("5. Θύελλα, Καταιγίδα και Πλημμύρα €".$storm_excess,"5. Flood, Storm and Tempest €".$storm_excess);?></td>
      </tr>
      <tr>
        <td><? echo $start_text.show_lang_text("8. Σεισμός, 1.5% στην ασφαλισμένη αξία.","8. Earthquake, 1.5% on total sum insured.");?></td>
      </tr>
      <tr>
        <td><? echo $start_text.show_lang_text("11. Κλοπή ή Απόπειρα Κλοπής €".$theft_excess,"11. Theft or attempted theft, €".$theft_excess);?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
  	<td height="95"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="medium_size_font">
      
      <tr>
        <td colspan="2" class="qt_main_small_text"><hr style="color:#000000; height:1px; width:100%" /></td>
        </tr>
      <tr>
        <td colspan="2"><? if ($qdata["oqq_extra_details"] != "" ) echo show_lang_text("Σημειώσεις: ","Notes: "); echo $qdata["oqq_extra_details"]; if ($qdata["oqq_extra_details"] != "" ) echo "<br><br>"; ?></td>
      </tr>
      <tr>
        <td width="73%" class="qt_main_small_text"><table width="75%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" align="left"><? echo show_lang_text("Υπογραφή Ασφαλιστή","Insurance Intermediary Signature");?></td>
              <td width="50%" align="right"><? echo show_lang_text("Υπογραφή Πελάτη","Clients Signature");?></td>
            </tr>
            <tr>
              <td align="left">&nbsp;</td>
              <td align="right">&nbsp;</td>
            </tr>
          </table></td>
        <td width="27%" align="left" valign="top" class="qt_main_small_text"><strong><? echo show_lang_text("Συνολικό Ασφάλιστρο","Total Premium");?> &#8364;<? echo $qdata["oqq_premium"] + $qdata["oqq_fees"] + $qdata["oqq_stamps"];?></strong><div id="print_date" name="print_date" class="medium_size_font"><? echo show_lang_text("Ημερομηνία Εκτύπωσης ","Print Date ").date("d/m/Y");?></div></td>
      </tr>
      <tr>
        <td height="40" colspan="2" valign="bottom" class="medium_size_font"><? echo show_lang_text("Το παρών δίδεται μόνο για σκοπούς προσφοράς. Η Εταιρεία Επιφυλάσσει τα δικαιώματα της μέχρι την αποδοχή της πρότασης ασφάλισης.","");?> </td>
        </tr>
    </table></td>
  </tr>
</table>
<script>

//document.getElementById("print_date").innerHTML = 'test';

</script>


<?
function show_lang_text($greek,$english) {
global $db,$qdata;

if ($qdata["oqq_language"] == 'gr') {
	return $greek;
}
else {
	return $english;
	
}
}

$db->show_footer();
?>