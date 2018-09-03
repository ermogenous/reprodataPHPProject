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

if ($_GET['section'] == 'products_search_machines') {

    $sql = "SELECT 
              prd_product_ID as value, 
              CONCAT(prd_code, ' ', prd_name) as label,
              prd_current_stock as current_stock,
              prd_description as description
              FROM 
              products 
              JOIN manufacturers ON mnf_manufacturer_ID = prd_manufacturer_ID
              WHERE 
              CONCAT(prd_code, prd_name) LIKE '%".$_GET['term']."%'
              AND prd_type = 'Machine'
	            
	          LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Products API:products_search_machines GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Products API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();