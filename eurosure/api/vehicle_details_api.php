<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/12/2020
 * Time: 4:49 ΜΜ
 */

include("../../include/main.php");
$db = new Main(1);
$db->working_section = 'Eurosure vehicle details for Rescueline API';
$db->apiGetReadHeaders();






if ($_GET['reg'] != '' && $_GET['usr'] == 'rescuel' && $_GET['psw'] == 'rreess123'){

    $sql = "
        SELECT 
        inpol_policy_number as policy_number,
        inpol_starting_date as starting_date,
        inpol_expiry_date as expiry_date,
        inpol_status as policy_status,
        initm_item_code as vehicle_registration,
        initm_make as vehicle_make,
        initm_cubic_capacity as vehicle_cc,
        incl_first_name,
        incl_long_description
        FROM 
        inpolicies
        JOIN inpolicyitems ON inpit_policy_serial = inpol_policy_serial
        JOIN initems ON initm_item_serial = inpit_item_serial
        JOIN inclients ON incl_client_serial = inpol_client_serial        
        WHERE
        initm_item_code = '".$_GET['reg']."'
        AND inpol_status = 'N'
        ";
    $result = $db->query($sql);
    while($data = $db->fetch_assoc($result)){
        $output[] = $data;
    }

    echo json_encode($output);
    exit();

}
else {
    exit();
}
