<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 23/04/2020
 * Time: 23:38
 */

include("../include/main.php");
include("creditCardPaymentsClass.php");

$db = new Main(0);
//$db->admin_title = "";
$db->apiGetReadHeaders();

//retrieve the data from curl json
//$postData = json_decode(file_get_contents('php://input'), true);

//$db->update_log_file_custom('Credit Card functions',print_r($postData,true));

$_SESSION[$main["environment"] . "_admin_username"] = $db->decrypt($_GET['username'],'123456');
$_SESSION[$main["environment"] . "_admin_password"] = $db->decrypt($_GET['password'],'123456');
$db->check_login();
if ($db->user_data['usr_users_ID'] > 0) {
    //the credentials look ok
}
else {
    $data['error'] = 'Invalid credentials';
    echo json_encode($data);
    exit();
}

if ($_GET['action'] == 'testConnection'){

    if ($db->user_data['usr_users_ID'] > 0){
        $data['testConnection'] = 'Yes';
    }
    else {
        $data['testConnection'] = 'No';
    }

}

if ($_GET['action'] == 'createNewCard'){
    $error = '0';
    $errorDescription = '';
    $db->update_log_file_custom('Credit Card create new card init',print_r($_GET,true));
    if ($_GET['number'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card number';
    }
    else if ($_GET['expYear'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card expiry year';
    }
    else if ($_GET['expMonth'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card expiry month';
    }
    else if ($_GET['ccv'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card ccv';
    }

    if ($error == true){
        $data['error'] = $errorDescription;
        //$db->update_log_file_custom('Credit Card create new card error found in checks',$errorDescription);
        echo json_encode($data);
        exit();
    }

    //all ok proceed to create the credit card
    $cc = new creditCardPaymentsClass();

    $cc->setCreditCardNumber($db->encrypt($_GET['number'],'123456'))
        ->setCreditCardExpiryYear($_GET['expYear'])
        ->setCreditCardExpiryMonth($_GET['expMonth'])
        ->setCreditCardCCV($_GET['ccv'])
        ->createNewCard();
    if ($cc->error == true){
        $data['error'] = $cc->errorDescription;
        //$db->update_log_file_custom('Credit Card create new card error found in creation',$cc->errorDescription);
        echo json_encode($data);
        exit();
    }

    $data['newCardRemoteID'] = $cc->getCardID();
    $data['error'] = "0";

}


echo json_encode($data);
exit();





/*
$cc = new creditCardPaymentsClass();

$cc->setCreditCardNumber($db->encrypt('5540373514340931','123456'))
    ->setCreditCardExpiryYear('21')
    ->setCreditCardExpiryMonth('04')
    ->setCreditCardCCV(756)
    ->createNewCard();
if ($cc->error == false){
    echo "Credit card created successfully ID:".$cc->getCardID()."<br>";
}
else {
    echo $cc->errorDescription."<br>";
}

echo '<br><b>Executing</b><br>';
$cc->setPaymentAmount(3.76)
    ->setPaymentDescription('A test payment')
    ->setPaymentForeignIdentifier('1101-001212')
    ->createNewPayment();

/*
$cc->setPaymentID(1)
    ->executePayment();

$cc->setPaymentAmount(5.75)
    ->setPaymentDescription('Another test payment')
    ->setPaymentForeignIdentifier('1101-001214')
    ->setCardID(7)
    ->createNewPayment();

if ($cc->error == false){
    echo "Payment created successfully:"."<br>";
}
else {
    echo $cc->errorDescription."<br>";
}

$cc->executePayment();
if ($cc->error == false){
    echo "Payment Executed successfully:"."<br>";
}
else {
    echo $cc->errorDescription."<br>";
}
*/