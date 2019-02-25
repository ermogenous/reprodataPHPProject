<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/2/2019
 * Time: 11:13 ΠΜ
 */

include("../include/main.php");
include('disc_class.php');
include('email_layout.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test List";

$layout = getEmailLayoutResult($_GET['lid'],'path');

echo $layout;