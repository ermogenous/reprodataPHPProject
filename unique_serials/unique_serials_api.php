<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/10/2018
 * Time: 10:52 ΠΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Unique Serials API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'check_if_exists') {

    if ($_GET['excludeSerial'] == ''){
        $_GET['excludeSerial'] = 0;
    }

    $sql = "SELECT
            uqs_unique_serial as value,
            uqs_product_ID as product_ID,
            uqs_agreement_ID as agreement_ID,
            uqs_status as status
            FROM
            unique_serials
            WHERE
            uqs_status = 'Active'
            AND uqs_unique_serial = '".$_GET['term']."'
            AND uqs_unique_serial_ID != ".$_GET['excludeSerial'];

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Unique Serials API:check_if_exists GET:'.print_r($_GET,true)."\nData:".print_r($data, true));
}
else {
    $db->update_log_file_custom('NONE', 'Unique Serials API:none GET:'.print_r($_GET,true));
}

echo json_encode($data);
exit();