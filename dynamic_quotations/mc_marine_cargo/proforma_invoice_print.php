<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 30/8/2021
 * Time: 11:25 π.μ.
 */
include("../../include/main.php");
include("../quotations_class.php");
require_once '../../vendor/autoload.php';
$db = new Main(1);
if ($_GET["quotation"] == "") {
    header("Location: ../quotations.php");
    exit();
}

$sql = "SELECT * 
FROM oqt_quotations 
JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
WHERE oqq_quotations_ID = " . $_GET["quotation"];
$qdata = $db->query_fetch($sql);

$html = getHTML();
$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'dejavusans'
]);
$mpdf->WriteHTML($html);
$mpdf->Output();

function getHTML()
{
    global $db;
    $html = '<head>
<style>
.normalText{
    font-size: 10px;
    font-family: Tahoma;
}
.table {
border:1px solid #000;
border-collapse:collapse;
}
.td {
border:none;
}
</style>
</head>
<body>
    <table width="100%">
        <tr>
            <td><img src="'.$db->admin_layout_url.'/images/Kemter-Icon.png" width="50"></td>
            <td align="rignt" style="font-size: 15px; color:blue">KEMTER INSURANCE AGENCIES, SUB-AGENCIES AND CONSULTANTS LTD</td>
        </tr>    
    </table>
    <br>
    <br>
    <table width="100%" class="normalText">
        <tr>
            <td width="50%">Messrs</td>
            <td width="50%">Pro-Forma Invoice:</td>
        </tr>
        <tr>
            <td></td>
            <td>Date:</td>
        </tr>
    </table>
    
    <br>
    <br>
    
    <table width="100%" class="table">
        <tr>
            <td width="80%">fgsfg</td>
            <td>dfsgsd</td>
        </tr>
    </table>
    
</body>
    ';
    return $html;
}
