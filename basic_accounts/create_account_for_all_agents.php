<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/2/2019
 * Time: 9:44 ΠΜ
 */

include("../include/main.php");
include("basic_accounts_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Basic Accounts Create account for all agents";


$db->show_header();

$acc = new BasicAccounts();
$acc->createAccountForAllAgents();
?>


<?php
$db->show_footer();
?>