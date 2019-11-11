<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 29/7/2019
 * Time: 10:23 ΠΜ
 */

include("../../include/main.php");
$db = new Main();
$db->admin_title = "Insurance Underwriters Modify";

if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Update Insurance underwriter Company';
    $db->start_transaction();

    $db->db_tool_update_row('ina_underwriter_companies', $_POST, "`inaunc_underwriter_company_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'inaunc_');

    $db->commit_transaction();
    header("Location: underwriter_companies.php?lid=" . $_POST['uid']);
    exit();

}

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("
      SELECT * FROM `ina_underwriter_companies` 
      JOIN ina_insurance_companies ON inainc_insurance_company_ID = inaunc_insurance_company_ID
      JOIN ina_underwriters ON inaund_underwriter_ID = inaunc_underwriter_ID
      JOIN users ON usr_users_ID = inaund_user_ID
      WHERE inaunc_underwriter_company_ID = " . $_GET["lid"]
    );

    //if advanced accounts and underwriter is sub agent get the commissions from the insurance companies
    //to check that the commissions defined below is not more than the top commissions
    $advancedAccounts = $db->get_setting('ac_advanced_accounts_enable');
    if ($advancedAccounts == 1){

        //if subagent and office top
        if ($data['inaund_subagent_ID'] == -1){
            $compCommData = $db->query_fetch('
            SELECT * FROM ina_insurance_companies WHERE inainc_insurance_company_ID = '.$data['inaunc_insurance_company_ID']
            );
            $prevAgentComm['motor'] = $compCommData['inainc_commission_motor'];
            $prevAgentComm['fire'] = $compCommData['inainc_commission_fire'];
            $prevAgentComm['pa'] = $compCommData['inainc_commission_pa'];
            $prevAgentComm['el'] = $compCommData['inainc_commission_el'];
            $prevAgentComm['pi'] = $compCommData['inainc_commission_pi'];
            $prevAgentComm['pl'] = $compCommData['inainc_commission_pl'];
            $prevAgentComm['medical'] = $compCommData['inainc_commission_medical'];
            $prevAgentComm['travel'] = $compCommData['inainc_commission_travel'];
        }
        //this underwriter is subagent of another subagent
        else if ($data['inaund_subagent_ID'] > 0){
            $parentUnderwriter = $db->query_fetch('SELECT * FROM ina_underwriter_companies 
            WHERE inaunc_underwriter_ID = '.$data['inaund_subagent_ID']." 
            AND inaunc_insurance_company_ID = ".$data['inaunc_insurance_company_ID']);
            $prevAgentComm['motor'] = $parentUnderwriter['inaunc_commission_motor'];
            $prevAgentComm['fire'] = $parentUnderwriter['inaunc_commission_fire'];
            $prevAgentComm['pa'] = $parentUnderwriter['inaunc_commission_pa'];
            $prevAgentComm['el'] = $parentUnderwriter['inaunc_commission_el'];
            $prevAgentComm['pi'] = $parentUnderwriter['inaunc_commission_pi'];
            $prevAgentComm['pl'] = $parentUnderwriter['inaunc_commission_pl'];
            $prevAgentComm['medical'] = $parentUnderwriter['inaunc_commission_medical'];
            $prevAgentComm['travel'] = $parentUnderwriter['inaunc_commission_travel'];
        }

    }

}

$db->show_header();


