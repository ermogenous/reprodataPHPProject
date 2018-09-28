<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/9/2018
 * Time: 3:50 ΜΜ
 */

include("../include/main.php");
$db = new Main();

$db->admin_title = "Agreements Change Status";

$db->check_restriction_area('extra_1');

$db->working_section = 'Agreements Change Status';

include('agreements_functions.php');

if ($_GET['action'] == 'lock'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->lockAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Locked Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}
else if ($_GET['action'] == 'unlock'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->unLockAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Un-Locked Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}
else if ($_GET['action'] == 'activate'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->activateAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Activated Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}
else if ($_GET['action'] == 'expire'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->expireAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Expired Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}
else if ($_GET['action'] == 'delete'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->deleteAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Deleted Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}
else if ($_GET['action'] == 'cancel'){
    $agr = new Agreements($_GET['lid']);
    if ($agr->cancelAgreement() == true) {
        $db->generateSessionAlertSuccess('Agreement Cancelled Successfully');
        header("Location: agreements_change_status.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError($agr->errorDescription);
    }
}

if ($_GET['lid'] > 0) {
    $data = $db->query_fetch('
  SELECT * FROM 
  agreements
  JOIN customers ON cst_customer_ID = agr_customer_ID
  WHERE agr_agreement_ID = ' . $_GET['lid']);
} else {
    header("Location: agreements.php");
    exit();
}
//print_r($data);
$db->show_header();
?>

<div class="container">

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">

            <div class="row">
                <div class="col-12 alert alert-primary text-center">Agreement Change Status</div>
            </div>

            <div class="row">
                <div class="col-12">&nbsp;</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                    <div class="row">
                        <div class="col-3 alert alert-info">Number</div>
                        <div class="col-3 alert"><?php echo $data['agr_agreement_number']; ?></div>
                        <div class="col-3 alert alert-info">Status</div>
                        <div class="col-3 alert <?php echo getAgreementColor($data['agr_status']);?>"><?php echo $data['agr_status']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-3 alert alert-info">Starting Data</div>
                        <div class="col-3 alert"><?php echo $db->convert_date_format($data['agr_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                        <div class="col-3 alert alert-info">Expiry</div>
                        <div class="col-3 alert"><?php echo $db->convert_date_format($data['agr_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-3 alert alert-info">Customer</div>
                        <div class="col-9 alert"><?php echo $data['cst_name'] . " " . $data['cst_surname'] . " " . $data['cst_identity_card']; ?></div>
                    </div>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">&nbsp;</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="card-text text-center">
                        <button type="button" value="Back" style="width: 140px;" class="btn btn-primary" onclick="goBack();">
                            Back
                        </button>
                        <?php
                        if ($data['agr_status'] == 'Pending') {
                            ?>
                            <button type="button" value="Lock" style="width: 140px;" class="btn agrLockedColor" onclick="lockAgreement();">
                                Lock
                            </button>
                            <?php
                        }
                        if ($data['agr_status'] == 'Locked') {
                            ?>
                            <button type="button" value="UnLock" style="width: 140px;" class="btn agrPendingColor" onclick="unLockAgreement();">
                                Un-Lock
                            </button>
                            <?php
                        }
                        if ($data['agr_status'] == 'Locked') {
                        ?>
                        <button type="button" value="Activate" style="width: 140px;" class="btn agrActiveColor" onclick="activateAgreement();">
                            Activate
                        </button>
                            <?php
                        }
                        if ($data['agr_status'] == 'Pending') {
                        ?>
                        <button type="button" value="Delete" style="width: 140px;" class="btn agrDeletedColor" onclick="deleteAgreement();">
                            Delete
                        </button>
                            <?php
                        }
                        if ($data['agr_status'] == 'Active') {
                        ?>
                        <button type="button" value="Cancel" style="width: 150px;" class="btn agrCancelledColor" onclick="cancelAgreement();">
                            Cancellation
                        </button>
                            <?php
                        }
                        ?>
                        <button type="button" value="Modify" style="width: 150px;" class="btn btn-success" onclick="modifyAgreement();">
                            <?php if ($data['agr_status'] == 'Pending') echo 'Modify'; else echo 'View'; ?>
                        </button>
                    </p>
                </div>
            </div>


        </div>

        <div class="col-lg-2"></div>
    </div>
</div>

<script>
    function lockAgreement(){
        if (confirm('Are you sure you want to lock this agreement?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=lock');
        }
    }

    function unLockAgreement() {
        if (confirm('Are you sure you want to un-lock this agreement?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=unlock');
        }
    }

    function activateAgreement() {
        if (confirm('Are you sure you want to activate this agreement?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=activate');
        }
    }

    function deleteAgreement() {
        if (confirm('Are you sure you want to delete this agreement?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=delete');
        }
    }

    function cancelAgreement() {
        if (confirm('Are you sure you want to cancel this agreement?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=cancel');
        }
    }

    function modifyAgreement() {
        window.location.assign('agreements_modify.php?lid=<?php echo $_GET['lid'];?>');
    }

    function goBack() {
        window.location.assign('agreements.php');
    }
</script>
<?php
$db->show_footer();
?>
