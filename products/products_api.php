<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/8/2018
 * Time: 1:23 ΜΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Customers API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'products_search') {

    $sql = "SELECT 
              cst_customer_ID as value, 
              CONCAT(cst_name, ' ', cst_surname) as label,
              cst_identity_card as identity_card,
              cst_work_tel_1 as work_tel,
              cst_mobile_1 as mobile
               FROM products WHERE 
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