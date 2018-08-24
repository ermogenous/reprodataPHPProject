<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/8/2018
 * Time: 5:35 ΜΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Customers API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'customers') {

    $sql = "SELECT 
              cst_customer_ID as value, 
              CONCAT(cst_name, ' ', cst_surname) as label FROM customers WHERE 
              (
CONCAT(cst_identity_card, ' ', cst_name, ' ', cst_surname) 
                LIKE '%".$_GET['term']."%'
OR
CONCAT(cst_work_tel_1, ' ', cst_work_tel_2, ' ', cst_fax, ' ', cst_mobile_1, ' ', cst_mobile_2 )
	LIKE '%".$_GET['term']."%') 
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