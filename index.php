<?php
include('include/common.php');
if (isset($_GET['goAdmin'])) {
    echo "admin";
} else {
    header("Location:" . $main["site_url"] . "/tolc/home.php");
    exit();
}
header("Location: login.php");
exit();
?>
<div align="center">
<a href="login.php"><img src="layout/generic/images/welcome.jpg" width="851" height="315" /></a>
</div>




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
        <input type="hidden" id="processStatusLine_` + TotalProductsShow +`"
               name="processStatusLine_` + TotalProductsShow + `"
               value="New">
    </div>
    <div class="row">
        <div class="col-lg-2 col-sm-3">Agrrement Type</div>
        <div class="col-lg-4 col-sm-3">
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
        <div class="col-lg-2 col-sm-3">Unique Serial</div>
        <div class="col-lg-3 col-sm-2">
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
        <div class="col-lg-2 col-sm-3">Rent Cost</div>
        <div class="col-lg-4 col-sm-3">
            <input name="rentCost_` + TotalProductsShow + `" type="text" id="rentCost_` + TotalProductsShow + `"
                   class="form-control" value="" <?php disable();?>>
        </div>
        <div class="col-lg-2 col-sm-3">Black Per Copy Cost</div>
        <div class="col-lg-4 col-sm-3">
            <input name="blackPerCopyCost` + TotalProductsShow + `" type="text" id="blackPerCopyCost` + TotalProductsShow + `"
                   class="form-control" value="" <?php disable();?>>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-2 col-sm-3">Color Per Copy Cost</div>
        <div class="col-lg-4 col-sm-3">
            <input name="colorPerCopyCost` + TotalProductsShow + `" type="text" id="colorPerCopyCost` + TotalProductsShow + `"
                   class="form-control" value="" <?php disable();?>>
        </div>
        <div class="col-lg-2 col-sm-3">Location</div>
        <div class="col-lg-4 col-sm-3">
            <input name="location` + TotalProductsShow + `" type="text" id="location` + TotalProductsShow + `"
                   class="form-control" value="" <?php disable();?>>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-sm-3">Product</div>
        <div class="col-lg-4 col-sm-3">
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