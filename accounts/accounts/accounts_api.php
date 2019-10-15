<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 16/7/2019
 * Time: 2:26 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Accounts Account API';

$db->apiGetReadHeaders();


if ($_GET['section'] == 'searchAccounts') {

    $db->working_section = 'Accounts API: searchAccounts';

    $sql = "SELECT 
            acacc_code as document_code
            ,CONCAT(acacc_code,' - ',acacc_name) as label
            ,acacc_account_ID as value
            ,ac_accounts.* 
            FROM ac_accounts WHERE
            acacc_active = 'Active'
            AND acacc_control != 1  
            AND acacc_code LIKE '%" . $_GET["term"] . "%'";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Accounts API:searchAccounts');
}
else if ($_GET['section'] == 'getFirstAccountByID') {

    $sql = "SELECT * FROM ac_accounts WHERE acacc_control != 1 AND acacc_active = 'Active' AND acacc_code LIKE '" . $_GET["value"] . "%' LIMIT 1";
    $data = $db->query_fetch($sql);

    $db->update_log_file_custom($sql, 'Accounts Account API: getAccountByID');

}
else if ($_GET['section'] == 'searchAccountSubTypesByType'){
    $sql = 'SELECT * FROM ac_account_types WHERE actpe_active = "Active" AND actpe_type = "SubType" 
            AND actpe_owner_ID = '.$_GET['value'].'
            ORDER BY actpe_code ASC';
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Accounts API:searchAccountSubTypesByType');
}
else {
    $db->update_log_file_custom('NONE', 'Accounts Account API:none');
}


echo json_encode($data);
exit();