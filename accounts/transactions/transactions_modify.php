<?php
include("../../include/main.php");
include('transactions_class.php');

$db = new Main();
$db->enable_rxjs_lite();
$db->admin_title = "Accounts";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');


    $tr = new Transaction();
    $tr->loadTransactionDataFromForm($_POST);
    echo $tr->verifyTransactionData();
    $tr->insertTransaction();


    //
    header("Location: transactions.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');


    $db->db_tool_update_row('ac_transactions', $_POST, "`actrn_transaction_ID` = " . $_POST["lid"], $_POST["lid"],
        'fld_', 'execute', 'actrn_');
    header("Location: transactions.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_transactions` WHERE `actrn_transaction_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

} else {

}


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>


<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="groups" method="post" action="" onSubmit="" class="justify-content-center">

                <div class="alert alert-primary text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Transaction</b>
                </div>

                <div class="form-group row">
                    <label for="fld_type" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="fld_type" id="fld_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Sale" <?php if ($data["actrn_type"] == 'Sale') echo "selected=\"selected\""; ?>>
                                Sale
                            </option>
                            <option value="Purchase" <?php if ($data["actrn_type"] == 'Purchase') echo "selected=\"selected\""; ?>>
                                Purchase
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_transaction_date" class="col-sm-4 col-form-label">Transaction Date</label>
                    <div class="col-sm-8">
                        <input name="fld_transaction_date"
                               type="text" id="fld_transaction_date"
                               class="form-control"/>
                    </div>
                </div>
                <script>
                    $(function () {
                        $("#fld_transaction_date").datepicker();
                        $("#fld_transaction_date").datepicker("option", "dateFormat", "dd/mm/yy");
                        $("#fld_transaction_date").val('<?php echo $db->convert_date_format($data["actrn_transaction_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>');

                    });
                </script>

                <div class="form-group row">
                    <label for="fld_account" class="col-sm-4 col-form-label">Account</label>
                    <div class="col-sm-8">
                        <span id="account_field" style="display: none;">
                            <select name="fld_account_ID" id="fld_account_ID" class="form-control" required
                                    onchange="getProductsPerSupplier();">
                                <option value="">Select Account</option>
                            </select>
                        </span>
                        <span id="account_spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                        <span id="account_empty" style="display: block;">
                            Must Select Type
                        </span>
                        <span id="account_not_found" class="alert alert-danger"
                              style="display: none;">No accounts found</span>
                    </div>
                </div>

                <div class="alert alert-primary text-center">
                    <b>Lines</b>
                    <i class="fas fa-plus-square" style="cursor: pointer; display: none" onclick="plusLine();"
                       id="line_plus_icon">+</i>
                </div>
                <div class="row">
                    <div class="col-sm-3 text-center">Product</div>
                    <div class="col-sm-3 text-center">Amount</div>
                    <div class="col-sm-3 text-center">Per Product #</div>
                    <div class="col-sm-3 text-left">Total</div>
                </div>
                <?php
                for ($i = 0; $i <= 100; $i++) {
                    echo '<div class="container-fluid row" id="transactionLines_' . $i . '" name="transactionLines_' . $i . '">
                        </div>';
                }
                ?>


                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                        <a href="transactions.php"><input type="button" value="Back" class="btn btn-danger"></a>
                        <input type="submit" name="Submit" value=" Save Transaction " class="btn btn-primary">

                    </div>
                </div>


            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>

<script>
    let userTypesInSearchBox = Rx.Observable.fromEvent(
        $("#fld_type"),
        'change'
    )
        .map((event) => {
            //start the spinner
            $('#account_spinner').show();
            $('#account_empty').hide();
            $('#account_field').hide();
            $('#account_not_found').hide();

            return getTypeOptionsText($("#fld_type").val());
        });

    userTypesInSearchBox
        .flatMap((searchTerm) => {
            return Rx.Observable.fromPromise(
                $.get('transactions_api.php?section=accounts&value=' + searchTerm)
            ).catch(() => Rx.Observable.empty());
        })
        .subscribe((response) => {
            renderAccountsList(response);
        });

    function renderAccountsList(accountsList) {
        let dropDown = $('#fld_account_ID');
        //console.log(accountsList);
        //empty the options first
        dropDown.empty();
        dropDown.append($("<option />").val('').text('Select Account'));
        if (accountsList) {
            for (var i = 0; i < accountsList.length; i++) {
                dropDown.append(
                    $("<option />").val(accountsList[i]["acacc_account_ID"]).text(accountsList[i]["acacc_name"])
                );
            }
            $('#account_spinner').hide();
            $('#account_empty').hide();
            $('#account_field').show();
        } else {
            $('#account_not_found').show();
            $('#account_spinner').hide();
            $('#account_empty').hide();
            $('#account_field').hide();
        }

    }

    let productsList;
    let productsListFull = false;

    function plusLine() {

        console.log($('#fld_type').val());

        if ($('#fld_type').val() == 'Purchase') {
            if (productsListFull) {
                console.log(productsList);
                //renderProductDropDown('fld_product_line_1');
                addNewLinePurchase();
            }
            else {
                console.log('List is full');

            }
        }
    }


    function renderProductDropDown(fieldName) {
        let dropDown = $('#' + fieldName);
        dropDown.empty();
        dropDown.append($("<option />").val('').text('Select Product'));

        if (productsList) {
            //console.log('rendering ' + fieldName);
            for (var i = 0; i < productsList.length; i++) {
                //console.log('rendering' + i);
                dropDown.append(
                    $("<option />").val(productsList[i]["stprd_product_ID"]).text(productsList[i]["stprd_name"])
                );
            }
        }
        else {

        }
    }


    totalLines = 0;

    function addNewLinePurchase() {

        let html = `<div class="container alert alert-secondary">
                        <div class="row">
                            <div class="col-sm-3">
                                <select name="lnd_product_line_` + totalLines + `"
                                        id="lnd_product_line_` + totalLines + `"
                                        class="form-control"
                                        required
                                        onchange="printProductName(` + totalLines + `)">
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input name="lnd_quantity_line_` + totalLines + `"
                                       id="lnd_quantity_line_` + totalLines + `"
                                       type="number"
                                       class="form-control"
                                       value=""
                                       onchange="calculatePurchaseLine('quantity', ` + totalLines + `)"/>
                            </div>
                            <div class="col-sm-3">
                                <input name="lnd_value_line_` + totalLines + `"
                                       id="lnd_value_line_` + totalLines + `"
                                       type=""
                                       class="form-control"
                                       value=""
                                       onkeyup="calculatePurchaseLine('each', ` + totalLines + `)"/>
                                 <input name="lnd_show_line_` + totalLines + `"
                                        id="lnd_show_line_` + totalLines + `"
                                        type="hidden"
                                        value="1">
                            </div>
                            <div class="col-sm-3">
                                <input name="lnd_total_line_` + totalLines + `"
                                       id="lnd_total_line_` + totalLines + `"
                                       type=""
                                       class="form-control"
                                       value=""
                                       onkeyup="calculatePurchaseLine('total', ` + totalLines + `)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" id="show_product_name_line_` + totalLines + `"></div>
                        </div>
                    <div>`;
        $('#transactionLines_' + totalLines).html(html);
        renderProductDropDown('lnd_product_line_' + totalLines);
        totalLines++;
    }

    function clearAllLines() {
        for (let i = 0; i <= totalLines; i++) {
            $('#transactionLines_' + i).html('');
        }
        totalLines = 0;
    }

    let typedSection = '';

    function calculatePurchaseLine(section, line) {
        let quantity = $('#lnd_quantity_line_' + line).val();
        let value = $('#lnd_value_line_' + line).val();
        let total = $('#lnd_total_line_' + line).val();
        console.log(line);
        if (quantity > 0 && (value > 0 || total > 0)) {

            if (section == 'total') {
                $('#lnd_value_line_' + line).val((total / quantity));
                typedSection = 'total';
            }
            else if (section == 'each') {
                $('#lnd_total_line_' + line).val((value * quantity));
                typedSection = 'each';
            }
            else if (section == 'quantity') {
                $('#lnd_total_line_' + line).val((value * quantity));
            }

        }
    }

    function printProductName(line) {

        let name = $('#lnd_product_line_' + line + ' option:selected').text();

        $('#show_product_name_line_' + line).html(name);
    }

    let productVal;

    function getProductsPerSupplier() {

        //check first if any lines exists
        if (totalLines > 0) {
            if (confirm('This will delete any lines present. Are you sure?')) {
                clearAllLines();
            }
            else {
                $('#fld_account_ID').val(productVal);
            }
        }
        else {
            //save option for later use
            productVal = $('#fld_account_ID').val();
        }


        $('#line_plus_icon').hide();

        supplier = $('#fld_account_ID').val();
        console.log(supplier);

        url = 'transactions_api.php?section=products&value=' + supplier;
        //console.log(url);


        Rx.Observable.fromPromise(
            $.get(url)
        ).catch(() => Rx.Observable.empty())
            .subscribe(
                (response) => {
                    console.log(response);
                    productsList = response;
                    productsListFull = true;
                    $('#line_plus_icon').show();
                    console.log('Show Plus');
                }
            );
        return true;
    }

    function getTypeOptionsText(option) {
        if (option == 'Sale') {
            return 'Customer';
        }
        else if (option == 'Purchase') {
            return 'Supplier';
        }
    }
</script>

<?php
$db->show_footer();
?>
