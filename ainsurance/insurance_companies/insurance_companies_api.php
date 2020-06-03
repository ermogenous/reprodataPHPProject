<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/2/2019
 * Time: 7:52 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Customer Groups API';
$db->apiGetReadHeaders();

if ($_GET['section'] == '') {

    $sql = "";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Insurance Companies From commission Types API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();