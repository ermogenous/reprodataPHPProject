<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 5:23 PM
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Customer Groups API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'customers_groups_search') {

    $sql = "SELECT 
              csg_customer_group_ID as value, 
              CONCAT(csg_code, ' ', csg_description) as label,
              csg_active as clo_active
              FROM customer_groups WHERE 
                CONCAT(csg_code, ' ', csg_description) LIKE '%".$_GET['term']."%'
	          LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Customer Groups API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Customer Groups API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();