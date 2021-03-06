<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/10/2018
 * Time: 3:22 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Tickets";
$db->enable_jquery_ui();
$db->show_header();

$table = new draw_table('tickets', 'tck_ticket_ID', 'ASC');
$table->extra_from_section = 'JOIN customers ON cst_customer_ID = tck_customer_ID';
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
        $table->extras .= " AND tck_status IN ('".$value."'";
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
        $table->extras .= " AND tck_ticket_ID = " . $_POST['search_field-id'];
    } else {
        $table->extras .= " AND (cst_identity_card LIKE '%" . $_POST['search_field'] . "%'
                            OR 
                            cst_name LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            cst_surname LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            cst_work_tel_1 LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            cst_work_tel_2  LIKE '%" . $_POST['search_field'] . "%'
                            OR 
                            cst_fax  LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            cst_mobile_1 LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            cst_mobile_2 LIKE '%" . $_POST['search_field'] . "%'
                            OR
                            tck_ticket_number  LIKE '%" . $_POST['search_field'] . "%')";
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
                    Tickets
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
                        <th scope="col"><?php $table->display_order_links('ID', 'tck_ticket_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'tck_ticket_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'tck_status'); ?></th>
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
                    <tr onclick="editLine(<?php echo $row["tck_ticket_ID"];?>);" class="tck<?php echo $row['tck_status'];?>Color">
                        <th scope="row"><?php echo $row["tck_ticket_ID"]; ?></th>
                        <td><?php echo $row["tck_ticket_number"]; ?></td>
                        <td><?php echo $row["cst_name"]; ?></td>
                        <td><?php echo $row["tck_status"]; ?></td>
                        <td>
                            <?php if ($row['tck_status'] == 'Outstanding') { ?>
                                <a href="ticket_modify.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["tck_ticket_ID"]; ?>&action=delete"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this ticket?');"><i
                                            class="fas fa-minus-circle"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["tck_ticket_ID"]; ?>">
                                    <i class="fas fa-lock" title="Change Status"></i></a>
                            <?php } else if ($row['tck_status'] == 'Open') {?>
                                <a href="ticket_modify.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"><i
                                            class="fas fa-eye"></i></a>&nbsp
                                <a href="ticket_status_change.php?lid=<?php echo $row["tck_ticket_ID"]; ?>">
                                    <i class="fas fa-lock" title="Change Status"></i></a>

                            <?php } else if ($row['tck_status'] == 'Closed') {?>
                                <a href="ticket_modify.php?lid=<?php echo $row["tck_ticket_ID"]; ?>"><i
                                            class="fas fa-eye"></i></a>&nbsp
                            <?php } else if ($row['tck_status'] == 'Deleted') {?>

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
        <div class="col-3 text-center tckOutstandingColor">Outstanding</div>
        <div class="col-3 text-center tckOpenColor">Open</div>
        <div class="col-3 text-center tckClosedColor">Closed</div>
        <div class="col-3 text-center tckDeletedColor">Deleted</div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('ticket_modify.php?lid=' + id);
        }
    }
</script>
<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "tickets_api.php?section=tickets";
$table->autoJsCodeHideFocus = true;
$table->autoJsCodeAddedSelectSection = "$('#myForm').submit();";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>
