<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 17/8/2021
 * Time: 12:56 μ.μ.
 */

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
include('../../lib/odbccon.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Accounts - Transaction Count by last user";

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
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-12 col-md-10">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Reports - Accounts - Transaction List Based on the last user</b></div>
                </div>
                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_year_from')
                        ->setFieldDescription('From Year')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_year_from'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_period_from')
                        ->setFieldDescription('From Period')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_period_from'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>


                </div>

                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_year_to')
                        ->setFieldDescription('To Year')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_year_to'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_period_to')
                        ->setFieldDescription('To Period')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('input')
                        ->setFieldInputType('number')
                        ->setInputValue($_POST['fld_period_to'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'input',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>


                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_status')
                        ->setFieldDescription('Report Type')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputSelectArrayOptions([
                            'P' => 'Only Posted',
                            'O' => 'Only Outstanding',
                            'PO' => 'Posted & Outstanding'
                        ])
                        ->setInputValue($_POST['fld_status'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_sort')
                        ->setFieldDescription('Order By')
                        ->setLabelClasses('col-sm-2')
                        ->setFieldType('select')
                        ->setInputSelectArrayOptions([
                            'UA' => 'User Asc',
                            'UD' => 'User Desc',
                            'TA' => 'Transactions Asc',
                            'TD' => 'Transactions Desc'
                        ])
                        ->setInputValue($_POST['fld_sort'])
                        ->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'select',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>

                </div>

                <div class="form-group row">
                    <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action" value="execute">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('index.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="Submit Form"
                               class="btn btn-primary">
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>

<?php

if ($_POST['action'] == 'execute') {

    if ($_POST['fld_status'] == 'P') {
        $status = "'1'";
    } else if ($_POST['fld_status'] == 'O') {
        $status = "'2'";
    } else if ($_POST['fld_status'] == 'PO') {
        $status = "'1','2'";
    }

    if ($_POST['fld_sort'] == 'UA'){
        $sort = 'acthe_last_user ASC';
    }
    else if ($_POST['fld_sort'] == 'UD'){
        $sort = 'acthe_last_user DESC';
    }
    else if ($_POST['fld_sort'] == 'TA'){
        $sort = 'clo_total_transactions ASC';
    }
    else if ($_POST['fld_sort'] == 'TD'){
        $sort = 'clo_total_transactions DESC';
    }

    $sql = "
        SELECT 
            COUNT(acthe_auto_serl)as clo_total_transactions,
            acthe_last_user
        FROM
            acmthead
        WHERE
            1=1 
            AND acthe_docu_cate IN ('01') 
            AND acthe_docu_type='1' 
            AND acthe_docu_stat IN (" . $status . ") 
            AND acthe_docu_year >= " . $_POST['fld_year_from'] . " 
            AND acthe_docu_year <= " . $_POST['fld_year_to'] . " 
            AND acthe_docu_perd >= " . $_POST['fld_period_from'] . "
            AND acthe_docu_perd <= " . $_POST['fld_period_to'] . "
        GROUP BY
        acthe_last_user
        ORDER BY ".$sort."
    ";
    //echo $sql;
    $sybase = new ODBCCON();
    $result = $sybase->query($sql);
    ?>

    <table width="400" border="1" align="center">
        <tr>
            <td><b>User</b></td>
            <td align="center"><b>Transactions</b></td>
        </tr>

        <?php
        while ($row = $sybase->fetch_assoc($result)) {

            echo "<tr>" . PHP_EOL;
            echo "<td>" . $row['acthe_last_user'] . "</td>" . PHP_EOL;
            echo '<td align="center">' . $row['clo_total_transactions'] . "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;

        }
        ?>
    </table>
    <?php

}

$formValidator->output();
$db->show_footer();
?>
