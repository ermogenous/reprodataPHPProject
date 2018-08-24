<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 22/8/2018
 * Time: 10:36 ΠΜ
 */

include("../include/main.php");
include ("stock.class.php");
$db = new Main();
$db->admin_title = "Stock Transaction Delete";

$db->check_restriction_area('delete');

if ($_GET["lid"] == ''){
    header("Location: stock_transactions_list.php");
    exit();
}

$stock = new Stock($_GET["pid"]);
$result = $stock->deleteTransaction($_GET["lid"]);

if ($result === true){
    $db->generateSessionDismissSuccess(' ');
    header("Location: stock_transactions_list.php");
    exit();
}
else {
    $db->generateSessionDismissError($result);
    header("Location: stock_transactions_list.php");
    exit();
}
