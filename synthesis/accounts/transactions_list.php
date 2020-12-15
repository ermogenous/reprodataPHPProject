<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 18/05/2020
 * Time: 11:00
 */

include("../../include/main.php");
include("../synthesis_class.php");

$db = new Main(1);
$db->admin_title = "Synthesis Accounts Transaction List";

$syn = new Synthesis();
$transactionList = $syn->getAccountTransactionList($_GET['lid']);
if ($syn->error == true) {
    $db->generateAlertError($syn->errorDescription);
}

$db->show_header();

if ($syn->error == false) {
    ?>

    <div class="container">
        <div class="col-12 alert alert-primary text-center">
            <b>Account <?php echo $_GET['lid']; ?> Transaction List</b>
        </div>

        <div class="row form-group">
            <table class="table table-hover table-light">
                <thead class="alert alert-secondary">
                <tr>
                    <th width="20"></th>
                    <th>Address</th>
                    <th>Document Number</th>
                    <th>Doc.Date</th>
                    <th>Line Comment</th>
                    <th>Amount</th>
                    <th>Account Balance</th>
                    <th>Stock Balance</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($transactionList as $row) {
                    //print_r($row);
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row->act_address_code;?></td>
                        <td><?php echo $row->act_document_number;?></td>
                        <td><?php echo $db->convert_date_format($row->act_document_date,'dd-mm-yyyy','dd/mm/yyyy');?></td>
                        <td><?php echo $row->act_line_comment;?></td>
                        <td><?php echo $row->act_account_amount;?></td>
                        <td><?php echo $row->act_account_balance;?></td>
                        <td><?php echo $row->act_stock_balance;?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php
}//if no error in getting transaction list
$db->show_footer();
?>