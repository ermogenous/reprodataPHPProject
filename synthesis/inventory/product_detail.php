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

$db = new Main(0);
$db->admin_title = "Synthesis Product Detail";


$syn = new Synthesis();
if (strpos($_SESSION['synthesis_menu'], 'ST,') === false) {
    header("Location: ".$main['site_url']."/home.php");
    exit();
}


if ($syn->error == true) {
    $db->generateAlertError($syn->errorDescription);
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
                <b>Product Details</b>
            </div>
        </div>

    </div>

    <div class="row" onclick="showHideSearch();" id="showSearchRow" style="display: none; cursor: pointer">
        <div class="col-sm-12 text-right">
            <?php echo $db->showLangText('Show Search', 'Εμφάνιση Αναζήτησης'); ?> <i class="fas fa-plus"></i>
        </div>
    </div>


    <div class="row" style="height: 20px;"></div>
    <table width="100%">
        <tr>
            <td width="40"></td>
            <td>
                <div class="container-fluid">
                    <?php
                    $productList = $syn->getProductDetail($_GET['lid']);
                    //print_r($productList);
                    if (!empty($productList)) {
                        ?>
                        <div class="row form-group">
                            <table class="table table-hover table-light">
                                <thead class="alert alert-secondary">
                                <tr class="font-weight-bold">
                                    <td width="20"></td>
                                    <td>Location</td>
                                    <td align="center">Quantity</td>
                                    <td align="center">Cost</td>
                                    <td align="center">U/Process</td>
                                    <td align="center">G.I.T</td>
                                    <td align="center">Free</td>
                                    <td align="center">Alt Free</td>
                                    <td align="center">P.Orders</td>
                                    <td align="center">S.Orders</td>
                                    <td align="center">Allocated</td>
                                    <td align="center">Reserved</td>
                                    <td align="center">Quotations</td>
                                    <td align="center">Adjust</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($productList as $value) {
                                    if ($value->stp_item_code != '') {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $value->stp_location_description."-".$value->stp_location_code; ?></td>
                                            <td align="center"><?php echo $value->stp_location_quantity; ?></td>
                                            <td align="center"><?php echo $value->stp_location_cost; ?></td>
                                            <td align="center"><?php echo $value->stp_location_under_process; ?></td>
                                            <td align="center"><?php echo $value->stp_location_git; ?></td>
                                            <td align="center"><?php echo $value->stp_free_quantity; ?></td>
                                            <td align="center"><?php echo $value->stp_free_quantity_alternative; ?></td>
                                            <td align="center"><?php echo $value->stp_location_purchase_orders; ?></td>
                                            <td align="center"><?php echo $value->stp_location_sales_orders; ?></td>
                                            <td align="center"><?php echo $value->stp_location_allcated; ?></td>
                                            <td align="center"><?php echo $value->stp_location_reserved; ?></td>
                                            <td align="center"><?php echo $value->stp_location_quotations; ?></td>
                                            <td align="center"><?php echo $value->stp_location_adjustment; ?></td>
                                        </tr>
                                        <?php
                                    }//do not show the empty rows
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <input type="button" class="btn btn-secondary" value="Back" onclick="window.location.assign('inventory.php');">
                            </div>
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
            </td>
            <td width="40"></td>
        </tr>
    </table>


    <?php
}
$db->show_footer();
?>
