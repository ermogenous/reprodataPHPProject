<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 14/9/2021
 * Time: 4:34 μ.μ.
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


$sybase = new ODBCCON();
if ($_POST['action'] == 'execute') {

    $list = explode(PHP_EOL, $_POST['fld_account_list']);
    //print_r($list);
    //get the policies
    foreach ($list as $value) {
        if ($value != '') {
            //echo $value . "!<br>";
            $sql = "
            SELECT
            inpol_policy_serial,
            inpol_period_starting_date
            FROM
            inclients
            JOIN inpolicies ON incl_client_serial = inpol_client_serial
            where
            incl_account_code = '" . $value . "'
            AND incl_update_ac_static = 'Y'
            AND inpol_status NOT IN ('D')
            ORDER BY inpol_period_starting_date ASC
            ";
            //echo $sql;
            $result = $sybase->query($sql);
            while ($row = $sybase->fetch_assoc($result)) {
                //echo $row['inpol_policy_serial'] . "<br>";

                $sqlBalance = "select * from sp_get_policy_due_amounts('".$row['inpol_policy_serial']."')";
                $resultBalance = $sybase->query($sqlBalance);
                while ($brow = $sybase->fetch_assoc($resultBalance)){
                    //echo "#".$brow['clo_policy_due_all']."#";
                    $data[$value][$brow['sp_policy_number']]['balance'] = $brow['clo_policy_due_all'];
                    $data[$value][$brow['sp_policy_number']]['date'] = $row['inpol_period_starting_date'];
                }

            }


        }
    }

    foreach($data as $acc => $row){

        $blist = '';

        foreach($row as $polName => $line){
            //echo $acc." -> ".$polName." -> ".$balance."<br>";
            if ($line['balance'] > 0){
                $blist .= $polName."[".$line['balance']."]".$db->convertDateToEU($line['date'])."-";
            }
        }
        echo $acc."#".$db->remove_last_char($blist)."<br>";
    }


    //$db->export_file_for_download($data,'Sample.txt');
    exit();
}





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
                    <div class="col-12 alert alert-primary text-center"><b>Reports - Accounts - Transaction List Based
                            on the last user</b></div>
                </div>
                <div class="row form-group">
                    <?php

                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_account_list')
                        ->setFieldDescription('List of accounts by break')
                        ->setLabelClasses('col-sm-3')
                        ->setFieldType('textarea')
                        ->setInputValue($_POST['fld_account_list'])
                        ->buildLabel();
                    ?>
                    <div class="col-9">
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



$formValidator->output();
$db->show_footer();
?>
