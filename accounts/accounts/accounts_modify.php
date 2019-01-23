<?php
include("../../include/main.php");
$db = new Main();
$db->admin_title = "Accounts";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_active'] = $db->get_check_value($_POST['fld_active']);

    $db->db_tool_insert_row('ac_accounts', $_POST, 'fld_', 0, 'acacc_');
    header("Location: accounts.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $_POST['fld_active'] = $db->get_check_value($_POST['fld_active']);

    $db->db_tool_update_row('ac_accounts', $_POST, "`acacc_account_ID` = " . $_POST["lid"], $_POST["lid"], 'fld_', 'execute', 'acacc_');
    header("Location: accounts.php");
    exit();

}


if ($_GET["lid"] != "") {

    $sql = "SELECT * FROM `ac_accounts` WHERE `acacc_account_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
    $balance = $data["acacc_balance"];

}
else {
    $balance = 0;
}


$db->show_header();
?>


<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="groups" method="post" action="" onSubmit="" class="justify-content-center">

                <div class="alert alert-primary text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Supplier</b>
                </div>

                <div class="form-group row">
                    <div class="col"></div>
                    <div class="col">
                        <input name="fld_active"
                               type="checkbox"
                               class="form-check-input"
                               id="fld_active"
                               value="1" <?php if ($data["acacc_active"] == 1) echo "checked=\"checked\""; ?> />
                        <label for="fld_active" class="form-check-label">Active</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_type" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="fld_type" id="fld_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Customer" <?php if ($data["acacc_type"] == 'Customer') echo "selected=\"selected\""; ?>>Customer</option>
                            <option value="Supplier" <?php if ($data["acacc_type"] == 'Supplier') echo "selected=\"selected\""; ?>>Supplier</option>
                            <option value="Bank" <?php if ($data["acacc_type"] == 'Bank') echo "selected=\"selected\""; ?>>Bank</option>
                            <option value="Cash" <?php if ($data["acacc_type"] == 'Cash') echo "selected=\"selected\""; ?>>Cash</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_code" class="col-sm-4 col-form-label">Code</label>
                    <div class="col-sm-8">
                        <input name="fld_code"
                               type="text" id="fld_code"
                               class="form-control"
                               value="<?php echo $data["acacc_code"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name"
                               type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["acacc_name"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Balance</label>
                    <div class="col-sm-8"><?php echo $balance;?></div>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input name="fld_description"
                               type="text" id="fld_description"
                               class="form-control"
                               value="<?php echo $data["acacc_description"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_mobile" class="col-sm-4 col-form-label">Mobile</label>
                    <div class="col-sm-8">
                        <input name="fld_mobile"
                               type="text" id="fld_mobile"
                               class="form-control"
                               value="<?php echo $data["acacc_mobile"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_work_tel" class="col-sm-4 col-form-label">Work Phone</label>
                    <div class="col-sm-8">
                        <input name="fld_work_tel"
                               type="text" id="fld_work_tel"
                               class="form-control"
                               value="<?php echo $data["acacc_work_tel"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_fax" class="col-sm-4 col-form-label">Fax</label>
                    <div class="col-sm-8">
                        <input name="fld_fax"
                               type="text" id="fld_fax"
                               class="form-control"
                               value="<?php echo $data["acacc_fax"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input name="fld_email"
                               type="text" id="fld_email"
                               class="form-control"
                               value="<?php echo $data["acacc_email"]; ?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_website" class="col-sm-4 col-form-label">Website</label>
                    <div class="col-sm-8">
                        <input name="fld_website"
                               type="text" id="fld_website"
                               class="form-control"
                               value="<?php echo $data["acacc_website"]; ?>"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">

                        <a href="accounts.php"><input type="button" value="Back" class="btn btn-danger"></a>
                        <input type="submit" name="Submit" value=" Save Account " class="btn btn-primary">

                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
