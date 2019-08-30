<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 8:57 ΠΜ
 */

include("../include/main.php");
include("policy_class.php");
$db = new Main();
$db->admin_title = "AInsurance Policy Change Status";

if ($_GET['action'] == 'activate') {
    $policy = new Policy($_GET['lid']);

    $db->start_transaction();
    if ($policy->activatePolicy() == true) {
        $db->generateSessionAlertSuccess('Policy ' . $policy->policyData['inapol_policy_number'] . ' activated');
        //$db->rollback_transaction();
        $db->commit_transaction();
        header('Location: policy_change_status.php?lid=' . $_GET['lid']);
        exit();
    } else {
        $db->generateSessionAlertError($policy->errorDescription);
        $db->rollback_transaction();
        header('Location: policy_change_status.php?lid=' . $_GET['lid']);
        exit();
    }

} else if ($_GET['action'] == 'cancel') {
    $policy = new Policy($_GET['lid']);

    $db->start_transaction();
    if ($policy->cancelPolicy() == true) {
        $db->generateSessionAlertSuccess('Policy ' . $policy->policyData['inapol_policy_number'] . ' cancelled');
        $db->commit_transaction();
        header('Location: policies.php');
        exit();
    } else {
        $db->generateSessionAlertError($policy->errorDescription);
        $db->rollback_transaction();
        header('Location: policy_change_status.php?lid=' . $_GET['lid']);
        exit();
    }
} else if ($_GET['action'] == 'delete') {
    $policy = new Policy($_GET['lid']);

    $db->start_transaction();
    if ($policy->deletePolicy() == true) {
        $db->generateSessionAlertSuccess('Policy ' . $policy->policyData['inapol_policy_number'] . ' deleted');
        $db->commit_transaction();
        header('Location: policies.php');
        exit();
    } else {
        $db->generateSessionAlertError($policy->errorDescription);
        $db->rollback_transaction();
        header('Location: policy_change_status.php?lid=' . $_GET['lid']);
        exit();
    }
}


if ($_GET['lid'] == '') {
    header('Location: policies.php');
    exit();
}

$data = $db->query_fetch('SELECT * FROM ina_policies JOIN customers ON cst_customer_ID = inapol_customer_ID WHERE inapol_policy_ID = ' . $_GET['lid']);
//print_r($data);
$db->show_header();
?>

    <div class="container">

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <?php
                        echo $db->showLangText('Policy Change Status', 'Αλλαγή Κατάστασης Συμβολαίου');
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                        <div class="row">
                            <div class="col-3 alert alert-info"><?php echo $db->showLangText('Number','Αριθμός');?></div>
                            <div class="col-3 alert"><?php echo $data['inapol_policy_number']; ?></div>
                            <div class="col-3 alert alert-info"><?php echo $db->showLangText('Status','Κατάσταση');?></div>
                            <div class="col-3 alert <?php echo getPolicyClass($data['inapol_status']); ?>"><?php echo $data['inapol_status']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-3 alert alert-info"><?php echo $db->showLangText('Starting Date','Ημ. Έναρξης');?></div>
                            <div class="col-3 alert"><?php echo $db->convert_date_format($data['inapol_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                            <div class="col-3 alert alert-info"><?php echo $db->showLangText('Expiry','Ημ. Λήξης');?></div>
                            <div class="col-3 alert"><?php echo $db->convert_date_format($data['inapol_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-3 alert alert-info"><?php echo $db->showLangText('Customer','Πελάτης');?></div>
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
                            <button type="button" value="Back" style="width: 140px;" class="btn btn-primary"
                                    onclick="goBack();">
                                <?php echo $db->showLangText('Back','Πίσω');?>
                            </button>
                            <?php
                            if ($data['inapol_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Activate" style="width: 140px;"
                                        class="btn inapolActiveColor" onclick="activatePolicy();">
                                    <?php echo $db->showLangText('Activate','Ενεργοποίηση');?>
                                </button>
                                <?php
                            }
                            if ($data['inapol_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Delete" style="width: 140px;"
                                        class="btn inapolDeletedColor" onclick="deletePolicy();">
                                    <?php echo $db->showLangText('Delete','Διαγραφή');?>
                                </button>
                                <?php
                            }
                            if ($data['inapol_status'] == 'Active') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;"
                                        class="btn inapolCancelledColor" onclick="cancelPolicy();">
                                    <?php echo $db->showLangText('Cancellation','Ακύρωση');?>
                                </button>
                                <button type="button" value="Cancel" style="width: 150px;"
                                        class="btn inapolEndorsenentColor" onclick="endorsePolicy();">
                                    <?php echo $db->showLangText('Endorse','Τροποποίηση');?>
                                </button>
                                <?php
                            }
                            ?>
                            <button type="button" value="Modify" style="width: 150px;" class="btn btn-success"
                                    onclick="modifyPolicy();">
                                <?php if ($data['inapol_status'] == 'Outstanding') echo 'Modify'; else echo 'View'; ?>
                            </button>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-lg-2"></div>
        </div>
    </div>
    <script>

        function activatePolicy() {
            if (confirm('<?php echo $db->showLangText('Are you sure you want to activate this Policy?','Είστε βέβαιοι ότι θέλετε να ενεργοποιήσετε αυτό το συμβόλαιο;');?>')) {
                window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=activate');
            }
        }

        function deletePolicy() {
            if (confirm('<?php echo $db->showLangText('Are you sure you want to delete this Policy?','Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτό το συμβόλαιο;');?>')) {
                window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=delete');
            }
        }

        function cancelPolicy() {

            if (confirm('<?php echo $db->showLangText('Are you sure you want to cancel this Policy?','Είστε βέβαιοι ότι θέλετε να ακυρώσετε αυτό το συμβόλαιο;');?>')) {
                window.location.assign('policy_cancellation.php?pid=<?php echo $_GET['lid'];?>');
            }
        }

        function modifyPolicy() {
            window.location.assign('policy_modify.php?lid=<?php echo $_GET['lid'];?>');
        }

        function endorsePolicy() {
            window.location.assign('policy_endorsement.php?pid=<?php echo $_GET['lid'];?>');
        }

        function goBack() {
            window.location.assign('policies.php');
        }
    </script>
<?php
$db->show_footer();
?>