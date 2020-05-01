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
$postData = json_decode(file_get_contents('php://input'), true);

$db->update_log_file_custom('Credit Card functions',print_r($postData,true));

$_SESSION[$main["environment"] . "_admin_username"] = $db->decrypt($postData['username'],'123456');
$_SESSION[$main["environment"] . "_admin_password"] = $db->decrypt($postData['password'],'123456');
$db->check_login();
if ($db->user_data['usr_users_ID'] > 0) {
    //the credentials look ok
}
else {
    $data['error'] = 'Invalid credentials';
    echo json_encode($data);
    exit();
}

if ($postData['action'] == 'testConnection'){


    if ($db->user_data['usr_users_ID'] > 0){
        $data['testConnection'] = 'Yes';
    }
    else {
        $data['testConnection'] = 'No';
    }

}

if ($postData['action'] == 'createNewCard'){
    $error = false;
    $errorDescription = '';
    $db->update_log_file_custom('Credit Card create new card init',print_r($postData,true));
    if ($postData['creditCardNumber'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card number';
    }
    if ($postData['creditCardExpiryYear'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card expiry year';
    }
    if ($postData['creditCardExpiryMonth'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card expiry month';
    }
    if ($postData['creditCardCCV'] == ''){
        $error = true;
        $errorDescription = 'Must provide credit card ccv';
    }

    if ($error == true){
        $data['error'] = true;
        $data['errorDescription'] = $errorDescription;
        //$db->update_log_file_custom('Credit Card create new card error found in checks',$errorDescription);
        echo json_encode($data);
        exit();
    }

    //all ok proceed to create the credit card
    $cc = new creditCardPaymentsClass();

    $cc->setCreditCardNumber($db->encrypt($postData['creditCardNumber'],'123456'))
        ->setCreditCardExpiryYear($postData['creditCardExpiryYear'])
        ->setCreditCardExpiryMonth($postData['creditCardExpiryMonth'])
        ->setCreditCardCCV($postData['creditCardCCV'])
        ->createNewCard();
    if ($cc->error == true){
        $data['error'] = true;
        $data['errorDescription'] = $cc->errorDescription;
        //$db->update_log_file_custom('Credit Card create new card error found in creation',$cc->errorDescription);
        echo json_encode($data);
        exit();
    }

    $data['newCardRemoteID'] = $cc->getCardID();

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