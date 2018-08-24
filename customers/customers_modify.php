<?php
include("../include/main.php");
$db = new Main();
$db->admin_title = "Customers Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: customers.php");
    exit();

}

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->db_tool_insert_row('customers', $_POST, 'fld_',0, 'cst_');
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
    $sql = "SELECT * FROM `customers` WHERE `cst_customer_ID` = " . $_GET["lid"];
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
                        &nbsp;Customer</b>
                </div>

                <div class="form-group row">
                    <label for="fld_business_type_code_ID" class="col-sm-4 col-form-label">Business Type</label>
                    <div class="col-sm-8">
                        <select name="fld_business_type_code_ID" id="fld_business_type_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <?php
                                $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'BusinessType' ORDER BY cde_value ASC");
                                while($bt = $db->fetch_assoc($btResult)){

                            ?>
                            <option value="<?php echo $bt['cde_code_ID'];?>"
                                <?php if ($bt['cde_code_ID'] == $data['cst_business_type_code_ID']) echo 'selected';?>>
                                <?php echo $bt['cde_value'];?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_identity_card" class="col-sm-4 col-form-label">I.D.</label>
                    <div class="col-sm-8">
                        <input name="fld_identity_card" type="text" id="fld_identity_card"
                               class="form-control"
                               value="<?php echo $data["cst_identity_card"]; ?>"
                        required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["cst_name"]; ?>"
                        required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_surname" class="col-sm-4 col-form-label">Surname</label>
                    <div class="col-sm-8">
                        <input name="fld_surname" type="text" id="fld_surname"
                               class="form-control"
                               value="<?php echo $data["cst_surname"]; ?>">
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
                    <label for="fld_address_line_1" class="col-sm-4 col-form-label">Address Line 2</label>
                    <div class="col-sm-8">
                        <input name="fld_address_line_2" type="text" id="fld_address_line_2"
                               value="<?php echo $data["cst_address_line_2"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_city_code_ID" class="col-sm-4 col-form-label">City</label>
                    <div class="col-sm-8">
                        <select name="fld_city_code_ID" id="fld_city_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <?php
                            $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'Cities' ORDER BY cde_value ASC");
                            while($bt = $db->fetch_assoc($btResult)){

                                ?>
                                <option value="<?php echo $bt['cde_code_ID'];?>"
                                    <?php if ($bt['cde_code_ID'] == $data['cst_city_code_ID']) echo 'selected';?>>
                                    <?php echo $bt['cde_value'];?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_contact_person" class="col-sm-4 col-form-label">Contact Person</label>
                    <div class="col-sm-8">
                        <input name="fld_contact_person" type="text" id="fld_contact_person"
                               value="<?php echo $data["cst_contact_person"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_contact_person_title_code_ID" class="col-sm-4 col-form-label">C.P. Title</label>
                    <div class="col-sm-8">
                        <select name="fld_contact_person_title_code_ID" id="fld_contact_person_title_code_ID"
                                class="form-control"
                                required>
                            <option value=""
                                <?php if ('' == $data['cst_contact_person_title_code_ID']) echo 'selected';?>>-----</option>
                            <?php
                            $btResult = $db->query("SELECT * FROM codes WHERE cde_type = 'ContactPersonTitle' ORDER BY cde_value ASC");
                            while($bt = $db->fetch_assoc($btResult)){

                                ?>
                                <option value="<?php echo $bt['cde_code_ID'];?>"
                                    <?php if ($bt['cde_code_ID'] == $data['cst_contact_person_title_code_ID']) echo 'selected';?>>
                                    <?php echo $bt['cde_value'];?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_work_tel_1" class="col-sm-4 col-form-label">Work Tel 1</label>
                    <div class="col-sm-8">
                        <input name="fld_work_tel_1" type="text" id="fld_work_tel_1"
                               value="<?php echo $data["cst_work_tel_1"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_work_tel_2" class="col-sm-4 col-form-label">Work Tel 2</label>
                    <div class="col-sm-8">
                        <input name="fld_work_tel_2" type="text" id="fld_work_tel_2"
                               value="<?php echo $data["cst_work_tel_2"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_fax" class="col-sm-4 col-form-label">Fax</label>
                    <div class="col-sm-8">
                        <input name="fld_fax" type="text" id="fld_fax"
                               value="<?php echo $data["cst_fax"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_mobile_1" class="col-sm-4 col-form-label">Mobile 1</label>
                    <div class="col-sm-8">
                        <input name="fld_mobile_1" type="text" id="fld_mobile_1"
                               value="<?php echo $data["cst_mobile_1"]; ?>"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_mobile_2" class="col-sm-4 col-form-label">Mobile 2</label>
                    <div class="col-sm-8">
                        <input name="fld_mobile_2" type="text" id="fld_mobile_2"
                               value="<?php echo $data["cst_mobile_2"]; ?>"
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
                               onclick="window.location.assign('customers.php')" >
                        <input type="submit" name="Submit"  id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Customer" class="btn btn-secondary"
                               onclick="submitForm()">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>
<script>
    function submitForm(){
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false){

        }
        else {
            document.getElementById('Submit').disabled = true
        }
    }
</script>
<?php
$db->show_footer();
?>
