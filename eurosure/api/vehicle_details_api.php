<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/12/2020
 * Time: 4:49 ΜΜ
 */

include("../../include/main.php");
$db = new Main(0);
$db->working_section = 'Eurosure vehicle details for Rescueline API';
$db->apiGetReadHeaders();

$db->update_log_file('odyky_vehicle_details',0,
    'Request for reg:'.$_GET['reg'].' Or identity:'.$_GET['identity']." Or Policy:".$_GET['policy']);

if ($_SERVER['REMOTE_ADDR'] != '213.207.149.26'
    && $_SERVER['REMOTE_ADDR'] != '82.102.46.6' /*Ali House*/
    && $_SERVER['REMOTE_ADDR'] != '5.79.78.235' /*Odyky IP */) {

    header("Location: http://www.eurosure.net");
    exit();
}

//also include id or policy number

if ($_GET['usr'] == 'odyky_usr' && $_GET['psw'] == 'odod-21_aa(36^') {

    if ($_GET['reg'] == '' && $_GET['identity'] == '' && $_GET['policy'] == '') {
        exit();
    }
    else {
        $where = '';
        if ($_GET['reg'] != '') {
            $where = "esrsc_registration LIKE '%" . $_GET['reg'] . "%'";
        } else if ($_GET['identity'] != '') {
            $where = "esrsc_client_id LIKE '%" . $_GET['identity'] . "%'";
        } else if ($_GET['policy'] != '') {
            $where = "esrsc_policy_number LIKE '%" . $_GET['policy'] . "%'";
        }
        if ($where == '') {
            exit();
        }

        $sql = "
        SELECT 
        esrsc_policy_number as policy_number,
        esrsc_client_id as client_id,
        esrsc_client_district as client_city,
        esrsc_registration as registration,
        esrsc_agent_code as agent_code,
        esrsc_make as make,
        esrsc_model as model,
        esrsc_body_type as body_type,
        esrsc_color as clolor,
        esrsc_engine_cc as engine_cc,
        esrsc_weight as weight,
        esrsc_starting_date as starting_date,
        #esrsc_period_starting_date as first_starting_date,
        esrsc_expiry_date as expiry_date,
        #esrsc_price as price,
        esrsc_cover_type as cover_type,
        esrsc_road_assistance as road_assistance,
        esrsc_accident_care as accident_care,
        esrsc_is_cover_note as is_cover_note
        #,esrsc_home_city as home_city
        FROM
             es_rescueline_vehicles
        WHERE
        " . $where . "
        ORDER BY esrsc_policy_number ASC
        ";
        if ($result = mysqli_query($db->db_handle, $sql)) {
            while ($data = $db->fetch_assoc($result)) {
                //$data['home_city'] = mb_convert_encoding($data['home_city'], "ISO-8859-1", "UTF-8");
                $output[] = $data;
            }

            echo json_encode($output);
            exit();
        } else {
            echo $sql . PHP_EOL . PHP_EOL;
            echo mysqli_error($db->db_handle);
            echo "<hr>";
            echo mysqli_errno($db->db_handle);
            $db->update_log_file_custom($sql, 'Rescueline API get vehicle details ERROR');
        }
    }
} else {
    exit();
}
