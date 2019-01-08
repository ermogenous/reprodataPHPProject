<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 07-Jan-19
 * Time: 12:02 PM
 */


include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Schedules API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'schedulesSearch') {

    $sql = "SELECT
            CONCAT(sch_schedule_number, ' ', usr_name)as label,
            sch_schedule_ID as value
            FROM
            schedules
            LEFT OUTER JOIN users ON sch_user_ID = usr_users_ID
            WHERE
            usr_name LIKE '%".$_GET['term']."%'
            OR 
            usr_username LIKE '%".$_GET['term']."%'
            OR
            usr_description LIKE '%".$_GET['term']."%'
            OR
            usr_signature_gr LIKE '%".$_GET['term']."%'
            OR
            usr_signature_en  LIKE '%".$_GET['term']."%'
            OR 
            usr_name_gr  LIKE '%".$_GET['term']."%'
            OR
            usr_name_en LIKE '%".$_GET['term']."%'
            OR
            sch_schedule_number  LIKE '%".$_GET['term']."%'
            ORDER BY sch_schedule_number ASC 
                LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Schedules API:schedulesSearch GET:'.print_r($_GET,true));
}
//needs fixing
else if ($_GET['section'] == 'opentickets'){

    if ($_GET['user'] == ''){
        $userClause = ' AND tck_assigned_user_ID = -1';
    }
    else {
        $userClause = " AND (tck_assigned_user_ID = '".$_GET['user']."' OR tck_assigned_user_ID = -1)";
    }

    $sql = "SELECT 
    *,
    ( 
        SELECT
        GROUP_CONCAT(tke_type, ' ' ,prd_model, '<br>')
        FROM
        ticket_events
        JOIN unique_serials ON tke_unique_serial_ID = uqs_unique_serial_ID
        JOIN products ON prd_product_ID = uqs_product_ID
        WHERE
        tke_ticket_ID = tck_ticket_ID
    )as events_description,
    (
    SELECT
        GROUP_CONCAT(' ',prd_model)as value
        FROM
        ticket_products
        JOIN products ON prd_product_ID = tkp_product_ID
        WHERE
        tkp_ticket_ID = tck_ticket_ID
    )as products_description
    FROM
    tickets
    JOIN customers ON cst_customer_ID = tck_customer_ID
    JOIN codes ON cst_city_code_ID = cde_code_ID
    WHERE
    tck_status = 'Open'".$userClause;
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Ticket API:OpenTickets GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Ticket API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();