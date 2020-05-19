<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 03/05/2020
 * Time: 17:43
 */

include("../../include/main.php");
include("credit_card_class.php");

$db = new Main(1);
$db->admin_title = "Credit cards API";

$db->apiGetReadHeaders();

$remoteUrl = 'http://localhost/insurance/rcb/credit_card_functions.php';
$remoteUrlUsername = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already
$remoteUrlPassword = 'VFVrKzd5STNYRHZ6bXpTT0tieW5Ydz09Ojpl8sKxALeRVF6SiG-6QH42'; //encrypted using the key already
$data['error'] = '1';

$db->update_log_file_custom('Credit cards api',print_r($_GET,true));

if ($_GET['action'] == 'getTestConnectionString') {
    $data['error'] = '0';
    $data['conString'] = $remoteUrl . "?action=testConnection&username=" . $remoteUrlUsername . "&password=" . $remoteUrlPassword;
}

if ($_GET['action'] == 'newCardConnectionString') {
    $data['error'] = '0';
    if ($_GET['card'] == '') {
        $data['error'] = 'Credit card number is missing';
    } else if ($_GET['expYear'] == '') {
        $data['error'] = 'Credit card expiry year is missing';
    } else if ($_GET['expMonth'] == '') {
        $data['error'] = 'Credit card expiry month is missing';
    } else if ($_GET['ccv'] == '') {
        $data['error'] = 'Credit card ccv is missing';
    } //all ok
    else {
        $data['conString'] = $remoteUrl . "?action=createNewCard&username=" . $remoteUrlUsername . "&password=" . $remoteUrlPassword;
        $data['conString'] .= "&number=" . $_GET['card'];
        $data['conString'] .= "&expYear=" . $_GET['expYear'];
        $data['conString'] .= "&expMonth=" . $_GET['expMonth'];
        $data['conString'] .= "&ccv=" . $_GET['ccv'];
    }

}
if ($_GET['action'] == 'insertCardToDB') {

    $db->update_log_file_custom('insertCardToDB',print_r($_GET,true));
    $data['error'] = '0';
    if ($_GET['card'] == '') {
        $data['error'] = 'Inserting Card: Card is missing';
    }
    else if ($_GET['remoteID'] == ''){
        $data['error'] = 'Inserting Card: Remote ID is missing';
    }
    else {
        $card = new MECreditCards();
        $card->makeNewCreditCardEntry();
        if ($card->error == true){
            $data['error'] = $card->errorDescription;
        }
        else {

        }
    }
}


echo json_encode($data);
exit();