<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/8/2018
 * Time: 11:49 ΜΜ
 */

include("../include/main.php");
include_once("agreements_functions.php");
$db = new Main();
$db->admin_title = "Agreements Modify";

//print_r($_POST);
//echo "\n\n\n\n<br><br><br>";
if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Agreements Insert';

    $db->start_transaction();

    //if has no items then the status will always be pending
    $itemsFound = false;
    for ($i = 1; $i <= 25; $i++) {
        if ($_POST['productLine_' . $i] == 1) {
            $itemsFound = true;
        }
    }

    $agrData['status'] = 'Pending';
    $agrData['process_status'] = 'New';
    $newAgreementNumber = issueAgreementNumber();
    //first insert the agreement
    $agrData['customer_ID'] = $_POST['customerSelectId'];
    $agrData['agreement_number'] = $newAgreementNumber;
    $agrData['replaced_by_agreement_ID'] = 0;
    $agrData['replacing_agreement_ID'] = 0;
    $agrData['starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $agrData['expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    //$agrData['agr_agreement_number'] = $_POST[''];
    $agreementNewID = $db->db_tool_insert_row('agreements', $agrData, '', 1, 'agr_');

    //get the data from the lines
    for ($i = 1; $i <= 100; $i++) {

        if ($_POST['productLine_' . $i] == 1) {
            $lines[$i]['agreement_ID'] = $agreementNewID;
            $lines[$i]['product_ID'] = $_POST['productSelectId_' . $i];
            $lines[$i]['line_number'] = $i;
            $lines[$i]['agreement_type'] = $_POST['agreementType_' . $i];
            $lines[$i]['per_copy_black_cost'] = $_POST['blackPerCopyCost' . $i];
            $lines[$i]['per_copy_color_cost'] = $_POST['colorPerCopyCost' . $i];
            $lines[$i]['rent_cost'] = $_POST['rentCost_' . $i];
            $lines[$i]['location'] = $_POST['location' . $i];
            $lines[$i]['status'] = 'Active';
            $lines[$i]['process_status'] = 'New';
            $lines[$i]['add_remove_stock'] = -1;

            $newSerial = $db->db_tool_insert_row('agreement_items', $lines[$i], '', 1, 'agri_');

            //insert the unique serials
            $uqs["product_ID"] = $_POST['productSelectId_' . $i];
            $uqs["agreement_ID"] = $agreementNewID;
            $uqs["line_number"] = $i;
            $uqs["agreement_number"] = $newAgreementNumber;
            $uqs["unique_serial"] = $_POST["unique_serial_" . $i];
            $uqs["status"] = 'Active';
            //check if the serial already exists
            $uqsCheck = $db->query_fetch("SELECT * FROM unique_serials WHERE uqs_status = 'Active' AND uqs_unique_serial = " . $_POST["unique_serial_" . $i]);
            if ($uqsCheck['uqs_unique_serial_ID'] > 0) {
                $db->generateSessionAlertError('Serial Used is not unique');
                $errorFound = true;
            } else {
                $db->db_tool_insert_row('unique_serials', $uqs, '', 0, 'uqs_');
            }

        }
    }

    if ($itemsFound == true && $errorFound != true) {
        if ($db->get_setting('agr_agreement_status_on_insert') == 'Locked') {
            $agr = new Agreements($newSerial);
            $agr->disableCommit = true;
            if ($agr->lockAgreement() == false) {
                $db->generateSessionDismissError($agr->errorDescription);

            }
        }
    }

    if ($errorFound != true) {
        $db->commit_transaction();
        header("Location: agreements.php");
        exit();
    } else {
        $db->rollback_transaction();
        $data = $agrData;
    }


} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agreements Modify';

    //only allow update if pending agreement
    $data = $db->query_fetch('SELECT * FROM agreements WHERE agr_agreement_ID = ' . $_GET['lid']);
    if ($data['agr_status'] != 'Pending') {
        $db->generateSessionDismissError('Can only edit Pending Agreements');
        header("Location: agreements.php");
        exit();
    }

    $db->start_transaction();

    //first update the agreement
    $agrData['customer_ID'] = $_POST['customerSelectId'];
    //$agrData['status'] = '  Outstanding';
    $agrData['starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $agrData['expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    //$agrData['agr_agreement_number'] = $_POST[''];
    $db->db_tool_update_row('agreements', $agrData, "`agr_agreement_ID` = " . $_POST["lid"],
        $_POST["lid"], '', 'execute', 'agr_');

    //get the data from the lines
    for ($i = 1; $i <= 100; $i++) {
        //echo $i." -> ".$_POST['productLine_'.$i]."<br>";

        $lines[$i]['product_ID'] = $_POST['productSelectId_' . $i];
        $lines[$i]['line_number'] = $_POST['lineNumber_' . $i];
        $lines[$i]['agreement_type'] = $_POST['agreementType_' . $i];
        $lines[$i]['per_copy_black_cost'] = $_POST['blackPerCopyCost' . $i];
        $lines[$i]['per_copy_color_cost'] = $_POST['colorPerCopyCost' . $i];
        $lines[$i]['rent_cost'] = $_POST['rentCost_' . $i];
        $lines[$i]['location'] = $_POST['location' . $i];


        //insert new line
        if ($_POST['productLine_' . $i] == 1) {
            $lines[$i]['agreement_ID'] = $_POST["lid"];
            $lines[$i]['status'] = 'Active';
            $lines[$i]['process_status'] = 'New';
            $lines[$i]['add_remove_stock'] = -1;
            $db->db_tool_insert_row('agreement_items', $lines[$i], '', 0, 'agri_');

            //insert the unique serials
            $uqs["product_ID"] = $_POST['productSelectId_' . $i];
            $uqs["agreement_ID"] = $_POST["lid"];
            $uqs["line_number"] = $_POST['lineNumber_' . $i];
            $uqs["agreement_number"] = $_POST['agreementNumber'];
            $uqs["unique_serial"] = $_POST["unique_serial_" . $i];
            $uqs["status"] = 'Active';
            //check if the serial already exists
            if ($_POST["unique_serial_" . $i] > 0) {
                $uqsCheck = $db->query_fetch("SELECT * FROM unique_serials WHERE uqs_status = 'Active' 
                            AND uqs_unique_serial = " . $_POST["unique_serial_" . $i]);
                if ($uqsCheck['uqs_unique_serial_ID'] > 0) {
                    $db->generateAlertError('Serial Used in line ' . $i . ' is not unique');
                    $errorFound = true;
                } else {
                    $db->db_tool_insert_row('unique_serials', $uqs, '', 0, 'uqs_');
                }
            }


        } //update existing line
        else if ($_POST['productLine_' . $i] == 2) {
            $db->db_tool_update_row('agreement_items', $lines[$i], "`agri_agreement_item_ID` = " . $_POST["agreementItemID_" . $i],
                $_POST["agreementItemID_" . $i], '', 'execute', 'agri_');

            //update unique serial
            $uqs["unique_serial"] = $_POST["unique_serial_" . $i];

            if ($_POST["unique_serial_" . $i] > 0) {
                //find the record first
                $uqsData = $db->query_fetch("SELECT * FROM unique_serials 
              WHERE `uqs_agreement_number` = '" . $_POST['agreementNumber'] . "' 
              AND `uqs_line_number` = " . $_POST['lineNumber_' . $i]);

                //if the record was created for the first time
                if ($uqsData['uqs_unique_serial_ID'] == ''){
                    $uqsData['uqs_unique_serial_ID'] = 0;
                }

                $uqsCheck = $db->query_fetch("SELECT * FROM unique_serials 
              WHERE uqs_unique_serial = '" . $_POST["unique_serial_" . $i] . "' 
              AND uqs_status = 'Active'
              AND uqs_unique_serial_ID != " . $uqsData['uqs_unique_serial_ID']);

                print_r($uqsCheck);

                if ($uqsCheck['uqs_unique_serial_ID'] > 0) {
                    $db->generateSessionAlertError('Serial Used is not unique');
                    $errorFound = true;
                } else {
                    //insert
                    if ($uqsData['uqs_unique_serial_ID'] == 0){
                        //insert the unique serials
                        $uqs["product_ID"] = $_POST['productSelectId_' . $i];
                        $uqs["agreement_ID"] = $_POST["lid"];
                        $uqs["line_number"] = $_POST['lineNumber_' . $i];
                        $uqs["agreement_number"] = $_POST['agreementNumber'];
                        $uqs["unique_serial"] = $_POST["unique_serial_" . $i];
                        $uqs["status"] = 'Active';
                        $db->db_tool_insert_row('unique_serials', $uqs, '', 0, 'uqs_');
                    }
                    else {//update
                        $db->db_tool_update_row('unique_serials', $uqs,
                            "`uqs_unique_serial_ID` = " . $uqsData["uqs_unique_serial_ID"],
                            $uqsData["uqs_unique_serial_ID"], '', 'execute', 'uqs_');
                    }

                }
            }


        } //delete existing line
        else if ($_POST['productLine_' . $i] == -2) {

            if ($_POST['agreementProcessStatus'] == 'New' || $_POST['processStatusLine_' . $i] == 'New') {
                $db->db_tool_delete_row('agreement_items', $_POST["agreementItemID_" . $i], "`agri_agreement_item_ID` = " . $_POST["agreementItemID_" . $i]);

                //delete the unique serial
                $uqsData = $db->query_fetch("SELECT * FROM unique_serials 
              WHERE `uqs_agreement_number` = '" . $_POST['agreementNumber'] . "' 
              AND `uqs_line_number` = " . $_POST['lineNumber_' . $i]);
                $db->db_tool_delete_row('unique_serials', $uqsData["uqs_unique_serial_ID"], "`uqs_unique_serial_ID` = " . $uqsData["uqs_unique_serial_ID"]);
            } else {//renewals endorsements

                if ($_POST['stockAddMinus_' . $i] == 1) {
                    $agrUpdateData['add_remove_stock'] = 1;
                }
                $agrUpdateData['status'] = 'Deleted';
                $db->db_tool_update_row('agreement_items', $agrUpdateData,
                    "`agri_agreement_item_ID` = " . $_POST["agreementItemID_" . $i],
                    $_POST["agreementItemID_" . $i], '', 'execute', 'agri_');
                //set unique serial status to delete.
                $uqsData = $db->query_fetch("SELECT * FROM unique_serials 
              WHERE `uqs_agreement_number` = '" . $_POST['agreementNumber'] . "' 
              AND `uqs_line_number` = " . $_POST['lineNumber_' . $i]);

                $uqsDel['status'] = 'Deleted';
                $db->db_tool_update_row('unique_serials', $uqsDel,
                    "`uqs_unique_serial_ID` = " . $uqsData["uqs_unique_serial_ID"],
                    $uqsData["uqs_unique_serial_ID"], '', 'execute', 'uqs_');


            }

        }
    }

    if ($errorFound != true) {
        $db->commit_transaction();
        //header("Location: agreements.php");
        //exit();
    } else {
        //echo "ERROR FOUND";
        $db->rollback_transaction();
    }


}


if ($_GET["lid"] != "") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agreements Get data';
    $sql = "SELECT * FROM 
            `agreements` 
            JOIN customers ON agr_customer_ID = cst_customer_ID
            WHERE `agr_agreement_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {
    $db->check_restriction_area('insert');
    $data["agr_status"] = "Pending";
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>
    <script>
        //global variables
        let outOfStockFound = false;
        let proceedSubmit = true;
    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-primary text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else if ($data["agr_status"] == 'Pending') echo "Update"; ?>
                            &nbsp;Agreement</b>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-3">Status</div>
                        <div class="col-lg-4 col-sm-9 text-left <?php echo getAgreementColor($data['agr_status']); ?>">
                            <?php echo $data["agr_status"]; ?>
                            <input type="hidden" name="agreementStatus" id="agreementStatus"
                                   value="<?php echo $data["agr_status"]; ?>">
                        </div>
                        <div class="col-lg-2 col-sm-3">Process Status</div>
                        <div class="col-lg-2 col-sm-6 text-left">
                            <?php echo $data["agr_process_status"]; ?>
                            <input type="hidden" name="agreementProcessStatus" id="agreementProcessStatus"
                                   value="<?php echo $data["agr_process_status"]; ?>">
                        </div>
                        <div class="col-lg-2 col-sm-3">
                            <?php

                            if ($data['agr_replacing_agreement_ID'] > 0) {
                                ?>
                                <a href="agreements_modify.php?lid=<?php echo $data['agr_replacing_agreement_ID']; ?>">
                                    <i class="fas fa-backward"></i>
                                </a>
                                <?php
                            }

                            if ($data['agr_replaced_by_agreement_ID'] > 0) {
                                ?>
                                <a href="agreements_modify.php?lid=<?php echo $data['agr_replaced_by_agreement_ID']; ?>">
                                    <i class="fas fa-forward"></i>
                                </a>
                                <?php
                            }

                            ?>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-3">Ag. Number</div>
                        <div class="col-lg-4 col-sm-9 text-left">
                            <?php echo $data["agr_agreement_number"]; ?>
                            <input type="hidden" id="agreementNumber" name="agreementNumber"
                                   value="<?php echo $data["agr_agreement_number"]; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_starting_date" class="col-lg-2 col-sm-3 col-form-label">Starting Date</label>
                        <div class="col-lg-4 col-sm-9">
                            <input name="fld_starting_date" type="text" id="fld_starting_date"
                                   class="form-control" onchange="setAutoExpiryDate()"
                                   required
                                <?php disable(); ?>>
                        </div>

                        <label for="fld_expiry_date" class="col-lg-2 col-sm-3 col-form-label">
                            Expiry Date
                            <i class="fas fa-sync" onclick="setAutoExpiryDate(true);" style="cursor: pointer;"></i>
                        </label>
                        <div class="col-lg-4 col-sm-9">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   required
                                <?php disable(); ?>>
                        </div>
                    </div>
                    <script>
                        $(function () {
                            $("#fld_starting_date").datepicker();
                            $("#fld_starting_date").datepicker("option", "dateFormat", "dd/mm/yy");
                            $("#fld_starting_date").val('<?php echo $db->convert_date_format($data["agr_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                        });

                        $(function () {
                            $("#fld_expiry_date").datepicker();
                            $("#fld_expiry_date").datepicker("option", "dateFormat", "dd/mm/yy");
                            $("#fld_expiry_date").val('<?php echo $db->convert_date_format($data["agr_expiry_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');
                        });

                        function setAutoExpiryDate(ignoreNotEmpty = false) {

                            var start = $("#fld_starting_date").val();

                            if (start != "") {
                                var split = start.split("/");
                                var newExpiry = new Date((split[2] * 1) + 1, (split[1] * 1) - 1, (split[0] * 1) - 1);

                                if ($("#fld_expiry_date").val() == "" || ignoreNotEmpty == true) {

                                    $("#fld_expiry_date").val(newExpiry.getDate() + "/" + ((newExpiry.getMonth() * 1) + 1) + "/" + newExpiry.getFullYear());

                                }
                            }

                        }
                    </script>

                    <div class="row">
                        <div class="col-lg-2 col-sm-3">Customer</div>
                        <div class="col-lg-4 col-sm-3">
                            <input name="customerSelect" type="text" id="customerSelect"
                                   class="form-control"
                                   value="<?php echo $data['cst_name'] . " " . $data['cst_surname']; ?>"
                                   required
                                <?php disable(); ?>>
                            <!--pattern="\d{13,16}"-->

                            <input name="customerSelectId" id="customerSelectId" type="hidden"
                                   value="<?php echo $data['cst_customer_ID']; ?>">
                        </div>
                        <div class="col-6">
                            <b>#</b><span id="cus_number"><?php echo $data['cst_customer_ID']; ?></span>
                            <b>ID:</b> <span id="cus_id"><?php echo $data['cst_identity_card']; ?></span>
                            <b>Tel:</b> <span id="cus_work_tel"><?php echo $data['cst_work_tel_1']; ?></span>
                            <b>Mobile:</b> <span id="cus_mobile"><?php echo $data['cst_mobile_1']; ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"> &nbsp;</div>
                    </div>
                    <?php if ($data['agr_status'] == 'Pending') { ?>
                        <div class="row">
                            <div class="alert alert-primary col-12">
                                <i class="fas fa-plus-circle" onclick="addNewProduct();" style="cursor: pointer;"></i>
                                Insert Products
                            </div>
                        </div>
                    <?php } ?>


                    <?php

                    for ($i = 1; $i <= 25; $i++) {
                        echo '
                            <div id="productHolder_' . $i . '"></div>';
                    }
                    ?>

                    <script>

                        var TotalProductsShow = 0;
                        var LastNumberUsed = 0;

                        function agreementTypeOnChange(lineNum) {
                            console.log('agreementTypeOnChange On :' + lineNum);
                            let option = $('#agreementType_' + lineNum).val();

                            $('#agreementType_' + lineNum).prop('disabled', false);
                            $('#unique_serial_' + lineNum).prop('disabled', false);
                            $('#rentCost_' + lineNum).prop('disabled', false);
                            $('#blackPerCopyCost' + lineNum).prop('disabled', false);
                            $('#colorPerCopyCost' + lineNum).prop('disabled', false);
                            $('#productSelect_' + lineNum).prop('disabled', false);
                            $('#location' + lineNum).prop('disabled', false);

                            if (option == 'Rent') {

                                //all enabled

                            }
                            else if (option == 'CPC') {
                                $('#rentCost_' + lineNum).prop('disabled', true);
                            }
                            else if (option == 'Min') {
                                $('#rentCost_' + lineNum).prop('disabled', true);
                            }
                            else if (option == 'Labour') {
                                $('#rentCost_' + lineNum).prop('disabled', true);
                                $('#blackPerCopyCost' + lineNum).prop('disabled', true);
                                $('#colorPerCopyCost' + lineNum).prop('disabled', true);
                            }
                            else if (option == 'No') {
                                $('#rentCost_' + lineNum).prop('disabled', true);
                                $('#blackPerCopyCost' + lineNum).prop('disabled', true);
                                $('#colorPerCopyCost' + lineNum).prop('disabled', true);
                            }


                        }

                        function fillProduct(objData) {

                            addNewProduct();
                            $('#agreementType_' + TotalProductsShow).val(objData.agreementType);
                            $('#unique_serial_' + TotalProductsShow).val(objData.uniqueSerial);
                            $('#unique_serial_ID_' + TotalProductsShow).val(objData.uniqueSerialID);
                            $('#rentCost_' + TotalProductsShow).val(objData.rentCost);
                            $('#blackPerCopyCost' + TotalProductsShow).val(objData.blackPerCopyCost);
                            $('#colorPerCopyCost' + TotalProductsShow).val(objData.colorPerCopyCost);
                            $('#productSelect_' + TotalProductsShow).val(objData.productName);
                            $('#productSelectId_' + TotalProductsShow).val(objData.productID);
                            $('#productSelect-id_' + TotalProductsShow).text(objData.productID);
                            $('#prod_number_' + TotalProductsShow).text(objData.productNumber);
                            $('#prod_stock_' + TotalProductsShow).text(objData.productStock);
                            $('#prod_description_' + TotalProductsShow).text(objData.productDescription);
                            $('#agreementItemID_' + TotalProductsShow).val(objData.agreementItemID);
                            $('#lineNumber_' + TotalProductsShow).val(objData.lineNumber);
                            $('#location' + TotalProductsShow).val(objData.location);
                            $('#productLine_' + TotalProductsShow).val(2);

                            //if line is deleted
                            if (objData.lineStatus == 'Deleted') {
                                $('#headerLine_' + TotalProductsShow).removeClass('alert-success');
                                $('#headerLine_' + TotalProductsShow).addClass('alert-danger');
                                $('#headerLine_' + TotalProductsShow).text(
                                    $('#headerLine_' + TotalProductsShow).text()
                                    + '(Deleted Line)'
                                );
                                $('#productHtmlHolder_' + TotalProductsShow).addClass('alert alert-danger');
                                $('#removeIconLine_' + TotalProductsShow).hide();

                                disableProduct(TotalProductsShow);
                            }
                            //console.log('Line ' + TotalProductsShow + ' line status - ' + objData.lineProcessStatus);
                            if ('<?php echo $data['agr_process_status'];?>' != 'New' && objData.lineProcessStatus != 'New') {
                                $('#productSelect_' + TotalProductsShow).prop('disabled', true);
                            }

                            //fill the process status
                            $('#processStatusLine_' + TotalProductsShow).val(objData.lineProcessStatus);

                            LastNumberUsed = objData.lineNumber;
                            if (objData.lineStatus != 'Deleted' && '<?php echo $data['agr_status'];?>' == 'Pending') {
                                agreementTypeOnChange(TotalProductsShow);
                            }


                        }

                        function disableProduct(lineNum) {
                            console.log('Disabling' + lineNum);
                            $('#agreementType_' + lineNum).prop('disabled', true);
                            $('#unique_serial_' + lineNum).prop('disabled', true);
                            $('#rentCost_' + lineNum).prop('disabled', true);
                            $('#blackPerCopyCost' + lineNum).prop('disabled', true);
                            $('#colorPerCopyCost' + lineNum).prop('disabled', true);
                            $('#productSelect_' + lineNum).prop('disabled', true);
                            $('#location' + lineNum).prop('disabled', true);
                            //$('#').disable();
                        }

                        function addNewProduct() {
                            if ($('#productHolder_' + (TotalProductsShow * 1 + 1)).length) {
                                //console.log("Inserting New Product" + (TotalProductsShow + 1));
                                addNewProductLine();
                            }
                            else {
                                //console.log("Cannot insert more lines");
                                alert('Reached Max amount of lines. Ask admin to add more');
                            }
                        }

                        function removeProductLine(lineNum) {
                            //console.log('Line ' + lineNum + $('#processStatusLine_' + lineNum).val());
                            if (confirm("Are you sure you want to remove this line?")) {
                                //console.log('Removing line' + lineNum);
                                $('#stockIcon_' + lineNum).hide();
                                $('#stockPlusIcon_' + lineNum).hide();
                                $('#stockMinusIcon_' + lineNum).hide();
                                //if new
                                if ($('#agreementProcessStatus').val() == 'New' || $('#processStatusLine_' + lineNum).val() == 'New') {
                                    $('#productHtmlHolder_' + lineNum).hide();
                                    $('#productHtmlDelete_' + lineNum).show();
                                    $('#productLine_' + lineNum).val(
                                        $('#productLine_' + lineNum).val() * -1
                                    );
                                    checkStockAllLines();
                                }
                                else {//if renewal
                                    let uniqueSerial = $('#unique_serial_' + lineNum).val();
                                    if (confirm('Add this machine serial #' + uniqueSerial + ' back to the stock?')) {
                                        $('#stockAddMinus_' + lineNum).val('1');
                                        $('#stockIcon_' + lineNum).show();
                                        $('#stockPlusIcon_' + lineNum).show();

                                        $('#productHtmlHolder_' + lineNum).hide();
                                        $('#productHtmlDelete_' + lineNum).show();
                                        $('#productLine_' + lineNum).val(
                                            $('#productLine_' + lineNum).val() * -1
                                        );
                                        checkStockAllLines();
                                    }
                                    else {
                                        $('#productHtmlHolder_' + lineNum).hide();
                                        $('#productHtmlDelete_' + lineNum).show();
                                        $('#productLine_' + lineNum).val(
                                            $('#productLine_' + lineNum).val() * -1
                                        );
                                        checkStockAllLines();
                                    }
                                }


                            }
                        }

                        function reAppearProductLine(lineNum) {
                            if (confirm('Are you sure you want to re-appear line ' + lineNum)) {
                                //console.log('ReAppearing line' + lineNum);
                                $('#productHtmlHolder_' + lineNum).show();
                                $('#productHtmlDelete_' + lineNum).hide();
                                $('#productLine_' + lineNum).val(
                                    $('#productLine_' + lineNum).val() * -1
                                );
                                checkStockAllLines();
                            }
                        }

                        function addNewProductLine() {
                            TotalProductsShow++;
                            LastNumberUsed++;
                            //console.log(LastNumberUsed);

                            $('#productHolder_' + TotalProductsShow).html(`
                            <div id="productHtmlHolder_` + TotalProductsShow + `">
                                <div class="row">
                                    <div class="col-12 alert alert-success" id="headerLine_` + TotalProductsShow + `"
                                        name="headerLine_` + TotalProductsShow + `">
                                        <div class="row">
                                         <div class="col-11">Product ` + TotalProductsShow + `</div>
                                         <?php if ($data['agr_status'] == 'Pending') { ?>
                                         <div class="col-1" id="removeIconLine_` + TotalProductsShow + `"
                                         name="removeIconLine_` + TotalProductsShow + `"><i class="fas fa-minus-circle redColor" style="cursor: pointer" onclick="removeProductLine(` + TotalProductsShow + `)"></i></div>
                                         <?php } ?>
                                        </div>
                                    </div>
                                    <input type="hidden" id="productLine_` + TotalProductsShow + `"
                                        name="productLine_` + TotalProductsShow + `"
                                        value="1" >
                                    <input type="hidden" id="agreementItemID_` + TotalProductsShow + `"
                                        name="agreementItemID_` + TotalProductsShow + `"
                                        value="">
                                    <input type="hidden" id="stockAddMinus_` + TotalProductsShow + `"
                                        name="stockAddMinus_` + TotalProductsShow + `"
                                        value="0">
                                    <input type="hidden" id="processStatusLine_` + TotalProductsShow + `"
                                        name="processStatusLine_` + TotalProductsShow + `"
                                        value="New">
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-3">Agrrement Type</div>
                                    <div class="col-lg-3 col-sm-9">
                                        <select name="agreementType_` + TotalProductsShow + `" id="agreementType_` + TotalProductsShow + `"
                                            class="form-control" onChange="agreementTypeOnChange(` + TotalProductsShow + `)"
                                            required <?php disable(); ?>>
                                            <option value=""></option>
                                            <option value="Rent">Rent +CPC</option>
                                            <option value="CPC">Charge Per Copy</option>
                                            <option value="Min">Minimum Charge</option>
                                            <option value="Labour">Labour Only</option>
                                            <option value="No">No Agreement</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-3">Unique Serial</div>
                                    <div class="col-lg-2 col-sm-2">
                                        <input name="unique_serial_` + TotalProductsShow + `" type="text" id="unique_serial_` + TotalProductsShow + `"
                                                   class="form-control" value="" <?php disable();?> onChange="checkUniqueSerial(` + TotalProductsShow + `);">
                                        <input name="unique_serial_ID_` + TotalProductsShow + `" id="unique_serial_ID_` + TotalProductsShow + `"
                                                type="hidden" value="">
                                    </div>
                                    <div class="col-lg-1 col-sm-1">
                                        <i class="fas fa-spinner" id="uqsSpinner_` + TotalProductsShow + `" name="uqsSpinner_` + TotalProductsShow + `" style="display:none"></i>
                                        <i class="fas fa-exclamation-triangle redColor" id="uqsError_` + TotalProductsShow + `" name="uqsError_` + TotalProductsShow + `" style="display:none"></i>
                                        <i class="fas fa-check greenColor" id="uqsOk_` + TotalProductsShow + `" name="uqsOk_` + TotalProductsShow + `" style="display:none"></i>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-3">Rent Cost</div>
                                    <div class="col-lg-3 col-sm-9">
                                        <input name="rentCost_` + TotalProductsShow + `" type="text" id="rentCost_` + TotalProductsShow + `"
                                                   class="form-control" value="" <?php disable();?>>
                                    </div>
                                    <div class="col-lg-3 col-sm-3">Black Per Copy Cost</div>
                                    <div class="col-lg-3 col-sm-9">
                                        <input name="blackPerCopyCost` + TotalProductsShow + `" type="text" id="blackPerCopyCost` + TotalProductsShow + `"
                                                   class="form-control" value="" <?php disable();?>>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-sm-3">Color Per Copy Cost</div>
                                    <div class="col-lg-3 col-sm-9">
                                        <input name="colorPerCopyCost` + TotalProductsShow + `" type="text" id="colorPerCopyCost` + TotalProductsShow + `"
                                                   class="form-control" value="" <?php disable();?>>
                                    </div>
                                    <div class="col-lg-3 col-sm-3">Location</div>
                                    <div class="col-lg-3 col-sm-9">
                                        <input name="location` + TotalProductsShow + `" type="text" id="location` + TotalProductsShow + `"
                                                   class="form-control" value="" <?php disable();?>>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-3">Product</div>
                                    <div class="col-lg-3 col-sm-3">
                                        <input name="productSelect_` + TotalProductsShow + `" type="text" id="productSelect_` + TotalProductsShow + `"
                                                   class="form-control" value="" required <?php disable();?>>

                                        <input name="productSelectId_` + TotalProductsShow + `"
                                               id="productSelectId_` + TotalProductsShow + `"
                                               type="hidden" value="" <?php disable();?>>
                                        <input name="lineNumber_` + TotalProductsShow + `"
                                               id="lineNumber_` + TotalProductsShow + `"
                                               type="hidden" value="` + LastNumberUsed + `" <?php disable();?>>
                                        </div>
                                        <div class="col-6">
                                            <b>#</b><span id="productSelect-id_` + TotalProductsShow + `"></span>
                                            <b>Model:</b> <span id="prod_number_` + TotalProductsShow + `"></span>
                                            <b>Stock:</b> <span id="prod_stock_` + TotalProductsShow + `"></span>
                                            <b>Description:</b> <span id="prod_description_` + TotalProductsShow + `"></span>

                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    &nbsp;
                                    </div>
                                </div>
                                <div class="row alert alert-danger" style="display:none;" id="prod_alert_` + TotalProductsShow + `">
                                    <div class="col-12 text-center">
                                        Not enough stock
                                    </div>
                                </div>
                            </div>
                            <div id="productHtmlDelete_` + TotalProductsShow + `" style="display: none;">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <div class="row">
                                         <div class="col-11 redColor">
                                            Product ` + TotalProductsShow + `
                                            <i class="fas fa-layer-group greenColor" title="Stock"
                                                 id="stockIcon_` + TotalProductsShow + `" style="display:none"></i>
                                            <i class="fas fa-plus-circle greenColor" title="Add back to stock"
                                                id="stockPlusIcon_` + TotalProductsShow + `" style="display:none"></i>
                                            <i class="fas fa-minus-circle" title="Remove from stock"
                                                name="stockMinusIcon_` + TotalProductsShow + `" style="display:none"></i>
                                         </div>
                                         <div class="col-1"><i class="fas fa-eye redColor" style="cursor: pointer" onclick="reAppearProductLine(` + TotalProductsShow + `)"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `);
                            enableAutoComplete(TotalProductsShow);

                        }

                        let linesData = {};
                        <?php

                        if ($_GET["lid"] > 0) {
                            //js data for the lines
                            $sql = "SELECT * FROM agreement_items
                                        LEFT OUTER JOIN agreements ON agr_agreement_ID = agri_agreement_ID
                                        LEFT OUTER JOIN products ON agri_product_ID = prd_product_ID
                                        LEFT OUTER JOIN unique_serials ON agr_agreement_number = uqs_agreement_number AND uqs_line_number = agri_line_number
                                        WHERE agri_agreement_ID = " . $_GET["lid"] . "
                                        #AND uqs_status = 'Active'
                                        ORDER BY agri_line_number ASC";
                            $result = $db->query($sql);

                            while ($line = $db->fetch_assoc($result)) {
                                $linesJsData = "\n linesData = {";
                                $linesJsData .= "agreementType:'" . $line['agri_agreement_type'] . "'";
                                $linesJsData .= ",rentCost:'" . $line['agri_rent_cost'] . "'";
                                $linesJsData .= ",blackPerCopyCost:'" . $line['agri_per_copy_black_cost'] . "'";
                                $linesJsData .= ",colorPerCopyCost:'" . $line['agri_per_copy_color_cost'] . "'";
                                $linesJsData .= ",productName:'" . $line['prd_name'] . "'";
                                $linesJsData .= ",productID:'" . $line['prd_product_ID'] . "'";
                                $linesJsData .= ",agreementItemID:'" . $line['agri_agreement_item_ID'] . "'";
                                $linesJsData .= ",productNumber:'" . $line['prd_model'] . "'";
                                $linesJsData .= ",productStock:'" . $line['prd_current_stock'] . "'";
                                $linesJsData .= ",productDescription:'" . $line['prd_description'] . "'";
                                $linesJsData .= ",lineNumber:'" . $line['agri_line_number'] . "'";
                                $linesJsData .= ",uniqueSerial:'" . $line['uqs_unique_serial'] . "'";
                                $linesJsData .= ",uniqueSerialID:'" . $line['uqs_unique_serial_ID'] . "'";
                                $linesJsData .= ",lineStatus:'" . $line['agri_status'] . "'";
                                $linesJsData .= ",lineProcessStatus:'" . $line['agri_process_status'] . "'";
                                $linesJsData .= ",location:'" . $line['agri_location'] . "'";
                                $linesJsData .= "};
                                    fillProduct(linesData);
                                    checkStock(TotalProductsShow);";
                                echo $linesJsData;
                            }
                        }
                        ?>

                        function enableAutoComplete(num) {

                            $('#productSelect_' + num).autocomplete({
                                source: '../products/products_api.php?section=products_search_machines',
                                delay: 500,
                                minLength: 1,
                                messages: {
                                    noResults: '',
                                    results: function () {
                                    }
                                },
                                focus: function (event, ui) {
                                    $('#productSelect_ ' + num).val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $('#productSelect_' + num).val(ui.item.label);
                                    $('#productSelect-id_' + num).val(ui.item.value);
                                    $('#productSelectId_' + num).val(ui.item.value);
                                    $('#prod_number_' + num).html(ui.item.value);
                                    $('#prod_stock_' + num).html(ui.item.current_stock);
                                    $('#prod_description_' + num).html(ui.item.description);

                                    checkStock(num);

                                    return false;
                                }

                            });

                        }

                        function checkStock(workingLine) {
                            outOfStockFound = false;
                            //first find the product ID of the line
                            let productID = $('#productSelect-id_' + workingLine).text();

                            let currentStock = $('#prod_stock_' + workingLine).text();
                            //loop into all the lines
                            let totalStockFound = 0;
                            for (let i = 1; i <= TotalProductsShow; i++) {
                                //console.log('checking line ' + i);
                                //console.log($('#productSelect-id_' + i).text() + " == " + productID)
                                if ($('#productSelect-id_' + i).text() == productID) {
                                    //also check if that line is removed
                                    if ($('#productLine_' + i).val() > 0) {
                                        //console.log('Found' + $('#productSelect-id_' + i).val());

                                        //this if will avoid marking also the previous lines
                                        if (i <= workingLine) {
                                            totalStockFound++;
                                        }
                                    }
                                }
                                $('#prod_alert_' + workingLine).hide();
                            }
                            if (totalStockFound > currentStock) {
                                //also check if the line has a product before creating the alert
                                //console.log(productID);
                                if (productID > 0) {
                                    $('#prod_alert_' + workingLine).show();
                                    //console.log('Marking line '+ workingLine);
                                    outOfStockFound = true;
                                }
                            }

                        }

                        function checkStockAllLines() {
                            for (let i = 1; i <= TotalProductsShow; i++) {
                                checkStock(i);
                            }
                        }
                    </script>


                    <!-- BUTTONS ------------------------------------------------------------------------------>
                    <div class="row">
                        <div class="col-12"> &nbsp;</div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('agreements.php')">
                            <?php if ($data["agr_status"] == 'Pending') { ?>
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Agreement"
                                       class="btn btn-secondary" onclick="return submitForm();">
                            <?php } ?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>


        function submitForm() {
            //extra validations in lines
            for (let i = 1; i <= TotalProductsShow; i++) {
                if ($('#productSelectId_' + i).val() == '') {
                    //if no actual product is selected then empty the product text field
                    $('#productSelect_' + i).val('');
                }

                //console.log($('#colorPerCopyCost' + i).val());
                if (1 == 2) {
                    $('#colorPerCopyCost' + i).attr('Required', true);
                    $('#colorPerCopyCost' + i).val(' ');
                    $('#colorPerCopyCost' + i).val('');
                }


            }

            //check if out of stock found
            if (outOfStockFound === true) {
                if (confirm('Stock is not enough for this agreement. Save anyway? \n You cannot lock this agreement until stock issue is fixed.')) {
                    outOfStockFound = false;
                }
            }

            let frm = document.getElementById('myForm');

            if (frm.checkValidity() === false) {
                console.log('Invalid Form');
                return false;
            }
            else {
                console.log(proceedSubmit);
                if (proceedSubmit == true) {
                    document.getElementById('Submit').disabled = true
                    return true;
                }
            }
            return false;

        }

        function checkUniqueSerial(lineNum) {
            //get the serial
            let serial = $('#unique_serial_' + lineNum).val();
            let excludeSerialID = $('#unique_serial_ID_' + lineNum).val();
            $('#uqsSpinner_' + lineNum).show();
            $('#uqsOk_' + lineNum).hide();
            $('#uqsError_' + lineNum).hide();
            //console.log(serial + " -> Exclude ID:" + excludeSerialID);
            //stop form from submiting before the observable
            proceedSubmit = false;
            Rx.Observable.fromPromise(
                $.get("../unique_serials/unique_serials_api.php?section=check_if_exists&term=" + serial + "&excludeSerial=" + excludeSerialID)
            )
                .subscribe((response) => {
                        //console.log(response);
                        data = response;
                    },
                    () => {
                    },
                    () => {
                        $('#uqsSpinner_' + lineNum).hide();
                        if (data == null) {
                            console.log('None found. OK!');
                            $('#uqsOk_' + lineNum).show();
                            proceedSubmit = true;
                        }
                        else {
                            console.log('Found Serial. Error!!');
                            $('#uqsError_' + lineNum).show();
                            proceedSubmit = false;
                        }
                    });


        }

        $('#customerSelect').autocomplete({
            source: '../customers/customers_api.php?section=customers',
            delay: 500,
            minLength: 2,
            messages: {
                noResults: '',
                results: function () {
                    //console.log('customer auto');
                }
            },
            focus: function (event, ui) {
                $('#customerSelect').val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $('#customerSelect').val(ui.item.label);
                $('#customerSelectId').val(ui.item.value);

                $('#cus_number').html(ui.item.value);
                $('#cus_id').html(ui.item.identity_card);
                $('#cus_work_tel').html(ui.item.work_tel);
                $('#cus_mobile').html(ui.item.mobile);
                return false;
            }

        });
    </script>
<?php
$db->show_footer();

function disable()
{
    global $data;
    if ($data["agr_status"] != 'Pending') {
        echo "disabled";
    }
}

?>