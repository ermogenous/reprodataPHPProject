<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/10/2019
 * Time: 12:08 ΜΜ
 */


include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('entities_class.php');
include('../accounts/accounts_class.php');

$db = new Main();
$db->admin_title = "Accounts Entity accounts iframe";

if ($_GET['action'] == 'createDebtorAccount' && $_GET['lid'] > 0) {
    $db->start_transaction();
    $entity = new AccountsEntity($_GET['lid']);
    $entity->createDebtorsAccount();
    if ($entity->error == true) {
        $db->generateAlertError($entity->errorDescription);
        $db->rollback_transaction();
    } else {
        $db->generateAlertSuccess('Debtors account created successfully');
    }
    $db->commit_transaction();
}
if ($_GET['action'] == 'createCreditorAccount' && $_GET['lid'] > 0) {
    $db->start_transaction();
    $entity = new AccountsEntity($_GET['lid']);
    $entity->createCreditorsAccount();
    if ($entity->error == true) {
        $db->generateAlertError($entity->errorDescription);
        $db->rollback_transaction();
    } else {
        $db->generateAlertSuccess('Creditors account created successfully');
    }
    $db->commit_transaction();
}

if ($_GET['lid'] > 0) {
    $entity = new AccountsEntity($_GET['lid']);

}
$db->show_empty_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <strong>Debtor Account</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                if ($entity->debtorAccountExists() == false) {
                    ?>
                    No debtors account is found <br>
                    <button class="btn btn-success" onclick="createDebtorAccount();return false;">Create Debtors Account
                    </button>
                    <?php
                } else {
                    $debtorData = $entity->getDebtorAccountData();
                    $account = new AdvAccounts($entity->getDebtorAccountData()['acacc_account_ID']);
                    $balances = $account->getAccountBalance();
                    //print_r($debtorData);
                    ?>
                    <table class="table table-responsive" width="500">
                        <tr>
                            <th scope="col">A/C ID</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Active B/ce</th>
                            <th scope="col">Locked B/ce</th>
                            <th scope="col">O/S B/ce</th>
                            <th scope="col">Total B/ce</th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $account->getAccountData()['acacc_account_ID']; ?></th>
                            <td><?php echo $account->getAccountData()['acacc_code']; ?></td>
                            <td><?php echo $account->getAccountData()['acacc_name']; ?></td>
                            <td><?php echo $account->getAccountData()['acacc_active']; ?></td>
                            <td align="center"><?php echo $balances['Active'] ?></td>
                            <td align="center"><?php echo $balances['Locked'] ?></td>
                            <td align="center"><?php echo $balances['Outstanding'] ?></td>
                            <td align="center"><?php echo $balances['Total'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <strong>Creditor Account</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                if ($entity->creditorAccountExists() == false) {
                    ?>
                    No creditor account is found <br>
                    <button class="btn btn-success" onclick="createCreditorAccount();return false;">Create Creditors
                        Account
                    </button>
                    <?php
                } else {
                    $account = new AdvAccounts($entity->getCreditorAccountData()['acacc_account_ID']);
                    $balances = $account->getAccountBalance();
                    //print_r($debtorData);
                    ?>
                    <table class="table table-responsive" width="500">
                        <tr>
                            <th scope="col">A/C ID</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Active B/ce</th>
                            <th scope="col">Locked B/ce</th>
                            <th scope="col">O/S B/ce</th>
                            <th scope="col">Total B/ce</th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $account->getAccountData()['acacc_account_ID']; ?></th>
                            <td><?php echo $account->getAccountData()['acacc_code']; ?></td>
                            <td><?php echo $account->getAccountData()['acacc_name']; ?></td>
                            <td><?php echo $account->getAccountData()['acacc_active']; ?></td>
                            <td align="center"><?php echo $balances['Active'] ?></td>
                            <td align="center"><?php echo $balances['Locked'] ?></td>
                            <td align="center"><?php echo $balances['Outstanding'] ?></td>
                            <td align="center"><?php echo $balances['Total'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <strong>Other Accounts</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                $total = 0;
                foreach($entity->otherAccountsRelated as $name => $value){
                    $account = new AdvAccounts($value['acacc_account_ID']);
                    $balances = $account->getAccountBalance();
                    $total++;
                    ?>
                    <table class="table table-responsive" width="500">
                        <tr>
                            <th scope="col">A/C ID</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Active B/ce</th>
                            <th scope="col">Locked B/ce</th>
                            <th scope="col">O/S B/ce</th>
                            <th scope="col">Total B/ce</th>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo $value['acacc_account_ID']; ?></th>
                            <td><?php echo $value['acacc_code']; ?></td>
                            <td><?php echo $value['acacc_name']; ?></td>
                            <td><?php echo $value['acacc_active']; ?></td>
                            <td align="center"><?php echo $balances['Active'] ?></td>
                            <td align="center"><?php echo $balances['Locked'] ?></td>
                            <td align="center"><?php echo $balances['Outstanding'] ?></td>
                            <td align="center"><?php echo $balances['Total'] ?></td>
                        </tr>
                    </table>
                <?php

                }

                if ($total == 0){
                    echo "Nothing Found.";
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function createDebtorAccount() {
            if (confirm('This will create a new account for debtor. Are you sure?')) {
                window.location.assign('entity_accounts_iframe.php?lid=<?php echo $_GET['lid'];?>&action=createDebtorAccount');
            }
        }

        function createCreditorAccount() {
            if (confirm('This will create a new account for creditor. Are you sure?')) {
                window.location.assign('entity_accounts_iframe.php?lid=<?php echo $_GET['lid'];?>&action=createCreditorAccount');
            }
        }
    </script>


<?php
$db->show_empty_footer();
?>