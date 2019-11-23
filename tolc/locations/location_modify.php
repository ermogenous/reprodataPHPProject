<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/11/2019
 * Time: 10:06 ΜΜ
 */

include("../../include/main.php");
include("../../scripts/form_builder_class.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Location Modify";


$db->show_header();
FormBuilder::buildPageLoader();

$formB = new FormBuilder();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">

            <div class="row">
                <div class="col-12 alert alert-success">Location Modify</div>
            </div>


        </div>
        <div class="col-1"></div>
    </div>
</div>
