<?php
include("../../include/main.php");
$db = new Main(1);

$db->apiGetReadHeaders();

if ($_GET['section'] == 'accounts') {

    $sql = "SELECT * FROM ac_accounts WHERE acacc_active = 1 AND acacc_type = '" . $_GET["value"] . "'";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Transaction API:accounts');
}

else if ($_GET['section'] == 'products') {

    $sql = 'SELECT * FROM 
            st_products
            JOIN st_product_suppliers ON stprs_product_ID = stprd_product_ID 
            WHERE stprd_active = 1 AND stprs_supplier_ID = '.$_GET['value'];
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Transaction API:products');

}
else {
    $db->update_log_file_custom('NONE', 'Transaction API:none');
}


echo json_encode($data);
exit();