<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 2/10/2018
 * Time: 8:17 ΠΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Agreements API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'agreements') {

    $sql = "SELECT
            CONCAT(agr_agreement_number, ' ',cst_identity_card, ' ',cst_name, ' ', cst_surname, ' ', cst_work_tel_1)as label,
            agr_agreement_ID as value
            FROM
            agreements
            JOIN customers ON cst_customer_ID = agr_customer_ID
            WHERE
            cst_identity_card LIKE '%".$_GET['term']."%'
            OR 
            cst_name LIKE '%".$_GET['term']."%'
            OR
            cst_surname LIKE '%".$_GET['term']."%'
            OR
            cst_work_tel_1 LIKE '%".$_GET['term']."%'
            OR
            cst_work_tel_2  LIKE '%".$_GET['term']."%'
            OR 
            cst_fax  LIKE '%".$_GET['term']."%'
            OR
            cst_mobile_1 LIKE '%".$_GET['term']."%'
            OR
            cst_mobile_2 LIKE '%".$_GET['term']."%'
            OR
            agr_agreement_number  LIKE '%".$_GET['term']."%'
            ORDER BY agr_agreement_number ASC 
                LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Transaction API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Transaction API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();