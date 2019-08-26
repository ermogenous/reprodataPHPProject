<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/8/2019
 * Time: 11:41 ΠΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "AInsurance Settings Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'AInsurance Settings Insert';
    $db->db_tool_insert_row('ina_settings', $_POST, 'fld_', 0, 'inaset_');
    header("Location: ainsurance_settings.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'AInsurance Settings Modify';

    $db->db_tool_update_row('ina_settings', $_POST, "`inaset_setting_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'inaset_');
    header("Location: ainsurance_settings.php");
    exit();

}

$data = $db->query_fetch('SELECT * FROM ina_settings');
if ($data['inaset_setting_ID'] > 0){
    $_GET['lid'] = $data['inaset_setting_ID'];
}

$db->show_header();
include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();
$formValidator->showErrorList();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 hidden-xs hidden-sm"></div>
            <div class="col-lg-8 col-md-2 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Insurance Settings </b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_enable_acc_transactions" class="col-sm-6 col-form-label">Auto Generate Account Transactions</label>
                        <div class="col-sm-3">
                            <select name="fld_enable_acc_transactions" id="fld_enable_acc_transactions"
                                    class="form-control">
                                <option value="1" <?php if ($data['inaset_enable_acc_transactions'] == '1') echo "selected=\"selected\""; ?>>
                                    Yes
                                </option>
                                <option value="0" <?php if ($data['inaset_enable_acc_transactions'] == '0') echo "selected=\"selected\""; ?>>
                                    No
                                </option>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_enable_acc_transactions",
                                "fieldDataType" => "select",
                                "required" => false,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_ins_comp_dr_acc_ID" class="col-sm-6 col-form-label">Dr Account Ins.Comp Commissions</label>
                        <div class="col-sm-6">
                            <select name="fld_ins_comp_dr_acc_ID" id="fld_ins_comp_dr_acc_ID"
                                    class="form-control">
                                <option value=""></option>
                                <?php
                                $accResult = $db->query("
                              SELECT * FROM ac_accounts 
                              WHERE acacc_control = 0
                              ORDER BY acacc_code ASC");
                                while ($acc = $db->fetch_assoc($accResult)) {

                                    ?>
                                    <option value="<?php echo $acc['acacc_account_ID']; ?>"
                                        <?php if ($acc['acacc_account_ID'] == $data['inaset_ins_comp_dr_acc_ID']) echo 'selected'; ?>>
                                        <?php echo $acc['acacc_code']." - ".$acc['acacc_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_ins_comp_dr_acc_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                                "requiredAddedCustomCode" => "&& $('#fld_enable_acc_transactions').val() == 1"
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_sub_agent_cr_acc_ID" class="col-sm-6 col-form-label">Cr Acc. For Sub-Agent Commissions</label>
                        <div class="col-sm-6">
                            <select name="fld_sub_agent_cr_acc_ID" id="fld_sub_agent_cr_acc_ID"
                                    class="form-control">
                                <option value=""></option>
                                <?php
                                $accResult = $db->query("
                              SELECT * FROM ac_accounts 
                              WHERE acacc_control = 0
                              ORDER BY acacc_code ASC");
                                while ($acc = $db->fetch_assoc($accResult)) {

                                    ?>
                                    <option value="<?php echo $acc['acacc_account_ID']; ?>"
                                        <?php if ($acc['acacc_account_ID'] == $data['inaset_sub_agent_cr_acc_ID']) echo 'selected'; ?>>
                                        <?php echo $acc['acacc_code']." - ".$acc['acacc_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_sub_agent_cr_acc_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                                "requiredAddedCustomCode" => "&& $('#fld_enable_acc_transactions').val() == 1"
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_ins_comm_ac_document_ID" class="col-sm-6 col-form-label">Acc.Document To Be Used</label>
                        <div class="col-sm-6">
                            <select name="fld_ins_comm_ac_document_ID" id="fld_ins_comm_ac_document_ID"
                                    class="form-control">
                                <option value=""></option>
                                <?php
                                $accResult = $db->query("
                              SELECT * FROM ac_documents 
                              ORDER BY acdoc_code ASC");
                                while ($doc = $db->fetch_assoc($accResult)) {

                                    ?>
                                    <option value="<?php echo $doc['acdoc_document_ID']; ?>"
                                        <?php if ($doc['acdoc_document_ID'] == $data['inaset_ins_comm_ac_document_ID']) echo 'selected'; ?>>
                                        <?php echo $doc['acdoc_code']." - ".$doc['acdoc_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php
                            $formValidator->addField([
                                "fieldName" => "fld_ins_comm_ac_document_ID",
                                "fieldDataType" => "select",
                                "required" => true,
                                "invalidTextAutoGenerate" => true,
                                "requiredAddedCustomCode" => "&& $('#fld_enable_acc_transactions').val() == 1"
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" style="height: 25px;"></div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Insurance Settings"
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