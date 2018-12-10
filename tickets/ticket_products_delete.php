<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 10-Dec-18
 * Time: 3:36 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Ticket Products Delete";

$db->working_section = 'Ticket Products Delete';

if ($_GET['lid'] == '' || $_GET['tid'] == '') {
    echo $_GET['tid'];
    header("Location: ticket_events.php?redirect=1");
    exit();
}

$data = $db->query_fetch("SELECT * FROM ticket_products WHERE tkp_ticket_product_ID = ".$_GET['lid']);
if ($data['tkp_ticket_product_ID'] > 0){
        //proceed to delete
        $db->db_tool_delete_row('ticket_products',$_GET['lid'],'tkp_ticket_product_ID = '.$_GET['lid']);

        header("Location: ticket_products.php?tid=".$_GET['tid']."&type=".$_GET['type']);
        exit();
}else {
    header("Location: ticket_products.php?tid=".$_GET['tid']."&type=".$_GET['type']);
    exit();
}