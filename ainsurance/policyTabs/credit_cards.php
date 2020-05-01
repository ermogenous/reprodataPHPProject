<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 20/04/2020
 * Time: 12:26
 */

include("../../include/main.php");
include("../policy_class.php");
include("credit_card_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include("../credit_cards_remote/creditCardRemoteClass.php");

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

if ($_POST['action'] == 'newCardEntry'){
    echo "Create new card entry";
    $card = new MECreditCards();
    $card->makeNewCreditCardEntry($_POST['fld_credit_card'],
        $_POST['fld_expiry_year'],
        $_POST['fld_expiry_month'],
        $_POST['fld_ccv'],
        $_POST['pid']
        );
    if ($card->error == true){
        echo $card->errorDescription;
    }

}

$card = new MECreditCards();
$connectionTest = $card->testRemoteConnection();

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->show_empty_header();
FormBuilder::buildPageLoader();

?>
    <div class="container">

        <?php

        if ($connectionTest != true){
            ?>
            <br>
            <div class="row">
                <div class="col-12 text-center alert alert-danger">
                    Credit cards remote system is not found. Contact administrator
                </div>
            </div>
            <?php
        }
        else {


            if ($policyFound === false) {
                ?>
                <br>
                <div class="row">
                    <div class="col-12 text-center alert alert-danger">
                        No policy has been found
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if ($policyStatus != 'Active' && $policyStatus != 'Archived') {
                ?>
                <br>
                <div class="row">
                    <div class="col-12 text-center alert alert-danger">
                        Policy must be active to be able to set credit card
                    </div>
                </div>
                <?php
            } else {
                //show only if policy exists and active
                ?>
                <br>
                <div class="row">
                    <div class="col-12 text-center alert alert-primary">
                        Credit Card
                    </div>
                </div>
                <?php
                if ($creditCardExists == true) {
                    ?>


                    <?php
                } //if no credit card
                else {
                    if ($_GET['action'] == 'formNewCard') {
                        createNewCardForm();
                    } else {
                        ?>
                        <div class="row form-group">
                            <div class="col-12">
                                <a href="credit_cards.php?action=formNewCard&pid=<?php echo $_GET['pid']; ?>">
                                    No card exists. Click here to create new entry
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>


                <?php
            }//if policy is active/archived
        }
        ?>
    </div>

<?php
$formValidator->output();
$db->show_empty_footer();

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