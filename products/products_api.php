<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/8/2018
 * Time: 1:23 ΜΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Products API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'products_search_machines') {

    $sql = "SELECT 
              prd_product_ID as value, 
              CONCAT(prd_model, ' ', prd_name) as label,
              prd_current_stock as current_stock,
              prd_description as description
              FROM 
              products 
              JOIN manufacturers ON mnf_manufacturer_ID = prd_manufacturer_ID
              WHERE 
              CONCAT(prd_model, prd_name) LIKE '%".$_GET['term']."%'
              AND prd_type = 'Machine'
	            
	          LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Products API:products_search_machines GET:'.print_r($_GET,true));
}
//search in consumables/spare parts or other for product from event
else if ($_GET['section'] == 'productsSearchForEvent'){
    $forEvent = $_GET['eventID'];
    $forType = $_GET['type'];

    //find the product
    $sql = "SELECT
            prd_product_ID
            FROM
            ticket_events
            JOIN unique_serials ON uqs_unique_serial_ID = tke_unique_serial_ID
            JOIN products ON uqs_product_ID = prd_product_ID
            WHERE
            tke_ticket_event_ID = ".$forEvent;
    $productID = $db->query_fetch($sql);
    $productID = $productID['prd_product_ID'];

    //find the related products
    $sql = "SELECT
            prd_product_ID as value,
            prd_name as label,
            prd_model as model,
            prd_description as description
            FROM 
            product_relations
            JOIN products ON prdr_product_child_ID = prd_product_ID
            WHERE
            prdr_product_parent_ID = '".$productID."'
            AND prdr_child_type = '".$forType."'";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Products API:productsSearchForEvent GET:'.print_r($_GET,true));

}
else {
    $db->update_log_file_custom('NONE', 'Products API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();