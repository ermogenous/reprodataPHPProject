<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/7/2019
 * Time: 2:52 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('transactions_class.php');
$db = new Main();
$db->admin_title = "Accounts";

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
              LEFT OUTER JOIN ac_accounts ON actrn_account_ID = acacc_account_ID
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

$totalAccountLines = 15;

?>
    <div id="pageLoadingDialog" title="" style="display: none;">
        <img src="../../images/icon_spinner_transparent.gif">
    </div>
    <script>

        $("#pageLoadingDialog").dialog({
            autoOpen: true,
            show: "slide",
            modal: true,
            height: 180,
            width: 150,
            create: function () {
                $(".ui-dialog").find(".ui-dialog-titlebar").css({
                    'background-image': 'none',
                    'background-color': 'white',
                    'border': 'none'
                });
            },
            closeOnEscape: false,
            open: function (event, ui) {
                $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
            }

        });

        $(document).ready(function () {
            $("#pageLoadingDialog").dialog('close');

            //in case modify execute few functions to load the page

            <?php if ($_GET['lid'] > 0) {?>
            //load the document
            documentAutoSelect();
            loadAccountByCode();
            <?php } ?>

        });
    </script>


    <div class="container">
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
                                       onclick="window.location.assign('transaction_change_status.php?action=issueLock&lid=<?php echo $data['actrn_transaction_ID'];?>')"/>
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
                        <label for="documentCode" class="col-sm-2 col-form-label">Document</label>
                        <div class="col-sm-3">
                            <input name="documentCode" type="text" id="documentCode"
                                   value="<?php echo $data["acdoc_code"]; ?>"
                                   class="form-control" onchange="documentAutoSelect();"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'documentCode',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'requiredAddedCustomCode' => '|| $("#fld_document_ID").val() == ""',
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                            <input type="hidden" id="fld_document_ID" name="fld_document_ID" value="">
                        </div>
                        <div class="col-sm-1">
                            <img src="../../images/icon_spinner_transparent.gif" height="35px" style="display: none"
                                 id="doc_spinner">
                            <img src="../../images/icon_correct_green.gif" height="35px" style="display: none"
                                 id="doc_correct">
                            <img src="../../images/icon_error_x_red.gif" height="35px" style="display: none"
                                 id="doc_error">
                        </div>
                        <div class="col-sm-6 col-form-label" id="documentSelectedValue"></div>

                        <script>
                            //autocomplete
                            $('#documentCode').autocomplete({
                                source: '../documents/documents_api.php?section=searchDocuments',
                                delay: 1000,
                                minLength: 1,
                                messages: {
                                    noResults: '',
                                    results: function () {
                                        //console.log('customer auto');
                                    }
                                },
                                search: function (event, ui) {

                                },
                                focus: function (event, ui) {
                                    $('#documentCode').val(ui.item.document_code);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $('#documentCode').val(ui.item.document_code);
                                    $('#fld_document_ID').val(ui.item.value);
                                    $('#documentSelectedValue').html(ui.item.label + ' - Last Number: ' + ui.item.clo_last_number_used);

                                    $('#doc_spinner').hide();

                                    return false;
                                }
                            });

                            function documentAutoSelect() {
                                $('#doc_correct').hide();
                                $('#doc_error').hide();
                                $('#doc_spinner').show();

                                let inputCode = $('#documentCode').val();
                                Rx.Observable.fromPromise($.get("../documents/documents_api.php?section=getFirstDocumentByCode&term=" + inputCode))
                                    .subscribe((response) => {
                                            data = response;
                                            //console.log(data);
                                        },
                                        () => {
                                            $('#doc_error').show();
                                            $('#documentSelectedValue').html('Error finding the document');
                                        }
                                        ,
                                        () => {
                                            $('#doc_spinner').hide();
                                            if (data != null) {
                                                $('#documentCode').val(data[0]['document_code']);
                                                $('#fld_document_ID').val(data[0]['value']);
                                                $('#documentSelectedValue').html(data[0]['label'] + ' - Last Number: ' + data[0]['clo_last_number_used']);
                                                $('#doc_correct').show();
                                            } else {
                                                $('#doc_error').show();
                                                $('#documentSelectedValue').html('Error finding the document');
                                                $('#fld_document_ID').val('');
                                            }

                                        }
                                    )
                                ;
                            }
                        </script>


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
                        <label for="accountCode" class="col-sm-2 col-form-label">
                            Account &nbsp;
                            <img src="../../images/icon_list_transparent.gif" height="20" style="cursor: pointer;"
                                 id="accountOverlayOpener">
                        </label>
                        <div class="col-sm-3">
                            <input name="accountCode" type="text" id="accountCode"
                                   value="<?php echo $data["acacc_code"]; ?>"
                                   class="form-control" onchange="loadAccountByCode();"/>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'accountCode',
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'requiredAddedCustomCode' => '|| $("#fld_account_ID").val() == ""',
                                ]);
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <img src="../../images/icon_spinner_transparent.gif" height="35px" style="display: none"
                                 id="acc_spinner">
                            <img src="../../images/icon_correct_green.gif" height="35px" style="display: none"
                                 id="acc_correct">
                            <img src="../../images/icon_error_x_red.gif" height="35px" style="display: none"
                                 id="acc_error">
                            <input type="hidden" id="fld_account_ID" name="fld_account_ID" value="">
                        </div>
                        <div class="col-sm-6 col-form-label" id="accountSelectDiv"></div>

                        <div id="accountDialog" title="Select Account" style="display: none;">
                            <iframe src="accounts_list_modal.php" width="100%" height="100%" frameborder="0"></iframe>
                        </div>

                        <script>

                            $('#accountCode').autocomplete({
                                source: '../accounts/accounts_api.php?section=searchAccounts',
                                delay: 1000,
                                minLength: 1,
                                messages: {
                                    noResults: '',
                                    results: function () {
                                        //console.log('customer auto');
                                    }
                                },
                                search: function (event, ui) {

                                },
                                focus: function (event, ui) {
                                    $('#accountCode').val(ui.item.document_code);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $('#accountCode').val(ui.item.document_code);
                                    loadAccountByCode();
                                    return false;
                                }
                            });

                            function loadAccountByCode() {
                                let accCode = $('#accountCode').val();
                                let inputCode = $('#accountCode').val();

                                $('#acc_spinner').show();
                                $('#acc_correct').hide();
                                $('#acc_error').hide();


                                Rx.Observable.fromPromise($.get("../accounts/accounts_api.php?section=getFirstAccountByID&value=" + inputCode))
                                    .subscribe((response) => {
                                            data = response;
                                        },
                                        () => {
                                            $('#acc_error').show();
                                            $('#acc_spinner').hide();
                                            $('#accountSelectDiv').html('Error finding the account');
                                            $('#fld_account_ID').val('');
                                        }
                                        ,
                                        () => {
                                            $('#acc_spinner').hide();
                                            if (data != null) {
                                                $('#acc_correct').show();
                                                $('#accountSelectDiv').html(data['acacc_code'] + ' - ' + data['acacc_name']);
                                                $('#accountCode').val(data['acacc_code']);
                                                $('#fld_account_ID').val(data['acacc_account_ID']);
                                            }
                                            else {
                                                $('#acc_error').show();
                                                $('#accountSelectDiv').html('Error finding the account');
                                                $('#fld_account_ID').val('');
                                            }

                                        }
                                    )
                                ;


                            }

                            //MODAL
                            $(function () {
                                $("#accountDialog").dialog({
                                    autoOpen: false,
                                    height: 600,
                                    width: 500,
                                    modal: true,
                                    show: {
                                        effect: "blind",
                                        duration: 1000
                                    },
                                    hide: {
                                        effect: "explode",
                                        duration: 1000
                                    }
                                });

                                $("#accountOverlayOpener").on("click", function () {
                                    $("#accountDialog").dialog("open");
                                });
                            });

                            window.loadAccount = function (code) {
                                $("#accountCode").val(code);
                                $("#accountDialog").dialog("close");
                                loadAccountByCode();
                            }
                        </script>

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
                        <div class="col-sm-2 m-0 p-0 text-center">Account</div>
                        <div class="col-sm-4 m-0 p-0 text-center">Account Name</div>
                        <div class="col-sm-1 m-0 p-0 text-center">Debit</div>
                        <div class="col-sm-1 m-0 p-0 text-center">Credit</div>
                        <div class="col-sm-3 m-0 p-0 text-center">Reference</div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <!-- ACCOUNT LINES ---------------------------------------------------------------------------------------------------------------------- -->
                    <?php

                    for ($i = 1; $i <= $totalAccountLines; $i++) {
                        echo '
                            <div id="accountLinesDiv_' . $i . '" class="row" style="display: none;">
                                <input type="hidden" id="activeLine_' . $i . '" name="activeLine_' . $i . '" value="0">
                                <div class="col-sm-1 m-0 p-0">
                                ' . $i . '
                                <i class="fas fa-minus-circle" style="cursor: pointer" onclick="deleteAccountLine(' . $i . ');"></i>
                                </div>
                                <div class="col-sm-2 m-0 p-0">
                                    <input type="text" name="accLineAccount_' . $i . '" id="accLineAccount_' . $i . '"
                                        value="" class="form-control" onchange="loadLineAccount(' . $i . ');"/>
                                        ';
                        $formValidator->addField(
                            [
                                'fieldName' => 'accLineAccount_' . $i,
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Account',
                                'requiredAddedCustomCode' => '&& $("#activeLine_' . $i . '").val() == "1"',
                            ]);
                        echo $formValidator::getAutoCompleteJSCode('accLineAccount_' . $i,
                            [
                                'source' => '../accounts/accounts_api.php?section=searchAccounts',
                                'minLength' => 1,
                                'selectCode' => '$("#accLineAccount_' . $i . '").val(ui.item.document_code);'
                            ]);

                        echo '
                                </div>
                                <div class="col-sm-4 m-0 p-0 d-inline-block">
                                    <div id="accountLineNameErrorText_' . $i . '"></div>
                                    <table>
                                        <tr>
                                            <td>
                                                <img src="../../images/icon_spinner_transparent.gif" height="25px" style="display: none" id="lineSpinner_' . $i . '">
                                                <img src="../../images/icon_correct_green.gif" height="25px" style="display: none" id="lineCorrect_' . $i . '">
                                                <img src="../../images/icon_error_x_red.gif" height="25px" style="display: none" id="lineError_' . $i . '">
                                            </td>
                                            <td>
                                                <input type="hidden" id="accLine_account_ID_' . $i . '" name="accLine_account_ID_' . $i . '" value="">
                                                <div id="accountLineName_' . $i . '" style="font-size: 12px;"></div>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    
                                </div>
                                <div class="col-sm-1 m-0 p-0">
                                    <input type="text" name="accLine_debit_' . $i . '" id="accLine_debit_' . $i . '"
                                        value="" class="form-control" onkeyup="checkDebitCreditField(' . $i . ')"/>';
                        $formValidator->addField(
                            [
                                'fieldName' => 'accLine_debit_' . $i,
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Dr.',
                                'requiredAddedCustomCode' => '&& $("#activeLine_' . $i . '").val() == "1" && $("#accLine_credit_' . $i . '").val() == "" ',
                            ]);
                        echo '
                                </div>
                                <div class="col-sm-1 m-0 p-0">
                                    <input type="text" name="accLine_credit_' . $i . '" id="accLine_credit_' . $i . '"
                                        value="" class="form-control" onkeyup="checkDebitCreditField(' . $i . ')"/>';
                        $formValidator->addField(
                            [
                                'fieldName' => 'accLine_credit_' . $i,
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidText' => 'Enter Cr.',
                                'requiredAddedCustomCode' => '
                                    && $("#activeLine_' . $i . '").val() == "1" 
                                    && $("#accLine_debit_' . $i . '").val() == ""
                                     
                                ',
                            ]);
                        echo '
                                </div>
                                <div class="col-sm-3 m-0 p-0">
                                    <input type="text" name="accLine_reference_' . $i . '" id="accLine_reference_' . $i . '"
                                        value="" class="form-control"/>';
                        $formValidator->addField(
                            [
                                'fieldName' => 'accLine_reference_' . $i,
                                'fieldDataType' => 'text',
                                'required' => false
                            ]);
                        echo '
                                
                                </div>                            
                            </div>';
                    }
                    ?>

                    <div class="row">
                        <div class="col-sm-7">
                            <input type="hidden" id="linesValid" name="linesValid" value="0">
                            <input type="hidden" id="totalAccountLines" name="totalAccountLines"
                                   value="<?php echo $totalAccountLines; ?>">
                        </div>
                        <div class="col-sm-1 m-0 p-0 text-center" id="totalDebit">0</div>
                        <div class="col-sm-1 m-0 p-0 text-center" id="totalCredit">0</div>
                    </div>

                    <script>

                        <?php
                        echo $formValidator::getPromiseJSCode(
                            [
                                'source' => '../accounts/accounts_api.php?section=getFirstAccountByID',
                                'functionName' => 'loadLineAccount(lineID)',
                                'sourceField' => '"#accLineAccount_" + lineID',
                                'spinnerIcon' => '"#lineSpinner_" + lineID',
                                'errorIcon' => '"#lineError_" + lineID',
                                'correctIcon' => '"#lineCorrect_" + lineID',
                                'errorField' => '"#accountLineName_" + lineID',
                                'ifDataJSCode' => '
                        $("#accLine_account_ID_" + lineID).val(data["acacc_account_ID"]);
                        $("#accountLineName_" + lineID).html(data["acacc_name"]);
                        $("#accLineAccount_" + lineID).val(data["acacc_code"]);
                        ',
                                'ifNoDataJSCode' => '
                        $("#accLine_account_ID_" + line_ID).val("");
                        $("#accountLineName_" + lineID).html("No Account Found");
                        '
                            ]);
                        ?>



                        function checkDebitCreditField(line) {
                            let debit = $("#accLine_debit_" + line).val();
                            let credit = $("#accLine_credit_" + line).val();

                            $("#accLine_credit_" + line).prop('disabled', false);
                            $("#accLine_debit_" + line).prop('disabled', false);

                            if (debit != '') {
                                $("#accLine_credit_" + line).prop('disabled', true);
                            }
                            if (credit != '') {
                                $("#accLine_debit_" + line).prop('disabled', true);
                            }
                            calculateDebitCreditTotals();

                        }

                        function calculateDebitCreditTotals() {
                            let totalDebit = 0;
                            let totalCredit = 0;
                            for (i = 1; i <= <?php echo $totalAccountLines;?>; i++) {
                                if ($('#activeLine_' + i).val() == 1) {
                                    totalDebit += $('#accLine_debit_' + i).val() * 1;
                                    totalCredit += $('#accLine_credit_' + i).val() * 1;
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

                        $(document).key('shift+a', function () {
                            insertNewLine();
                        });

                        let totalAccountLines = 0;

                        function insertNewLine() {
                            if (totalAccountLines >= <?php echo $totalAccountLines;?>) {
                                alert('Reached the Max Limit of lines');
                            }
                            else {
                                insertNewAccountLine();
                            }
                        }

                        function insertNewAccountLine() {
                            totalAccountLines++;

                            $('#accountLinesDiv_' + totalAccountLines).show();
                            $('#activeLine_' + totalAccountLines).val('1');
                        }

                        function deleteAccountLine(id) {
                            $('#accountLinesDiv_' + id).hide();
                            $('#activeLine_' + id).val('0');

                            //fix totalAccountLines
                            let lastFound = 1;
                            for (g = 1; g <= <?php echo $totalAccountLines;?>; g++) {
                                if ($('#activeLine_' + g).val() == 1) {
                                    lastFound = g;
                                }
                            }
                            totalAccountLines = lastFound;
                            calculateDebitCreditTotals();
                        }

                        //if modify create and fill the lines
                        <?php
                        if ($_GET['lid'] > 0) {
                            $sql = 'SELECT * FROM 
                                              ac_transaction_lines 
                                              JOIN ac_accounts ON acacc_account_ID = actrl_account_ID
                                              WHERE actrl_transaction_ID = ' . $_GET['lid'] . " ORDER BY actrl_line_number ASC";
                            $result = $db->query($sql);
                            while ($line = $db->fetch_assoc($result)) {

                                if ($line['actrl_dr_cr'] == 1) {
                                    $debit = $line['actrl_value'];
                                    $credit = '';
                                } else {
                                    $debit = '';
                                    $credit = $line['actrl_value'];
                                }

                                echo 'insertNewLine();
                                        ';
                                //load the data
                                echo '$("#accLineAccount_' . $line['actrl_line_number'] . '").val("' . $line['acacc_code'] . '");
                                        loadLineAccount(' . $line['actrl_line_number'] . ');
                                        ';
                                echo '$("#accLine_debit_' . $line['actrl_line_number'] . '").val("' . $debit . '");
                                        ';
                                echo '$("#accLine_credit_' . $line['actrl_line_number'] . '").val("' . $credit . '");
                                        ';
                                echo 'checkDebitCreditField(' . $line['actrl_line_number'] . ');
                                        ';
                                echo '$("#accLine_reference_' . $line['actrl_line_number'] . '").val("' . $line['actrl_reference'] . '");
                                        ';
                            }
                        }//if modify
                        ?>

                    </script>

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