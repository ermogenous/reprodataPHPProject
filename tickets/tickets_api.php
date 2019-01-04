<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 28-Dec-18
 * Time: 5:17 PM
 */


include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Tickets API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'tickets') {

    $sql = "SELECT
            CONCAT(tck_ticket_number, ' ',cst_identity_card, ' ',cst_name, ' ', cst_surname, ' ', cst_work_tel_1)as label,
            tck_ticket_ID as value
            FROM
            tickets
            JOIN customers ON cst_customer_ID = tck_customer_ID
            WHERE
            cst_identity_card LIKE '%".$_GET['term']."%'
            OR 
            cst_name LIKE '%".$_GET['term']."%'
            OR
            cst_surname LIKE '%".$_GET['term']."%'
            OR
            cst_work_tel_1 LIKE '%".$_GET['term']."%'
            OR
            cst_work_tel_2  LIKE '%".$_GET['term']."%'
            OR 
            cst_fax  LIKE '%".$_GET['term']."%'
            OR
            cst_mobile_1 LIKE '%".$_GET['term']."%'
            OR
            cst_mobile_2 LIKE '%".$_GET['term']."%'
            OR
            tck_ticket_number  LIKE '%".$_GET['term']."%'
            ORDER BY tck_ticket_number ASC 
                LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Ticket API:TicketsSearch GET:'.print_r($_GET,true));
}
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