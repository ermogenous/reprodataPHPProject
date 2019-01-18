<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 6:54 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Customer Products Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $_POST['fld_customer_ID'] = $_POST['cid'];
    $db->db_tool_insert_row('customer_group_relation', $_POST, 'fld_', 0, 'cstg_');
    header("Location: customers_groups_list.php?cid=".$_POST['cid']);
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->db_tool_update_row('customer_group_relation', $_POST, "`cstg_customer_group_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'cstg_');
    header("Location: customers_groups_list.php?cid=".$_POST['cid']);
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `customer_group_relation` WHERE `cstg_customer_group_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->enable_jquery_ui();
$db->show_empty_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Group to Customer</b>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">
                            Select Group
                        </div>
                        <div class="card-text">
                            <select name="fld_customer_groups_ID" id="fld_customer_groups_ID"
                                    class="form-control"
                                    required>
                                <option value=""></option>
                                <?php
                                if ($_GET['lid'] != '') {
                                    $sql = 'SELECT * FROM customer_groups WHERE csg_customer_group_ID = '.$data['cstg_customer_groups_ID'];
                                    $resGroup = $db->query_fetch($sql);
                                    echo '<option value="'.$resGroup['csg_customer_group_ID'].'" selected>'.$resGroup['csg_code'].'-'.$resGroup['csg_description'].'</option>';
                                }
                                //get all the groups excluding the ones already used
                                $cgResult = $db->query("SELECT * FROM 
                                customer_groups 
                                LEFT OUTER JOIN customer_group_relation ON cstg_customer_groups_ID = csg_customer_group_ID AND cstg_customer_ID = ".$_GET['cid']."
                                WHERE csg_active = 1 
                                AND cstg_customer_group_ID is NULL ORDER BY csg_code ASC");
                                while ($cg = $db->fetch_assoc($cgResult)) {

                                    ?>
                                    <option value="<?php echo $cg['csg_customer_group_ID']; ?>"
                                        <?php if ($cg['csg_customer_group_ID'] == $data['cstg_customer_groups_ID']) echo 'selected'; ?>>
                                        <?php echo $cg['csg_code']."-".$cg['csg_description']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('customers_groups_list.php?cid=<?php echo $_GET['cid'];?>')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Customer Group"
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
