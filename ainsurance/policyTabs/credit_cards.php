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
} else {
    //pid is required
    exit();
}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();
FormBuilder::buildPageLoader();

?>
    <div class="container-fluid">

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
                There was a problem connecting to the credit card remote system. Contact the administrator.
            </div>
        </div>


    </div>

    <div class="container-fluid" id="mainContainer" style="display: none">
        <?php
        createNewCardForm();
        ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                Console
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="console"></div>
        </div>
    </div>

    <script>
        <?php
        //create the rxjs function to get the connection string
        $connectionStringSettings = [
            'functionName' => 'connectionTest()',
            'source' => '"' . $main['site_url'] . '/ainsurance/credit_cards_remote/credit_cards_api.php?action=getTestConnectionString"',
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
                    $("#mainContainer").show();
                    //console.log($("#conTestValue").val());
                }
                else {
                    $("#connectionTestSpinner").hide();
                    $("#connectionTestError").show();
                    $("#errorConnectingRow").show();
                    $("#mainContainer").hide();
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

        function updateConsole(text) {
            let currentText = $('#console').html();
            $('#console').html(currentText + '<br>' + text);
        }
    </script>

<?php
$formValidator->output();
$db->show_empty_footer();
?>


<?php
function createNewCardForm()
{
    global $formValidator, $main;

    //disable form from submitting
    //and disable the input fields
    $formValidator->addCustomCode('
        if (FormErrorFound == false) {
            FormErrorFound = true;
            $("#fld_credit_card").prop("disabled",true);
            $("#fld_expiry_month").prop("disabled",true);
            $("#fld_expiry_year").prop("disabled",true);
            $("#fld_ccv").prop("disabled",true);
            $("#newCardSubmit").prop("disabled",true);
            newCardConString();
        }
    ');

    ?>
    <script>
        <?php
        //step 1 get the connection string
        //create the rxjs function to get the connection string
        $url = '"' . $main['site_url'] . '/ainsurance/credit_cards_remote/credit_cards_api.php?action=newCardConnectionString';
        $url .= '&card=" + $("#fld_credit_card").val()';
        $url .= '+ "&expYear=" + $("#fld_expiry_year").val()';
        $url .= '+ "&expMonth=" + $("#fld_expiry_month").val()';
        $url .= '+ "&ccv=" + $("#fld_ccv").val()';

        $connectionStringSettings = [
            'functionName' => 'newCardConString()',
            'source' => $url,
            'errorJSCode' => '
                newCardMakeError("An error occurred reaching the api");
            ',
            'successJSCode' => " 
                console.log('Create string result ' + data.error);
                if (data.error != '0'){
                    console.log('Error creating string');
                    newCardMakeError(data.error,true);
                }
                else {
                    console.log('String success');
                    updateConsole('Connection string generated successfully.');
                    //proceed to make card
                    newCardMakeCardRemote(data.conString);
                }
            "
        ];
        echo customFormValidator::getPromiseJSCodeV2($connectionStringSettings);
        //step 2 send the connection string to create the remote card
        //create the rxjs function to go at the rcb remote and create the card in the remote db
        $remoteNewCardSettings = [
            'functionName' => 'newCardMakeCardRemote(connString)',
            'source' => "connString",
            'successJSCode' => '
                console.log("Create remote card result [" + data.error + "]");
                if (data.error != "0"){
                    newCardMakeError("Remote Server Says: " + data.error,true);
                }
                else {
                    if (data.newCardRemoteID > 0){
                        updateConsole("Remote Server created the card [" + data.newCardRemoteID + "]");
                        console.log("Inserting the card with remote ID " + data.newCardRemoteID);
                        insertCreditCard(data.newCardRemoteID);
                    }
                    else {
                        updateConsole("Remote card ID is empty from server");
                    }
                }
            '
        ];
        echo customFormValidator::getPromiseJSCodeV2($remoteNewCardSettings);


        //step 3 create the card locally
        //create the card in credit_cards
        $insertCardUrl = '"' . $main['site_url'] . '/ainsurance/credit_cards_remote/credit_cards_api.php?action=insertCardToDB';
        $insertCardUrl .= '&card=" + $("#fld_credit_card").val()';
        $insertCardUrl .= ' + "&remoteID=" + remoteID';

        $insertCardSettings = [
            'functionName' => ' (remoteID)',
            'source' => $insertCardUrl,
            'prefixJSCode' => '
            console.log("Starting step 3 inserting card in local db");
            ',
            'successJSCode' => '
                console.log("Api insert card local executed");
                if (data.error != "0"){
                    console.log("Inserting card local with string");
                    console.log('.$insertCardUrl.');
                    newCardMakeError("Inserting Card: " + data.error,true);
                }
                else {
                    updateConsole("Card inserted successfully");
                }
            '
        ];
        echo customFormValidator::getPromiseJSCodeV2($insertCardSettings);

        ?>
        function newCardMakeError(error, enableForm = false) {
            $('#newCardErrorDiv').show();
            $('#newCardErrorDiv').html(error);
            if (enableForm == true) {
                $("#fld_credit_card").prop("disabled", false);
                $("#fld_credit_card").removeClass('is-valid');
                $("#fld_expiry_month").prop("disabled", false);
                $("#fld_expiry_month").removeClass('is-valid');
                $("#fld_expiry_year").prop("disabled", false);
                $("#fld_expiry_year").removeClass('is-valid');
                $("#fld_ccv").prop("disabled", false);
                $("#fld_ccv").removeClass('is-valid');
                $("#newCardSubmit").prop("disabled", false);

            }
            updateConsole(error);
        }
    </script>
    <form name="myForm" id="myForm" method="post" action="#" onsubmit=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="form-group row">
            <div class="col-12 alert alert-danger text-center" style="display: none" id="newCardErrorDiv"></div>
        </div>
        <div class="row form-group">
            <?php
            $formB = new FormBuilder();
            $formB->setFieldName('fld_credit_card')
                ->setFieldDescription('Card Number')
                ->setLabelClasses('col-sm-2')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue('11')
                ->buildLabel();
            $formValidator->addField(
                [
                    'fieldName' => $formB->fieldName,
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
            <div class="col-2">
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
                ->setInputValue('1')
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
                ?>
            </div>
            <div class="col-2">
                <?php
                $year = [];
                $d = date("Y");
                for ($i = $d; $i <= $d + 5; $i++) {
                    $year[$i] = $i;
                }
                $formB->setFieldName('fld_expiry_year')
                    ->setFieldType('select')
                    ->setInputSelectArrayOptions($year)
                    ->setInputSelectAddEmptyOption(true)
                    ->setInputValue('2020')
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
        </div>
        <div class="form-group row">
            <?php
            $formB->setFieldName('fld_ccv')
                ->setFieldDescription('CCV')
                ->setLabelClasses('col-sm-2')
                ->setFieldType('input')
                ->setFieldInputType('text')
                ->setInputValue('123')
                ->buildLabel();
            ?>
            <div class="col-2">
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
                <input type="submit" id="newCardSubmit" value="Create New Card" class="btn btn-primary">
            </div>
        </div>
    </form>
    <?php
}

?>