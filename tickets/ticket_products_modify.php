<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 3:32 ΜΜ
 */

include("../include/main.php");

$db = new Main();
$db->admin_title = "Tickets products Modify";

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ticket Products Insert';
    $db->start_transaction();

    $_POST['fld_ticket_ID'] = $_GET['tid'];
    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $newID = $db->db_tool_insert_row('ticket_products', $_POST, 'fld_', 1, 'tkp_');
    $db->commit_transaction();

    header("Location: ticket_products.php?tid=".$_POST['tid']);
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Ticket Products Update';
    $db->start_transaction();

    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $db->db_tool_update_row('ticket_products', $_POST, "`tkp_ticket_event_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tkp_');

    $db->commit_transaction();
    header("Location: ticket_products.php?tid=".$_POST['tid']);
    exit();

}

if ($_GET['type'] == 'SP'){
    $frameName = 'frmTabSpareParts';
    $frameTitle = 'Spare Parts';
}
else if ($_GET['type'] == 'CM'){
    $frameName = 'frmTabConsumables';
    $frameTitle = 'Consumables';
}
else if ($_GET['type'] == 'OT'){
    $frameName = 'frmTabOther';
    $frameTitle = 'Other';
}
else {
    exit();
}

if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `ticket_products` JOIN `tickets` ON tkp_ticket_ID = tck_ticket_ID 
            WHERE `tkp_ticket_event_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_empty_header();

//echo "Tid:" . $_GET["tid"] . " - Lid:" . $_GET["lid"]."<br>";
//print_r($data);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-success text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Ticket <?php echo $frameTitle;?></b>
                </div>

                <div class="form-group row">
                    <label for="fld_business_type_code_ID"
                           class="col-2 col-form-label">Select Event</label>
                    <div class="col-4">
                        <select name="fld_type" id="fld_type"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <?php
                                $sql = "SELECT * FROM ticket_events
                                        JOIN unique_serials ON uqs_unique_serial_ID = tke_unique_serial_ID
                                        JOIN products ON prd_product_ID = uqs_product_ID
                                        WHERE tke_ticket_ID = ".$_GET["tid"];
                                $ticketsResult = $db->query($sql);
                                while ($ticket = $db->fetch_assoc($ticketsResult)){
                                    echo '<option value="'.$ticket['tke_ticket_event_ID'].'">
                                    '.$ticket['tke_ticket_event_ID'].' - '.$ticket['tke_type'].' - '.$ticket['prd_model'].'
                                    </option>';
                                }
                            ?>
                        </select>
                        <?php //echo $sql; ?>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4">

                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-2 col-sm-3"></div>
                    <div class="col-lg-4 col-sm-3">

                    </div>
                    <div class="col-6">

                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input name="tid" type="hidden" id="tid" value="<?php echo $_GET["tid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="goBack();">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Event"
                               class="btn btn-secondary"
                               onclick="submitForm('')">
                        <input name="subAction" id="subAction" type="hidden" value="">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

    function submitForm(action) {
        let frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {

        }
        else {
            document.getElementById('Submit').disabled = true
        }
        $('#subAction').val(action);
    }

    function goBack(){
        location.href = 'ticket_events.php?tid=<?php echo $_GET['tid'];?>';
    }
</script>

<?php
$db->show_empty_footer();
?>
