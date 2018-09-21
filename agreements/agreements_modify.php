<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/8/2018
 * Time: 11:49 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Agreements Modify";

//print_r($_POST);
//echo "\n\n\n\n<br><br><br>";
if ($_POST["action"] == "insert") {
    echo "Inserting";
    $db->check_restriction_area('insert');

    $db->working_section = 'Agreements Insert';

    include('agreements_functions.php');


    $db->start_transaction();

    $newAgreementNumber = issueAgreementNumber();
    //first insert the agreement
    $agrData['customer_ID'] = $_POST['customerSelectId'];
    $agrData['status'] = $db->get_setting('agr_agreement_status_on_insert');
    $agrData['agreement_number'] = $newAgreementNumber;
    $agrData['starting_date'] = $db->convert_date_format($_POST['fld_starting_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $agrData['expiry_date'] = $db->convert_date_format($_POST['fld_expiry_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    //$agrData['agr_agreement_number'] = $_POST[''];
    $agreementNewID = $db->db_tool_insert_row('agreements', $agrData, '', 1, 'agr_');

    //get the data from the lines
    for ($i = 1; $i <= 25; $i++) {

        if ($_POST['productLine_' . $i] == 1) {
            $lines[$i]['agreement_ID'] = $agreementNewID;
            $lines[$i]['product_ID'] = $_POST['productSelectId_' . $i];
            $lines[$i]['line_number'] = $i;
            $lines[$i]['agreement_type'] = $_POST['agreementType_' . $i];
            $lines[$i]['per_copy_black_cost'] = $_POST['blackPerCopyCost' . $i];
            $lines[$i]['per_copy_color_cost'] = $_POST['colorPerCopyCost' . $i];
            $lines[$i]['rent_cost'] = $_POST['rentCost_' . $i];

            $db->db_tool_insert_row('agreement_items', $lines[$i], '', 0, 'agri_');
        }
    }
    $db->commit_transaction();
    header("Location: agreements.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agreements Modify';

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
    for ($i = 1; $i <= 25; $i++) {
        //echo $i." -> ".$_POST['productLine_'.$i]."<br>";

        $lines[$i]['product_ID'] = $_POST['productSelectId_' . $i];
        $lines[$i]['line_number'] = $i;
        $lines[$i]['agreement_type'] = $_POST['agreementType_' . $i];
        $lines[$i]['per_copy_black_cost'] = $_POST['blackPerCopyCost' . $i];
        $lines[$i]['per_copy_color_cost'] = $_POST['colorPerCopyCost' . $i];
        $lines[$i]['rent_cost'] = $_POST['rentCost_' . $i];

        //insert new line
        if ($_POST['productLine_' . $i] == 1) {
            $lines[$i]['agreement_ID'] = $_POST["lid"];
            $db->db_tool_insert_row('agreement_items', $lines[$i], '', 0, 'agri_');
        } //update existing line
        else if ($_POST['productLine_' . $i] == 2) {
            $db->db_tool_update_row('agreement_items', $lines[$i], "`agri_agreement_item_ID` = " . $_POST["agreementItemID_" . $i],
                $_POST["agreementItemID_" . $i], '', 'execute', 'agri_');
        } //delete existing line
        else if ($_POST['productLine_' . $i] == -2) {
            $db->db_tool_delete_row('agreement_items', $_POST["agreementItemID_" . $i], "`agri_agreement_item_ID` = " . $_POST["agreementItemID_" . $i]);
        }
    }


    $db->commit_transaction();
    header("Location: agreements.php");
    exit();

}


if ($_GET["lid"] != "") {
    $db->working_section = 'Agreements Get data';
    $sql = "SELECT * FROM 
            `agreements` 
            JOIN customers ON agr_customer_ID = cst_customer_ID
            WHERE `agr_agreement_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);


}

$db->enable_jquery_ui();
$db->show_header();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-primary text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Agreement</b>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-2 col-sm-3">Status</div>
                        <div class="col-lg-4 col-sm-3 text-left">
                            <?php echo $data["agr_status"]; ?>
                        </div>
                        <div class="col-lg-2 col-sm-3">Ag. Number</div>
                        <div class="col-lg-4 col-sm-3 text-left">
                            RP12-000011
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_starting_date" class="col-lg-2 col-sm-3 col-form-label">Starting Date</label>
                        <div class="col-lg-4 col-sm-3">
                            <input name="fld_starting_date" type="text" id="fld_starting_date"
                                   class="form-control" onchange="setAutoExpiryDate()"
                                   required>
                        </div>

                        <label for="fld_expiry_date" class="col-lg-2 col-sm-3 col-form-label">
                            Expiry Date
                            <i class="fas fa-sync" onclick="setAutoExpiryDate(true);" style="cursor: pointer;"></i>
                        </label>
                        <div class="col-lg-4 col-sm-3">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   required>
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

                                   data-value-missing="Translate('Required')"
                                   pattern="\d{13,16}" data-pattern-mismatch="Translate('Invalid credit card')"
                            >
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

                    <div class="row">
                        <div class="alert alert-primary col-12">
                            <i class="fas fa-plus-circle" onclick="addNewProduct();" style="cursor: pointer;"></i>
                            Insert Products
                        </div>
                    </div>

                    <?php
                    for ($i = 1; $i <= 25; $i++) {
                        echo '
                            <div id="productHolder_' . $i . '"></div>';
                    }
                    ?>

                    <script>

                        var TotalProductsShow = 0;

                        function fillProduct(objData) {

                            addNewProduct();
                            $('#agreementType_' + TotalProductsShow).val(objData.agreementType);
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
                            $('#productLine_' + TotalProductsShow).val(2);

                        }

                        function addNewProduct() {
                            if ($('#productHolder_' + (TotalProductsShow * 1 + 1)).length) {
                                console.log("Inserting New Product" + (TotalProductsShow + 1));
                                addNewProductLine();
                            }
                            else {
                                console.log("Cannot insert more lines");
                                alert('Reached Max amount of lines. Ask admin to add more');
                            }
                        }

                        function removeProductLine(lineNum) {
                            if (confirm("Are you sure you want to remove this line?")) {
                                console.log('Removing line' + lineNum);
                                $('#productHtmlHolder_' + lineNum).hide();
                                $('#productHtmlDelete_' + lineNum).show();
                                $('#productLine_' + lineNum).val(
                                    $('#productLine_' + lineNum).val() * -1
                                );
                            }
                        }

                        function reAppearProductLine(lineNum) {
                            console.log('ReAppearing line' + lineNum);
                            $('#productHtmlHolder_' + lineNum).show();
                            $('#productHtmlDelete_' + lineNum).hide();
                            $('#productLine_' + lineNum).val(
                                $('#productLine_' + lineNum).val() * -1
                            );
                        }

                        function addNewProductLine() {
                            TotalProductsShow++;

                            $('#productHolder_' + TotalProductsShow).html(`
                            <div id="productHtmlHolder_` + TotalProductsShow + `">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <div class="row">
                                         <div class="col-11">Product ` + TotalProductsShow + `</div>
                                         <div class="col-1"><i class="fas fa-minus-circle" style="cursor: pointer" onclick="removeProductLine(` + TotalProductsShow + `)"></i></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="productLine_` + TotalProductsShow + `"
                                        name="productLine_` + TotalProductsShow + `"
                                        value="1">
                                    <input type="hidden" id="agreementItemID_` + TotalProductsShow + `"
                                        name="agreementItemID_` + TotalProductsShow + `"
                                        value="">
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-sm-3">Agrrement Type</div>
                                    <div class="col-lg-4 col-sm-3">
                                        <select name="agreementType_` + TotalProductsShow + `" id="agreementType_` + TotalProductsShow + `"
                                            class="form-control"
                                            required>
                                            <option value=""></option>
                                            <option value="Type">Type</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-3">Rent Cost</div>
                                    <div class="col-lg-4 col-sm-3">
                                        <input name="rentCost_` + TotalProductsShow + `" type="text" id="rentCost_` + TotalProductsShow + `"
                                                   class="form-control" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-sm-3">Black Per Copy Cost</div>
                                    <div class="col-lg-4 col-sm-3">
                                        <input name="blackPerCopyCost` + TotalProductsShow + `" type="text" id="blackPerCopyCost` + TotalProductsShow + `"
                                                   class="form-control" value="">
                                    </div>
                                    <div class="col-lg-2 col-sm-3">Color Per Copy Cost</div>
                                    <div class="col-lg-4 col-sm-3">
                                        <input name="colorPerCopyCost` + TotalProductsShow + `" type="text" id="colorPerCopyCost` + TotalProductsShow + `"
                                                   class="form-control" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-sm-3">Product</div>
                                    <div class="col-lg-4 col-sm-3">
                                        <input name="productSelect_` + TotalProductsShow + `" type="text" id="productSelect_` + TotalProductsShow + `"
                                                   class="form-control" value="">
                                        <input name="productSelectId_` + TotalProductsShow + `"
                                               id="productSelectId_` + TotalProductsShow + `"
                                               type="hidden" value="">
                                        </div>
                                        <div class="col-6">
                                            <b>#</b><span id="productSelect-id_` + TotalProductsShow + `"></span>
                                            <b>Model:</b> <span id="prod_number_` + TotalProductsShow + `"></span>
                                            <b>Stock:</b> <span id="prod_stock_` + TotalProductsShow + `"></span>
                                            <b>Description:</b> <span id="prod_description_` + TotalProductsShow + `"></span>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">&nbsp;</div>
                                </div>
                            </div>
                            <div id="productHtmlDelete_` + TotalProductsShow + `" style="display: none;">
                                <div class="row">
                                    <div class="col-12 alert alert-success">
                                        <div class="row">
                                         <div class="col-11 redColor">Product ` + TotalProductsShow + `</div>
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
                                        JOIN products ON agri_product_ID = prd_product_ID
                                        WHERE agri_agreement_ID = " . $_GET["lid"] . "
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
                                $linesJsData .= "};
                                    fillProduct(linesData);";
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
                                    return false;
                                }

                            });

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
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Agreement"
                                   class="btn btn-secondary" onclick="submitForm()">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                document.getElementById('Submit').disabled = true
            }
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
?>