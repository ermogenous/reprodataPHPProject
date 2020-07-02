<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 15/06/2020
 * Time: 11:19
 */

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
include("../../../tools/table_list.php");

$db = new Main(1);
$db->admin_title = "Accounts - Reports - Transaction List";

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

//reload the post from the session kept by TableList
if ($_SESSION['ac_report_trans_list']['sch_period_from'] != '') {
    $_POST['sch_period_from'] = $_SESSION['ac_report_trans_list']['sch_period_from'];
}
if ($_SESSION['ac_report_trans_list']['sch_period_to'] != '') {
    $_POST['sch_period_to'] = $_SESSION['ac_report_trans_list']['sch_period_to'];
}
if ($_SESSION['ac_report_trans_list']['sch_outstanding'] != '') {
    $_POST['sch_outstanding'] = $_SESSION['ac_report_trans_list']['sch_outstanding'];
}
if ($_SESSION['ac_report_trans_list']['sch_locked'] != '') {
    $_POST['sch_locked'] = $_SESSION['ac_report_trans_list']['sch_locked'];
}
if ($_SESSION['ac_report_trans_list']['sch_posted'] != '') {
    $_POST['sch_posted'] = $_SESSION['ac_report_trans_list']['sch_posted'];
}

if ($_POST['sch_print'] != 'Print') {
    $db->enable_jquery_ui();
    $db->enable_rxjs_lite();
    $db->show_header();
    FormBuilder::buildPageLoader();
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-sm-12 col-md-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Report - Transaction List</b>
                    </div>
                </div>
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_period_from')
                            ->setFieldDescription('Period From:')
                            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_period_from'])
                            ->setFieldStyle('text-align: center')
                            ->buildLabel();
                        ?>
                        <div class="col-xs-12 col-sm-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['sch_period_from']
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_period_to')
                            ->setFieldDescription('Period To:')
                            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_period_to'])
                            ->setFieldStyle('text-align: center')
                            ->buildLabel();
                        ?>
                        <div class="col-xs-12 col-sm-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['sch_period_to']
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="row input-group form-group">
                        <div class="col-12 form-inline">
                            <?php
                            $formB = new FormBuilder();
                            $formB->setFieldName('sch_outstanding')
                                ->setFieldDescription('Outstanding')
                                ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                                ->setFieldType('checkbox')
                                ->setInputValue($_POST['sch_outstanding'])
                                ->setInputCheckBoxValue(1)
                                ->setFieldStyle('text-align: center')
                                ->buildLabel()->buildInput();

                            $formB->setFieldName('sch_locked')
                                ->setFieldDescription('Locked')
                                ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                                ->setFieldType('checkbox')
                                ->setInputValue($_POST['sch_locked'])
                                ->setInputCheckBoxValue(1)
                                ->buildLabel()->buildInput();

                            $formB->setFieldName('sch_posted')
                                ->setFieldDescription('Posted')
                                ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                                ->setFieldType('checkbox')
                                ->setInputValue($_POST['sch_posted'])
                                ->setInputCheckBoxValue(1)
                                ->buildLabel()->buildInput();

                            $printOptions = [
                                'Show' => 'Show',
                                'Print' => 'Print'
                            ];
                            $formB->setFieldName('sch_print')
                                ->setFieldDescription('Print Report')
                                ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                                ->setFieldType('select')
                                ->setInputValue($_POST['sch_print'])
                                ->setInputSelectArrayOptions($printOptions)
                                ->buildLabel()->buildInput();
                            ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="hidden" id="action" name="action" value="show">
                            <input type="submit" value="Show Report" class="form-control btn btn-primary"
                                   style="width: 180px;">
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <div class="col-1 d-none d-md-block"></div>
    </div>
    </div>
    <?php
}
//show the report
if ($_POST['action'] == 'show') {
    //load the data into a session
    $_SESSION['ac_report_trans_list'] = $_POST;
}

if ($_SESSION['ac_report_trans_list']['action'] == 'show') {
    ?>
    <div class="row" style="height: 25px"></div>
    <?php
    $where_status = '';
    $where = '1=1 ';
    if ($_POST['sch_outstanding'] == 1) {
        $where_status .= '"Outstanding",';
    }
    if ($_POST['sch_locked'] == 1) {
        $where_status .= '"Locked",';
    }
    if ($_POST['sch_posted'] == 1) {
        $where_status .= '"Active",';
    }
    if ($where_status != '') {
        $where_status = $db->remove_last_char($where_status);
        $where .= ' AND actrn_status IN (' . $where_status . ')';
    }

    if ($_POST['sch_period_from'] != '') {
        $where .= ' AND actrn_transaction_date >= "' . $db->convertDateToUS($_POST['sch_period_from']) . '"';
    }
    if ($_POST['sch_period_to'] != '') {
        $where .= ' AND actrn_transaction_date <= "' . $db->convertDateToUS($_POST['sch_period_to']) . '"';
    }

    $list = new TableList();
    $list->setTable('ac_transactions', 'accountsReportTransactionList')
        ->setSqlFrom('JOIN ac_transaction_lines ON actrn_transaction_ID = actrl_transaction_ID')
        ->setSqlFrom('JOIN ac_accounts ON acacc_account_ID = actrl_account_ID')
        ->setSqlSelect('actrn_transaction_ID', 'TransID')
        ->setSqlSelect('actrn_status', 'Status')
        ->setSqlSelect('actrn_transaction_date', 'TransDate', ['functionName' => 'convertDate'])
        ->setSqlSelect('acacc_code', 'Account')
        ->setSqlSelect('IF (actrl_dr_cr = 1 , actrl_value , 0)', 'Debit')
        ->setSqlSelect('IF (actrl_dr_cr = -1 , actrl_value , 0)', 'Credit')
        ->setSqlWhere($where)
        //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
        ->setSqlOrder('actrn_transaction_date DESC, actrn_transaction_ID ASC, actrl_line_number', 'ASC')
        ->setPerPage(100)
        ->generateData();

//echo $list->getSql();

    $list->setMainColumn('col-lg-10')
        ->setTopTitle('Transaction List')
        ->setTopContainerToFluid()
        ->setLeftColumn('col-lg-1')
        ->setRightColumn('col-lg-1')
        ->showPagesLinksTop()
        ->showPagesLinksBottom()
        ->setDisableDeleteICon()
        ->setMainFieldID('TransID')
        ->setModifyLink('../../transactions/transaction_modify.php?lid=', '_blank');

    if ($_POST['sch_print'] == 'Print') {
        $list->setOutputAsPDF();
    }
    //->setFunctionIconArea('IconsFunction')
    $list->tableFullBuilder();


}//if to show report
function convertDate($date)
{
    global $db;
    return $db->convertDateFormat($date, 'dd/mm/yyyy');
}

?>

<?php
if ($_POST['sch_print'] != 'Print') {
    $formValidator->output();
    $db->show_footer();
}
?>