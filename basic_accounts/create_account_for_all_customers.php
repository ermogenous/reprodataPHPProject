<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/2/2019
 * Time: 10:25 ΠΜ
 */

include("../include/main.php");
include("basic_accounts_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Basic Accounts Create account for all customers";


$db->show_header();

$acc = new BasicAccounts();
$acc->createAccountForAllCustomers();
?>


<?php
$db->show_footer();
?>