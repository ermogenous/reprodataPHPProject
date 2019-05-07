<?php
include("../include/main.php");
include("../include/tables.php");
include('quotations_class.php');
$db = new Main();

//activate quotation
if ($_GET['action'] == 'activate' && $_GET['lid'] > 0) {
    $quote = new dynamicQuotation($_GET['lid']);
    $db->start_transaction();
    if ($quote->activate() == true) {
        $db->generateSessionAlertSuccess($quote->getQuotationType() . " activated successfully");
    } else {
        if ($quote->errorType == 'warning') {
            $db->generateSessionAlertWarning($quote->errorDescription);
        } else {
            $db->generateSessionAlertError($quote->errorDescription);
        }
    }
    $db->commit_transaction();
    header("Location: quotations.php");
    exit();

}


$table = new draw_table('oqt_quotations', 'oqq_quotations_ID', 'DESC');
$table->extra_from_section = " JOIN `oqt_quotations_types` ON oqqt_quotations_types_ID = oqq_quotations_type_ID ";
$table->extra_select_section = ", (oqq_fees + oqq_stamps + oqq_premium)as clo_total_price";

//set the filter in session
if ($_POST['filter'] == 'Filter'){
    echo "Creating filters in session";
    $_SESSION['dyqt_filter'] = true;
    $_SESSION['dyqt_filter_user'] = $_POST['filter_user_selected'];
    $_SESSION['dyqt_filter_number'] = $_POST['flt_number'];
    $_SESSION['dyqt_filter_active'] = $_POST['fltActive'];
    $_SESSION['dyqt_filter_outstanding'] = $_POST['fltOutstanding'];
    $_SESSION['dyqt_filter_approved'] = $_POST['fltApproved'];
    $_SESSION['dyqt_filter_pending'] = $_POST['fltPending'];
    $_SESSION['dyqt_filter_deleted'] = $_POST['fltDeleted'];
}
if ($_POST['filter_clear'] == 'Clear'){
    echo "Clearing filters in session";
    unset($_SESSION['dyqt_filter']);
    unset($_SESSION['dyqt_filter_user']);
    unset($_SESSION['dyqt_filter_number']);
    unset($_SESSION['dyqt_filter_active']);
    unset($_SESSION['dyqt_filter_outstanding']);
    unset($_SESSION['dyqt_filter_approved']);
    unset($_SESSION['dyqt_filter_pending']);
    unset($_SESSION['dyqt_filter_deleted']);
}

//if filter
if ($_SESSION['dyqt_filter']) {
    $table->extras = '1=1';
    if ($_SESSION['dyqt_filter_number'] != ''){
        $table->extras .= " AND oqq_number LIKE '%".$_SESSION['dyqt_filter_number']."%'";
    }
}


if ($db->user_data["usr_user_rights"] == 0) {

    if ($_SESSION["quotations_user_filter"] == "") {
        //$_SESSION["quotations_user_filter"] = $db->user_data["usr_users_ID"];
    }

    if ($_POST["filter_user_action"] == "change") {
        //$_SESSION["quotations_user_filter"] = $_POST["filter_user_selected"];
    }

    if ($_SESSION["quotations_user_filter"] != '0') {
        //$table->extras .= " oqq_users_ID = " . $_SESSION["quotations_user_filter"];
    }
} else {
    $table->extras .= " AND oqq_users_ID = " . $db->user_data["usr_users_ID"];
}


$table->generate_data();
echo $db->prepare_text_as_html($table->sql);

$db->admin_on_load = "show_price();";
$db->show_header();

