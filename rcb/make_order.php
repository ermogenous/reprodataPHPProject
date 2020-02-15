<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2020
 * Time: 2:48 μ.μ.
 */

include("../include/main.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items Premium";

include('rcb_bank_class.php');
include('rcb_payments_class.php');

//$db->show_header();
/*
$rcb = new rcbConnection();
$rcb->setCardNumber('5540373514340931')
    ->setCardExpiry('2104')
    ->setCardCCV('756')
    ->setPurchaseAmount(100);
$rcb->createOrder();
$rcb->sentPurchaseCard();
//$rcb->testFunction();

echo "<br><hr>Error Description. If Any<hr><br>" . $rcb->errorDescription;
*/
//$db->show_footer();


$rcb = new RCB_Payment();

//Make purchase with card number

$rcb->setCardNumber('5540373514340931')
    ->setCardExpiry('2104')
    ->setCardCCV('756')
    ->setPurchaseAmount(250)
    ->setDescription('Test Payment')
    ->setForeignIdentifier('1101-000001')
    ->makePayment();


//make purschase with token
/*
$rcb->setTokenNumber('235578552')
    ->setPurchaseAmount(354)
    ->setDescription('Some Description Anthimos')
    ->setForeignIdentifier('1101-000100')
    ->makePayment();
*/