<?php
include("../include/main.php");
include("../include/tables.php");
include('quotations_class.php');
$db = new Main();

//activate quotation
if ($_GET['action'] == 'activate' && $_GET['lid'] > 0) {
    $quote = new dynamicQuotation($_GET['lid']);

    //check if user is allowed

    $db->start_transaction();
    if ($quote->activate() == true) {
        $db->generateSessionAlertSuccess($quote->getQuotationType() . " activated successfully");

        //check if the email was sent
        if ($quote->error == true) {
            $db->generateSessionAlertError('Activated! Error sending the email. Please check in AutoEmails.');
        }

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

$underwriter = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID']);

$table = new draw_table('oqt_quotations', 'oqq_quotations_ID', 'DESC');
$table->extra_from_section = " JOIN `oqt_quotations_types` ON oqqt_quotations_types_ID = oqq_quotations_type_ID ";
$table->extra_from_section .= " JOIN users ON usr_users_ID = oqq_users_ID";
$table->extra_select_section = ", (oqq_fees + oqq_stamps + oqq_premium)as clo_total_price";

//set the filter in session
if ($_POST['filter'] == 'Filter') {
    $_SESSION['dyqt_filter'] = true;
    $_SESSION['dyqt_filter_user'] = $_POST['filter_user_selected'];
    $_SESSION['dyqt_filter_number'] = $_POST['flt_number'];
    $_SESSION['dyqt_filter_active'] = $_POST['fltActive'];
    $_SESSION['dyqt_filter_outstanding'] = $_POST['fltOutstanding'];
    $_SESSION['dyqt_filter_approved'] = $_POST['fltApproved'];
    $_SESSION['dyqt_filter_pending'] = $_POST['fltPending'];
    $_SESSION['dyqt_filter_deleted'] = $_POST['fltDeleted'];
}
if ($_POST['filter_clear'] == 'Clear') {
    unset($_SESSION['dyqt_filter']);
    unset($_SESSION['dyqt_filter_user']);
    unset($_SESSION['dyqt_filter_number']);
    unset($_SESSION['dyqt_filter_active']);
    unset($_SESSION['dyqt_filter_outstanding']);
    unset($_SESSION['dyqt_filter_approved']);
    unset($_SESSION['dyqt_filter_pending']);
    unset($_SESSION['dyqt_filter_deleted']);
}
$table->extras = '1=1';
//if filter
if ($_SESSION['dyqt_filter']) {

    if ($_SESSION['dyqt_filter_number'] != '') {
        $table->extras .= " AND (
        oqq_number LIKE '%" . $_SESSION['dyqt_filter_number'] . "%' 
        OR oqq_insureds_id LIKE '%".$_SESSION['dyqt_filter_number']."%' 
        OR oqq_insureds_tel LIKE '%".$_SESSION['dyqt_filter_number']."%'
        OR oqq_insureds_mobile LIKE '%".$_SESSION['dyqt_filter_number']."%'
        OR oqq_insureds_name LIKE '%".$_SESSION['dyqt_filter_number']."%'
        OR oqq_quotations_ID = '".$_SESSION['dyqt_filter_number']."'
        
        OR IF (oqq_quotations_type_ID = 2,  #MARINE
            (SELECT oqqit_rate_7 FROM oqt_quotations_items WHERE oqqit_quotations_ID = oqq_quotations_ID AND oqqit_items_ID = 4)
            ,'') COLLATE UTF8_GENERAL_CI LIKE '%".$_SESSION['dyqt_filter_number']."%'
            
        OR IF (oqq_quotations_type_ID = 2,  #MARINE
            (SELECT oqqit_rate_5 FROM oqt_quotations_items WHERE oqqit_quotations_ID = oqq_quotations_ID AND oqqit_items_ID = 4)
            ,'') COLLATE UTF8_GENERAL_CI LIKE '%".$_SESSION['dyqt_filter_number']."%'
        
        )";

        /*
         * Modify search for MARINE as follows
         * Destination city, destination country, supplier,
         *
         * */

    }

    $statusFilterNum = 0;
    ($_SESSION['dyqt_filter_active'] == 1) ? $statusFilter[] = 'Active' : '';
    ($_SESSION['dyqt_filter_outstanding'] == 1) ? $statusFilter[] = 'Outstanding' : '';
    ($_SESSION['dyqt_filter_approved'] == 1) ? $statusFilter[] = 'Approved' : '';
    ($_SESSION['dyqt_filter_pending'] == 1) ? $statusFilter[] = 'Pending' : '';
    ($_SESSION['dyqt_filter_deleted'] == 1) ? $statusFilter[] = 'Deleted' : '';
    //prepare the status filter
    $i = 0;
    if (is_array($statusFilter)) {
        foreach ($statusFilter as $value) {
            $i++;
            if ($i > 1) {
                $filterSql .= ",";
            }
            $filterSql .= "'" . $value . "'";
        }
        if ($i > 0) {
            $table->extras .= " AND oqq_status IN (" . $filterSql . ")";
        }
    }
}


if ($db->user_data["usr_user_rights"] <= 2) {

    if ($_SESSION["dyqt_filter_user"] != '' && $_SESSION["dyqt_filter_user"] != 'ALL') {

        $table->extras .= " AND oqq_users_ID = " . $_SESSION["dyqt_filter_user"];
    } else if ($_SESSION["dyqt_filter_user"] == 'ALL') {
        //no filter
    } else {
        $table->extras .= " AND oqq_users_ID = " . $db->user_data["usr_users_ID"];
    }
}
else if ($underwriter['oqun_view_group_ID'] > 0) {

    if ($_SESSION["dyqt_filter_user"] != '' && $_SESSION["dyqt_filter_user"] != 'ALL') {
        $table->extras .= " AND oqq_users_ID = " . $_SESSION["dyqt_filter_user"];
    } else if ($_SESSION["dyqt_filter_user"] == 'ALL') {
        $table->extras .= " AND oqq_users_ID = " . $db->user_data["usr_users_ID"];
    } else {
        $table->extras .= " AND oqq_users_ID = " . $db->user_data["usr_users_ID"];
    }

}
else {
    $table->extras .= " AND oqq_users_ID = " . $db->user_data["usr_users_ID"];
}

//marine reference extra column
$table->extra_select_section = ",IF (oqq_quotations_type_ID = 2,  
(SELECT oqqit_rate_7 FROM oqt_quotations_items WHERE oqqit_quotations_ID = oqq_quotations_ID AND oqqit_items_ID = 4)
,'')
as clo_marine_reference";

