<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/2/2019
 * Time: 11:05 ΠΜ
 */

include("../include/main.php");
include("basic_accounts_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Basic Accounts Create release account for all agents";


$db->show_header();

$acc = new BasicAccounts();
$acc->createReleaseAccountForAllAgents();
?>


<?php
$db->show_footer();
?>