<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/9/2019
 * Time: 11:44 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");
include('../scripts/form_validator_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "Accounts Settings";

if ($_POST['action'] == 'update') {

    $db->db_tool_insert_update_row('ac_settings',
        $_POST, 'acstg_setting_ID = 1', 1,
        'fld_', 'acstg_');

}


$db->show_header();

$data = $db->query_fetch("SELECT * FROM ac_settings WHERE acstg_setting_ID = 1");

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$db->enable_rxjs_lite();
?>

    <div class="container-fluid">
        <form name="myForm" id="myForm" method="post" action="" onsubmit=""
            <?php $formValidator->echoFormParameters(); ?>>
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

                            <div class="row">
                                <label for="fld_auto_ac_debtors_control_ID" class="col-sm-4 col-form-label">
                                    Auto A/C`s Debtor Control
                                </label>
                                <div class="col-sm-4">
                                    <select name="fld_auto_ac_debtors_control_ID" id="fld_auto_ac_debtors_control_ID"
                                            class="form-control">
                                        <option value=""></option>
                                        <?php
                                        $sql = 'SELECT 
                                                * 
                                                FROM 
                                                ac_accounts 
                                                JOIN ac_account_types ON acacc_account_type_ID = actpe_account_type_ID
                                                WHERE acacc_active = "Active" 
                                                AND acacc_control = 1
                                                AND actpe_category = "CurrentAsset" ';
                                        $result = $db->query($sql);
                                        while ($row = $db->fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['acacc_account_ID'];?>"
                                                <?php if ($data['acstg_auto_ac_debtors_control_ID'] == $row['acacc_account_ID']) echo 'selected'; ?>>
                                                <?php echo $row['acacc_name'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_auto_ac_debtors_control_ID',
                                            'fieldDataType' => 'select',
                                            'required' => true,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_auto_ac_creditors_control_ID" class="col-sm-4 col-form-label">
                                    Auto A/C`s Creditor Control
                                </label>
                                <div class="col-sm-4">
                                    <select name="fld_auto_ac_creditors_control_ID" id="fld_auto_ac_creditors_control_ID"
                                            class="form-control">
                                        <option value=""></option>
                                        <?php
                                        $sql = 'SELECT 
                                                * 
                                                FROM 
                                                ac_accounts 
                                                JOIN ac_account_types ON acacc_account_type_ID = actpe_account_type_ID
                                                WHERE acacc_active = "Active" 
                                                AND acacc_control = 1
                                                AND actpe_category = "CurrentLiability" ';
                                        $result = $db->query($sql);
                                        while ($row = $db->fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['acacc_account_ID'];?>"
                                                <?php if ($data['acstg_auto_ac_creditors_control_ID'] == $row['acacc_account_ID']) echo 'selected'; ?>>
                                                <?php echo $row['acacc_name'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_auto_ac_creditors_control_ID',
                                            'fieldDataType' => 'select',
                                            'required' => true,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <label for="fld_auto_account_suffix_num" class="col-sm-4 col-form-label">
                                    Auto A/C`s suffix num
                                </label>
                                <div class="col-sm-4">
                                    <input name="fld_auto_account_suffix_num" type="text"
                                           id="fld_auto_account_suffix_num"
                                           value="<?php echo $data["acstg_auto_account_suffix_num"]; ?>"
                                           class="form-control"/>
                                    <?php
                                    $formValidator->addField(
                                        [
                                            'fieldName' => 'fld_auto_account_suffix_num',
                                            'fieldDataType' => 'text',
                                            'required' => true,
                                            'invalidTextAutoGenerate' => true
                                        ]);
                                    ?>
                                </div>
                                <div class="col-sm-5">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    When auto create account how many digits to use for numbering after control account
                                    number
                                </div>
                            </div>

                        </div> <!-- GENERAL TAB -->

                        <div class="tab-pane fade show" id="pills-bs" role="tabpanel"
                             aria-labelledby="pills-bs-tab">
                            <!-- BALANCE SHEET TAB -----------------------------------------------------------------------------BALANCE SHEET TAB-->
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
                            <!-- PROFIT & LOSS TAB -----------------------------------------------------------------------------PROFIT & LOSS TAB-->
                            <div class="row alert alert-success text-center">
                                <div class="col-12">
                                    <b>Profit & Loss Settings</b>
                                </div>
                            </div>

                        </div> <!-- PROFIT & LOSS TAB -->

                    </div>
                    <br><br>
                    <div class="form-group row">
                        <label for="name" class="col-5 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-7">
                            <input name="action" type="hidden" id="action"
                                   value="update">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Update Settings"
                                   class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </form>
    </div>


<?php
$formValidator->output();
$db->show_footer();
?>