<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/3/2019
 * Time: 9:54 ΠΜ
 */
include("../include/main.php");
include('disc_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test List";


if ($_GET['lid'] != ''){
    $disc = new DiscTest($_GET['lid']);
    $disc->getPdf();
}
