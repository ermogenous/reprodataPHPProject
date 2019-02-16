<?php
include("../include/main.php");
$db = new Main();
$db->admin_title = "BAccounts Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'BAccounts Insert';

    $db->db_tool_insert_row('bc_basic_accounts', $_POST, 'fld_', 0, 'bcacc_');
    header("Location: baccounts.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'BAccounts Update';

    $db->db_tool_update_row('bc_basic_accounts', $_POST, "`bcacc_basic_account_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'bcacc_');
    header("Location: baccounts.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `bc_basic_accounts` WHERE `bcacc_basic_account_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    $balance = $data["acacc_balance"];

} else {
    $balance = 0;
}

//check if this account is blocked
if (checkForDisabledFields() != '') {
    $db->generateAlertError('This account is linked with a '.$data['bcacc_type'].'. If you want to modify the details of this account, modify the '.$data['bcacc_type']);
}

$db->show_header();
?>


<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">

                <div class="alert alert-primary text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Supplier</b>
                </div>

                <div class="form-group row">
                    <label for="fld_type" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="fld_type" id="fld_type" class="form-control"
                                required <?php echo checkForDisabledFields(); ?>>
                            <option value="">Select Type</option>
                            <option value="Customer" <?php if ($data["bcacc_type"] == 'Customer') echo "selected=\"selected\""; ?>>
                                Customer
                            </option>
                            <option value="Supplier" <?php if ($data["bcacc_type"] == 'Supplier') echo "selected=\"selected\""; ?>>
                                Supplier
                            </option>
                            <option value="Bank" <?php if ($data["bcacc_type"] == 'Bank') echo "selected=\"selected\""; ?>>
                                Bank
                            </option>
                            <option value="Cash" <?php if ($data["bcacc_type"] == 'Cash') echo "selected=\"selected\""; ?>>
                                Cash
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Balance</label>
                    <div class="col-sm-8"><?php echo $balance; ?></div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name"
                               type="text" id="fld_name"
                               class="form-control"
                            <?php echo checkForDisabledFields(); ?>
                               value="<?php echo $data["bcacc_name"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description"
                               type="text" id="fld_description"
                               class="form-control"
                            <?php echo checkForDisabledFields();?>
                               value="<?php echo $data["bcacc_description"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_mobile" class="col-sm-4 col-form-label">Mobile</label>
                    <div class="col-sm-8">
                        <input name="fld_mobile"
                               type="text" id="fld_mobile"
                               class="form-control"
                            <?php echo checkForDisabledFields();?>
                               value="<?php echo $data["bcacc_mobile"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_work_tel" class="col-sm-4 col-form-label">Work Phone</label>
                    <div class="col-sm-8">
                        <input name="fld_work_tel"
                               type="text" id="fld_work_tel"
                               class="form-control"
                            <?php echo checkForDisabledFields();?>
                               value="<?php echo $data["bcacc_work_tel"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input name="fld_email"
                               type="text" id="fld_email"
                               class="form-control"
                            <?php echo checkForDisabledFields();?>
                               value="<?php echo $data["bcacc_email"]; ?>"/>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                        <a href="baccounts.php"><input type="button" value="Back" class="btn btn-danger"></a>
                        <?php if (checkForDisabledFields() == '') { ?>
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Basic Account"
                               class="btn btn-secondary" onclick="submitForm()">
                        <?php } ?>

                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
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
</script>
<?php

function checkForDisabledFields()
{
    global $data, $db;
    if ($data['bcacc_type'] == 'Customer') {
        //check if customer is linked with this customer
        $cust = $db->query_fetch('SELECT * FROM customers WHERE cst_basic_account_ID = ' . $data['bcacc_basic_account_ID']);
        if ($cust['cst_customer_ID'] > 0) {
            //customer exists. Disabled fields
            return 'disabled="disabled"';
        }
    }
    return '';
}

$db->show_footer();
?>
