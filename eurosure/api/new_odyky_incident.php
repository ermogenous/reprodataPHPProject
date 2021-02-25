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

if ($_SERVER['REMOTE_ADDR'] != '213.207.149.26'
    && $_SERVER['REMOTE_ADDR'] != '82.102.46.7' /*Ali House*/
    && $_SERVER['REMOTE_ADDR'] != '5.79.78.235' /*Odyky IP */){

    header("Location: http://www.eurosure.net");
    exit();
}

if ($_GET['incident_id'] != '' && $_GET['usr'] == 'odyky_usr' && $_GET['psw'] == 'odod-21_aa(36^'){

    $newData['fld_odyky_incident_id'] = $_GET['incident_id'];
    $db->db_tool_insert_row('es_odyky_incidents',$newData,'fld_',
    0,'esoin_');
    echo 'true';
}
else {
    exit();
}
