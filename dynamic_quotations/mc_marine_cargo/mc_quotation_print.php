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
    $item3 = $db->query_fetch('SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ' . $quotationID . ' AND oqqit_items_ID = 3');

    if ($quotationData['oqq_effective_date'] == '') {
        $quotationData['oqq_effective_date'] = date('Y-m-d');
    }

    $date = explode(" ", $quotationData['oqq_effective_date']);
    $date = explode("-", $date[0]);
    $date = ($date[0] * 10000) + ($date[1] * 100) + $date[2];
    $february = (2020 * 10000) + (02 * 100) + (01 * 1);
    $july2021 = (2021 * 10000) + (07 * 100) + (01 * 1);
    $D01112021 = (2021 * 10000) + (11 * 100) + (01 * 1);

    //echo $date." -> July:".$july2021;exit();
    //print_r($item3);exit();

    if ($quotationData['oqq_users_ID'] == 42) {
        //if ($db->user_data['usr_user_rigths'] == 0){ echo "1"; exit(); }
        //echo "1";exit();
        include("quotation_print_2020.php");
    }
    else if ($item3['oqqit_rate_4'] == 'Other' ) { //this is for pharmaceutical/medochemie
        if ($db->user_data['usr_user_rigths'] == 0){
            //echo "2"; exit();
            //echo $date;exit();
        }
        //echo "2";exit();
        if ($date >= $D01112021){ //after/equal 29/10/2021 the cover goes to lloyds
            include("quotation_print_2021.php"); //Lloyds Cover
        }
        else {
            include("quotation_print_2020b.php"); //Cromar Cover
        }
    }
    else if ($date < $february) {
        //if ($db->user_data['usr_user_rigths'] == 0){ echo "3"; exit(); }
        //echo "3";exit();
        include("quotation_print_2019.php");
    } else if ($date < $july2021) {
        //if ($db->user_data['usr_user_rigths'] == 0){ echo "4"; exit(); }
        //echo "4";exit();
        include("quotation_print_2020.php");
    } else {
        //if ($db->user_data['usr_user_rigths'] == 0){ echo "5"; exit(); }
        //echo "5";exit();
        include("quotation_print_2021.php");
    }

    return getMarineQuotation($quotationID);
}


?>
