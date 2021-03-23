<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 16/3/2021
 * Time: 10:53 π.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main();

$sybase = new ODBCCON();


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="row">
                <div class="col-12 alert alert-primary text-center">
                    <b>Synthesis Users</b>
                </div>
            </div>
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_search_user_desc')
                        ->setFieldDescription('Search Name')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setInputValue($_POST['sch_search_user_desc'])
                        ->buildLabel();
                    ?>
                    <div class="col-3">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_search_user_name')
                        ->setFieldDescription('Search User Name')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setInputValue($_POST['sch_search_user_name'])
                        ->buildLabel();
                    ?>
                    <div class="col-3">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>
                </div>

                <div class="row form-group">


                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_search_user_group')
                        ->setFieldDescription('Search User Group')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setInputValue($_POST['sch_search_user_group'])
                        ->buildLabel();
                    ?>
                    <div class="col-3">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_search_user_menu')
                        ->setFieldDescription('Search User Menu')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setInputValue($_POST['sch_search_user_menu'])
                        ->buildLabel();
                    ?>
                    <div class="col-3">
                        <?php
                        $formB->buildInput();
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 text-center">
                        <input type="hidden" id="action" name="action" value="search">
                        <input type="submit" name="Submit" id="Submit" value="Search" class="btn btn-primary"
                               style="width: 150px;">
                    </div>
                </div>

            </form>


            <?php
            if ($_POST['action'] == 'search') {

            $where = '';

            if ($_POST['sch_search_user_desc'] != '') {
                $where .= " AND syus_user_name LIKE '%" . $_POST['sch_search_user_desc'] . "%'";
            }
            if ($_POST['sch_search_user_name'] != '') {
                $where .= " AND syus_user_idty LIKE '%" . $_POST['sch_search_user_name'] . "%'";
            }
            if ($_POST['sch_search_user_group'] != '') {
                $where .= " AND syus_user_grup LIKE '%" . $_POST['sch_search_user_group'] . "%'";
            }
            if ($_POST['sch_search_user_menu'] != '') {
                $where .= " AND syus_user_menu LIKE '%" . $_POST['sch_search_user_menu'] . "%'";
            }

            $sql = "SELECT * FROM sypusers 
                        WHERE 1=1 
                        " . $where . "  
                        ORDER BY syus_user_idty ASC";
            $result = $sybase->query($sql);
            while ($user = $sybase->fetch_assoc($result)) {

            ?>
            <div class="row">
                <div class="col-12 alert alert-primary">
                    <?php echo $user['syus_user_idty'] . " - " . $user['syus_user_name']; ?>
                </div>
            </div>
            <div class="container">
                <?php
                $undSql = "
                    SELECT
                        (
                        SELECT COUNT() 
                        FROM inunderwriterinstypes JOIN inunderwriters ON inuw_auto_serial = inuwit_underwritter_serial 
                        WHERE inuwit_insurance_type_serial = inity_insurance_type_serial AND inuw_user_code = '".$user['syus_user_idty']."'
                        )as clo_exists_underwriter,
                        inity_insurance_type,
                        inity_long_description
                        FROM
                        ininsurancetypes
                        ORDER BY clo_exists_underwriter ASC, inity_insurance_type ASC";
                $undResult = $sybase->query($undSql);
                while ($unIns = $sybase->fetch_assoc($undResult)) {

                    if ($unIns['clo_exists_underwriter'] > 0) {
                        $color = 'alert-success';
                    }
                    else {
                        $color = 'alert-danger';
                    }
                    ?>
                    <div class="row alert <?php echo $color; ?>">
                        <div class="col-8"><?php echo $unIns['inity_insurance_type'] . " - " . $unIns['inity_long_description']; ?></div>
                        <div class="col-4">
                            <?php
                            if ($unIns['clo_exists_underwriter'] == 1) {
                                echo "Exists";
                            } else if ($unIns['clo_exists_underwriter'] == 0) {
                                echo "Does not Exists";
                            } else {
                                echo "Found another number result";
                            }
                            //echo $unIns['clo_exists_underwriter'];
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
                <?php

                }

                ?>



                <?php
                }
                ?>


            <?php
            $formValidator->output();
            $db->show_footer();
            ?>
