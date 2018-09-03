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


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Agreements Insert';
    //$db->db_tool_insert_row('agreements', $_POST, 'fld_',0, 'mnf_');
    //header("Location: manufacturers.php");
    //exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agreements Modify';

    //$db->db_tool_update_row('manufacturers', $_POST, "`mnf_manufacturer_ID` = " . $_POST["lid"],
    //    $_POST["lid"], 'fld_', 'execute', 'mnf_');
    //header("Location: manufacturers.php");
    //exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Agreements Get data';
    $sql = "SELECT * FROM `manufacturers` WHERE `mnf_manufacturer_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {
    $data['mnf_active'] = 1;
}

$db->enable_jquery_ui();
$db->show_header();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                    <div class="alert alert-dark text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Agreement</b>
                    </div>

                    <div class="card" >
                        <div class="card-body alert-light">
                            <div class="card-title text-center">
                                Select Customer
                            </div>
                            <div class="card-text">
                                <input name="customerSelect" type="text" id="customerSelect"
                                       class="form-control" value="">
                                <input type="hidden" name="customerSelect-id" id="customerSelect-id">


                                <div class="row">
                                    <div class="col-sm-6 col-lg-2">#</div>
                                    <div class="col-sm-6 col-lg-4" id="cus_number"></div>
                                    <div class="col-sm-6 col-lg-2">ID</div>
                                    <div class="col-sm-6 col-lg-4" id="cus_id"></div>
                                    <div class="col-sm-6 col-lg-2">Tel:</div>
                                    <div class="col-sm-6 col-lg-4" id="cus_work_tel"></div>
                                    <div class="col-sm-6 col-lg-2">Mobile</div>
                                    <div class="col-sm-6 col-lg-4" id="cus_mobile"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="fld_status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_starting_date" class="col-sm-3 col-form-label">Starting Date</label>
                        <div class="col-sm-3">
                            <input name="fld_starting_date" type="text" id="fld_starting_date"
                                   class="form-control" onchange="setAutoExpiryDate()"
                                   value="<?php echo $data["agr_starting_date"]; ?>"
                                   required>
                        </div>

                        <label for="fld_expiry_date" class="col-sm-3 col-form-label">
                            Expiry Date
                            <i class="fas fa-sync" onclick="setAutoExpiryDate(true);" style="cursor: pointer;"></i>
                        </label>
                        <div class="col-sm-3">
                            <input name="fld_expiry_date" type="text" id="fld_expiry_date"
                                   class="form-control"
                                   value="<?php echo $data["agr_expiry_date"]; ?>"
                                   required>
                        </div>
                    </div>
                    <script>
                        $(function () {
                            $("#fld_starting_date").datepicker();
                            $("#fld_starting_date").datepicker("option", "dateFormat", "dd/mm/yy");
                        });

                        $(function () {
                            $("#fld_expiry_date").datepicker();
                            $("#fld_expiry_date").datepicker("option", "dateFormat", "dd/mm/yy");
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





                    <div class="card">
                        <div class="card-body alert-light">
                            <div class="card-title text-center">
                                Products
                            </div>
                            <div class="card-text">
                                <input name="productSelect" type="text" id="productSelect"
                                       class="form-control" value="">
                                <input type="hidden" name="productSelect-id" id="productSelect-id">

                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-2">#</div>
                                <div class="col-sm-6 col-lg-4" id="prod_number"></div>
                                <div class="col-sm-6 col-lg-2">Stock</div>
                                <div class="col-sm-6 col-lg-4" id="prod_stock"></div>
                                <div class="col-sm-2 col-lg-2">Description</div>
                                <div class="col-sm-10 col-lg-10" id="prod_description"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $('#productSelect').autocomplete({
                            source: '../products/products_api.php?section=products_search_machines',
                            delay: 500,
                            minLength: 1,
                            messages: {
                                noResults: '',
                                results: function () {
                                }
                            },
                            focus: function (event, ui) {
                                $('#productSelect').val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $('#productSelect').val(ui.item.label);
                                $('#productSelect-id').val(ui.item.value);

                                $('#prod_number').html(ui.item.value);
                                $('#prod_stock').html(ui.item.current_stock);
                                $('#prod_description').html(ui.item.description);
                                return false;
                            }

                        });
                    </script>






                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('manufacturers.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Agreement"
                                   class="btn btn-secondary" onclick="submitForm()">
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

        $('#customerSelect').autocomplete({
            source: '../customers/customers_api.php?section=customers',
            delay: 500,
            minLength: 2,
            messages: {
                noResults: '',
                results: function () {
                }
            },
            focus: function (event, ui) {
                $('#customerSelect').val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $('#customerSelect').val(ui.item.label);
                $('#customerSelect-id').val(ui.item.value);

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