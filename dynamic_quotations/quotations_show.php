<?php
include("../include/main.php");
include("../include/tables.php");
include("quotations_class.php");
$db = new Main();

if ($_GET["lid"] != "") {
    $data = $db->query_fetch("SELECT 
	oqq_insureds_name
	,oqq_quotations_ID
	,oqq_quotations_type_ID
	,(oqq_fees + oqq_stamps + oqq_premium)as clo_total_price 
	,oqqt_print_layout
	,oqqt_enable_premium
	,oqq_fees
	,oqq_stamps
	,oqq_premium
	,oqq_calculation_type
	FROM 
	oqt_quotations 
	JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
	WHERE 
	oqq_quotations_ID = " . $_GET["lid"]);

    $quote = new dynamicQuotation($_GET['lid']);

} else {
    header("Location: quotations.php");
    exit();
}

//activate quotation
if ($_GET['action'] == 'activate' && $_GET['lid'] > 0) {
    $db->start_transaction();
    if ($quote->activate() == true) {
        $db->generateSessionAlertSuccess($quote->getQuotationType() . " activated successfully");

        //check if the email was sent
        if ($quote->error == true) {
            $db->generateSessionAlertError('Activated! Error sending the email. Please check in AutoEmails.');
        }

    } else {
        if ($quote->errorType == 'warning') {
            $db->generateSessionAlertWarning($quote->errorDescription);
        } else {
            $db->generateSessionAlertError($quote->errorDescription);
        }
    }
    $db->commit_transaction();
    header("Location: quotations_show.php?lid=" . $_GET['lid']);
    exit();
}
$db->show_header();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">

            <div class="row">
                <div class="col-12 text-center alert alert-primary">
                    <strong><?php echo $quote->getQuotationType(); ?> Information</strong>
                </div>
            </div>

            <div class="row">
                <div class="col-5 text-right"><strong>Name</strong></div>
                <div class="col-7"><?php echo $data["oqq_insureds_name"]; ?></div>
            </div>
            <?php
            if ($data['oqqt_enable_premium'] == 1) {
                ?>
                <div class="row">
                    <div class="col-5 text-right"><strong>Indicative Price  </strong></div>
                    <div class="col-7">
                        €<?php echo round($data["clo_total_price"], 2)
                            . " (Premium:€" . $data['oqq_premium'] . " Fees:€" . $data['oqq_fees'] . " Stamps:€" . $data['oqq_stamps'] . ")"; ?>
                        <?php if ($db->user_data['usr_user_rights'] <= 2) { ?>
                            <a href="quotation_premium_modify.php?lid=<?php echo $_GET['lid']; ?>">Modify Premium
                                (<?php echo $data['oqq_calculation_type']; ?>)</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-5 text-right"><strong>Status</strong></div>
                <div class="col-7"><?php echo $quote->quotationData()['oqq_status']; ?></div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr style="color: grey;">
                </div>
            </div>

            <div class="row">
                <?php
                if ($quote->quotationData()['oqqt_info_page_extra_button'] == '') {
                    ?>
                    <div class="col-2"></div>
                    <?php
                } else {
                    ?>
                    <div class="col-1"></div>
                <?php } ?>

                <div class="col-2 text-center">
                    <a href="#">
                        <i class="fas fa-edit fa-5x"
                           onclick="window.location.assign('quotations_modify.php?quotation_type=<?php echo $data["oqq_quotations_type_ID"]; ?>&quotation=<?php echo $data["oqq_quotations_ID"]; ?>')">
                        </i><br>
                    </a>
                    <?php
                    if ($quote->quotationData()['oqq_status'] == 'Outstanding') {
                        echo 'Edit ';
                    } else {
                        echo 'View ';
                    }
                    echo $quote->getQuotationType();
                    ?>
                </div>
                <div class="col-2 text-center">
                    <a href="#">
                        <i class="far fa-file-pdf fa-5x"
                            <?php
                            if ($quote->quotationData()['oqq_status'] == 'Active' ||
                                (($quote->quotationData()['oqq_status'] == 'Outstanding' || $quote->quotationData()['oqq_status'] == 'Pending')
                                    && $quote->quotationData()['oqqt_allow_print_outstanding'] == 1)) { ?>
                                onclick="window.open('quotation_print.php?quotation=<?php echo $data["oqq_quotations_ID"]; ?>&pdf=1','_blank')"
                            <?php } ?>
                        >
                        </i><br>
                    </a>
                    PDF
                </div>
                <div class="col-2 text-center">
                    <a href="#">
                        <i class="fas fa-list fa-5x"
                           onclick="window.location.assign('quotations.php');"></i><br/>
                    </a>
                    View All
                </div>


                <div class="col-2 text-center" id="activateDiv">
                    <a href="#">
                        <i class="fas fa-lock fa-5x"
                            <?php if ($quote->quotationData()['oqq_status'] == 'Outstanding' || $quote->quotationData()['oqq_status'] == 'Approved') { ?>
                                onclick="
                                        $('#activateDiv').hide();
                                        if (confirm('Are you sure you want to activate this <?php echo $quote->getQuotationType(); ?>?')){
                                        window.location.assign('quotations_show.php?action=activate&lid=<?php echo $data["oqq_quotations_ID"]; ?>')

                                        }
                                        else {
                                        $('#activateDiv').show();
                                        return false;
                                        }

                                        "
                            <?php } ?>
                        >
                        </i>
                    </a><br>
                    Activate
                </div>


                <?php
                if ($quote->quotationData()['oqqt_info_page_extra_button'] != '') {
                    ?>
                    <div class="col-2 text-center">
                        <?php
                        echo $quote->quotationData()['oqqt_info_page_extra_button'];
                        ?>
                    </div>
                    <?php
                }
                ?>

            </div>

            <?php
            if ($quote->quotationData()['oqqt_print_layout2'] != '') {
                ?>
            <br>
            <div class="row">
                <?php
                if ($quote->quotationData()['oqqt_info_page_extra_button'] == '') {
                    ?>
                    <div class="col-2"></div>
                    <?php
                } else {
                    ?>
                    <div class="col-1"></div>
                <?php } ?>
                <div class="col-2 text-center">
                    <a href="#">
                        <i class="far fa-file-pdf fa-5x"
                           onclick="window.open('<?php echo $quote->quotationData()['oqqt_print_layout2'];?>?quotation=<?php echo $data["oqq_quotations_ID"]; ?>&pdf=1','_blank')"
                        >
                        </i><br>
                    </a>
                    <?php echo $quote->quotationData()['oqqt_print_layout2_name'];?>
                </div>
            </div>
            <?php } ?>

            <div class="row">
                <div class="col-12">
                    <hr style="color: grey;">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <strong>Approvals</strong>
                </div>
            </div>
            <?php
            $sql = "SELECT * FROM oqt_quotation_approvals WHERE oqqp_quotation_ID = " . $_GET['lid'];
            $result = $db->query($sql);
            $i = 0;
            while ($row = $db->fetch_assoc($result)) {
                $i++;
                $createdSplit = explode(' ', $row['oqqp_created_date_time']);

                ?>

                <div class="row">
                    <div class="col-2">Created on</div>
                    <div class="col-3"><?php echo $db->convert_date_format($createdSplit[0], 'yyyy-mm-dd', 'dd/mm/yyyy') . " " . $createdSplit[1]; ?></div>
                    <div class="col-1">Status</div>
                    <div class="col-2"><?php echo $row['oqqp_status']; ?></div>
                    <div class="col-4"><?php echo $row['oqqp_comments']; ?></div>
                </div>

                <?php
            }
            if ($i == 0) {
                ?>
                <div class="row">
                    <div class="col-12"><strong>No approvals found.</strong></div>
                </div>
            <?php } ?>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
