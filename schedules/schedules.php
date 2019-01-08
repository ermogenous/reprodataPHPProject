<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02-Jan-19
 * Time: 5:33 PM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Schedules";
$db->enable_jquery_ui();
$db->show_header();

$table = new draw_table('schedules', 'sch_schedule_ID', 'ASC');
$table->extra_from_section = 'LEFT OUTER JOIN users ON sch_user_ID = usr_users_ID';
$table->extras = '1=1 ';
//filter status
$filterStatus[0] = 'Outstanding';
$filterStatus[1] = 'Open';

$filterStatusFound = 0;
//find all the filters if filter is submitted
if ($_POST['filter'] == 'filter') {
    foreach ($_POST as $name => $value) {

        if (substr($name, 0, 12) == 'filterStatus' && $value == 1) {
            $filterStatusFound++;
            if ($filterStatusFound == 1){
                unset($filterStatus);
            }
            $filterStatus[] = substr($name,12);
        }
    }
}

$filterFound = 0;
foreach($filterStatus as $value){
    $filterFound++;
    $selectedStatus[$value] = 'checked';
    if ($filterFound == 1){
        $table->extras .= " AND sch_status IN ('".$value."'";
    }
    else {
        $table->extras .= ",'".$value."'";
    }
}
//close the parenthesis
if ($filterFound > 0){
    $table->extras .= ")";
}

if ($_POST['search'] == 'search') {
    $db->working_section = 'Agreements Search';
    if ($_POST['search_field-id'] > 0) {
        $table->extras .= " AND sch_schedule_ID = " . $_POST['search_field-id'];
    } else {
        $table->extras .= " AND (
                            usr_name LIKE '%" . $_POST['search_field'] . "%'
                            OR 
                            usr_username LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            usr_description LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            usr_signature_gr LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            usr_signature_en  LIKE '%" . $_POST['search_field'] . "%'
                            OR 
                            usr_name_gr  LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            usr_name_en LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            sch_schedule_number  LIKE '%" . $_POST['search_field'] . "%')";
    }
}


$table->generate_data();
//echo $table->sql;
?>


<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="row alert alert-success text-center">
                <div class="col-12">
                    Schedules
                </div>
            </div>

            <div class="row">

                <div class="col-12">
                    <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                        <div class="form-group row">
                            <label for="search_field" class="col-sm-2 col-form-label">Search</label>
                            <div class="col-sm-8 ui-widget">
                                <input name="search_field" type="text" id="search_field"
                                       class="form-control"
                                       value="<?php echo $_POST['search_field'];?>">
                                <input id="search_field-id" name="search_field-id" type="hidden">
                                <input id="search" name="search" value="search" type="hidden">
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" name="Submit" id="Submit"
                                       value="Search"
                                       class="btn btn-secondary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <form name="myForm2" id="myForm2" method="post" action="" onsubmit="">
                <div class="row">
                    <div class="col-10 main_text_smaller text-right">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusOutstanding" name="filterStatusOutstanding"
                                   value="1" <?php echo $selectedStatus['Outstanding'];?>>
                            <label class="form-check-label" for="filterStatusOutstanding">Outstanding</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusOpen" name="filterStatusOpen"
                                   value="1" <?php echo $selectedStatus['Open'];?>>
                            <label class="form-check-label" for="filterStatusOpen">Open</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusClosed" name="filterStatusClosed"
                                   value="1" <?php echo $selectedStatus['Closed'];?>>
                            <label class="form-check-label" for="filterStatusClosed">Closed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusDeleted" name="filterStatusDeleted"
                                   value="1" <?php echo $selectedStatus['Deleted'];?>>
                            <label class="form-check-label" for="filterStatusDeleted">Deleted</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <input type="submit" name="Submit" id="Submit"
                               value="Filter"
                               class="btn btn-secondary" onclick="">
                        <input type="hidden" name="filter" id="filter" value="filter">
                    </div>
                </div>
            </form>

            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="alert alert-success">
                        <th scope="col"><?php $table->display_order_links('ID', 'sch_schedule_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'sch_schedule_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('User', 'sch_user_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Date', 'sch_schedule_date'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'sch_status'); ?></th>
                        <th scope="col">
                            <a href="ticket_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["sch_schedule_ID"];?>);" class="sch<?php echo $row['sch_status'];?>Color">
                        <th scope="row"><?php echo $row["sch_schedule_ID"]; ?></th>
                        <td><?php echo $row["sch_schedule_number"]; ?></td>
                        <td><?php echo $row["sch_user_ID"]; ?></td>
                        <td><?php echo $db->convert_date_format($row["sch_schedule_date"],'yyyy-mm-dd','dd/mm/yyyy'); ?></td>
                        <td><?php echo $row["sch_status"]; ?></td>
                        <td>
                            <?php if ($row['sch_status'] == 'Outstanding') { ?>
                                <a href="schedule_modify.php?lid=<?php echo $row["sch_schedule_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["sch_schedule_ID"]; ?>&action=delete"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this ticket?');"><i
                                            class="fas fa-minus-circle"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["sch_schedule_ID"]; ?>">
                                    <i class="fas fa-lock" title="Change Status"></i></a>
                            <?php } else if ($row['sch_status'] == 'Open') {?>
                                <a href="schedule_modify.php?lid=<?php echo $row["sch_schedule_ID"]; ?>"><i
                                            class="fas fa-eye"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["sch_schedule_ID"]; ?>">
                                    <i class="fas fa-lock" title="Change Status"></i></a>

                            <?php } else if ($row['sch_status'] == 'Closed') {?>
                                <a href="schedule_modify.php?lid=<?php echo $row["sch_schedule_ID"]; ?>"><i
                                            class="fas fa-eye"></i></a>&nbsp
                            <?php } else if ($row['sch_status'] == 'Deleted') {?>

                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row">
        <div class="col-3 text-center schOutstandingColor">Outstanding</div>
        <div class="col-3 text-center schOpenColor">Open</div>
        <div class="col-3 text-center schClosedColor">Closed</div>
        <div class="col-3 text-center schDeletedColor">Deleted</div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('schedule_modify.php?lid=' + id);
        }
    }
</script>
<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "schedule_api.php?section=schedulesSearch";
$table->autoJsCodeHideFocus = true;
$table->autoJsCodeAddedSelectSection = "$('#myForm').submit();";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>
