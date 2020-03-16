<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 2:52 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');
include('transactions_class.php');
$db = new Main();
$db->admin_title = "Accounts - Transactions ";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Accounts Issue Transaction Inserting';

    $transaction = new AccountsTransaction();

    $db->start_transaction();
    if ($transaction->insertAccountsTransaction($_POST) == true) {
        $db->commit_transaction();
        $db->generateSessionAlertSuccess('Transaction Created Successfully');
        header("Location: transactions.php");
        exit();
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($transaction->errorDescription);
        $data = $_POST;
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Accounts Issue Transaction Modifying';

    $transaction = new AccountsTransaction();

    $db->start_transaction();
    if ($transaction->updateAccountsTransaction($_POST) == true) {
        $db->commit_transaction();
        $db->generateSessionAlertSuccess('Transaction Updated Successfully');
        header("Location: transactions.php");
        exit();
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($transaction->errorDescription);
        $_GET['lid'] = $_POST['lid'];
    }

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM 
              `ac_transactions` 
              JOIN ac_documents ON actrn_document_ID = acdoc_document_ID
              LEFT OUTER JOIN ac_entities ON actrn_entity_ID = acet_entity_ID
              WHERE `actrn_transaction_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

} else {
    $data['actrn_period'] = $db->dbSettings['ac_open_period']['value'];
    $data['actrn_year'] = $db->dbSettings['ac_open_year']['value'];
}


$todayDate = date('d/m/Y');

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();
if ($data['actrn_status'] != 'Outstanding' && $_GET['lid'] != '') {
    $formValidator->disableForm(array('buttons'));
}


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

$totalAccountLines = 15;

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">

                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row alert alert-primary text-center">
                        <div class="col-12">
                            <strong>Issue Transaction</strong>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-5 col-form-label">
                            Status: <?php echo $data['actrn_status']; ?>

                            <?php if ($data['actrn_status'] == 'Locked') { ?>
                                <input type="button" class="btn btn-secondary" value="UnLock"
                                       onclick="window.location.assign('transaction_change_status.php?action=issueUnlock&lid=<?php echo $data['actrn_transaction_ID']; ?>')"/>
                                <input type="button" class="btn btn-primary" value="Post"
                                       onclick="window.location.assign('transaction_change_status.php?action=issuePost&lid=<?php echo $data['actrn_transaction_ID']; ?>')"/>
                                <?php
                            }
                            if ($data['actrn_status'] == 'Outstanding') {
                                ?>
                                <input type="button" class="btn btn-secondary" value="Lock"
                                       onclick="window.location.assign('transaction_change_status.php?action=issueLock&lid=<?php echo $data['actrn_transaction_ID']; ?>')"/>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="col-sm-3 col-form-label">
                            Period/Year:
                            <?php echo $data['actrn_period'] . "/" . $data['actrn_year']; ?>
                        </div>

                        <div class="col-sm-4 col-form-label">
                            Transaction Number:
                            <?php echo $data['actrn_transaction_number']; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder([
                            "fieldName" => "fld_document_ID",
                            "fieldDescription" => "Document",
                            "labelClasses" => "col-sm-2",
                            "fieldType" => "select",
                            "inputValue" => $data['actrn_document_ID'],
                            "inputSelectAddEmptyOption" => true
                        ]);
                        $formB->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $docResult = $db->query('
                              SELECT 
                                CONCAT(acdoc_code," - ",acdoc_name)as name,
                                acdoc_document_ID as value
                                FROM ac_documents WHERE acdoc_active = "Active"');
                            $formB->setInputSelectQuery($docResult);
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

                        <div class="col-6">
                            <?php
                            if ($data['actrn_from_module'] != '')
                            echo "From:".$data['actrn_from_module']." ";

                            echo "Comments:".$data['actrn_comments'];
                            ?>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="fld_transaction_date" class="col-sm-2 col-form-label">Transaction Date</label>
                        <div class="col-sm-4">
                            <input name="fld_transaction_date" type="text" id="fld_transaction_date"
                                   value="" onfocusout="transDateFocusOut();"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_transaction_date',
                                    'fieldDataType' => 'date',
                                    'enableDatePicker' => true,
                                    'required' => true,
                                    'datePickerValue' => $db->convert_date_format($data["actrn_transaction_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                            <script>
                                function transDateFocusOut() {
                                    let transDate = $('#fld_transaction_date').val();
                                    let todayDate = '<?php echo $todayDate;?>';
                                    if (transDate == '') {
                                        $('#fld_transaction_date').val(todayDate);
                                    }
                                }
                            </script>
                        </div>

                        <label for="fld_reference_date" class="col-sm-2 col-form-label">Reference Date</label>
                        <div class="col-sm-4">
                            <input name="fld_reference_date" type="text" id="fld_reference_date"
                                   value="<?php echo $data["accat_name"]; ?>" onfocusout="refDateFocusOut()"
                                   class="form-control"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_reference_date',
                                    'fieldDataType' => 'date',
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $db->convert_date_format($data["actrn_reference_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>
                        <script>
                            function refDateFocusOut() {
                                let transDate = $('#fld_reference_date').val();
                                let todayDate = '<?php echo $todayDate;?>';
                                if (transDate == '') {
                                    $('#fld_reference_date').val(todayDate);
                                }
                            }
                        </script>
                    </div>


                    <div class="form-group row">
                        <?php
                        $formB = new FormBuilder([
                            "fieldName" => "fld_entity_ID",
                            "fieldDescription" => "Entity",
                            "labelClasses" => "col-sm-2",
                            "fieldType" => "select",
                            "inputValue" => $data['actrn_entity_ID'],
                            "inputSelectAddEmptyOption" => true
                        ]);
                        $formB->buildLabel();
                        ?>
                        <div class="col-sm-4">
                            <?php
                            $formB->setInputSelectQuery($db->query('
                                SELECT 
                                acet_entity_ID as value,
                                acet_name as name
                                FROM
                                ac_entities
                                WHERE acet_active = "Active"
                            '));
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => 'fld_entity_ID',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'requiredAddedCustomCode' => '|| $("#fld_account_ID").val() == ""',
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 alert alert-secondary text-center">
                            <strong>Lines</strong>
                            &nbsp;&nbsp;<i class="fas fa-plus-circle" style="cursor: pointer"
                                           onclick="insertNewLine();"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-1 m-0 p-0">#</div>
                        <div class="col-sm-4 m-0 p-0">Account</div>
                        <div class="col-sm-2 m-0 p-0 text-center">Debit</div>
                        <div class="col-sm-2 m-0 p-0 text-center">Credit</div>
                        <div class="col-sm-3 m-0 p-0 text-center">Reference</div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <!-- ACCOUNT LINES ---------------------------------------------------------------------------------------------------------------------- -->
                    <script>
                        let lastOpenLine = 0;
                        $(document).key('shift+a', function () {
                            insertNewLine();
                        });

                        function insertNewLine(){
                            lastOpenLine++;
                            $('#line_' + lastOpenLine).show();
                            $('#activeLine_' + lastOpenLine).val(1);
                            calculateDebitCreditTotals();
                        }

                        function deleteLine(lineNum){
                            $('#line_' + lineNum).hide();
                            $('#activeLine_' + lineNum).val(0);
                            calculateDebitCreditTotals();

                            if (lineNum == lastOpenLine){
                                lastOpenLine--;
                            }

                        }
                        function calculateDebitCreditTotals() {
                            let totalDebit = 0;
                            let totalCredit = 0;
                            for (let i = 1; i <= 15; i++) {
                                if ($('#activeLine_' + i).val() == 1) {
                                    totalDebit += $('#accLine_debit_' + i).val() * 1;
                                    totalCredit += $('#accLine_credit_' + i).val() * 1;
                                }

                                if ($('#accLine_debit_' + i).val() != ''){
                                    $('#accLine_credit_' + i).prop('disabled', true);
                                }
                                else if ($('#accLine_credit_' + i).val() != ''){
                                    $('#accLine_debit_' + i).prop('disabled', true);
                                }

                            }
                            $('#totalDebit').html(totalDebit);
                            $('#totalCredit').html(totalCredit);

                            if (totalDebit == totalCredit) {
                                $('#linesValid').val('1');

                                $('#totalDebit').removeClass('alert-danger');
                                $('#totalCredit').removeClass('alert-danger');

                                $('#totalDebit').addClass('alert-success');
                                $('#totalCredit').addClass('alert-success');
                            }
                            else {
                                $('#linesValid').val('0');

                                $('#totalDebit').removeClass('alert-success');
                                $('#totalCredit').removeClass('alert-success');

                                $('#totalDebit').addClass('alert-danger');
                                $('#totalCredit').addClass('alert-danger');
                            }

                        }

                        $( document ).ready(function() {
                            calculateDebitCreditTotals();
                        });
                    </script>
                    <?php
                    if ($_GET['lid'] > 0) {
                        $sql = "SELECT * FROM ac_transaction_lines 
                            WHERE actrl_transaction_ID = " . $data['actrn_transaction_ID']
                            . " ORDER BY actrl_line_number ASC";
                        $result = $db->query($sql);
                        $totalLinesFound = 0;
                        while ($row = $db->fetch_assoc($result)) {
                            $totalLinesFound++;
                            $linesData[$totalLinesFound] = $row;
                        }
                        $result = $db->query($sql);
                    }
                    for ($i = 1; $i <= 15; $i++) {
                        $debitValue = '';
                        $creditValue = '';
                        if ($linesData[$i]['actrl_dr_cr'] == 1){
                            $debitValue = $linesData[$i]['actrl_value'];
                        }
                        else {
                            $creditValue = $linesData[$i]['actrl_value'];
                        }
                        ?>
                        <div class="row" id="line_<?php echo $i;?>" style="display: none;">
                            <input type="hidden" id="activeLine_<?php echo $i;?>"
                                   name="activeLine_<?php echo $i;?>" value="0">
                            <div class="col-sm-1 m-0 p-0">
                                <?php echo $i;?>
                                <i class="fas fa-minus-circle" style="cursor: pointer"
                                   onclick="deleteLine(<?php echo $i;?>);"></i>
                            </div>
                            <div class="col-sm-4 m-0 p-0">
                                <?php
                                $formB = new FormBuilder([
                                    "fieldName" => "accLine_account_ID_".$i,
                                    "fieldType" => "select",
                                    "inputValue" => $linesData[$i]['actrl_account_ID'],
                                    "inputSelectAddEmptyOption" => true
                                ]);
                                $formB->setInputSelectQuery($db->query('
                                SELECT 
                                acacc_account_ID as value,
                                CONCAT(acacc_code," - ",acacc_name) as name
                                FROM
                                ac_accounts
                                WHERE acacc_active = "Active" AND acacc_control = 0
                                ORDER BY acacc_code ASC, acacc_name ASC
                            '));
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'select',
                                        'required' => true,
                                        'invalidTextAutoGenerate' => true,
                                        'requiredAddedCustomCode' => ' && $("#activeLine_'.$i.'").val() == 1'
                                    ]);
                                ?>
                            </div>
                            <!-- DEBIT -->
                            <div class="col-sm-2 m-0 p-0">
                                <?php
                                $formB = new FormBuilder([
                                    "fieldName" => "accLine_debit_".$i,
                                    "fieldType" => "input",
                                    "fieldInputType" => 'text',
                                    "inputExtraClasses" => 'text-center',
                                    "fieldOnKeyUp" => 'calculateDebitCreditTotals();',
                                    "inputValue" => $debitValue
                                ]);
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'Debit Required',
                                        'requiredAddedCustomCode' => ' && $("#activeLine_'.$i.'").val() == 1 && $("#accLine_credit_' . $i . '").val() == ""'
                                    ]);
                                ?>
                            </div>
                            <!-- CREDIT -->
                            <div class="col-sm-2 m-0 p-0">
                                <?php
                                $formB = new FormBuilder([
                                    "fieldName" => "accLine_credit_".$i,
                                    "fieldType" => "input",
                                    "fieldInputType" => 'text',
                                    "inputExtraClasses" => 'text-center',
                                    "fieldOnKeyUp" => 'calculateDebitCreditTotals();',
                                    "inputValue" => $creditValue
                                ]);
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'number',
                                        'required' => true,
                                        'invalidText' => 'Credit Required',
                                        'requiredAddedCustomCode' => ' && $("#activeLine_'.$i.'").val() == 1 && $("#accLine_debit_' . $i . '").val() == ""'
                                    ]);
                                ?>
                            </div>
                            <!-- REFERENCE -->
                            <div class="col-sm-3 m-0 p-0">
                                <?php
                                $formB = new FormBuilder([
                                    "fieldName" => "accLine_reference_".$i,
                                    "fieldType" => "input",
                                    "fieldInputType" => 'text',
                                    "inputExtraClasses" => 'text-center',
                                    "inputValue" => $linesData[$i]['actrl_reference']
                                ]);
                                $formB->buildInput();
                                $formValidator->addField(
                                    [
                                        'fieldName' => $formB->fieldName,
                                        'fieldDataType' => 'text',
                                        'required' => false,
                                        'invalidText' => 'Reference Required',
                                        'requiredAddedCustomCode' => '',
                                    ]);
                                ?>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                    <script>

                        function showLines(totalToShow){
                            for(let i=1; i <= totalToShow; i++){
                                insertNewLine();
                            }
                        }
                        <?php
                                echo "showLines(".$totalLinesFound.");";
                        ?>
                    </script>

                    <div class="row">
                        <div class="col-sm-5">
                            <input type="hidden" id="linesValid" name="linesValid" value="0">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'linesValid',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidText' => 'Error',
                                    'requiredAddedCustomCode' => ' || $("#linesValid").val() != 1',
                                ]);
                            ?>

                        </div>
                        <div class="col-sm-2 m-0 p-0 text-center" id="totalDebit">0</div>
                        <div class="col-sm-2 m-0 p-0 text-center" id="totalCredit">0</div>
                    </div>

                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('transactions.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Transaction"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>


            </div>
            <div class="col-1 d-none d-md-block"></div>
        </div>
    </div>
    <script>

    </script>
<?php
$formValidator->output();
$db->show_footer();
?>