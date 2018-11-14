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
    $db->working_section = 'Ticket Insert';

    $db->db_tool_insert_row('tickets', $_POST, 'fld_', 0, 'tck_');
    header("Location: tickets.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Ticket Update';

    $db->db_tool_update_row('tickets', $_POST, "`tck_ticket_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'tck_');
    header("Location: tickets.php");
    exit();


}


if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `tickets` WHERE `tck_ticket_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Ticket</b>
                </div>


                <div class="form-group row">
                    <label for="fld_business_type_code_ID"
                           class="col-2 col-form-label">Ticket Type</label>
                    <div class="col-4">
                        <select name="fld_business_type_code_ID" id="fld_business_type_code_ID"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <option value="">Problem</option>
                            <option value="">Service</option>
                        </select>
                    </div>

                    <label for="fld_incident_date"
                           class="col-2 col-form-label">Incident Date</label>
                    <div class="col-4">
                        <input name="fld_incident_date" type="text" id="fld_incident_date"
                               class="form-control"/>
                    </div>
                </div>

                <script>
                    let incidentDate = <?php if ($_GET['lid'] == '') {
                        echo "'".date('d/m/Y')."'";
                    }else {
                        echo "'".$db->convert_date_format($data["tck_incident_date"], 'yyyy-mm-dd', 'dd/mm/yyyy')."'";
                    }?>;

                    $(function () {
                        $("#fld_incident_date").datepicker();
                        $("#fld_incident_date").datepicker("option", "dateFormat", "dd/mm/yy");
                        $("#fld_incident_date").val(incidentDate);

                    });
                </script>

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
                               value="<?php echo $data['cst_name'] . " " . $data['cst_surname']; ?>"
                               required>
                        <input name="customerSelectId" id="customerSelectId" type="hidden"
                               value="<?php echo $data['cst_customer_ID']; ?>">
                    </div>

                    <div class="col-6">
                        <b>#</b><span id="cus_number"><?php echo $data['cst_customer_ID']; ?></span>
                        <b>ID:</b> <span id="cus_id"><?php echo $data['cst_identity_card']; ?></span>
                        <b>Tel:</b> <span id="cus_work_tel"><?php echo $data['cst_work_tel_1']; ?></span>
                        <b>Mobile:</b> <span id="cus_mobile"><?php echo $data['cst_mobile_1']; ?></span>
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
                            Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="spareParts-tab" data-toggle="tab"
                           href="#spareParts" role="tab" aria-controls="spareParts" aria-selected="false">
                            Spare Parts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="consumables-tab" data-toggle="tab"
                           href="#consumables" role="tab" aria-controls="consumables" aria-selected="false">
                            Consumables
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="other-tab" data-toggle="tab"
                           href="#other" role="tab" aria-controls="other" aria-selected="false">
                            Other
                        </a>
                    </li>
                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="events-tab">
                        <iframe src="ticket_events.php?<?php echo $_GET['lid'];?>" width="100%" height="300" frameborder="0"></iframe>
                    </div>
                    <div class="tab-pane fade" id="spareParts" role="tabpanel" aria-labelledby="spareParts-tab">
                        Spare Parts
                    </div>
                    <div class="tab-pane fade" id="consumables" role="tabpanel" aria-labelledby="consumables-tab">
                        Consumables
                    </div>
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                        Other
                    </div>
                </div>

                <?php

                for ($i = 1; $i <= 25; $i++) {
                    echo '
                            <div id="eventHolder_' . $i . '"></div>';
                }
                ?>


                <div class="row">
                    <div class="col-2">Event Type</div>
                    <div class="col-4">
                        <select name="eventType" id="eventType"
                                class="form-control"
                                required>
                            <option value=""></option>
                            <option value="">Problem</option>
                            <option value="">Service</option>
                        </select>
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
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Ticket"
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
