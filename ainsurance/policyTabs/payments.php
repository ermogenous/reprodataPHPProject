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
    if ($policy->policyData['inapol_status'] == 'Active') {

        $table = new draw_table('ina_policy_payments', 'inapp_policy_payment_ID', 'ASC');
        $table->extras .= 'inapp_policy_ID = ' . $_GET['pid'];

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
                                <th scope="col"><?php $table->display_order_links('Commission', 'inapp_commission_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links('Status', 'inapp_status'); ?></th>
                                <th scope="col">
                                    <a href="payment_modify.php?pid=<?php echo $_GET['pid'] . "&type=" . $_GET['type']; ?>">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalLines = 0;
                            while ($row = $table->fetch_data()) {
                                $totalLines++;
                                ?>
                                <tr onclick="editLine(<?php echo $row["inapp_policy_payment_ID"] . "," . $_GET['pid'] . ",'" . $_GET['type'] . "'"; ?>);">
                                    <th scope="row"><?php echo $row["inapp_policy_payment_ID"]; ?></th>
                                    <td><?php echo $row["inapp_payment_date"]; ?></td>
                                    <td><?php echo $row["inapp_amount"]; ?></td>
                                    <td><?php echo $row["inapp_commission_amount"]; ?></td>
                                    <td><?php echo $row["inapp_status"]; ?></td>
                                    <td>
                                        <a href="payment_modify.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $_GET['pid']; ?>"><i
                                                    class="fas fa-edit"></i></a>

                                        <?php if ($row['inapp_status'] == 'Outstanding') { ?>
                                            &nbsp
                                            <a href="payment_delete.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $_GET['pid']; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this policy payment?');"><i
                                                        class="fas fa-minus-circle"></i></a>
                                        <?php }
                                        if ($row['inapp_status'] == 'Outstanding') { ?>
                                            &nbsp
                                            <a href="payments.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $_GET['pid'] . "&action=apply"; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to apply this policy payment?');"><i
                                                        class="fas fa-fast-forward"></i></a>
                                        <?php }
                                        if ($row['inapp_status'] == 'Applied') { ?>
                                            &nbsp
                                            <a href="payments.php?lid=<?php echo $row["inapp_policy_payment_ID"] . "&pid=" . $_GET['pid'] . "&action=reverse"; ?>"
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
            parent.window.frames['premiumTab'].location.reload(true);


            let fixedPx = 200;
            let totalPx = fixedPx + (<?php echo $totalLines;?> * 60
        )
            ;
            $('#paymentsTab', window.parent.document).height(totalPx + 'px');
            parent.window.frames['installmentsTab'].location.reload(true);
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
