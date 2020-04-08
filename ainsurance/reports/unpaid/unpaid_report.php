<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/3/2020
 * Time: 11:09 ΜΜ
 */

include("../../../include/main.php");
include("../customers_due_collect.php");
include('../../../scripts/form_validator_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Unpaid Installments Report";

$db->enable_jquery_ui();
$db->show_header();

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();
?>
<div class="container">
    <div class="row">
        <div class="col-12 alert alert-primary text-center">
            <b>Filter Unpaid</b>
        </div>
    </div>
    <form method="post">
        <div class="row form-group">
            <label for="asAtDate" class="col-form-label col-2">As At Date</label>
            <div class="col-2">
                <input class="form-control" type="text" id="asAtDate" name="asAtDate">
                <?php
                if ($_POST['asAtDate'] == ''){
                    $_POST['asAtDate'] = date('d/m/Y');
                }
                $formValidator->addField(
                    [
                        'fieldName' => 'asAtDate',
                        'fieldDataType' => 'date',
                        'enableDatePicker' => true,
                        'datePickerValue' => $_POST['asAtDate'],
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
            <label for="agent" class="col-form-label col-1">Agent</label>
            <div class="col-3">
                <select class="form-control" id="agent" name="agent">
                    <option value="ALL">All</option>
                    <?php
                    $sql = "SELECT * FROM
                    ina_underwriters
                    JOIN users ON usr_users_ID = inaund_user_ID
                    WHERE
                    inaund_status = 'Active'
                    AND inaund_subagent != 0 
                    ORDER BY usr_name ASC";
                    $result = $db->query($sql);
                    while ($row = $db->fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $row['inaund_underwriter_ID'];?>"
                                <?php if ($row['inaund_underwriter_ID'] == $_POST['agent']) echo "selected='selected'";?>>
                                <?php echo $row['usr_name'];?>
                            </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <label for="agent" class="col-form-label col-1">Type</label>
            <div class="col-3">
                <select class="form-control" id="insurance_type" name="insurance_type">
                    <option value="ALL">All</option>
                    <option value="Motor" <?php if ($_POST['insurance_type'] == 'Motor')echo 'selected="selected"';?>>Motor</option>
                    <option value="Fire" <?php if ($_POST['insurance_type'] == 'Fire')echo 'selected="selected"';?>>Fire</option>
                    <option value="PA" <?php if ($_POST['insurance_type'] == 'PA')echo 'selected="selected"';?>>PA</option>
                    <option value="EL" <?php if ($_POST['insurance_type'] == 'EL')echo 'selected="selected"';?>>EL</option>
                    <option value="PI" <?php if ($_POST['insurance_type'] == 'PI')echo 'selected="selected"';?>>PI</option>
                    <option value="PL" <?php if ($_POST['insurance_type'] == 'PL')echo 'selected="selected"';?>>PL</option>
                    <option value="Medical" <?php if ($_POST['insurance_type'] == 'Medical')echo 'selected="selected"';?>>Medical</option>
                    <option value="Travel" <?php if ($_POST['insurance_type'] == 'Travel')echo 'selected="selected"';?>>Travel</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <input type="submit" class="form-control alert-primary" value="Search">
        </div>
    </form>
</div>
<?php

if ($_POST['asAtDate'] == ''){
    //$_POST['asAtDate'] = date('d/m/Y');
}
$filters = [];
if ($_POST['agent'] != '' && $_POST['agent'] != 'ALL'){
    $filters['agent'] = $_POST['agent'];
}
if ($_POST['insurance_type'] != '' && $_POST['insurance_type'] != 'ALL'){
    $filters['insuranceType'] = $_POST['insurance_type'];
}

echo customers_due_collect($_POST['asAtDate'],'',$filters);

$db->show_footer();