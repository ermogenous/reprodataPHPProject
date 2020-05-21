<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 20/05/2020
 * Time: 15:15
 */

include("../include/main.php");

$db = new Main(1);


if ($db->get_setting('biv_enable_basic_invoice') == 1){
    header("Location: basicInvoice/products.php");
    exit();
}
else {
    header("Location: default/products.php");
    exit();
}