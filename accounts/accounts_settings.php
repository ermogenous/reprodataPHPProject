<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/9/2019
 * Time: 11:44 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Settings";

$db->show_header();

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">

            <div class="row">
                <div class="col-sm-12 alert alert-success text-center">
                    <strong>Accounts Settings</strong>
                </div>
            </div>


            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                       role="tab"
                       aria-controls="pills-general" aria-selected="true">General Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-bs-tab" data-toggle="pill" href="#pills-bs"
                       role="tab"
                       aria-controls="pills-bs" aria-selected="true">Balance Sheet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-pl-tab" data-toggle="pill" href="#pills-pl"
                       role="tab"
                       aria-controls="pills-pl" aria-selected="true">Profit & Loss</a>
                </li>

            </ul>


            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                     aria-labelledby="pills-general-tab">

                    <!-- General ---------------------------------------------------------------------------------------GENERAL TAB-->
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>General Settings</b>
                        </div>
                    </div>

                </div> <!-- GENERAL TAB -->

                <div class="tab-pane fade show" id="pills-bs" role="tabpanel"
                     aria-labelledby="pills-bs-tab">
                    <!-- General ---------------------------------------------------------------------------------------BALANCE SHEET TAB-->
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Balance Sheet Report Settings</b>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="fld_mf_age_restriction" class="col-sm-4 col-form-label">
                            Fixed Assets Category
                        </label>

                    </div>




                </div> <!-- BALANCE SHEET TAB -->

                <div class="tab-pane fade show" id="pills-pl" role="tabpanel"
                     aria-labelledby="pills-pl-tab">
                    <!-- General ---------------------------------------------------------------------------------------PROFIT & LOSS TAB-->
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b>Profit & Loss Settings</b>
                        </div>
                    </div>

                </div> <!-- PROFIT & LOSS TAB -->

            </div>


        </div>
        <div class="col-sm-2"></div>
    </div>
</div>


<?php
$db->show_footer();
?>