<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/11/2019
 * Time: 10:54 ΠΜ
 */

include("../include/main.php");
include("customer_class.php");
include('../accounts/entities/entities_class.php');
include('../accounts/accounts/accounts_class.php');

$db = new Main();
$db->admin_title = "Customers Modify Entity Tab";

if ($_GET['lid'] == '') {
    header("Location: ../home.php");
    exit();
} else {
    $customer = new Customers($_GET['lid']);
    //print_r($customer->getCustomerData());
}

if ($_GET['action'] == 'createEntity') {
    $customer->createACEntity();
    if ($customer->error == false) {
        $db->generateAlertSuccess('Entity Created Successfully');
    } else {
        $db->generateAlertError($customer->errorDescription);
    }
} else if ($_GET['action'] == 'createDebtor') {

    if ($customer->getCustomerData()['cst_entity_ID'] > 0){
        $db->start_transaction();
        $entity = new AccountsEntity($customer->getCustomerData()['cst_entity_ID']);
        $entity->createDebtorsAccount();
        if ($entity->error == true){
            $db->generateAlertError($entity->errorDescription);
            $db->rollback_transaction();
        }
        else {
            $db->generateAlertSuccess('Debtors account for entity created successfully');
        }
        $db->commit_transaction();
    }
    else {
        $db->generateAlertError('No entity is found to create debtor account.');
    }

} else if ($_GET['action'] == 'createCreditor') {
    if ($customer->getCustomerData()['cst_entity_ID'] > 0){
        $db->start_transaction();
        $entity = new AccountsEntity($customer->getCustomerData()['cst_entity_ID']);
        $entity->createCreditorsAccount();
        if ($entity->error == true){
            $db->generateAlertError($entity->errorDescription);
            $db->rollback_transaction();
        }
        else {
            $db->generateAlertSuccess('Creditor account for entity created successfully');
        }
        $db->commit_transaction();
    }
    else {
        $db->generateAlertError('No entity is found to create creditor account.');
    }
}
$db->show_empty_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center alert alert-primary">Accounts Entity</div>
        </div>
        <?php
        if ($customer->getCustomerData()['cst_entity_ID'] > 0) {
            $entity = new AccountsEntity($customer->getCustomerData()['cst_entity_ID']);
            ?>
            <div class="row">
                <div class="col-12">
                    Entity ID: <?php echo $entity->getEntityData()['acet_entity_ID']; ?><br>
                    Entity Name: <?php echo $entity->getEntityData()['acet_name']; ?><br>
                    Entity Description: <?php echo $entity->getEntityData()['acet_description']; ?><br>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-12">
                    Entity is not found.<br>
                    <button class="btn btn-primary" onclick="createEntity();">Create Entity</button>
                    <script>
                        function createEntity() {
                            if (confirm('This will create an Entity in the accounts. Are you sure?')) {
                                window.location.assign('customer_entity_tab.php?lid=<?php echo $_GET['lid'];?>&action=createEntity');
                            }
                        }
                    </script>
                </div>
            </div>
        <?php } ?>

        <div class="row" style="height: 25px;"></div>

        <?php
        if ($customer->getCustomerData()['cst_entity_ID'] > 0) {
            ?>
            <div class="row">
                <div class="col-12 text-center alert alert-primary">Entity Account - Debtor Account</div>
            </div>

        <?php
        if ($entity->debtorAccountExists() == true) {

        $debtorData = $entity->getDebtorAccountData();
        $account = new AdvAccounts($entity->getDebtorAccountData()['acacc_account_ID']);
        $balances = $account->getAccountBalance();

        ?>
            <div class="row">
                <div class="col-12">
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
                            <th scope="row"><?php echo $account->getAccountData()['acacc_account_ID'];?></th>
                            <td><?php echo $account->getAccountData()['acacc_code'];?></td>
                            <td><?php echo $account->getAccountData()['acacc_name'];?></td>
                            <td><?php echo $account->getAccountData()['acacc_active'];?></td>
                            <td align="center"><?php echo $balances['Active']?></td>
                            <td align="center"><?php echo $balances['Locked']?></td>
                            <td align="center"><?php echo $balances['Outstanding']?></td>
                            <td align="center"><?php echo $balances['Total']?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php
        }
        else {
        ?>
            <div class="row">
                <div class="col-12">
                    No debtors account is found <br>
                    <button class="btn btn-success" onclick="createDebtorAccount();return false;">Create Debtors Account
                    </button>
                </div>
            </div>
            <script>
                function createDebtorAccount() {
                    if (confirm('This will create a debtor account of the entity. Are you sure?')) {
                        window.location.assign('customer_entity_tab.php?lid=<?php echo $_GET['lid'];?>&action=createDebtor');
                    }
                }
            </script>
        <?php
        }
        ?>

            <div class="row">
                <div class="col-12 text-center alert alert-primary">Entity Account - Creditor Account</div>
            </div>
        <?php
        if ($entity->creditorAccountExists() == true){
            $account = new AdvAccounts($entity->getCreditorAccountData()['acacc_account_ID']);
            $balances = $account->getAccountBalance();
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
                    <th scope="row"><?php echo $account->getAccountData()['acacc_account_ID'];?></th>
                    <td><?php echo $account->getAccountData()['acacc_code'];?></td>
                    <td><?php echo $account->getAccountData()['acacc_name'];?></td>
                    <td><?php echo $account->getAccountData()['acacc_active'];?></td>
                    <td align="center"><?php echo $balances['Active']?></td>
                    <td align="center"><?php echo $balances['Locked']?></td>
                    <td align="center"><?php echo $balances['Outstanding']?></td>
                    <td align="center"><?php echo $balances['Total']?></td>
                </tr>
            </table>
            <?php
        }//if creditor exists
        else {
            ?>
            <div class="row">
                <div class="col-12">
                    No Creditor account is found <br>
                    <button class="btn btn-success" onclick="createCreditorAccount();return false;">Create Creditors Account
                    </button>
                </div>
            </div>
            <script>
                function createCreditorAccount(){
                    if (confirm('This will create a creditor account of the entity. Are you sure?')) {
                        window.location.assign('customer_entity_tab.php?lid=<?php echo $_GET['lid'];?>&action=createCreditor');
                    }
                }
            </script>
            <?php
        }//no creditor account exists
        } else {
        ?>
            <div class="row">
                <div class="col-12">
                    No Entity exists. Must first create entity.
                </div>
            </div>
            <?php
        }
        ?>
    </div>

<?php
$db->show_empty_footer();
?>