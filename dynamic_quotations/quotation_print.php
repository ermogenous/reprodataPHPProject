<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/3/2019
 * Time: 3:38 ΜΜ
 */

include("../include/main.php");
include("quotations_class.php");
require_once '../vendor/autoload.php';
$db = new Main(1);
//if no parameters then kick out.
if ($_GET["quotation"] == "") {
    header("Location: quotations.php");
    exit();
}

//get the quotation type and quotation data
$sql = "SELECT * 
FROM oqt_quotations 
JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
WHERE oqq_quotations_ID = " . $_GET["quotation"];
$qdata = $db->query_fetch($sql);

$quotationUnderwriter = $db->query_fetch(
    'SELECT * FROM 
                  oqt_quotations_underwriters 
                  WHERE oqun_user_ID = ' . $qdata['oqq_users_ID']
);

$underwriter = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID']);
$quote = new dynamicQuotation($_GET['quotation']);

//check if the user has access to see this quotation
if ($db->user_data["usr_users_ID"] != $quote->quotationData()["oqq_users_ID"] && $db->user_data["usr_user_rights"] >= 3) {
    //check if this underwriter has access to see quotations of other groups
    if ($underwriter['oqun_view_group_ID'] > 0 && $underwriter['oqun_view_group_ID'] == $quote->quotationData()['usr_users_groups_ID']){
        //do nothing
    }
    else {
        header("Location: quotations.php");
        exit();
    }
}









//get the quotation print file
//print_r($qdata);
if (is_file($quote->quotationData()['oqqt_print_layout'])) {
    include($quote->quotationData()['oqqt_print_layout']);

    //check in parameters if allowed to print on outstanding
    if ($quote->quotationData()['oqq_status'] != 'Active' && $qdata['oqqt_allow_print_outstanding'] != 1) {
        $db->generateAlertError($quote->getQuotationType().' is not active. Cannot view report.');
        $db->show_header();
        $db->show_footer();

    } else {

        $html = getQuotationHTML($_GET['quotation']);
        if ($_GET['pdf'] == 1) {
            $mpdf = new \Mpdf\Mpdf([
                'default_font' => 'dejavusans'
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            $db->show_empty_header();
            echo $html;
            $db->show_empty_footer();
        }
    }


} else {
    $db->generateAlertError('Print file is missing');
    $db->show_header();
    $db->show_footer();
}

function show_lang_text($greek, $english)
{
    global $db, $quote;

    if ($quote->quotationData()["oqq_language"] == 'gr') {
        return $greek;
    } else {
        return $english;

    }
}

//$db->show_empty_header();
//$db->show_empty_footer();

?>