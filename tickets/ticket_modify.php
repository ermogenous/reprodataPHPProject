<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/10/2018
 * Time: 3:22 ΜΜ
 */

include("../include/main.php");
include("tickets_functions.php");
$db = new Main();
$db->admin_title = "Tickets Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ticket Insert';
    $db->start_transaction();

    $_POST['fld_ticket_number'] = issueTicketNumber();
    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_appointment_date'] = $db->convert_date_format($_POST['fld_appointment_date'], 'dd/mm/yyyy', 'yyyy-mm-dd', 1);
    $_POST['fld_customer_ID'] = $_POST['customerSelectId'];
    $_POST['fld_status'] = 'Outstanding';

    $newID = $db->db_tool_insert_row('tickets', $_POST, 'fld_', 1, 'tck_');
    $db->commit_transaction();
    if ($_POST['subAction'] == 'exit') {
        header("Location: tickets.php");
        exit();
    } else {
        header("Location: ticket_modify.php?lid=" . $newID);
        exit();
    }

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Ticket Update';
    $db->start_transaction();

    $_POST['fld_incident_date'] = $db->convert_date_format($_POST['fld_incident_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_appointment_date'] = $db->convert_date_format($_POST['fld_appointment_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_customer_ID'] = $_POST['customerSelectId'];
    $db->db_tool_update_row('tickets', $_POST, "`tck_ticket_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tck_');

    $db->commit_transaction();
    if ($_POST['subAction'] == 'exit') {
        header("Location: tickets.php");
        exit();
    } else {
        header("Location: ticket_modify.php?lid=" . $_POST["lid"]);
        exit();
    }


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `tickets` WHERE `tck_ticket_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

    if ($data['tck_customer_ID'] > 0) {
        $sql = "SELECT * FROM `customers` WHERE cst_customer_ID = " . $data['tck_customer_ID'];
        $customerData = $db->query_fetch($sql);
    }
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-success text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Ticket</b>
                </div>


                <div class="form-group row">
                    <label for="fld_incident_date"
                           class="col-2 col-form-label">Incident Date</label>
                    <div class="col-2">
                        <input name="fld_incident_date" type="text" id="fld_incident_date"
                               class="form-control" <?php checkDisable(); ?>/>
                    </div>

                    <div class="col-2 tck<?php echo $data['tck_status'];?>Color">
                        <b><?php echo $data['tck_status'];?></b>
                    </div>

                    <label for="fld_business_type_code_ID"
                           class="col-2 col-form-label">Ticket Number</label>
                    <div class="col-4">
                        <?php echo $data['tck_ticket_number']; ?>
                    </div>
                </div>

                <script>
                    let incidentDate = <?php if ($_GET['lid'] == '') {
                        echo "'" . date('d/m/Y') . "'";
                    } else {
                        echo "'" . $db->convert_date_format($data["tck_incident_date"], 'yyyy-mm-dd', 'dd/mm/yyyy') . "'";
                    }?>;

                    $(function () {
                        $("#fld_incident_date").datepicker();
                        $("#fld_incident_date").datepicker("option", "dateFormat", "dd/mm/yy");
                        $("#fld_incident_date").val(incidentDate);

                    });
                </script>

                <div class="form-group row">
                    <label for="fld_appointment_date"
                           class="col-2 col-form-label">Appointment Date</label>
                    <div class="col-4">
                        <input name="fld_appointment_date" type="text" id="fld_appointment_date"
                               class="form-control" <?php checkDisable(); ?>/>
                    </div>

                    <div class="col-2">Assigned to User</div>
                    <div class="col-4"><select name="fld_assigned_user_ID" id="fld_assigned_user_ID"
                                               class="form-control"
                                               required <?php checkDisable(); ?>>
                            <option value="-1">Assign Later</option>
                            <?php
                            $sql = "SELECT * FROM users WHERE usr_is_service = 1 OR usr_is_delivery = 1";
                            $result = $db->query($sql);
                            while ($row = $db->fetch_assoc($result)) {
                                echo '<option value="' . $row['usr_users_ID'] . '"';
                                if ($data['tck_assigned_user_ID'] == $row['usr_users_ID']) {
                                    echo 'selected';
                                }
                                echo '>' . $row['usr_name'] . '</option>';
                            }
                            ?>

                        </select></div>

                    <script>
                        let appointmentDate = <?php if ($_GET['lid'] == '') {
                            echo "'" . date('d/m/Y') . "'";
                        } else {
                            echo "'" . $db->convert_date_format($data["tck_appointment_date"], 'yyyy-mm-dd', 'dd/mm/yyyy', 1) . "'";
                        }?>;

                        $(function () {
                            $("#fld_appointment_date").datepicker();
                            $("#fld_appointment_date").datepicker("option", "dateFormat", "dd/mm/yy");
                            $("#fld_appointment_date").val(appointmentDate);

                        });
                    </script>
                </div>


                <div class="form-group row">
                    <div class="col-12" style="height: 10px">
                        <hr>
                    </div>
                </div>

                <div class="form-group row" style="height: 18px">
                    <label for="customerSelect" class="col-2 col-form-label">Customer</label>
                    <div class="col-4">
                        <input name="customerSelect" type="text" id="customerSelect"
                               class="form-control"
                               value="<?php echo $customerData['cst_name'] . " " . $customerData['cst_surname']; ?>"
                               required <?php checkDisable(); ?>>
                        <input name="customerSelectId" id="customerSelectId" type="hidden"
                               value="<?php echo $customerData['cst_customer_ID']; ?>">
                    </div>

                    <div class="col-6">
                        <b>#</b><span id="cus_number"><?php echo $customerData['cst_customer_ID']; ?></span>
                        <b>ID:</b> <span id="cus_id"><?php echo $customerData['cst_identity_card']; ?></span>
                        <b>Tel:</b> <span id="cus_work_tel"><?php echo $customerData['cst_work_tel_1']; ?></span>
                        <b>Mobile:</b> <span id="cus_mobile"><?php echo $customerData['cst_mobile_1']; ?></span>
                    </div>

                </div>

                <script>

                    $('#customerSelect').autocomplete({
                        source: '../customers/customers_api.php?section=customers',
                        delay: 500,
                        minLength: 2,
                        messages: {
                            noResults: '',
                            results: function () {
                                //console.log('customer auto');
                            }
                        },
                        focus: function (event, ui) {
                            $('#customerSelect').val(ui.item.label);
                            return false;
                        },
                        select: function (event, ui) {
                            $('#customerSelect').val(ui.item.label);
                            $('#customerSelectId').val(ui.item.value);

                            $('#cus_number').html(ui.item.value);
                            $('#cus_id').html(ui.item.identity_card);
                            $('#cus_work_tel').html(ui.item.work_tel);
                            $('#cus_mobile').html(ui.item.mobile);
                            return false;
                        }

                    });

                </script>


                <div class="form-group row">
                    <div class="col-12" style="height: 10px">
                        <hr>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="events-tab" data-toggle="tab"
                           href="#events" role="tab" aria-controls="events" aria-selected="true">
                            <b>Events</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="spareParts-tab" data-toggle="tab"
                           href="#spareParts" role="tab" aria-controls="spareParts" aria-selected="false">
                            <b>Spare Parts</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="consumables-tab" data-toggle="tab"
                           href="#consumables" role="tab" aria-controls="consumables" aria-selected="false">
                            <b>Consumables</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="other-tab" data-toggle="tab"
                           href="#other" role="tab" aria-controls="other" aria-selected="false">
                            <b>Other</b>
                        </a>
                    </li>
                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="events-tab">
                        <?php if ($_GET['lid'] > 0) { ?>
                            <iframe src="ticket_events.php?tid=<?php echo $_GET['lid']; ?>" width="100%" height="100"
                                    frameborder="0" id="frmTabEvents" name="frmTabEvents"></iframe>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12 text-center alert alert-danger">
                                    First create the Ticket.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="spareParts" role="tabpanel" aria-labelledby="spareParts-tab">
                        <?php if ($_GET['lid'] > 0) { ?>
                            <iframe src="ticket_products.php?type=SparePart&tid=<?php echo $_GET['lid']; ?>"
                                    width="100%" height="100"
                                    frameborder="0" id="frmTabSpareParts" name="frmTabSpareParts"></iframe>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12 text-center alert alert-danger">
                                    First create the Ticket.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="consumables" role="tabpanel" aria-labelledby="consumables-tab">
                        <?php if ($_GET['lid'] > 0) { ?>
                            <iframe src="ticket_products.php?type=Consumable&tid=<?php echo $_GET['lid']; ?>"
                                    width="100%" height="100"
                                    frameborder="0" id="frmTabConsumables" name="frmTabConsumables"></iframe>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12 text-center alert alert-danger">
                                    First create the Ticket.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                        <?php if ($_GET['lid'] > 0) { ?>
                            <iframe src="ticket_products.php?type=Other&tid=<?php echo $_GET['lid']; ?>" width="100%"
                                    height="100"
                                    frameborder="0" id="frmTabOther" name="frmTabOther"></iframe>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12 text-center alert alert-danger">
                                    First create the Ticket.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">

                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('tickets.php')">
                        <input name="subAction" id="subAction" type="hidden" value="">
                        <?php if ($data['tck_status'] == 'Outstanding' || $_GET['lid'] == '') { ?>
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> & Exit"
                                   class="btn btn-secondary"
                                   onclick="submitForm('exit')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="<?php if ($_GET["lid"] == "") echo "Create"; else echo "Save"; ?> Ticket"
                                   class="btn btn-secondary"
                                   onclick="submitForm('save')">
                        <?php } ?>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<script>

    function submitForm(action) {
        frm = document.getElementById('myForm');
        if (frm.checkValidity() === false) {

        }
        else {
            document.getElementById('Submit').disabled = true
        }
        $('#subAction').val(action);
    }


</script>
<?php

function checkDisable()
{
    global $data;
    if ($data['tck_status'] != 'Outstanding' && $_GET['lid'] != '') {
        echo 'disabled';
    }
}

$db->show_footer();
?>