//get details if show price
if ($_GET["price_id"] != "") {
    $show_price = $db->query_fetch("SELECT 
	oqq_insureds_name
	,(oqq_fees + oqq_stamps + oqq_premium)as clo_total_price 
	,oqqt_print_layout
	FROM 
	oqt_quotations 
	JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID
	WHERE 
	oqq_quotations_ID = " . $_GET["price_id"]);

}

?>
    <script language="JavaScript" type="text/javascript">

        function show_price() {
            var price_to_show = <?php if ($_GET["price_id"] != "") echo $show_price["clo_total_price"]; else echo 0; ?>;

            if (price_to_show != 0) {

                if (confirm('Total Price For Quotation\n <?php echo $show_price["oqq_insureds_name"];?>\n €' + price_to_show + '\nShow Print?')) {
                    window.open("<?php echo $show_price["oqqt_print_layout"];?>?quotation=<?php echo $_GET["price_id"];?>");
                }

            }

        }


        function show_hide_hidden_info(ID) {

            if (document.getElementById('quot_info_id_' + ID).style.display == 'none') {
                document.getElementById('quot_info_id_' + ID).style.display = 'block';
            }
            else {
                document.getElementById('quot_info_id_' + ID).style.display = 'none';
            }

        }
    </script>
    <div class="container-fluid">

        <div class="form-group">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-7">
                    <form action="" method="post">

                        <div class="row">
                            <div class="col-4">
                                <input name="filter_user_action" id="filter_user_action" type="hidden" value="change"/>
                                <select name="filter_user_selected" id="filter_user_selected"
                                        class="form-control">
                                    <option value="0">ALL</option>
                                    <?php
                                    $all_users = $db->query("SELECT * FROM users ORDER BY usr_name ASC");
                                    while ($user_info = $db->fetch_assoc($all_users)) {
                                        ?>
                                        <option value="<?php echo $user_info["usr_users_ID"]; ?>" <?php if ($_SESSION["quotations_user_filter"] == $user_info["usr_users_ID"]) { ?> selected="selected" <?php } ?>><?php echo $user_info["usr_name"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="flt_number">Number</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control"
                                               id="flt_number" name="flt_number" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <input name="filter" type="submit" value="Filter" class="btn btn-primary"/>
                                <input name="filter_clear" type="submit" value="Clear" class="btn btn-secondary"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-inline">
                                <div class=" custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="fltActive" name="fltActive" value="1">
                                    <label for="fltActive" class="custom-control-label">Active</label>
                                </div>&nbsp;&nbsp;
                                <div class=" custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltOutstanding"
                                           name="fltOutstanding" value="1">
                                    <label for="fltOutstanding" class="custom-control-label">Outstanding</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltApproved"
                                           name="fltApproved" value="1">
                                    <label for="fltApproved" class="custom-control-label">Approved</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltPending"
                                           name="fltPending" value="1">
                                    <label for="fltPending" class="custom-control-label">Pending</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltDeleted"
                                           name="fltDeleted" value="1">
                                    <label for="fltDeleted" class="custom-control-label">Deleted</label>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="col-3">

                    <div class="row">
                        <div class="col-8">
                            <select name="quotation_ID" id="quotation_ID" class="form-control">
                                <?php
                                $sql = "SELECT * FROM oqt_quotations_types WHERE oqqt_status = 'A' ORDER BY oqqt_name ASC";
                                $result = $db->query($sql);
                                while ($row_qt = $db->fetch_assoc($result)) {
                                    if ($row_qt["oqqt_allowed_user_groups"] == "" || strpos($row_qt["oqqt_allowed_user_groups"], $db->user_data["usg_group_name"] . ",") !== false) {
                                        ?>
                                        <option value="<?php echo $row_qt["oqqt_quotations_types_ID"]; ?>"><?php echo $row_qt["oqqt_name"]; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <input name="new_quotation" type="button" id="new_quotation" value="New"
                                   class="btn btn-primary"
                                   onclick="window.location.href = 'quotations_modify.php?quotation_type=' + document.getElementById('quotation_ID').value;"/>
                        </div>
                    </div>

                </div>
                <div class="col-1"></div>
            </div>


            <div class="col-1"></div>
            <div class="col-3">


            </div>
            <div class="col-3">

            </div>
            <div class="col-5">


            </div>
            <div class="col-1"></div>
        </div>

        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12 text-center"><?php $table->show_pages_links(); ?></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr class="alert alert-success">
                                    <th scope="col"><?php $table->display_order_links('ID', 'oqq_quotations_ID'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Number', 'oqq_number'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Name', 'oqq_insureds_name'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Type', 'oqqt_name'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Status', 'oqq_status'); ?></th>
                                    <th scope="col">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                while ($row = $table->fetch_data()) {
                                    $i++;
                                    ?>
                                    <tr onclick="editLine(<?php echo $row["oqq_quotations_type_ID"] . "," . $row["oqq_quotations_ID"] . ",'" . $row['oqq_status'] . "'"; ?>);"
                                        class="<?php if ($row['oqq_status'] == 'Deleted') echo 'alert alert-danger'; ?>">
                                        <th scope="row">

                                            <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                                            <a href="#"
                                               onclick="show_hide_hidden_info(<?php echo $row["oqq_quotations_ID"]; ?>);">
                                                <?php
                                                }
                                                echo $row["oqq_quotations_ID"];
                                                if ($db->user_data["usr_user_rights"] <= 2) { ?></a><?php } ?>
                                        </th>
                                        <td><?php echo $row["oqq_number"]; ?></td>
                                        <td>
                                            <?php echo $row["oqq_insureds_name"]; ?>
                                            <?php echo "<div id=\"quot_info_id_" . $row["oqq_quotations_ID"] . "\" style=\"display:none\">" . $row["oqq_detail_price_array"] . "</div>"; ?>
                                        </td>

                                        <td><?php echo $row["oqqt_name"]; ?></td>
                                        <td><?php echo $row["oqq_status"]; ?></td>
                                        <td>
                                            <a href="quotations_show.php?lid=<?php echo $row["oqq_quotations_ID"]; ?>">
                                                <i class="fas fa-info-circle"></i>
                                            </a>

                                            <?php if ($row['oqq_status'] == 'Outstanding') { ?>
                                                <a href="quotations_modify.php?quotation_type=<?php echo $row["oqq_quotations_type_ID"]; ?>&quotation=<?php echo $row["oqq_quotations_ID"]; ?>"><i
                                                            class="fas fa-edit"></i></a>&nbsp
                                            <?php } ?>
                                            <?php if ($row['oqq_status'] == 'Outstanding') { ?>
                                                <a href="quotations_delete.php?quotation_type=<?php echo $row["oqq_quotations_type_ID"]; ?>&quotation=<?php echo $row["oqq_quotations_ID"]; ?>"
                                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this quotation?');"><i
                                                            class="fas fa-minus-circle"></i></a>&nbsp
                                            <?php } ?>
                                            <?php if ($row['oqq_status'] == 'Active') { ?>
                                                <a target="_blank"
                                                   href="quotation_print.php?quotation=<?php echo $row["oqq_quotations_ID"]; ?>&pdf=1"
                                                   onclick="ignoreEdit = true;">
                                                    <i class="far fa-file-pdf"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($row['oqq_status'] == 'Outstanding' || $row['oqq_status'] == 'Approved') { ?>
                                                <a href="#">
                                                    <i class="fas fa-lock"
                                                       onclick="activateQuotation(<?php echo $row["oqq_quotations_ID"]; ?>);"></i>
                                                </a>
                                            <?php } ?>


                                        </td>
                                    </tr>
                                    <?php
                                }


                                if ($i == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5" align="center">
                                            No Quotations Found. Press &lt;NEW&gt; to create a new quotation.
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr class="row_table_head">
                                    <td colspan="5" align="center"><?php $table->show_pages_links(); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>

    </div>
    <script>

        var ignoreEdit = false;

        function editLine(quotationType, quotation, status) {
            if (ignoreEdit === false) {
                if (status == 'Outstanding') {
                    window.location.assign('quotations_modify.php?quotation_type=' + quotationType + '&quotation=' + quotation);
                }
                else {
                    window.location.assign('quotations_show.php?price_id=' + quotation);
                }
            }
        }

        function activateQuotation(id) {
            ignoreEdit = true;
            if (confirm('Are you sure you want to activate this?')) {
                window.location.assign('quotations.php?lid=' + id + '&action=activate')
            }
        }
    </script>
<?php
$db->show_footer();
?>