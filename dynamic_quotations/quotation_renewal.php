<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 20-May-19
 * Time: 10:57 AM
 */

include("../include/main.php");
include("../include/tables.php");
include("quotations_class.php");
$db = new Main();


if ($_POST['action'] == 'renew'){
    $db->working_section = 'Dynamic quotation Renew';
    $quote = new dynamicQuotation($_POST['lid']);

    if ($quote->makeRenewal($_POST['new_expiry_date'])==true){
        $db->generateSessionAlertSuccess('Renewed Successfully');
        header("Location: quotations.php");
        exit();
    }
    else{
        $db->generateAlertError($quote->errorDescription);
    }

}


if ($_GET["lid"] > 0) {
    $quote = new dynamicQuotation($_GET['lid']);
} else {
    header("Location: quotations.php");
    exit();
}
$db->enable_jquery_ui();
include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

$db->show_header();
?>
    <form name="myForm" id="myForm" method="post" action=""
        <?php $formValidator->echoFormParameters(); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">

                    <div class="row">
                        <div class="col-12 text-center alert alert-success">
                            <strong>
                                Renew <?php echo $quote->getQuotationType() . " " . $quote->quotationData()['oqq_number']; ?>
                            </strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Name</strong></div>
                        <div class="col-7"><?php echo $quote->quotationData()["oqq_insureds_name"]; ?></div>
                    </div>
                    <?php
                    if ($quote->quotationData()['oqqt_enable_premium'] == 1) {
                        ?>
                        <div class="row">
                            <div class="col-5 text-right"><strong>Total Price </strong></div>
                            <div class="col-7">€<?php echo $data["clo_total_price"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Status</strong></div>
                        <div class="col-7"><?php echo $quote->quotationData()['oqq_status']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-5 text-right"><strong>Period</strong></div>
                        <div class="col-7">
                            <?php
                            echo $db->convert_date_format($quote->quotationData()['oqq_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 0)
                                . " - "
                                . $db->convert_date_format($quote->quotationData()['oqq_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 0);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr style="color: grey;">
                        </div>
                    </div>
                    <?php
                    $expiryDate = $quote->quotationData()['oqq_expiry_date'];
                    $expiryDate = explode('-', $expiryDate);
                    $newStartingDate = date('d/m/Y', mktime(0, 0, 0, $expiryDate[1], ($expiryDate[2] + 1), $expiryDate[0]));
                    ?>
                    <div class="row">
                        <div class="col-5 text-right"><strong>New starting Date</strong></div>
                        <div class="col-7">
                            &nbsp;<?php echo $newStartingDate; ?>
                            <input type="hidden" id="newStartingDate" name="newStartingDate" value="<?php echo $newStartingDate; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-right"><strong>New Expiry Date</strong></div>
                        <div class="col-3">
                            <input name="new_expiry_date" type="text" id="new_expiry_date"
                                   class="form-control" readonly
                                   value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'new_expiry_date',
                                    'fieldDataType' => 'date',
                                    'required' => true,
                                    'enableDatePicker' => false,
                                    'dateMinDate' => $newStartingDate,
                                    'invalidText' => 'Enter expiry date'
                                ]);
                            ?>
                        </div>
                        <div class="col-4"></div>
                    </div>

                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-7">
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(3)">3M</button>&nbsp;
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(6)">6M</button>&nbsp;
                            <button type="button" class="btn" style="width: 45px;" onclick="setExpiryDate(9)">9M</button>&nbsp;
                            <button type="button" class="btn" style="width: 55px;" onclick="setExpiryDate(12)">12M</button>
                        </div>
                    </div>

                    <div class="row" style="height: 25px;"></div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">

                            <input name="action" type="hidden" id="action" value="renew"/>
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET['lid'];?>"/>

                            <div class="btn btn-secondary" onclick="window.location.assign('quotations.php')">Back</div>
                            <input type="submit" value="Renew <?php echo $quote->getQuotationType();?>"
                                   class="btn btn-secondary">
                        </div>
                    </div>

                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </form>
<script>
    function setExpiryDate(months) {
        let newMonth = 0;
        let newDay = 0;
        let newYear = 0;
        let curDay;
        let curMonth;
        let curYear;
        let curDate = $('#newStartingDate').val();
        if (curDate != '') {

            //split the current date;
            let split = curDate.split('/');
            curDay = split[0];
            curMonth = split[1];
            curYear = split[2];

            //first add the months
            newMonth = (curMonth * 1) + months;
            //update the rest of the fields
            newDay = (curDay * 1) - 1;
            newYear = curYear;

            //check the month if need to change year
            if (newMonth > 12) {
                //first update the year
                newYear++;
                newMonth = newMonth - 12;
            }

            let isLeap = ((newYear % 4 == 0) && (newYear % 100 != 0)) || (newYear % 400 == 0);

            //check the day. if 0 then need to go back one day and one month
            if (newDay == 0) {
                //first fix the month
                newMonth--;
                //check if the month now is 0
                if (newMonth == 0) {
                    newMonth = 12;
                    newYear--;
                }
                //now set the day to 31
                newDay = 31;


            }

            //validate days 31, 30, 29
            if (newDay >= 28 && newDay <= 31) {

                //now check the day compared to month
                if (newMonth == 1 || newMonth == 3 || newMonth == 5 || newMonth == 7 || newMonth == 8 || newMonth == 10 || newMonth == 12) {
                    //do nothing is already 29 or 30 or 31;
                }
                else if (newMonth == 2) {
                    //find leap year
                    if (isLeap == true) {
                        if (newDay > 29) {
                            newDay = 29;
                        }
                    }
                    else {
                        if (newDay > 28) {
                            newDay = 28;
                        }
                    }
                }
                else {
                    if (newDay > 30) {
                        newDay = 30;
                    }
                }
            }

            //update the field with the new date
            $('#new_expiry_date').val(newDay + '/' + newMonth + '/' + newYear);
        }
    }
</script>
<?php
$formValidator->output();
$db->show_footer();
?>