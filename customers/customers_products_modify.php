<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/8/2018
 * Time: 6:29 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Customer Products Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->db_tool_insert_row('customers', $_POST, 'fld_', 0, 'cst_');
    header("Location: customers.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->db_tool_update_row('customers', $_POST, "`cst_customer_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'cst_');
    header("Location: customers.php");
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `customer_products` WHERE `cspr_customer_product_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->show_empty_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Customer Product</b>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">
                            Select Product
                        </div>
                        <div class="card-text">
                            fdslfjlsd
                            sadfsd<br>
                            sdf
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="name" type="text" id="name"
                               class="form-control"
                               value="<?php echo $data["usg_group_name"]; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('customers.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Customer"
                               class="btn btn-secondary"
                               onclick="submitForm()">
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
$db->show_empty_footer();
?>
