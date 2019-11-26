<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 13/11/2019
 * Time: 4:51 ΜΜ
 */
include("../include/main.php");
include("template.php");
$db = new Main(0);

show_tolc_header();
require('content/home.php');
show_tolc_footer();
