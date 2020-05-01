<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 12:58 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include("installments_class.php");
include('../policy_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Installments";

if ($_GET['action'] == 'calculate' && $_GET['pid'] != '') {
    $inst = new Installments($_GET['pid']);
    $db->start_transaction();
    if ($inst->updateInstallmentsAmountAndCommission() == true) {
        $db->generateAlertSuccess('Amounts/Commissions Updated');
    } else {
        $db->generateAlertError($inst->errorDescription);
    }
    $db->commit_transaction();
} else if ($_GET['action'] == 'clearall' && $_GET['pid'] != '') {
    $db->start_transaction();
    $inst = new Installments($_GET['pid']);
    if ($inst->deleteAllInstallments() == true) {
        $db->commit_transaction();
        $db->generateAlertSuccess('All installments Deleted successfully');
    } else {
        $db->rollback_transaction();
        $db->generateAlertError('An error occurred deleting all installments');
    }
} else if ($_GET['action'] == 'genrecursive') {
    $db->start_transaction();
    $inst = new Installments($_GET['pid']);
    if ($inst->generateRecursiveInstallments($_GET['amount']) == true) {

        //update the amounts/commissions
        $inst->updateInstallmentsAmountAndCommission();

        $db->commit_transaction();
        $db->generateAlertSuccess('Recursive installments generated successfully');
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($inst->errorDescription);
    }
} else if ($_GET['action'] == 'gendivided') {
    $db->start_transaction();
    $inst = new Installments($_GET['pid']);
    if ($inst->generateDividedInstallments($_GET['amount']) == true) {

        //update the amounts/commissions
        $inst->updateInstallmentsAmountAndCommission();

        $db->commit_transaction();
        $db->generateAlertSuccess('Divided installments generated successfully');
    } else {
        $db->rollback_transaction();
        $db->generateAlertError($inst->errorDescription);
    }
}

//if not items exists then show alert and hide everything else


if ($_GET['pid'] > 0) {

    //get the policy
    $policy = new Policy($_GET['pid']);

    $table = new draw_table('ina_policy_installments', 'inapi_policy_installments_ID', 'ASC');
    $table->extras .= 'inapi_policy_ID = ' . $policy->policyData['inapol_installment_ID'];

    $table->generate_data();

    $policy = new Policy($_GET['pid']);
    if ($policy->getTotalItems() == 0 && $policy->policyData['inapol_process_status'] != 'Cancellation') {
        $db->generateAlertError(
                $db->showLangText('Must Insert Vehicle First','Πρέπει να εισαχθεί αυτοκίνητο πρώτα')
        );
    }


    //$db->start_transaction();
    //$policy->applyEndorsementAmount();
    //$db->rollback_transaction();

    $db->show_empty_header();

    $totalLines = 0; //number of records found to resize the window accordingly
    if ($policy->getTotalItems() > 0 || $policy->policyData['inapol_process_status'] == 'Cancellation') {
//echo $table->sql;
//echo $_GET['type'];
        ?>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="height: 25px;"></div>
                <?php if ($policy->policyData['inapol_status'] == 'Outstanding') { ?>
                    <div class="col-3">
                        <input type="button" value="<?php echo $db->showLangText('Calculate Premium','Υπολογισμός Ασφαλίστρων');?>" class="btn btn-primary"
                               onclick="calculatePremium();">
                    </div>
                    <div class="col-2">
                        <input type="button" value="<?php echo $db->showLangText('Clear All','Καθαρισμός');?>" class="btn btn-danger" onclick="clearAll();">
                    </div>
                    <div class="col-2"></div>
                    <div class="col-1"></div>
                    <div class="col-2"></div>
                    <div class="col-2"></div>
                    <div class="col-2"></div>
                    <script>
                        function calculatePremium() {
                            if (confirm(
                                <?php echo $db->showLangText("'Are you sure you want to calculate? This will replace existing installments amount'",
                                    "'Είστε βέβαιοι ότι θέλετε να υπολογίσετε; Αυτό θα αντικαταστήσει το ποσό των υφιστάμενων δόσεων'");?>
                            )) {
                                window.location.assign('?pid=<?php echo $_GET['pid'];?>&action=calculate');
                            }
                        }

                        function clearAll() {
                            if (confirm(
                                <?php echo $db->showLangText("'Are you sure you want to delete all installments?'",
                                    "'Είστε βέβαιοι ότι θέλετε να διαγράψετε όλες τις δόσεις;'");?>
                            )) {
                                window.location.assign('?pid=<?php echo $_GET['pid'];?>&action=clearall');
                            }
                        }

                    </script>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center"><?php $table->show_pages_links(); ?></div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="alert alert-success">
                            <tr>
                                <th scope="col"><?php $table->display_order_links($db->showLangText('Doc.Date','Ημερομηνία'), 'inapi_document_date'); ?></th>
                                <th scope="col"><?php $table->display_order_links($db->showLangText('Amount','Ποσό'), 'inapi_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links($db->showLangText('Paid','Πληρωμένο'), 'inapi_paid_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links($db->showLangText('Commission/Paid','Προμήθεια/Πληρωμένη'), 'inapi_commission_amount'); ?></th>
                                <th scope="col"><?php $table->display_order_links($db->showLangText('Status','Κατάσταση'), 'inapi_paid_status'); ?></th>
                                <th scope="col">
                                    <?php if ($policy->policyData['inapol_status'] == 'Outstanding' && $policy->policyData['inapol_process_status'] != 'Endorsement') { ?>
                                        <a href="installment_modify.php?pid=<?php echo $_GET['pid'] ?>">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                    <?php } ?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            //if endorsement get all changes to show
                            $unallocated = '';
                            if ( ($policy->policyData['inapol_process_status'] == 'Endorsement' || $policy->policyData['inapol_process_status'] == 'Cancellation')
                                && $policy->policyData['inapol_status'] == 'Outstanding') {
                                $endChanges = $policy->getSplitEndorsementAmount();

                                $amountAddMinus = [];
                                $commAddMinus = [];
                                foreach ($endChanges as $name => $value) {
                                    if ($name != 'new') {
                                        $amountAddMinus['total'] += $value['amount'];
                                        $commAddMinus['total'] += $value['commission'];
                                        if ($value['amount'] > 0) {
                                            $amountAddMinus[$name] .= ' <span style="color: green;">(+' . $value['amount'] . ")</span>";
                                            $commAddMinus[$name] .= ' <span style="color: green;">(+' . $value['commission'] . ")</span>";
                                        } else {
                                            $amountAddMinus[$name] .= ' <span style="color: red;">(' . $value['amount'] . ")</span>";
                                            $commAddMinus[$name] .= ' <span style="color: red;">(' . $value['commission'] . ")</span>";
                                        }
                                    }
                                }

                                if ($amountAddMinus['total'] > 0){
                                    $amountAddMinus['total'] = ' <span style="color: green;">(+' . $amountAddMinus['total'] . ")</span>";
                                    $commAddMinus['total'] = ' <span style="color: green;">(+' . $commAddMinus['total'] . ")</span>";
                                }
                                else {
                                    $amountAddMinus['total'] = ' <span style="color: red;">(' . $amountAddMinus['total'] . ")</span>";
                                    $commAddMinus['total'] = ' <span style="color: red;">(' . $commAddMinus['total'] . ")</span>";
                                }

                                //check if unallocated entry exists
                                if ($endChanges['unallocated']['amount'] != 0) {
                                    $unallocated = '<span style="color:red;"
                                        >'.$db->showLangText('Unallocated Entry will be created with the amount: ',
                                            'Μη κατανεμημένη εγγραφή θα δημιουργηθεί με το ποσό:')
                                        . $endChanges['unallocated']['amount'] . "</span>";
                                }
                                if ($endChanges['new']['amount'] != 0 || $endChanges['new']['commission'] != 0) {
                                    $newEntry = '<br><span style="color:red;"
                                        >'.$db->showLangText('New entry will be created with the Amount: ',
                                            'Θα δημιουργηθεί νέα εγγραφή με το ποσό: ') . $endChanges['new']['amount'] .
                                        $db->showLangText(' and Commission: ', ' και προμήθεια'). $endChanges['new']['commission'] . "</span>";
                                }
                            }

                            $amountSum = 0;
                            $commSum = 0;
                            while ($row = $table->fetch_data()) {
                                $totalLines++;
                                $amountSum += $row["inapi_amount"];
                                $commSum += $row["inapi_commission_amount"];
                                $paidSum += $row["inapi_paid_amount"];
                                $commPaidSum += $row['inapi_paid_commission_amount'];
                                ?>
                                <tr onclick="editLine(<?php echo $row["inapi_policy_installments_ID"] . "," . $_GET['pid'] . ",'" . $_GET['type'] . "'"; ?>);">
                                    <td><?php echo $db->convert_date_format($row["inapi_document_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></td>
                                    <td><?php echo $row["inapi_amount"] . $amountAddMinus[$row["inapi_policy_installments_ID"]]; ?></td>
                                    <td><?php echo $row["inapi_paid_amount"]; ?></td>
                                    <td><?php echo $row["inapi_commission_amount"] . "/" . $row['inapi_paid_commission_amount'] . $commAddMinus[$row["inapi_policy_installments_ID"]]; ?></td>
                                    <td><?php echo $row["inapi_paid_status"]; ?></td>
                                    <td>
                                        <?php if ($policy->policyData['inapol_status'] == 'Outstanding' && $policy->policyData['inapol_process_status'] != 'Endorsement') { ?>
                                            <a href="installment_modify.php?lid=<?php echo $row["inapi_policy_installments_ID"] . "&pid=" . $_GET['pid']; ?>"><i
                                                        class="fas fa-edit" title="<?php echo $db->showLangText('Modify Installment','Επεξεργασία Δόσης');?>"></i></a>&nbsp
                                            <a href="installment_delete.php?lid=<?php echo $row["inapi_policy_installments_ID"] . "&pid=" . $_GET['pid']; ?>"
                                               onclick="ignoreEdit = true;
                               return confirm(
                                   <?php echo $db->showLangText("'Are you sure you want to delete this policy installment?'",
                                       "'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτήν την δόση'");?>
                                   );"><i
                                                        class="fas fa-minus-circle" title="<?php echo $db->showLangText('Delete Installment','Διαγραφή Δόσης');?>"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td  class="text-right"><b>Total:</b></td>
                                <td><b><?php echo $amountSum.$amountAddMinus['total']; ?></b></td>
                                <td><b><?php echo $paidSum; ?></b></td>
                                <td><b><?php echo $commSum . "/" . $commPaidSum.$commAddMinus['total']; ?></b></td>
                                <td><b>Unpaid:</b> <?php echo $amountSum - $paidSum; ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php if ($policy->policyData['inapol_status'] == 'Outstanding' && $policy->policyData['inapol_process_status'] != 'Cancellation' && $policy->policyData['inapol_process_status'] != 'Endorsement') { ?>
                <div class="row">
                    <div class="col-12"><?php echo $unallocated . $newEntry; ?></div>
                    <div class="col-4">
                        <?php echo $db->showLangText('Generate Recursive Installments','Δημιούργησε Συνεχόμενες Δόσεις');?>
                    </div>
                    <div class="col-2">
                        <select name="genRescursiveAmount" id="genRescursiveAmount"
                                class="form-control">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="button" value="<?php echo $db->showLangText('Generate', 'Δημιουργία');?>" class="btn btn-secondary"
                               onclick="generateRecursive(<?php echo $_GET['pid']; ?>);">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" style="height: 15px;"></div>
                </div>
                <div class="row">

                    <div class="col-4">
                        <?php echo $db->showLangText('Generate Divided Installments','Δημιούργησε Διαιρούμενες Δόσεις');?>
                    </div>
                    <div class="col-3">
                        <select name="genDividedAmount" id="genDividedAmount"
                                class="form-control">
                            <option value="12"><?php echo $db->showLangText('Monthly','Μηνιαία');?> - 12</option>
                            <option value="4"><?php echo $db->showLangText('Quarterly','Τριμηνιαία');?> - 4</option>
                            <option value="2"><?php echo $db->showLangText('Semi-Yearly','Εξαμηνιαία');?> - 2</option>
                            <option value="1"><?php echo $db->showLangText('Yearly','Ετήσια');?> - 1</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <input type="button" value="<?php echo $db->showLangText('Generate', 'Δημιουργία');?>" class="btn btn-secondary"
                               onclick="generateDivided(<?php echo $_GET['pid']; ?>);">
                    </div>

                </div>
            <?php } ?>
        </div>

        <?php
    }//if items exists

}//if policy exists


?>
    <script>

        function generateRecursive(pid) {
            let amount = $('#genRescursiveAmount').val();
            window.location.assign('installments.php?pid=' + pid + '&action=genrecursive&amount=' + amount);
        }

        function generateDivided(pid) {
            let amount = $('#genDividedAmount').val();
            window.location.assign('installments.php?pid=' + pid + '&action=gendivided&amount=' + amount);
        }

        var ignoreEdit = false;

        function editLine(id, pid, type) {
            <?php if ($policy->policyData['inapol_status'] == 'Outstanding' && $policy->policyData['inapol_process_status'] != 'Endorsement') { ?>
            if (ignoreEdit === false) {
                window.location.assign('installment_modify.php?lid=' + id + '&pid=' + pid);
            }
            <?php } ?>
        }

        $(document).ready(function () {
            let fixedPx = 400;
            let totalPx = fixedPx + (<?php echo $totalLines;?> * 60
        )
            ;

            <?php if ($policy->policyData['inapol_status'] != 'Outstanding') { ?>
            totalPx = totalPx - 250;
            <?php }?>
            $('#installmentsTab', window.parent.document).height(totalPx + 'px');
        });

    </script>
<?php
$db->show_empty_footer();
?>