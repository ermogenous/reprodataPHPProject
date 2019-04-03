<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/3/2019
 * Time: 3:38 ΜΜ
 */

include("../include/main.php");
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
WHERE oqq_quotations_ID = ".$_GET["quotation"];
$qdata = $db->query_fetch($sql);

//get the quotation print file
//print_r($qdata);
if (is_file($qdata['oqqt_print_layout'])){
    include($qdata['oqqt_print_layout']);

    $html = getQuotationHTML($_GET['quotation']);
    if ($_GET['pdf'] == 1){
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'dejavusans'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    else {
        $db->show_empty_header();
        echo $html;
        $db->show_empty_footer();
    }


}
else {
    $db->generateAlertError('Print file is missing');
    $db->show_header();
    $db->show_footer();
}

function show_lang_text($greek, $english)
{
    global $db, $qdata;

    if ($qdata["oqq_language"] == 'gr') {
        return $greek;
    } else {
        return $english;

    }
}

$db->show_empty_header();
$db->show_empty_footer();

?>