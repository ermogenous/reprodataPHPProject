<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 10-Dec-18
 * Time: 12:17 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Ticket Events Delete";

$db->working_section = 'Ticket Events Delete';

if ($_GET['lid'] == '' || $_GET['tid'] == '') {
    echo $_GET['tid'];
    header("Location: ticket_events.php?redirect=1");
    exit();
}

$data = $db->query_fetch("SELECT * FROM ticket_events WHERE tke_ticket_event_ID = ".$_GET['lid']);
if ($data['tke_ticket_event_ID'] > 0){

    //check if no products are using this event
    $sql = "SELECT count(*) as clo_total_products FROM ticket_products WHERE tkp_ticket_event_ID = ".$_GET['lid'];
    $check = $db->query_fetch($sql);
    if ($check['clo_total_products'] > 0){
        header("Location: ticket_events.php?tid=".$_GET['tid']);
        exit();
    }
    else {
       //proceed to delete
        $db->db_tool_delete_row('ticket_events',$_GET['lid'],'tke_ticket_event_ID = '.$_GET['lid']);
        header("Location: ticket_events.php?tid=".$_GET['tid']);
        exit();
    }

}else {
    header("Location: ticket_events.php?tid=".$_GET['tid']);
    exit();
}