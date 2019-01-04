<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02-Jan-19
 * Time: 5:33 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Schedule Modify";
include('schedules_functions.php');

if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Schedule Insert';
    $db->start_transaction();

    $_POST['fld_schedule_number'] = issueScheduleNumber();
    $_POST['fld_schedule_date'] = $db->convert_date_format($_POST['fld_schedule_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');
    $_POST['fld_status'] = 'Outstanding';

    $newID = $db->db_tool_insert_row('schedules', $_POST, 'fld_', 1, 'sch_');

    foreach($_POST as $name => $value){
        if (substr($name,0,9) == 'ticketRow'){

            $data['fld_schedule_ID'] = $newID;
            $data['fld_ticket_ID'] = $value;
            $db->db_tool_insert_row('schedule_ticket', $data, 'fld_', 1, 'scht_');
        }
    }

    $db->commit_transaction();

    if ($_POST['subAction'] == 'exit') {
        header("Location: schedules.php");
        exit();
    } else {
        header("Location: schedule_modify.php?lid=" . $newID);
        exit();
    }


} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Schedule Update';
    $db->start_transaction();

    $_POST['fld_schedule_date'] = $db->convert_date_format($_POST['fld_schedule_date'], 'dd/mm/yyyy', 'yyyy-mm-dd');

    $db->db_tool_update_row('schedules', $_POST, "`sch_schedule_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'sch_');

    foreach($_POST as $name => $value){
        //check if exists. if not insert
        if (substr($name,0,9) == 'ticketRow'){

            $sql = "SELECT * FROM schedule_ticket WHERE scht_schedule_ID = ".$_POST['lid']." AND scht_ticket_ID = ".$value;
            $checkRes = $db->query_fetch($sql);
            if ($checkRes['scht_schedule_ticket_ID'] > 0){
                //the record already exists
                //no need to do anything
            }
            else {
                $data['fld_schedule_ID'] = $_POST['lid'];
                $data['fld_ticket_ID'] = $value;
                $db->db_tool_insert_row('schedule_ticket', $data, 'fld_', 1, 'scht_');
            }

        }
        //delete this row
        if (substr($name,0,15) == 'DeleteticketRow' && $value > 0){
            $db->db_tool_delete_row('schedule_ticket', $value, 'scht_schedule_ID = '.$_POST['lid'].' AND scht_ticket_ID = '.$value);
        }
    }
    $db->commit_transaction();

    if ($_POST['subAction'] == 'exit') {
        header("Location: schedules.php");
        exit();
    } else {
        header("Location: schedule_modify.php?lid=" . $_POST['lid']);
        exit();
    }
}

