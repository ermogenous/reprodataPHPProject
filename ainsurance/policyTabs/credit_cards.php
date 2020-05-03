<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 20/04/2020
 * Time: 12:26
 */

include("../../include/main.php");
include("../policy_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include("../credit_cards_remote/credit_card_class.php");

$db = new Main(1);
$db->admin_title = "";

$policyFound = false;
$creditCardExists = false;
if ($_GET['pid'] > 0) {
    $policy = new Policy($_GET['pid']);
    if ($policy->policyData['inapol_policy_ID'] > 0) {
        $policyFound = true;
        $policyStatus = $policy->policyData['inapol_status'];

        //get the credit card if exsits
        $creditCard = new MECreditCards($policy->policyData['inapol_credit_card_ID']);
        if ($creditCard->getData()['inacrc_credit_card_ID'] > 0) {
            $creditCardExists = true;
        } else {
            $creditCardExists = false;
        }
    } else {
        $policyFound = false;
    }
}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();
FormBuilder::buildPageLoader();

?>
    <div class="container">

        <div class="row">
            <div class="col-11 alert alert-primary text-center">
                Credit Cards
            </div>
            <div class="col-1 alert alert-primary text-center">
                <img src="../../images/spinner-transparent.gif" height="25" id="connectionTestSpinner">
                <img src="../../images/icon_correct_green.gif" height="25" id="connectionTestCorrect"
                     style="display: none;">
                <img src="../../images/icon_error_x_red.gif" height="25" id="connectionTestError"
                     style="display: none;">
                <input type="hidden" id="conTestValue" name="conTestValue" value="0">
            </div>
        </div>
        <div class="row" id="errorConnectingRow" style="display: none">
            <div class="col-12 alert alert-danger text-center">
                There was a problem connecting to the credit card remote system. Contact the administrator
            </div>
        </div>

    </div>

    <script>
        <?php
        //create the rxjs function to get the connection string
        $connectionStringSettings = [
            'functionName' => 'connectionTest()',
            'source' => '"'.$main['site_url'] . '/ainsurance/credit_cards_remote/credit_cards_api.php?action=getTestConnectionString"',
            'successJSCode' => " 
                //console.log(data.conString);
                connectionMakeTest(data.conString);
            "
        ];
        echo customFormValidator::getPromiseJSCodeV2($connectionStringSettings);

        //create the rxjs function to go at the rcb remote and get the data
        $connectionTestSettings = [
            'functionName' => 'connectionMakeTest(connString)',
            'source' => "connString",
            'successJSCode' => '
                //console.log("Remote");
                //console.log(data.testConnection);
                if (data.testConnection == "Yes"){
                    $("#connectionTestSpinner").hide();
                    $("#connectionTestCorrect").show();
                    $("#errorConnectingRow").hide();
                    $("#conTestValue").val(1);
                    //console.log($("#conTestValue").val());
                }
                else {
                    $("#connectionTestSpinner").hide();
                    $("#connectionTestError").show();
                    $("#errorConnectingRow").show();
                    //console.log("NO");
                }
            '
        ];
        echo customFormValidator::getPromiseJSCodeV2($connectionTestSettings);



        ?>

        $(document).ready(function () {
            //console.log('ready');
            connectionTest();
        });
    </script>

<?php
$formValidator->output();
$db->show_empty_footer();
?>


<?php
function createNewCardForm()
{
    global $formValidator;
    ?>
    <form name="myForm" id="myForm" method="post" action="" onsubmit=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="row form-group form-inline">
            <?php
            $formB = new FormBuilder();
            $formB->setFieldName('fld_credit_card')
                ->setFieldDescription('Credit Card Number')
                ->setLabelClasses('col-sm-2')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue('')
                ->buildLabel();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
            <div class="col-3">
                <?php
                $formB->buildInput();
                ?>
            </div>
            <?php
            $month = [];
            for ($i = 1; $i <= 12; $i++) {
                $month[$i] = $i;
            }

            $formB->setFieldName('fld_expiry_month')
                ->setFieldDescription('Expiry')
                ->setLabelClasses('col-sm-1')
                ->setFieldType('select')
                ->setInputSelectAddEmptyOption(true)
                ->setInputSelectArrayOptions($month)
                ->setInputValue('')
                ->buildLabel();
            ?>
            <div class="col-2">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidText' => 'Required'
                    ]);
                $year = [];
                $d = date("Y");
                for ($i = $d; $i <= $d + 5; $i++) {
                    $year[$i] = $i;
                }
                $formB->setFieldName('fld_expiry_year')
                    ->setFieldType('select')
                    ->setInputSelectArrayOptions($year)
                    ->setInputSelectAddEmptyOption(true)
                    ->setInputValue('')
                    ->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidText' => 'Required'
                    ]);
                ?>
            </div>
            <?php
            $formB->setFieldName('fld_ccv')
                ->setFieldDescription('CCV')
                ->setLabelClasses('col-sm-1')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue('')
                ->buildLabel();
            ?>
            <div class="col-1">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'number',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-12 center-block text-center">
                <input type="hidden" name="action" id="action" value="newCardEntry">
                <input type="hidden" name="pid" id="pid" value="<?php echo $_GET['pid']; ?>>">
                <input type="submit" value="Create New Card" class="btn btn-primary">
            </div>
        </div>
    </form>
    <?php
}

?>