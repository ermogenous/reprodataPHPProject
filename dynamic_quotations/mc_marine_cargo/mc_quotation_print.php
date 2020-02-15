<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/3/2019
 * Time: 10:12 ΠΜ
 */

function getQuotationHTML($quotationID)
{

    global $db;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    if ($quotationData['oqq_effective_date'] == ''){
        $quotationData['oqq_effective_date'] = date('Y-m-d');
    }

    $date = explode(" ",$quotationData['oqq_effective_date']);
    $date = explode("-",$date[0]);
    $date = ($date[0] * 10000) + ($date[1] * 100) + $date[2];
    $february = (2020 * 10000) + (02 * 100) + (01 * 1);

    if ($quotationData['oqq_users_ID'] == 41){
        include("quotation_print_2020.php");
    }
    else if ($date < $february){
        include("quotation_print_2019.php");
    }
    else {
        include("quotation_print_2020.php");
    }

    return getMarineQuotation($quotationID);
}



?>