if ($_GET["lid"] != "") {
    $sql = "SELECT * FROM `schedules` WHERE `sch_schedule_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

    $sql = "SELECT * FROM schedule_ticket WHERE scht_schedule_ID = ".$_GET["lid"];
    $schTicketsResult = $db->query($sql);
}

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
?>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <form name="myForm" id="myForm" method="post" action="">
                    <div class="alert alert-success text-center">
                        <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                            &nbsp;Schedule</b>
                    </div>

                    <div class="form-group row">
                        <label for="fld_schedule_date"
                               class="col-2 col-form-label">Schedule Date</label>
                        <div class="col-4">
                            <input name="fld_schedule_date" type="text" id="fld_schedule_date"
                                   class="form-control" <?php checkDisable(); ?>/>
                        </div>

                        <script>
                            let scheduleDate = <?php if ($_GET['lid'] == '') {
                                echo "'" . date('d/m/Y') . "'";
                            } else {
                                echo "'" . $db->convert_date_format($data["sch_schedule_date"], 'yyyy-mm-dd', 'dd/mm/yyyy') . "'";
                            }?>;

                            $(function () {
                                $("#fld_schedule_date").datepicker();
                                $("#fld_schedule_date").datepicker("option", "dateFormat", "dd/mm/yy");
                                $("#fld_schedule_date").val(scheduleDate);

                            });
                        </script>

                        <label for="fld_schedule_number"
                               class="col-2 col-form-label">Schedule Number</label>
                        <div class="col-4">
                            <?php echo $data['sch_schedule_number']; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fld_user_ID"
                               class="col-2 col-form-label">Assign to User</label>
                        <div class="col-4">
                            <select name="fld_user_ID" id="fld_user_ID"
                                    class="form-control"
                                    required <?php checkDisable(); ?>
                                    onchange="getTicketsFromApi();">
                                <option value="">Select User</option>
                                <?php
                                $sql = "SELECT * FROM users WHERE (usr_is_service = 1 OR usr_is_delivery = 1) AND usr_active = 1 ORDER BY usr_name ASC";
                                $result = $db->query($sql);
                                while ($row = $db->fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row["usr_users_ID"]; ?>" <?php if ($data['sch_user_ID'] == $row['usr_users_ID']) echo 'selected'; ?>>
                                        <?php echo $row["usr_name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <label for="fld_status"
                               class="col-2 col-form-label">Status</label>
                        <div class="col-2 tck<?php echo $data['sch_status']; ?>Color">
                            <?php echo $data['sch_status']; ?>
                        </div>
                    </div>

                    <table class="table" id="ticketTable" border="0">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" onclick="fillTable();" class="text-center">
                                <i class="fas fa-spinner" id="tableSpinner" style="display: none"></i>
                                #
                                <i class="fas fa-sync" onclick="getTicketsFromApi();"></i>
                            </th>
                            <th scope="col" onclick="clearTable();">Ticket Num/Events</th>
                            <th scope="col">Customer/Products</th>
                            <th scope="col">City</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <th scope="row"></th>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>

                    </table>
                    <script>
                        var selectedTickets = [];

                        function fillTable(data) {
                            //console.log('Filling');

                            clearTable();

                            $.each(data, function(key, value){
                               //console.log(key);
                               //console.log(data[key]['tck_ticket_number']);
                               makeTableRow(data[key]);
                            });

                        }

                        function makeTableRow(data){
                            var classLine = '';
                            var squareShow = '';
                            var checkSquareShow = '';
                            var showHidden = '';
                            //check if already selected
                            if (selectedTickets[data['tck_ticket_ID']] == true){
                                classLine = 'alert-success';
                                squareShow = 'none';
                                checkSquareShow = '';
                                showHidden = '';
                            }
                            else {
                                squareShow = '';
                                checkSquareShow = 'none';
                                showHidden = 'disabled';
                            }
                            //console.log(data);
                            $('#ticketTable tr:last').after(`
                                <tr id="tableLine-` + data['tck_ticket_ID'] +`" onclick="clickLine(` + data['tck_ticket_ID'] + `);" class="` + classLine + `">
                                <td scope="row" class="text-center">` + data['tck_ticket_ID'] + `
                                    <i class="far fa-square" id="tableSquare-` + data['tck_ticket_ID'] + `" style="display:` + squareShow + `"></i>
                                    <i class="far fa-check-square" id="tableCheckSquare-` + data['tck_ticket_ID'] + `" style="display:` + checkSquareShow + `"></i>
                                </td>
                                <td>` + data['tck_ticket_number'] + `<br>` + data['events_description'] + `</td>
                                <td>` + data['cst_name'] + ' ' + data['cst_surname'] + `<br>` + data['products_description'] + `</td>
                                <td>` + data['cde_value'] + `
                                    <input type="hidden"
                                        id="ticketRow-` + data['tck_ticket_ID'] + `"
                                        name="ticketRow-` + data['tck_ticket_ID'] + `"
                                        value="` + data['tck_ticket_ID'] + `" ` + showHidden + `>
                                    <input type="hidden"
                                        id="DeleteticketRow-` + data['tck_ticket_ID'] + `"
                                        name="DeleteticketRow-` + data['tck_ticket_ID'] + `"
                                        value="0">
                                </td>
                                </tr>
                            `);

                        }

                        function clickLine(ticketID){


                            if (selectedTickets[ticketID] == true){
                                $('#tableLine-' + ticketID).removeClass('alert-success');
                                $('#tableSquare-' + ticketID).show();
                                $('#tableCheckSquare-' + ticketID).hide();
                                $('#ticketRow-' + ticketID).attr('disabled', true);
                                $('#DeleteticketRow-' + ticketID).val(ticketID);
                                selectedTickets[ticketID] = false;
                            }
                            else {
                                $('#tableLine-' + ticketID).addClass('alert-success');
                                $('#tableSquare-' + ticketID).hide();
                                $('#tableCheckSquare-' + ticketID).show();
                                $('#ticketRow-' + ticketID).attr('disabled', false);
                                $('#DeleteticketRow-' + ticketID).val('0');
                                selectedTickets[ticketID] = true;
                            }
                        }

                        function clearTable() {
                            //console.log('Clearing');
                            $("#ticketTable td").parent().remove();
                        }

                        function getTicketsFromApi() {
                            $('#tableSpinner').show();

                            var userSelected = $('#fld_user_ID').val();
                            //console.log('Selected User: '+ userSelected);

                            Rx.Observable.fromPromise($.get("../tickets/tickets_api.php?section=opentickets&user=" + userSelected))
                                .subscribe((response) =>
                            {
                                //console.log(response);
                                data = response;
                            },
                            () => { }
                            ,
                            () => {
                                //console.log(data);
                                fillTable(data);
                                $('#tableSpinner').hide();

                            }
                            );
                        }

                        <?php
                        if ($_GET['lid'] != '') {

                            while($row = $db->fetch_assoc($schTicketsResult)){
                                echo "selectedTickets['".$row["scht_ticket_ID"]."'] = true;\n";
                            }

                            echo "getTicketsFromApi();";
                        }
                        ?>


                    </script>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">

                            <input name="action" type="hidden" id="action"
                                   value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                            <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('schedules.php')">
                            <input name="subAction" id="subAction" type="hidden" value="">
                            <?php if ($data['sch_status'] == 'Outstanding' || $_GET['lid'] == '') { ?>
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> & Exit"
                                       class="btn btn-secondary"
                                       onclick="submitForm('exit')">
                                <input type="submit" name="Submit" id="Submit"
                                       value="<?php if ($_GET["lid"] == "") echo "Create"; else echo "Save"; ?> Schedule"
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

            } else {
                document.getElementById('Submit').disabled = true
            }
            $('#subAction').val(action);
        }


    </script>
<?php

function checkDisable()
{
    global $data;
    if ($data['sch_status'] != 'Outstanding' && $_GET['lid'] != '') {
        echo 'disabled';
    }
}

$db->show_footer();
?>