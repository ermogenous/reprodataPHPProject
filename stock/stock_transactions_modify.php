<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/8/2018
 * Time: 2:54 ΜΜ
 */

include("../include/main.php");
include("stock.class.php");
$db = new Main();
$db->admin_title = "Stock Transaction Modify";


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: stock_transactions_list.php");
    exit();

}

if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $stock = new Stock($_POST["pid"]);
    $result = $stock->updateTransaction($_GET['lid'],$_POST['fld_amount']);

    if ($result !== true){

        $db->generateSessionAlertError($result);
    }
    ELSE {
        $db->generateSessionAlertSuccess(' ');
    }

    header("Location: stock_transactions_list.php");
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `stock` JOIN products ON stk_product_ID = prd_product_ID WHERE `stk_stock_ID` = " . $_GET["lid"];
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
                            &nbsp;Stock Transaction</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_amount" class="col-sm-4 col-form-label">Product</label>
                        <div class="col-sm-8">
                            <?php echo $data['prd_name'];?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_amount" class="col-sm-4 col-form-label">Amount</label>
                        <div class="col-sm-8">
                            <input name="fld_amount" type="text" id="fld_amount"
                                   class="form-control"
                                   value="<?php echo $data["stk_amount"] * $data["stk_add_minus"]; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="update">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input name="pid" type="hidden" id="pid" value="<?php echo $data["prd_product_ID"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('stock_transactions_list.php')" >
                            <input type="submit" name="Submit" id="Submit" value="Update"
                                   class="btn btn-secondary" onclick="submitForm()">
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