include('../../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 hidden-xs hidden-sm"></div>
            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row alert alert-success text-center">
                        <div class="col-12">
                            <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                                 Underwriter Company</b>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-4">Underwriter</div>
                        <div class="col-sm-6 text-left">
                            <?php echo $data['usr_name'];?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">Company</div>
                        <div class="col-sm-6">
                            <?php echo $data['inainc_name'];?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_calculation" class="col-sm-4">Commission Calculation</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="fld_commission_calculation" name="fld_commission_calculation">
                                <option value="commNetPrem" <?php if ($data['inaunc_commission_calculation'] == 'commNetPrem') echo 'selected';?>>Commission On Net Premium</option>
                                <option value="commNetPremFees" <?php if ($data['inaunc_commission_calculation'] == 'commNetPremFees') echo 'selected';?>>Commission On Net Premium + Fees</option>
                            </select>

                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_calculation",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_motor" class="col-sm-4">Commission Motor</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_motor" id="fld_commission_motor"
                                   value="<?php echo $data['inaunc_commission_motor'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_motor",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                            <input type="text" class="form-control" name="comp_commission_motor" id="comp_commission_motor"
                                   value="<?php echo $prevAgentComm['motor'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_motor",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Motor commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_motor").val()*1) > $("#comp_commission_motor").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="fld_commission_fire" class="col-sm-4">Commission Fire</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_fire" id="fld_commission_fire"
                                   value="<?php echo $data['inaunc_commission_fire'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_fire",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_fire" id="comp_commission_fire"
                                       value="<?php echo $prevAgentComm['fire'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_fire",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Fire commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_fire").val()*1) > $("#comp_commission_fire").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_pa" class="col-sm-4">Commission PA</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_pa" id="fld_commission_pa"
                                   value="<?php echo $data['inaunc_commission_pa'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_pa",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_pa" id="comp_commission_pa"
                                       value="<?php echo $prevAgentComm['pa'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pa",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PA commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pa").val()*1) > $("#comp_commission_pa").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_el" class="col-sm-4">Commission EL</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_el" id="fld_commission_el"
                                   value="<?php echo $data['inaunc_commission_el'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_el",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_el" id="comp_commission_el"
                                       value="<?php echo $prevAgentComm['el'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_el",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'EL commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_el").val()*1) > $("#comp_commission_el").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_pi" class="col-sm-4">Commission PI</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_pi" id="fld_commission_pi"
                                   value="<?php echo $data['inaunc_commission_pi'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_pi",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_pi" id="comp_commission_pi"
                                       value="<?php echo $prevAgentComm['pi'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pi",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PI commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pi").val()*1) > $("#comp_commission_pi").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_pl" class="col-sm-4">Commission PL</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_pl" id="fld_commission_pl"
                                   value="<?php echo $data['inaunc_commission_pl'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_pl",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_pl" id="comp_commission_pl"
                                       value="<?php echo $prevAgentComm['pl'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_pl",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'PL commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_pl").val()*1) > $("#comp_commission_pl").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_medical" class="col-sm-4">Commission Medical</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_medical" id="fld_commission_medical"
                                   value="<?php echo $data['inaunc_commission_medical'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_medical",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_medical" id="comp_commission_medical"
                                       value="<?php echo $prevAgentComm['medical'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_medical",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Medical commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_medical").val()*1) > $("#comp_commission_medical").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_commission_travel" class="col-sm-4">Commission Travel</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="fld_commission_travel" id="fld_commission_travel"
                                   value="<?php echo $data['inaunc_commission_travel'];?>">
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_commission_travel",
                                "fieldDataType" => "number",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php if ($data['inaund_subagent_ID'] != 0 && $advancedAccounts == 1){ ?>
                                <input type="text" class="form-control" name="comp_commission_travel" id="comp_commission_travel"
                                       value="<?php echo $prevAgentComm['travel'];?>" style="width: 80px;" disabled>
                            <?php
                                $formValidator->addField([
                                    "fieldName" => "comp_commission_travel",
                                    "fieldDataType" => "number",
                                    "required" => true,
                                    "invalidText" => 'Travel commission cannot be more than top commission',
                                    "requiredAddedCustomCode" => '|| ($("#fld_commission_travel").val()*1) > $("#comp_commission_travel").val()'
                                ]);
                            }
                            ?>
                        </div>
                    </div>


                    <!-- BUTTONS -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="update">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="uid" type="hidden" id="uid" value="<?php echo $data['inaunc_underwriter_ID']; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('underwriter_companies.php?lid=<?php echo $data['inaunc_underwriter_ID'];?>')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Update Underwriter Company"
                                   class="btn btn-secondary">
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