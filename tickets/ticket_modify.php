<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/10/2018
 * Time: 3:22 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Tickets Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->db_tool_insert_row('tickets', $_POST, 'fld_', 0, 'tck_');
    header("Location: tickets.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->db_tool_update_row('tickets', $_POST, "`tck_ticket_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tck_');
    header("Location: tickets.php");
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `tickets` WHERE `tck_ticket_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Ticket</b>
                </div>


                <div class="form-group row">
                    <label for="fld_business_type_code_ID" class="col-sm-4 col-form-label">Ticket Type</label>
                    <div class="col-sm-8">
                        <select name="fld_business_type_code_ID" id="fld_business_type_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                                <option value="">Problem</option>
                                <option value="">Service</option>
                        </select>
                    </div>
                </div>



                <div class="form-group row">
                    <label for="fld_address_line_1" class="col-sm-4 col-form-label">Address Line 1</label>
                    <div class="col-sm-8">
                        <input name="fld_address_line_1" type="text" id="fld_address_line_1"
                               value="<?php echo $data["cst_address_line_1"]; ?>"
                               class="form-control"/>
                    </div>
                </div>





                <div class="form-group row">
                    <label for="fld_email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input name="fld_email" type="text" id="fld_email"
                               value="<?php echo $data["cst_email"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_email_newsletter" class="col-sm-4 col-form-label">Email NewsLetter</label>
                    <div class="col-sm-8">
                        <input name="fld_email_newsletter" type="text" id="fld_email_newsletter"
                               value="<?php echo $data["cst_email_newsletter"]; ?>"
                               class="form-control"/>
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
$db->show_footer();
?>
