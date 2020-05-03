<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 03/05/2020
 * Time: 17:43
 */

include("../../include/main.php");

$db = new Main(1);
$db->admin_title = "Credit cards API";

$db->apiGetReadHeaders();

$remoteUrl =  'http://localhost/insurance/rcb/credit_card_functions.php';
$remoteUrlUsername = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already
$remoteUrlPassword = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already


if ($_GET['action'] == 'getTestConnectionString'){
    $data['conString'] = $remoteUrl."?action=testConnection&username=".$remoteUrlUsername."&password=".$remoteUrlPassword;
}




echo json_encode($data);
exit();