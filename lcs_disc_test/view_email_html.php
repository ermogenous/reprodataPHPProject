<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 8:45 ΜΜ
 */

include("../include/main.php");
include('disc_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS Introvert Extrovert Test View Email Html";

if ($_GET['lid'] == ''){
    header("Location: intro_extro_test_list.php");
    exit();
}

$db->show_empty_header();

$test = new DiscTest($_GET['lid']);
echo $test->getEmailHtml();

$db->show_empty_footer();
?>