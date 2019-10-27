<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/10/2019
 * Time: 3:42 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Accounts Account API';

$db->apiGetReadHeaders();

if ($_GET['section'] == 'searchEntityByAnything'){
    $sql = "
    SELECT
    *
    FROM
    ac_entities
    WHERE
    acet_name LIKE '%".$_GET['value']."%'
    OR acet_description LIKE '%".$_GET['value']."%'
    OR acet_mobile LIKE '%".$_GET['value']."%'
    OR acet_work_tel LIKE '%".$_GET['value']."%'
    OR acet_fax LIKE '%".$_GET['value']."%'
    OR acet_email LIKE '%".$_GET['value']."%'
    OR acet_website LIKE '%".$_GET['value']."%'
    ";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Accounts Entity API:searchEntityByAnything');
}
else {
    $db->update_log_file_custom('NONE', 'Accounts Entity API:none');
}


echo json_encode($data);
exit();