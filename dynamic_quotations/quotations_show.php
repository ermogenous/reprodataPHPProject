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
    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
        <tr class="row_table_head">
            <td colspan="3" align="center"><strong><?php echo $quote->getQuotationType(); ?> Information</strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="10">&nbsp;</td>
            <td width="93" height="27"><strong>Name</strong></td>
            <td width="397"><?php echo $data["oqq_insureds_name"]; ?></td>
        </tr>
        <?php
        if ($data['oqqt_enable_premium'] == 1) {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td height="27"><strong>Total Price </strong></td>
                <td>€<?php echo $data["clo_total_price"]; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>&nbsp;</td>
            <td><strong>Status</strong></td>
            <td><?php echo $quote->quotationData()['oqq_status']; ?></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" align="center">
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


                        </td>
                        <td width="25%" align="center">
                            <a href="#">
                                <i class="far fa-file-pdf fa-5x"
                                    <?php if ($quote->quotationData()['oqq_status'] == 'Active') { ?>
                                        onclick="window.open('quotation_print.php?quotation=<?php echo $data["oqq_quotations_ID"]; ?>&pdf=1','_blank')"
                                    <?php } ?>
                                >
                                </i><br>
                            </a>
                            PDF
                        </td>
                        <td width="25%" align="center">
                            <a href="#">
                                <i class="fas fa-list fa-5x"
                                   onclick="window.location.assign('quotations.php');"></i><br/>
                            </a>
                            All Quotations
                        </td>
                        <td width="25%" align="center">
                            <a href="#">
                                <i class="fas fa-lock fa-5x"
                                    <?php if ($quote->quotationData()['oqq_status'] == 'Outstanding') { ?>
                                        onclick="window.location.assign('quotations_show.php?action=activate&lid=<?php echo $data["oqq_quotations_ID"]; ?>')"
                                    <?php } ?>
                                >
                                </i>
                            </a>
                            Activate

                        </td>

                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

<?php
$db->show_footer();
?>