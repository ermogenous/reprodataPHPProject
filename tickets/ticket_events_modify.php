<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 3:32 ΜΜ
 */

include("../include/main.php");

$db = new Main();
$db->admin_title = "Tickets events Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ticket Events Insert';
    $db->start_transaction();

    $_POST['fld_ticket_ID'] = $_GET['tid'];
    $_POST['fld_user_ID'] = $db->user_data['usr_users_ID'];
    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $newID = $db->db_tool_insert_row('ticket_events', $_POST, 'fld_', 1, 'tke_');
    $db->commit_transaction();

    header("Location: ticket_events.php?tid=".$_POST['tid']);
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Ticket Event Update';
    $db->start_transaction();

    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $db->db_tool_update_row('ticket_events', $_POST, "`tke_ticket_event_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tke_');

    $db->commit_transaction();
    header("Location: ticket_events.php?tid=".$_POST['tid']);
    exit();

}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `ticket_events` JOIN `tickets` ON tke_ticket_ID = tck_ticket_ID WHERE `tke_ticket_event_ID` = " . $_GET["lid"];
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
                        &nbsp;Ticket Event</b>
                </div>

                <div class="form-group row">
                    <label for="fld_business_type_code_ID"
                           class="col-2 col-form-label">Event Type</label>
                    <div class="col-4">
                        <select name="fld_type" id="fld_type"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <option value="MachineError" <?php if ($data['tke_type'] == 'MachineError') echo 'selected'; ?>>
                                Machine Error
                            </option>
                            <option value="MachineService" <?php if ($data['tke_type'] == 'MachineService') echo 'selected'; ?>>
                                Machine Service
                            </option>
                            <option value="Order" <?php if ($data['tke_type'] == 'Order') echo 'selected'; ?>>
                                Order
                            </option>
                            <option value="Visit" <?php if ($data['tke_type'] == 'Visit') echo 'selected'; ?>>
                                Visit
                            </option>
                            <option value="Delivery" <?php if ($data['tke_type'] == 'Delivery') echo 'selected'; ?>>
                                Delivery
                            </option>
                        </select>
                    </div>
                    <label for="fld_incident_date"
                           class="col-2 col-form-label">Incident Date</label>
                    <div class="col-4">
                        <input name="fld_incident_date" type="text" id="fld_incident_date"
                               class="form-control"/>
                    </div>

                    <script>
                        let incidentDate = <?php if ($_GET['lid'] == '') {
                            echo "$('#fld_incident_date', window.parent.document).val()";
                        } else {
                            echo "'" . $db->convert_date_format($data["tke_incident_date"], 'yyyy-mm-dd', 'dd/mm/yyyy') . "'";
                        }?>;

                        //console.log($('#fld_incident_date', window.parent.document).val());

                        $(function () {
                            $("#fld_incident_date").datepicker();
                            $("#fld_incident_date").datepicker("option", "dateFormat", "dd/mm/yy");
                            $("#fld_incident_date").val(incidentDate);

                        });
                    </script>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-sm-3">Machine</div>
                    <div class="col-lg-4 col-sm-3">
                        <select name="fld_unique_serial_ID" id="fld_unique_serial_ID"
                                class="form-control">
                            <option value=""></option>
                            <?php
                            if ($_GET['lid'] > 0 && $data['tke_unique_serial_ID'] > 0){
                                $sql = "SELECT * FROM unique_serials 
                                        JOIN products ON prd_product_ID = uqs_product_ID
                                        WHERE uqs_unique_serial_ID = ".$data['tke_unique_serial_ID'];
                                $prod = $db->query_fetch($sql);
                                echo '<option value="'.$prod['uqs_unique_serial_ID'].'" selected>'.$prod['prd_model'].' - '.$prod['prd_description'].'</option>';
                                echo '<option value="" disabled>-----</option>';
                            }
                            $productsSql = "SELECT * FROM unique_serials 
                                                JOIN agreements ON agr_agreement_ID = uqs_agreement_ID
                                                JOIN customers ON cst_customer_ID = agr_customer_ID
                                                JOIN products ON prd_product_ID = uqs_product_ID
                                                WHERE uqs_status = 'Active'
                                                AND agr_status = 'Active'
                                                ";
                            $productResult = $db->query($productsSql);
                            while($prod = $db->fetch_assoc($productResult)){
                                echo '<option value="'.$prod['uqs_unique_serial_ID'].'">'.$prod['prd_model'].' - '.$prod['prd_description'].'</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-2">
                        Assign to user.......
                    </div>
                    <div class="col-4">

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
