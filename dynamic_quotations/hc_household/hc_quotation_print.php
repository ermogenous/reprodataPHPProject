<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/12/2019
 * Time: 10:52 π.μ.
 */

function getQuotationHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    //underwriter data
    $underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = '.$db->user_data['usr_users_ID']);
}