<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 15/05/2020
 * Time: 13:20
 */

include("../../include/main.php");
include("../synthesis_class.php");
include('../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Synthesis Account List";


$syn = new Synthesis();

//$accountList = $syn->getAccountList();
if ($syn->error == true) {
    $db->generateAlertError($syn->errorDescription);
}
//print_r($accountList);

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

if ($syn->error != true) {
    ?>

    <div class="container">
        <div class="row alert alert-primary">
            <div class="col-12 text-center">
                <b>Account List</b>
            </div>
        </div>


        <div class="card" id="searchBody">
            <div class="card-body">
                <form class="form-inline" action="" method="post">
                    <label for="" class="mr-sm-2">Account</label>


                    <input type="text" class="form-control mb-2 mr-sm-2" value="<?php echo $_POST['searchAccount']; ?>"
                           name="searchAccount" id="searchAccount">


                        <input type="button" value="<?php echo $db->showLangText('Reset', 'Καθαρισμός'); ?>"
                               class="btn btn-warning" onclick="resetForm();">
                        <input type="submit" value="<?php echo $db->showLangText('Search', 'Αναζήτηση'); ?>"
                               class="btn btn-primary" id="Search">
                </form>
            </div>

            <script>
                function resetForm() {
                    $('#srgStatus').val('ALL');
                    $('#srgProcessStatus').val('ALL');
                    $('#srgCustomer').val('');
                    $('#srgPolicy').val('');
                    $('#srgCompany').val('');
                }
            </script>
            <div class="row" style="cursor: pointer;" onclick="showHideSearch();">
                <input type="hidden" id="searchBodyActive" value="1">
                <div class="col-sm-12 text-right">
                    <?php echo $db->showLangText('Hide Search', 'Απόκρυψη Αναζήτησης'); ?> <i
                            class="fas fa-minus"></i>
                </div>
            </div>
            <script>
                function showHideSearch() {
                    if ($('#searchBodyActive').val() == '1') {
                        $('#searchBody').hide();
                        $('#searchBodyActive').val('0');
                        $('#showSearchRow').show();
                    } else {
                        $('#searchBody').show();
                        $('#searchBodyActive').val('1');
                        $('#showSearchRow').hide();
                    }
                }
            </script>
        </div>
    </div>

    <div class="row" onclick="showHideSearch();" id="showSearchRow" style="display: none; cursor: pointer">
        <div class="col-sm-12 text-right">
            <?php echo $db->showLangText('Show Search', 'Εμφάνιση Αναζήτησης'); ?> <i class="fas fa-plus"></i>
        </div>
    </div>


    <div class="row" id="accountsSearchDiv">
        <div class="col-1">
            Account
        </div>
        <div class="col-2">
            <input type="text" class="form-control"
                   id="searchAccount" name="searchAccount" value="">
        </div>
    </div>

    <div class="row" style="height: 20px;"></div>

    <?php
    if (!empty($accountList)) {
        ?>
        <div class="row form-group">
            <table class="table table-hover table-light">
                <thead class="alert alert-secondary">
                <tr>
                    <th>Account Code</th>
                    <th>Description</th>
                    <th>Balance</th>
                    <th>Stock Balance</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($accountList as $value) {
                    if ($value->acc_account_code != '') {
                        ?>
                        <tr onclick="editLine('<?php echo $value->acc_account_code; ?>')">
                            <td><?php echo $value->acc_account_code; ?></td>
                            <td><?php echo $value->acc_address_description; ?></td>
                            <td><?php echo $value->acc_account_balance; ?></td>
                            <td><?php echo $value->acc_stock_balance; ?></td>
                            <td>
                                <a href="account_modify.php?lid=<?php echo $value->acc_account_code; ?>"
                                   title="View/Modify Account">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="transactions_list.php?lid=<?php echo $value->acc_account_code; ?>"
                                   title="Transaction List"
                                   onclick="ignoreEdit=true;">
                                    <i class="fas fa-list"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }//do not show the empty rows
                }

                ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        ?>
        <div class="row form-group">
            <div class="col-12 alert alert-warning">
                No records found!
            </div>
        </div>
        <?php
    }
    ?>
    </div>
    <script>

        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign("account_modify.php?lid=" + id);
            }
        }

    </script>
    <?php
}
$db->show_footer();
?>