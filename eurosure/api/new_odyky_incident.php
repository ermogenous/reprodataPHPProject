<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 4:36 μ.μ.
 */

include("../../include/main.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicle details for Rescueline API';
$db->apiGetReadHeaders();

if ($_SERVER['REMOTE_ADDR'] != '81.4.169.250'
    && $_SERVER['REMOTE_ADDR'] != '82.102.46.7' /*Ali House*/
    && $_SERVER['REMOTE_ADDR'] != '5.79.78.235' /*Odyky IP */){
    $db->update_log_file_custom('Access denied for IP:'.$_SERVER['REMOTE_ADDR'],'Insert odyky incident. GET DATA:'.print_r($_GET,true));
    header("Location: http://www.eurosure.net");
    exit();
}

if ($_GET['incident_id'] != '' && $_GET['usr'] == 'odyky_usr' && $_GET['psw'] == 'odod-21_aa(36^'){

    //first check if the incident already exists
    $sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_odyky_incident_id = "'.$_GET['incident_id'].'"';
    $checkResult = $db->query_fetch($sql);
    if ($checkResult['esoin_incident_id'] > 0){
        $info = 'Duplicate:'.$_GET['incident_id']." -> ".print_r($_GET,true);
        echo '[{"result":"duplicate"}]';
        $db->update_log_file_custom($info,'Insert odyky incident');
        exit();
    }

    $newData['fld_odyky_incident_id'] = $_GET['incident_id'];
    $newData['fld_call_type'] = $_GET['call_type'];
    $newData['fld_odyky_status'] = $_GET['odyky_status'];


    $db->db_tool_insert_row('es_odyky_incidents',$newData,'fld_',
    0,'esoin_');
    echo '[{"result":true}]';
    $info = 'Inserted:'.$_GET['incident_id']." -> ".print_r($_GET,true);
    $db->update_log_file_custom($info,'Insert odyky incident');
}
else {
    exit();
}
