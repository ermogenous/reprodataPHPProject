<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 15/05/2020
 * Time: 13:20
 */

include("../../include/main.php");
include("../main_extender.php");
include("../synthesis_class.php");
include('../../scripts/form_builder_class.php');

$db = new MainSynthesis(1);
$db->admin_title = "Synthesis Inventory List";


$syn = new Synthesis();

if ($syn->error == true) {
    $db->generateAlertError($syn->errorDescription);
}
$searchWhere = '';
if ($_POST['action'] == 'search'){
    if ($_POST['searchInventory'] != ''){
        $searchWhere = "(stp_product_code LIKE '%".$_POST['searchInventory']."%' OR stp_product_description LIKE '%".$_POST['searchInventory']."%')";
    }
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

if ($syn->error != true) {
    ?>

    <div class="container">
        <div class="row alert alert-primary">
            <div class="col-12 text-center">
                <b>Inventory List</b>
            </div>
        </div>


        <div class="card" id="searchBody">
            <div class="card-body">
                <form class="form-inline" action="" method="post">
                    <label for="" class="mr-sm-2">Inventory</label>


                    <input type="text" class="form-control mb-2 mr-sm-2" value="<?php echo $_POST['searchInventory']; ?>"
                           name="searchInventory" id="searchInventory">

                    <input type="hidden" name="action" value="search">


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


    <div class="row" style="height: 20px;"></div>

    <?php
    //$inventoryList = $syn->getInventoryList($searchWhere);
    echo "test";
    if (!empty($inventoryList)) {
        ?>
        <div class="row form-group">
            <table class="table table-hover table-light">
                <thead class="alert alert-secondary">
                <tr>
                    <th width="20"></th>
                    <th>Product Code</th>
                    <th>Description</th>
                    <th>Short Desc.</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($inventoryList as $value) {
                    if ($value->stp_product_code != '') {
                        ?>
                        <tr onclick="editLine('<?php echo $value->stp_product_code; ?>')">
                            <td></td>
                            <td><?php echo $value->stp_product_code; ?></td>
                            <td><?php echo $value->stp_product_description; ?></td>
                            <td><?php echo $value->stp_product_short; ?></td>
                            <td><?php echo $value->stp_product_qty; ?></td>
                            <td>
                                <a href="product_detail.php?lid=<?php echo $value->stp_product_code; ?>"
                                   title="View/Modify Account">
                                    <i class="fas fa-list"></i>
                                </a>
                                <!--
                                <a href="transactions_list.php?lid=<?php echo $value->stp_product_code; ?>"
                                   title="Transaction List"
                                   onclick="ignoreEdit=true;">
                                    <i class="fas fa-list"></i>
                                </a>
                                -->
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
                startPageLoader();
                window.location.assign("product_detail.php?lid=" + id);
            }
        }

        function resetForm(){
            $('#searchInventory').val('');

        }

    </script>
    <?php
}
$db->show_footer();
?>
