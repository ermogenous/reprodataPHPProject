<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/3/2019
 * Time: 3:31 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include("payments_class.php");
include('../policy_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Payments";

if ($_GET['action'] == 'apply' && $_GET['lid'] != '') {
    $db->working_section = 'Posting Payment: ' . $_GET['lid'];
    $db->start_transaction();
    $payment = new PolicyPayment($_GET['lid']);
    if ($payment->postPayment() == true) {

        $db->commit_transaction();
        $db->generateAlertSuccess('Payment Posted Successfully');
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($payment->errorDescription);
    }

}

if ($_GET['action'] == 'reverse' && $_GET['lid'] != '') {
    $db->working_section = 'Reversing Payment: ' . $_GET['lid'];
    $db->start_transaction();
    $payment = new PolicyPayment($_GET['lid']);
    if ($payment->reversePostPayment() == true) {

        $db->commit_transaction();
        $db->generateAlertSuccess('Payment Reversed Successfully');
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($payment->errorDescription);
    }

}

$db->show_empty_header();


if ($_GET['pid'] > 0) {

    $policy = new Policy($_GET['pid']);
    if ($policy->policyData['inapol_status'] == 'Active' || $policy->policyData['inapol_status'] == 'Archived') {

        $table = new draw_table('ina_policy_payments', 'inapp_policy_payment_ID', 'ASC');
        $table->extras .= 'inapp_policy_ID = ' . $policy->installmentID;

        $table->generate_data();
        ?>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="height: 25px;">

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center"><?php $table->show_pages_links(); ?></div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="alert alert-success">
                            <tr>
                                <th scope="col"><?php $table->display_order_links('ID', 'inapp_policy_payment_ID'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Date', 'inapp_payment_date'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Amount', 'inapp_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links('All.Amount', 'inapp_allocated_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links('All.Commission', 'inapp_allocated_commission'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Status', 'inapp_status'); ?></th>
                                <th scope="col">
                                    <a href="payment_modify.php?pid=<?php echo $policy->installmentID . "&type=" . $_GET['type']; ?>">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalLines = 0;
                            $maxPaymentID = $db->query_fetch("
                                            SELECT MAX(inapp_policy_payment_ID)as clo_max FROM ina_policy_payments 
                                            WHERE inapp_policy_ID = ".$policy->installmentID." AND inapp_status = 'Applied' AND inapp_locked != 1");
                            $minPaymentID = $db->query_fetch("
                                            SELECT MIN(inapp_policy_payment_ID)as clo_min FROM ina_policy_payments 
                                            WHERE inapp_policy_ID = ".$policy->installmentID." AND inapp_status = 'Outstanding' AND inapp_locked != 1");
                            while ($row = $table->fetch_data()) {
                                $totalLines++;
                                ?>
                                <tr onclick="editLine(<?php echo $row["inapp_policy_payment_ID"] . "," . $policy->installmentID . ",'" . $_GET['type'] . "'"; ?>);">
                                    <th scope="row"><?php echo $row["inapp_policy_payment_ID"]; ?></th>
                                    <td><?php echo $row["inapp_payment_date"]; ?></td>
                                    <td><?php echo $row["inapp_amount"]; ?></td>
                                    <td><?php echo $row["inapp_allocated_amount"]; ?></td>
                                    <td><?php echo $row["inapp_allocated_commission"]; ?></td>
                                    <td><?php echo $row["inapp_status"]; ?></td>
                                    <td>
                                        <?php if ($row['inapp_status'] == 'Outstanding') { ?>
                                            <a href="payment_modify.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $policy->installmentID; ?>"><i
                                                        class="fas fa-edit"></i></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="payment_modify.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $policy->installmentID; ?>"><i
                                                        class="fas fa-eye"></i></a>
                                            <?php
                                        }
                                        if ($row['inapp_status'] == 'Outstanding') { ?>
                                            &nbsp
                                            <a href="payment_delete.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $policy->installmentID; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this policy payment?');"><i
                                                        class="fas fa-minus-circle"></i></a>
                                        <?php }
                                        if ($row['inapp_status'] == 'Outstanding' && $row['inapp_policy_payment_ID'] == $minPaymentID['clo_min']) { ?>
                                            &nbsp
                                            <a href="payments.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $policy->installmentID . "&action=apply"; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to apply this policy payment?');"><i
                                                        class="fas fa-fast-forward"></i></a>
                                        <?php }
                                        if ($row['inapp_status'] == 'Applied'
                                            && $row['inapp_policy_payment_ID'] == $maxPaymentID['clo_max']
                                            && $row['inapp_locked'] != 1) { ?>
                                            &nbsp
                                            <a href="payments.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $policy->installmentID . "&action=reverse"; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to reverse this policy payment?');"><i
                                                        class="fas fa-fast-backward"></i></a>

                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>

            var ignoreEdit = false;

            function editLine(id, pid, type) {
                if (ignoreEdit === false) {
                    window.location.assign('payment_modify.php?lid=' + id + '&pid=' + pid + '&type=' + type);
                }
            }

            //every time this page loads reload the premium tab
            $(document).ready(function () {

                <?php if ($_GET['rel'] == 'yes') { ?>
                parent.window.frames['premTab'].location.reload(true);
                parent.window.frames['installmentsTab'].location.reload(true);
                <?php } ?>

                let fixedPx = 200;
                let totalPx = fixedPx + (<?php echo $totalLines;?> * 60);
                $('#paymentsTab', window.parent.document).height(totalPx + 'px');

            });


        </script>
        <?php
    }//if policy is active
    else {
        ?>
        <div class="container-fluid">
            <div class="row" style="height: 25px"></div>
            <div class="row">
                <div class="col-12 text-center alert alert-danger">Policy must be active to insert payments.</div>
            </div>
        </div>
        <script>
            $('#paymentsTab', window.parent.document).height(100 + 'px');
        </script>
        <?php
    }

}
$db->show_empty_footer();
?>
