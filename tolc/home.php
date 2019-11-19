<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 13/11/2019
 * Time: 4:51 ΜΜ
 */
include("../include/main.php");
$db = new Main(0);

$db->show_header();
require('content/home.php');
$db->show_footer();
