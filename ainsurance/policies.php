<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 23/1/2019
 * Time: 11:53 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");
include('policy_class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policies";

$table = new draw_table('ina_policies', 'inapol_policy_ID', 'DESC');
$table->extra_from_section .= 'JOIN ina_insurance_companies ON inapol_insurance_company_ID = inainc_insurance_company_ID';
$table->extra_from_section .= ' JOIN customers ON cst_customer_ID = inapol_customer_ID';
$table->extra_from_section .= ' JOIN ina_underwriters ON inaund_underwriter_ID = inapol_underwriter_ID';
$table->extra_from_section .= ' JOIN users ON inaund_user_ID = usr_users_ID';
$table->extras = 'inapol_underwriter_ID ' . Policy::getAgentWhereClauseSql();

//search parameters
if ($_POST['srgStatus'] != 'ALL' && $_POST['srgStatus'] != '') {
    $table->extras .= 'AND inapol_status = "' . $_POST['srgStatus'] . '"';
}
if ($_POST['srgProcessStatus'] != 'ALL' && $_POST['srgProcessStatus'] != '') {
    $table->extras .= 'AND inapol_process_status = "' . $_POST['srgProcessStatus'] . '"';
}
if ($_POST['srgPolicy'] != '') {
    $table->extras .= 'AND inapol_policy_number LIKE "%' . $_POST['srgPolicy'] . '%"';
}
if ($_POST['srgCustomer'] != '') {
    $table->extras .= 'AND (cst_name LIKE "%' . $_POST['srgCustomer'] . '%" OR cst_surname LIKE "%' . $_POST['srgCustomer'] . '%" ';
    $table->extras .= 'OR cst_identity_card LIKE "%' . $_POST['srgCustomer'] . '%" OR cst_work_tel_1 LIKE "%' . $_POST['srgCustomer'] . '%" ';
    $table->extras .= 'OR cst_work_tel_2 LIKE "%' . $_POST['srgCustomer'] . '%" OR cst_fax LIKE "%' . $_POST['srgCustomer'] . '%" ';
    $table->extras .= 'OR cst_mobile_1 LIKE "%' . $_POST['srgCustomer'] . '%" OR cst_mobile_2 LIKE "%' . $_POST['srgCustomer'] . '%" )';
}

$table->generate_data();

//find how many users are under this user
$underwriter = Policy::getUnderwriterData();
$sql = "
  SELECT * FROM
  users
  JOIN users_groups ON usr_users_groups_ID = usg_users_groups_ID
  JOIN ina_underwriters ON inaund_user_ID = usr_users_ID
  WHERE
  usg_users_groups_ID = " . $db->user_data['usr_users_groups_ID'] . "
  AND inaund_vertical_level > " . $underwriter['inaund_vertical_level'];
$result = $db->query($sql);
$totalUnderwriters = $result->num_rows;

$db->show_header();
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <div class="card" id="searchBody">
                <div class="card-body">
                    <form action="" method="post">
                            <div class="row">
                                <label for="" class="col-form-label col-sm-2 pr-0 pl-0">Status</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="srgStatus" id="srgStatus">
                                        <option value="ALL" <?php if ($_POST['srgStatus'] == 'ALL') echo 'selected'; ?>>
                                            All
                                        </option>
                                        <option value="Outstanding" <?php if ($_POST['srgStatus'] == 'Outstanding') echo 'selected'; ?>>
                                            Outstanding
                                        </option>
                                        <option value="Active" <?php if ($_POST['srgStatus'] == 'Active') echo 'selected'; ?>>
                                            Active
                                        </option>
                                        <option value="Archived" <?php if ($_POST['srgStatus'] == 'Archived') echo 'selected'; ?>>
                                            Archived
                                        </option>
                                    </select>
                                </div>

                                <label for="" class="col-form-label col-sm-2 pr-0 pl-0">ProcessStatus</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="srgProcessStatus" id="srgProcessStatus">
                                        <option value="ALL" <?php if ($_POST['srgProcessStatus'] == 'ALL') echo 'selected'; ?>>
                                            All
                                        </option>
                                        <option value="New" <?php if ($_POST['srgProcessStatus'] == 'New') echo 'selected'; ?>>
                                            New
                                        </option>
                                        <option value="Renewal" <?php if ($_POST['srgProcessStatus'] == 'Renewal') echo 'selected'; ?>>
                                            Renewal
                                        </option>
                                        <option value="Endorsement" <?php if ($_POST['srgProcessStatus'] == 'Endorsement') echo 'selected'; ?>>
                                            Endorsement
                                        </option>
                                        <option value="Cancellation" <?php if ($_POST['srgProcessStatus'] == 'Cancellation') echo 'selected'; ?>>
                                            Cancellation
                                        </option>
                                    </select>
                                </div>

                                <label for="" class="col-form-label col-sm-1 pr-0 pl-0">Policy</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $_POST['srgPolicy']; ?>"
                                           name="srgPolicy" id="srgPolicy">
                                </div>

                            </div>
                            <div class="row">
                                <label for="" class="col-sm-2 pr-0 pl-0"
                                       title="Search By Name/Surname/ID/Tel">Customer</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $_POST['srgCustomer']; ?>"
                                           name="srgCustomer" id="srgCustomer">
                                </div>

                                <label for="" class="col-sm-2 pr-0 pl-0" title="Search By Name">Company</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $_POST['srgCompany']; ?>"
                                           name="srgCompany" id="srgCompany">
                                </div>

                                <div class="col-sm-2 text-right p-0">
                                    <input type="button" value="Reset" class="btn btn-warning" onclick="resetForm();">
                                    <input type="submit" value="Search"
                                           class="btn btn-primary" id="Search">
                                </div>
                                <script>
                                    function resetForm() {
                                        $('#srgStatus').val('ALL');
                                        $('#srgProcessStatus').val('ALL');
                                        $('#srgCustomer').val('');
                                        $('#srgPolicy').val('');
                                        $('#srgCompany').val('');
                                    }
                                </script>
                            </div>
                    </form>
                    <div class="row" style="cursor: pointer;" onclick="showHideSearch();">
                        <input type="hidden" id="searchBodyActive" value="1">
                        <div class="col-sm-12 text-right">Hide Search <i class="fas fa-minus"></i></div>
                    </div>
                    <script>
                        function showHideSearch() {
                            if ($('#searchBodyActive').val() == '1') {
                                $('#searchBody').hide();
                                $('#searchBodyActive').val('0');
                                $('#showSearchRow').show();
                            }
                            else {
                                $('#searchBody').show();
                                $('#searchBodyActive').val('1');
                                $('#showSearchRow').hide();
                            }
                        }
                    </script>
                </div>
            </div>

            <div class="row" onclick="showHideSearch();" id="showSearchRow" style="display: none; cursor: pointer">
                <div class="col-sm-12 text-right">
                    Show Search <i class="fas fa-plus"></i>
                </div>
            </div>



        </div>
        <div class="col-lg-1"></div>
    </div>
</div>

<div class="container-fluid" style="font-size: 13px;">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover" id="myTableList">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inapol_policy_ID'); ?></th>
                        <?php if ($totalUnderwriters > 0) { ?>
                            <th scope="col"><?php $table->display_order_links($db->showLangText('Underwriter', 'Ασφαλιστής'), 'usr_name'); ?></th>
                        <?php } ?>
                        <th scope="col"><?php $table->display_order_links($db->showLangText('Policy Number', 'Αρ.Συμβολαίου'), 'inapol_policy_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText('Customer', 'Ον.Πελάτη'), 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText('Customer ID', 'Ταυτότητα'), 'cst_identity_card'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText('Status', 'Κατάσταση'), 'inapol_status'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText('St.Date', 'Ημ.Έναρξης'), 'inapol_starting_date'); ?></th>
                        <th scope="col">
                            <a href="policy_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row["inapol_policy_ID"]; ?></th>
                            <?php if ($totalUnderwriters > 0) { ?>
                                <td><?php echo $row["usr_name"]; ?></td>
                            <?php } ?>
                            <td><?php echo $row["inapol_policy_number"]; ?></td>
                            <td><?php echo $row["cst_name"] . " " . $row['cst_surname']; ?></td>
                            <td><?php echo $row["cst_identity_card"]; ?></td>
                            <td><?php echo $row['inapol_process_status'] . "/" . $row["inapol_status"]; ?></td>
                            <td><?php echo $db->convert_date_format($row['inapol_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?></td>
                            <td>
                                <input type="hidden" id="myLineID" name="myLineID"
                                       value="<?php echo $row["inapol_policy_ID"]; ?>">
                                <?php if ($row['inapol_status'] == 'Outstanding') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-edit"
                                           title="<?php echo $db->showLangText('Modify Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp

                                    <a href="policy_delete.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this policy?');">
                                        <i class="fas fa-minus-circle"
                                           title="<?php echo $db->showLangText('Delete Policy', 'Διαγραφή Συμβολαίου'); ?>"></i></a>&nbsp

                                    <a href="policy_change_status.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-lock"
                                                title="<?php echo $db->showLangText('Activate Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp
                                <?php }
                                if ($row['inapol_status'] == 'Active') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-eye"
                                                title="<?php echo $db->showLangText('View Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp
                                <?php }
                                if ($row['inapol_status'] == 'Cancelled' || $row['inapol_status'] == 'Deleted') { ?>
                                    <a href="policy_modify.php?lid=<?php echo $row["inapol_policy_ID"]; ?>"><i
                                                class="fas fa-eye"
                                                title="<?php echo $db->showLangText('View Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp

                                <?php }
                                if ($row['inapol_status'] == 'Active' && $row['inapol_replaced_by_ID'] == 0) { ?>
                                    <a href="policy_renewal.php?pid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-retweet"
                                           title="<?php echo $db->showLangText('Review Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp

                                <?php } ?>
                                <?php
                                if ($row['inapol_status'] == 'Active' && $row['inapol_replaced_by_ID'] == 0) { ?>
                                    <a href="policy_endorsement.php?pid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-wrench"
                                           title="<?php echo $db->showLangText('Endorse Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp

                                    <a href="policy_cancellation.php?pid=<?php echo $row["inapol_policy_ID"]; ?>">
                                        <i class="fas fa-ban"
                                           title="<?php echo $db->showLangText('Cancel Policy', 'Επεξεργασία Συμβολαίου'); ?>"></i></a>&nbsp

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
        <div class="col-lg-1"></div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('policy_modify.php?lid=' + id);
        }
        ignoreEdit = false;
    }

    $(document).ready(function () {
        $('#myTableList tr').click(function () {
            var href = $(this).find('input[id=myLineID]').val();
            if (href) {
                editLine(href);
            }
        });
    });
</script>
<?php
$db->show_footer();
?>
