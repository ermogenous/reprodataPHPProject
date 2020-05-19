<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:19 ΜΜ
 */

header("Location:synthesis/accounts/accounts.php");
exit();

include_once("include/main.php");
$db = new Main(1);

$db->show_header();

$db->show_footer();