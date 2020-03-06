<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/3/2020
 * Time: 12:29 μ.μ.
 */

include("../include/main.php");
include("../scripts/form_builder_class.php");
include("../scripts/form_validator_class.php");
include("quotations_class.php");
include("../send_auto_emails/send_auto_emails_class.php");

$db = new Main(0, 'UTF-8');
$db->admin_title = "Dynamic Quotations Approvals Open";

//get the id and identifier
$out = false;
$data = explode('|2|', $_GET['i']);
if ($data[0] == '' || $data[1] == '') {
    $out = true;
}
if (!is_numeric($data[0])) {
    $out = true;
}

if ($out) {
    header("Location: ../home.php");
    exit();
}
//check if quotation num exists and matches with identifier
$sql = "SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = " . $data[0];
$quotation = $db->query_fetch($sql);
if ($quotation['oqq_quotations_ID'] == '' || !is_numeric($quotation['oqq_quotations_ID'])) {
    //echo "quotation id issue";
    $out = true;
}
if ($quotation['oqq_unique_identifier'] != $data[1]) {
    //echo "identifier issue";
    $out = true;
}

if ($out) {
    header("Location: ../home.php");
    exit();
}

//all checks are ok proceed
if ($_POST['action'] != '') {
    if ($_POST['action'] == 'Approve') {
        $newData['fld_status'] = 'Approved';
    }
    if ($_POST['action'] == 'Reject') {
        $newData['fld_status'] = 'Rejected';
    }
    $newData['fld_comments'] = $_POST['comments'];

    //update the approval
    $db->db_tool_update_row('oqt_quotation_approvals', $newData, 'oqqp_quotation_ID = ' . $_POST['qID'] . " AND oqqp_status = 'Pending'"
        , 0, 'fld_', 'execute', 'oqqp_');
    //update the policy

    $qNewData['fld_status'] = $newData['fld_status'];
    $db->db_tool_update_row('oqt_quotations', $qNewData, "oqq_quotations_ID = " . $_POST['qID'], $_POST['qID']
        , 'fld_', 'execute', 'oqq_');
    $action = 'done';

    //proceed to activate the cover note
    $quote = new dynamicQuotation($_POST['qID']);
    $quote->checkForActivation();
    if ($quote->error == false){
        $quote->activate();
    }
    else {
        //get email info from quotation type
        $quote->sendEmail('Cover note CMR has been rejected',
            'Cover Note has been rejected<br>Cover Note ID: [QTID]<br>View PDF Report <a href="[PDFLINK]">Here</a><br><br>
                        <strong>Kemter Insurance</strong>','','','','','CMR-Cover-Note.pdf');
        
    }


}
$status = 'pending';
if ($quotation['oqq_status'] != 'Pending'){
    $status = 'notPending';
}

$db->show_header();
?>

<div class="container">
    <form target="" method="post">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Approve/Reject CMR Cover Note</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">Client Name</div>
                    <div class="col-3"><?php echo $quotation['oqq_insureds_name']; ?></div>
                </div><br>
                <?php
                if ($action != 'done' && $status == 'pending') {
                    ?>
                    <div class="row">
                        <div class="col-3">Comments</div>
                        <div class="col-9 form-group">
                            <textarea class="form-control" id="comments" name="comments" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-2 text-center">
                            <input type="submit" id="action" name="action" class="form-control btn btn-primary"
                                   value="Approve" onclick="return confirm('Are you sure you want to Approve this cover note?');">
                            <input type="hidden" id="qID" name="qID" value="<?php echo $data[0]; ?>">
                        </div>
                        <div class="col-2 text-center">
                            <input type="submit" id="action" name="action" class="form-control btn btn-danger"
                                   value="Reject" onclick="return confirm('Are you sure you want to Reject this cover note?');">
                        </div>
                        <div class="col-3"></div>
                    </div>

                    <?php
                }

                if ($action == 'done'){
                    ?>
                    <div class="row">
                        <div class="col-12 text-center alert alert-success">DONE</div>
                    </div>
                    <?php
                }

                if ($status != 'pending'){
                    ?>
                    <div class="row">
                        <div class="col-12 text-center alert alert-warning">This cover note has no pending approval</div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="col-1"></div>
        </div>
    </form>
</div>

<?php
$db->show_footer();
?>
