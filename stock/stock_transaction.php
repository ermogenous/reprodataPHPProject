<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 8:13 PM
 */

include("../include/main.php");
include("stock.class.php");
$db = new Main();
$db->admin_title = "Stock Transaction";

if ($_POST["action"] == 'insert'){
    $stock = new Stock($_GET['pid']);
    $stock->addRemoveStock($_POST['fld_amount'],$_POST['fld_description']);
    header("Location: stock_month_list.php?pid=".$_POST["pid"]);
    exit();
}

$db->show_empty_header();
?>

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b>Insert +/- Stock</b>
                </div>

                <div class="form-group row">
                    <label for="fld_description" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="fld_description" id="fld_description"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <option value="Initial">Initial Stock</option>
                            <option value="Transaction">Transaction</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_amount" class="col-sm-4 col-form-label">Amount</label>
                    <div class="col-sm-8">
                        <input name="fld_amount" type="text" id="fld_amount"
                               class="form-control"
                               value=""
                               required>
                    </div>
                </div>



                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action" value="insert">
                        <input name="pid" type="hidden" id="pid" value="<?php echo $_GET["pid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('stock_month_list.php?pid=<?php echo $_GET['pid'];?>')" >
                        <input type="submit" name="Submit"  id="Submit"
                               value="Add Transaction" class="btn btn-secondary"
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
$db->show_empty_footer();
?>
