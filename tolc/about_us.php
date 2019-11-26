<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/11/2019
 * Time: 5:44 ΜΜ
 */
include("../include/main.php");
include("template.php");
$db = new Main(0);

show_tolc_header();
require('content/about_us.php');
show_tolc_footer();