<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/8/2018
 * Time: 11:39 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");
include("agreements_functions.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Agreements";
//$db->enable_rxjs_lite();
$db->enable_jquery_ui();

$db->show_header();

$table = new draw_table('agreements', 'agr_agreement_ID', 'ASC');
$table->extra_from_section = "JOIN customers ON cst_customer_ID = agr_customer_ID";


//filter status and pstatus
$filterStatus[0] = 'Active';
$filterStatus[1] = 'Pending';


$filterPStatus[0] = 'New';
$filterPStatus[1] = 'Endorsement';
$filterPStatus[2] = 'Renewal';

$filterStatusFound = 0;
$filterPStatusFound = 0;
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
        if (substr($name, 0, 13) == 'filterPStatus') {
            $filterPStatusFound++;
            if ($filterPStatusFound == 1){
                unset($filterPStatus);
            }
            $filterPStatus[] = substr($name,13);
        }
    }
}



$filterFound = 0;
foreach($filterStatus as $value){

    $filterFound++;
    $selectedStatus[$value] = 'checked';
    if ($filterFound == 1){
        $table->extras = "agr_status IN ('".$value."'";
    }
    else {
        $table->extras .= ",'".$value."'";
    }
}
//close the parenthesis
if ($filterFound > 0){
    $table->extras .= ")";
}

//reset the filter for pstatus
$filterFound = 0;
foreach($filterPStatus as $value){

    $selectedPStatus[$value] = 'checked';
    $filterFound++;
    if ($filterFound == 1){
        $table->extras .= " AND agr_process_status IN ('".$value."'";
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
        $table->extras .= "agr_agreement_ID = " . $_POST['search_field-id'];
    } else {
        $table->extras .= "cst_identity_card LIKE '%" . $_POST['search_field'] . "%'
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
                            agr_agreement_number  LIKE '%" . $_POST['search_field'] . "%'";
    }
}


$table->order_by = 'DESC';
$table->generate_data();
//echo $table->sql;
//print_r($selectedStatus);
//print_r($selectedPStatus);


?>


<div class="container-fluid">

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">

            <div class="row">

                <div class="col-12">
                    <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                        <div class="form-group row">
                            <label for="search_field" class="col-sm-2 col-form-label">Search</label>
                            <div class="col-sm-8 ui-widget">
                                <input name="search_field" type="text" id="search_field"
                                       class="form-control"
                                       value="">
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
                    <div class="col-10 main_text_smaller">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusActive" name="filterStatusActive"
                                   value="1" <?php echo $selectedStatus['Active'];?>>
                            <label class="form-check-label" for="filterStatusActive">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusPending" name="filterStatusPending"
                                   value="1" <?php echo $selectedStatus['Pending'];?>>
                            <label class="form-check-label" for="filterStatusPending">Pending</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusLocked" name="filterStatusLocked"
                                   value="1" <?php echo $selectedStatus['Locked'];?>>
                            <label class="form-check-label" for="filterStatusLocked">Locked</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusExpired" name="filterStatusExpired"
                                   value="1" <?php echo $selectedStatus['Expired'];?>>
                            <label class="form-check-label" for="filterStatusExpired">Expired</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusDeleted" name="filterStatusDeleted"
                                   value="1" <?php echo $selectedStatus['Deleted'];?>>
                            <label class="form-check-label" for="filterStatusDeleted">Deleted</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusCancelled" name="filterStatusCancelled"
                                   value="1" <?php echo $selectedStatus['Cancelled'];?>>
                            <label class="form-check-label" for="filterStatusCancelled">Cancelled</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterStatusArchived" name="filterStatusArchived"
                                   value="1" <?php echo $selectedStatus['Archived'];?>>
                            <label class="form-check-label" for="filterStatusArchived">Archived</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <input type="submit" name="Submit" id="Submit"
                               value="Filter"
                               class="btn btn-secondary" onclick="">
                        <input type="hidden" name="filter" id="filter" value="filter">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 main_text_smaller">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterPStatusNew" name="filterPStatusNew"
                                   value="1" <?php echo $selectedPStatus['New'];?>>
                            <label class="form-check-label" for="filterPStatusNew">New</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterPStatusRenewal" name="filterPStatusRenewal"
                                   value="1" <?php echo $selectedPStatus['Renewal'];?>>
                            <label class="form-check-label" for="filterPStatusRenewal">Renewal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="filterPStatusEndorsement" name="filterPStatusEndorsement"
                                   value="1" <?php echo $selectedPStatus['Endorsement'];?>>
                            <label class="form-check-label" for="filterPStatusEndorsement">Endorsement</label>
                        </div>
                    </div>
                    <div class="col-6">

                    </div>
                </div>
            </form>

            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover alert alert-success">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('#', 'agr_agreement_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'agr_agreement_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'agr_status'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Process Status', 'agr_process_status'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Starting Date', 'agr_starting_date'); ?></th>
                        <th scope="col">
                            <a href="agreements_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["agr_agreement_ID"]; ?>);"
                            class="<?php echo getAgreementColor($row['agr_status']); ?>">
                            <th scope="row"><?php echo $row["agr_agreement_ID"]; ?></th>
                            <td><?php echo $row["agr_agreement_number"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td><?php echo $row["agr_status"]; ?></td>
                            <td><?php echo $row["agr_process_status"]; ?></td>
                            <td><?php echo $db->convert_date_format($row["agr_starting_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></td>
                            <td>

                                <?php if ($row['agr_status'] == 'Pending') { ?>
                                    <a href="agreements_modify.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-edit" title="Modify"></i></a>&nbsp
                                    <a href="agreements_delete.php?lid=<?php echo $row["agr_agreement_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this agreement?');">
                                        <i class="fas fa-minus-circle" title="Delete"></i></a>&nbsp
                                    <a href="agreements_change_status.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-lock" title="Change Status"></i></a>
                                <?php } else if ($row['agr_status'] == 'Locked') { ?>
                                    <a href="agreements_modify.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-eye" title="View"></i></a>&nbsp
                                    <a href="agreements_change_status.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-plug" title="Change Status"></i></a>
                                <?php } else if ($row['agr_status'] == 'Active') { ?>
                                    <a href="agreements_modify.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-eye" title="View"></i></a>&nbsp
                                    <a href="agreements_change_status.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                        <i class="fas fa-ban" title="Change Status"></i></a>
                                    <?php if ($row["agr_replaced_by_agreement_ID"] == 0) { ?>
                                        <a href="agreement_review.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                            <i class="fas fa-retweet" title="Review"></i></a>
                                        <a href="agreement_endorse.php?lid=<?php echo $row["agr_agreement_ID"]; ?>">
                                            <i class="fas fa-pen-square" title="Endorse"></i></a>

                                    <?php } ?>

                                <?php } ?>


                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-4 agrPendingColor text-center">
                    Pending
                </div>
                <div class="col-4 agrLockedColor text-center">
                    Locked
                </div>
                <div class="col-4 agrActiveColor text-center">
                    Active
                </div>
                <div class="col-3 agrArchivedColor text-center">
                    Archived
                </div>
                <div class="col-3 agrExpiredColor text-center">
                    Expired
                </div>
                <div class="col-3 agrDeletedColor text-center">
                    Deleted
                </div>
                <div class="col-3 agrCancelledColor text-center">
                    Cancelled
                </div>

            </div>
        </div>

        <div class="col-lg-2"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('agreements_modify.php?lid=' + id);
        }
    }

</script>

<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "agreements_api.php?section=agreements";
$table->autoJsCodeHideFocus = true;
$table->autoJsCodeAddedSelectSection = "$('#myForm').submit();";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>