$table->generate_data();
//echo $table->sql;
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
            ignoreEdit = true;

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
                            <?php
                            if ($db->user_data['usr_user_rights'] <= 2 || $underwriter['oqun_view_group_ID'] > 0) { ?>
                                <div class="col-4">
                                    <input name="filter_user_action" id="filter_user_action" type="hidden"
                                           value="change"/>
                                    <select name="filter_user_selected" id="filter_user_selected"
                                            class="form-control">
                                        <option value="ALL"><?php if ($db->user_data['usr_user_rights'] <= 2) echo 'ALL'; else echo 'Mine';?></option>
                                        <?php
                                        if ($db->user_data['usr_user_rights'] <= 2) {
                                            $all_users = $db->query("SELECT * FROM users ORDER BY usr_name ASC");
                                        }
                                        //when underwriter has access to see quotations of a specific group of users
                                        else {
                                            $all_users = $db->query("SELECT * FROM users WHERE usr_users_groups_ID = ".$underwriter['oqun_view_group_ID']." ORDER BY usr_name ASC");
                                        }
                                        while ($user_info = $db->fetch_assoc($all_users)) {
                                            ?>
                                            <option value="<?php echo $user_info["usr_users_ID"]; ?>" <?php if ($_SESSION['dyqt_filter_user'] == $user_info["usr_users_ID"]) { ?> selected="selected" <?php } ?>><?php echo $user_info["usr_name"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="flt_number">Search</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control"
                                               id="flt_number" name="flt_number"
                                               value="<?php echo $_SESSION['dyqt_filter_number']; ?>">
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
                                           id="fltActive" name="fltActive"
                                           value="1" <?php if ($_SESSION['dyqt_filter_active'] == 1) echo 'checked'; ?>>
                                    <label for="fltActive" class="custom-control-label">Active</label>
                                </div>&nbsp;&nbsp;
                                <div class=" custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltOutstanding"
                                           name="fltOutstanding"
                                           value="1" <?php if ($_SESSION['dyqt_filter_outstanding'] == 1) echo 'checked'; ?>>
                                    <label for="fltOutstanding" class="custom-control-label">Outstanding</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltApproved"
                                           name="fltApproved"
                                           value="1" <?php if ($_SESSION['dyqt_filter_approved'] == 1) echo 'checked'; ?>>
                                    <label for="fltApproved" class="custom-control-label">Approved</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltPending"
                                           name="fltPending"
                                           value="1" <?php if ($_SESSION['dyqt_filter_pending'] == 1) echo 'checked'; ?>>
                                    <label for="fltPending" class="custom-control-label">Pending</label>
                                </div>&nbsp;&nbsp;
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fltDeleted"
                                           name="fltDeleted"
                                           value="1" <?php if ($_SESSION['dyqt_filter_deleted'] == 1) echo 'checked'; ?>>
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
                                $sql = "SELECT * FROM oqt_quotations_types WHERE oqqt_status = 'A' ORDER BY oqqt_quotations_types_ID ASC";
                                $result = $db->query($sql);
                                while ($row_qt = $db->fetch_assoc($result)) {
                                    if ($row_qt["oqqt_allowed_user_groups"] == "" || strpos($row_qt["oqqt_allowed_user_groups"], $db->user_data["usg_group_name"] . ",") !== false) {
                                        if (strpos($underwriter['oqun_allow_quotations'], '#' . $row_qt["oqqt_quotations_types_ID"] . '-1#') !== false) {
                                            ?>
                                            <option value="<?php echo $row_qt["oqqt_quotations_types_ID"]; ?>"><?php echo $row_qt["oqqt_name"]; ?></option>
                                            <?php
                                        }
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
                                    <?php if ($db->user_data['usr_user_rights'] <= 3) { ?>
                                        <th scope="col"><?php $table->display_order_links('Agent', 'usr_name'); ?></th>
                                    <?php } ?>
                                    <th scope="col"><?php $table->display_order_links('Number', 'oqq_number'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Name', 'oqq_insureds_name'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Type', 'oqqt_name'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Status', 'oqq_status'); ?></th>
                                    <th scope="col"><?php $table->display_order_links('Expiry', 'oqq_expiry_date'); ?></th>
                                    <?php if ($db->user_data['usr_user_rights'] >= 0) { ?>
                                    <th scope="col"><?php $table->display_order_links('Reference', 'clo_marine_reference'); ?></th>
                                    <?php } ?>
                                    <th scope="col">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                while ($row = $table->fetch_data()) {
                                    //check for renewal icon
                                    $showRenewal = false;
                                    if ($row['oqqt_enable_renewal'] == 1 && $row['oqq_status'] == 'Active' && $row['oqq_replaced_by_ID'] < 1) {
                                        $showRenewal = true;
                                    }
                                    $i++;
                                    ?>
                                    <tr onclick="editLine(<?php echo $row["oqq_quotations_type_ID"] . "," . $row["oqq_quotations_ID"] . ",'" . $row['oqq_status'] . "'"; ?>);"
                                        class="<?php
                                        if ($row['oqq_status'] == 'Deleted') echo 'alert alert-danger';
                                        if ($row['oqq_status'] == 'Cancelled') echo 'alert alert-danger';
                                        ?>">
                                        <th scope="row">

                                            <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                                            <a href="#"
                                               onclick="show_hide_hidden_info(<?php echo $row["oqq_quotations_ID"]; ?>);">
                                                <?php
                                                }
                                                echo $row["oqq_quotations_ID"];
                                                if ($db->user_data["usr_user_rights"] <= 2) { ?></a><?php } ?>
                                        </th>
                                        <?php if ($db->user_data['usr_user_rights'] <= 3) { ?>
                                            <td><?php echo $row["usr_name"]; ?></td>
                                        <?php }?>
                                        <td><?php echo $row["oqq_number"]; ?></td>
                                        <td>
                                            <?php echo $row["oqq_insureds_name"]; ?>
                                            <?php echo "<div id=\"quot_info_id_" . $row["oqq_quotations_ID"] . "\" style=\"display:none\">" . $row["oqq_detail_price_array"] . "</div>"; ?>
                                        </td>

                                        <td><?php echo $row["oqqt_name"]; ?></td>
                                        <td><?php echo $row["oqq_status"]; ?></td>
                                        <td><?php echo $db->convert_date_format($row["oqq_expiry_date"],'yyyy-mm-dd','dd/mm/yyyy',1,0); ?></td>
                                        <?php if ($db->user_data['usr_user_rights'] >= 0) { ?>
                                        <td><?php echo $row["clo_marine_reference"]; ?></td>
                                        <?php } ?>
                                        <td>
                                            <a href="quotations_show.php?lid=<?php echo $row["oqq_quotations_ID"]; ?>">
                                                <i class="fas fa-info-circle" title="View Info"></i>
                                            </a>

                                            <?php if ($row['oqq_status'] == 'Outstanding' || $row['oqq_status'] == 'Copy') { ?>
                                                <a href="quotations_modify.php?quotation_type=<?php echo $row["oqq_quotations_type_ID"]; ?>&quotation=<?php echo $row["oqq_quotations_ID"]; ?>"><i
                                                            class="fas fa-edit" title="Edit"></i></a>&nbsp
                                            <?php } ?>
                                            <?php if ($row['oqq_status'] == 'Outstanding' || $row['oqq_status'] == 'Copy') { ?>
                                                <a href="quotations_delete.php?quotation_type=<?php echo $row["oqq_quotations_type_ID"]; ?>&quotation=<?php echo $row["oqq_quotations_ID"]; ?>"
                                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this quotation?');"><i
                                                            class="fas fa-minus-circle" title="Delete"></i></a>&nbsp
                                            <?php } ?>
                                            <?php if ($row['oqq_status'] == 'Active' ||
                                                (
                                                    ($row['oqq_status'] == 'Outstanding'
                                                        || $row['oqq_status'] == 'Pending')
                                                    && $row['oqqt_allow_print_outstanding'] == 1
                                                ) || $row['oqq_status'] == 'Cancelled'

                                            ) { ?>
                                                <a target="_blank"
                                                   href="quotation_print.php?quotation=<?php echo $row["oqq_quotations_ID"]; ?>&pdf=1"
                                                   onclick="ignoreEdit = true;">
                                                    <i class="far fa-file-pdf" title="View PDF"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($row['oqq_status'] == 'Outstanding' || $row['oqq_status'] == 'Approved') { ?>
                                                <a href="#">
                                                    <i class="fas fa-lock" title="Activate"
                                                       onclick="activateQuotation(<?php echo $row["oqq_quotations_ID"]; ?>);"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($showRenewal == true) { ?>
                                                <a href="#">
                                                    <i class="fas fa-retweet" title="Renew"
                                                       onclick="renewQuotation(<?php echo $row["oqq_quotations_ID"]; ?>);"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($row['oqq_status'] == 'Active' && $db->user_data['usr_user_rights'] <= 2 && $row['oqqt_enable_cancellation'] == 1) { ?>
                                                <a href="quotation_cancellation.php?lid=<?php echo $row['oqq_quotations_ID']; ?>">
                                                    <i class="fas fa-times-circle" title="Cancel"></i>
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
            else {
                ignoreEdit = false;
            }
        }

        function activateQuotation(id) {
            ignoreEdit = true;
            if (confirm('Are you sure you want to activate this?')) {
                window.location.assign('quotations.php?lid=' + id + '&action=activate')
            }
        }

        function renewQuotation(id) {
            ignoreEdit = true;
            if (confirm('Are you sure you want to renew this?')) {
                window.location.assign('quotation_renewal.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>
