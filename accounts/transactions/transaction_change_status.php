<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/7/2019
 * Time: 1:20 ΜΜ
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('transactions_class.php');
$db = new Main();
$db->admin_title = "Accounts Transaction change status";

if ($_GET['action'] == 'lock') {
    $db->start_transaction();
    $transaction = new AccountsTransaction($_GET['lid']);
    if ($transaction->lockTransaction() == true) {
        $db->generateAlertSuccess('Transaction locked successfully');
        $db->commit_transaction();
    } else {
        $db->generateAlertError($transaction->errorDescription);
        $db->rollback_transaction();
    }
}

if ($_GET['action'] == 'unlock') {
    $db->start_transaction();
    $transaction = new AccountsTransaction($_GET['lid']);
    if ($transaction->unlockTransaction() == true) {
        $db->generateAlertSuccess('Transaction unlocked successfully');
        $db->commit_transaction();
    } else {
        $db->generateAlertError($transaction->errorDescription);
        $db->rollback_transaction();
    }
}

if ($_GET['action'] == 'delete') {
    $db->start_transaction();
    $transaction = new AccountsTransaction($_GET['lid']);
    if ($transaction->deleteTransaction() == true) {
        $db->generateSessionAlertSuccess('Transaction deleted successfully');
        $db->commit_transaction();
        header("Location: transactions.php");
        exit();
    } else {
        $db->generateAlertError($transaction->errorDescription);
        $db->rollback_transaction();
    }
}

if ($_GET['action'] == 'activate') {
    $db->start_transaction();
    $transaction = new AccountsTransaction($_GET['lid']);
    if ($transaction->activateTransaction() == true) {
        $db->generateSessionAlertSuccess('Transaction activated successfully');
        $db->commit_transaction();
        header("Location: transactions.php");
        exit();
    } else {
        $db->generateAlertError($transaction->errorDescription);
        $db->rollback_transaction();
    }
}


if ($_GET['lid'] == '') {
    header('Location: transactions.php');
    exit();
}

$data = $db->query_fetch('
    SELECT * FROM ac_transactions 
    LEFT OUTER JOIN ac_documents ON acdoc_document_ID = actrn_document_ID 
    WHERE actrn_transaction_ID = ' . $_GET['lid']);
//print_r($data);
$db->show_header();
?>

    <div class="container">

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">Transaction Change Status</div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                        <div class="row">
                            <div class="col-3 alert alert-info">Number</div>
                            <div class="col-3 alert"><?php echo $data['actrn_transaction_number']; ?></div>
                            <div class="col-3 alert alert-info">Status</div>
                            <div class="col-3 alert"><?php echo $data['actrn_status']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-3 alert alert-info">Document Date</div>
                            <div class="col-3 alert"><?php echo $db->convert_date_format($data['actrn_transaction_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                            <div class="col-3 alert alert-info">Reference Date</div>
                            <div class="col-3 alert"><?php echo $db->convert_date_format($data['actrn_reference_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-3 alert alert-info">Document</div>
                            <div class="col-9 alert"><?php echo $data['acdoc_code'] . " " . $data['acdoc_name']; ?></div>
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
                                Back
                            </button>
                            <?php
                            if ($data['actrn_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Activate" style="width: 140px;"
                                        class="btn inapolActiveColor" onclick="lockTransaction();">
                                    Lock
                                </button>

                                <button type="button" value="Delete" style="width: 140px;"
                                        class="btn inapolDeletedColor" onclick="deleteTransaction();">
                                    Delete
                                </button>
                                <?php
                            }
                            if ($data['actrn_status'] == 'Locked') {
                                ?>
                                <button type="button" value="Unlock" style="width: 150px;"
                                        class="btn inapolCancelledColor" onclick="unlockTransaction();">
                                    UnLock
                                </button>
                                <button type="button" value="Activate" style="width: 150px;"
                                        class="btn inapolEndorsenentColor" onclick="activateTransaction();">
                                    Activate
                                </button>
                                <?php
                            }
                            ?>
                            <button type="button" value="Modify" style="width: 150px;" class="btn btn-success"
                                    onclick="modifyTransaction();">
                                <?php if ($data['inapol_status'] == 'Outstanding') echo 'Modify'; else echo 'View'; ?>
                            </button>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-lg-1"></div>
        </div>
    </div>
    <script>

        function lockTransaction() {
            if (confirm('Are you sure you want to lock this Transaction?')) {
                window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=lock');
            }
        }

        function deleteTransaction() {
            if (confirm('Are you sure you want to delete this Transaction?')) {
                window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=delete');
            }
        }

        function unlockTransaction() {
            if (confirm('Are you sure you want to UnLock this Transaction?')) {
                window.location.assign('?action=unlock&lid=<?php echo $_GET['lid'];?>');
            }
        }

        function modifyTransaction() {
            window.location.assign('transaction_modify.php?lid=<?php echo $_GET['lid'];?>');
        }

        function activateTransaction() {
            if (confirm('Are you sure you want to Activate this Transaction?')) {
                window.location.assign('?action=activate&lid=<?php echo $_GET['lid'];?>');
            }
        }

        function goBack() {
            window.location.assign('transactions.php');
        }

        $(document).ready(function () {
            <?php
            if ($_GET['action'] == 'issueUnlock') {
                echo 'unlockTransaction();';
            }
            if ($_GET['action'] == 'issueLock') {
                echo 'lockTransaction();';
            }
            ?>
        });
    </script>
<?php
$db->show_footer();
?>