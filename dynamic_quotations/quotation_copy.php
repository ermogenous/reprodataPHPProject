<?php
include("../include/main.php");

$db = new Main();
$db->include_js_file("../include/jscripts.js");
$db->include_css_file("main_quotation_css.css");
$db->include_js_file("jscripts.js");



if ($_POST['proceed'] == 'Proceed'){
    $db->start_transaction();
    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = '.$_POST['lid']);
    foreach($quotationData as $name => $value){

        if ($name != 'oqq_quotations_ID') {
            $newData['fld_' . substr($name, 4)] = $value;
        }
    }
    $newData['fld_status'] = 'Outstanding';
    $newData['fld_effective_date'] = date("Y-m-d G:i:s");
    $newData['fld_starting_date'] = date("Y-m-d G:i:s");
    $newData['fld_expiry_date'] = date("Y-m-d G:i:s");
    unset($newData['fld_created_date_time']);
    unset($newData['fld_created_by']);
    unset($newData['fld_last_update_date_time']);
    unset($newData['fld_last_update_by']);

    $newQuotationID = $db->db_tool_insert_row('oqt_quotations',$newData,'fld_',1,'oqq_');
    $sql = 'SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = '.$_POST['lid'];
    $itemsResult = $db->query($sql);
    while ($row = $db->fetch_assoc($itemsResult)){
        foreach ($row as $name => $value){
            $newItemData['fld_'.substr($name,6)] = $value;
        }
        $newItemData['fld_quotations_ID'] = $newQuotationID;
        unset($newItemData['fld_quotations_items_ID']);
        unset($newItemData['fld_created_date_time']);
        unset($newItemData['fld_created_by']);
        unset($newItemData['fld_last_update_date_time']);
        unset($newItemData['fld_last_update_by']);
        $db->db_tool_insert_row('oqt_quotations_items',$newItemData,'fld_',0,'oqqit_');
    }

    $db->commit_transaction();
    header("Location: quotations_show.php?lid=".$newQuotationID);
    exit();
}

if ($_POST['cancel'] == 'Cancel'){
    header("Location:quotations.php");
    exit();
}


if ($_GET['lid'] == ''){
    header("Location: quotations.php");
    exit();
}
$db->show_header();
$data = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = '.$_GET['lid']);

?>

<div class="container">
    <div class="row alert alert-primary">
        <div class="col-12 text-center">
            <strong>Copy To New</strong>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            You are about to copy <strong><?php echo $data['oqq_number'];?></strong> to new.<br>
            <strong>Insured Name:</strong> <?php echo $data['oqq_insureds_name'];?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <form method="post" target="">
                <?php
                if ($data['oqq_status'] == 'Active') {
                ?>
                <input type="submit" class="btn btn-primary" id="proceed" name="proceed" value="Proceed">
                <input type="submit" class="btn btn-danger" id="cancel" name="cancel" value="Cancel">
                <input type="hidden" id="lid" name="lid" value="<?php echo $_GET['lid'];?>">
                <?php
                }
                else {
                    ?>
                    <div class="alert alert-danger">Only active can be copied.</div>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$db->show_footer();
?>
