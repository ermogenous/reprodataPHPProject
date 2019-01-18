<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 20/9/2018
 * Time: 10:45 ΠΜ
 */


include("../include/main.php");
$db = new Main();
$db->admin_title = "Settings";


if ($db->user_data["usr_user_rights"] == 0) {

    if ($db->originalUserData['usr_user_rights'] == 0) {

    } else {
        header("Location: ../home.php");
        exit();
    }

}

if ($_POST["action"] == "update") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Settings Update';
    //loop into all the fld`s
    foreach ($_POST as $name => $value) {

        if (substr($name, 0, 4) == 'fld_') {
            //echo $name." -> ".$value."<br>";
            //check if the settings exists
            $check = $db->query_fetch("SELECT stg_settings_ID FROM settings WHERE stg_section = '" . substr($name, 4) . "'");
            if ($check['stg_settings_ID'] > 0) {
                $db->update_setting(substr($name, 4), $value, $_POST['startup_' . $name]);
            } else {
                $setData['section'] = substr($name, 4);
                $setData['value'] = $value;
                $setData['fetch_on_startup'] = $db->get_check_value($_POST['startup_' . $name]);
                $db->db_tool_insert_row('settings', $setData, '', 0, 'stg_');
            }


        }

    }

    header('Location:settings_update.php');
    exit();

}

$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b>Update Settings</b>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                           role="tab"
                           aria-controls="pills-general" aria-selected="true">General</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-addons-tab" data-toggle="pill" href="#pills-addons"
                           role="tab"
                           aria-controls="pills-addons" aria-selected="true">Addons</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-customers-tab" data-toggle="pill" href="#pills-customers"
                           role="tab"
                           aria-controls="pills-customers" aria-selected="true">Customers</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-insurance-tab" data-toggle="pill" href="#pills-insurance"
                           role="tab"
                           aria-controls="pills-insurance" aria-selected="true">Agent Insurance</a>
                    </li>

                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                         aria-labelledby="pills-general-tab">
                        <!-- GENERAL -->


                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Layout
                            </div>
                        </div>

                        <?php
                        $footerShowStats = $db->get_setting('layout_show_footer_stats');
                        ?>
                        <div class="form-group row">
                            <label for="fld_layout_show_footer_stats" class="col-sm-4 col-form-label">Footer
                                Stats
                                <input type="checkbox" title="Bring On Startup" value="1"
                                       id="startup_fld_layout_show_footer_stats"
                                       name="startup_fld_layout_show_footer_stats"
                                    <?php if ($db->get_setting('layout_show_footer_stats', 'startup') == 1) echo 'checked'; ?>>
                            </label>
                            <div class="col-sm-8">
                                <select name="fld_layout_show_footer_stats" id="fld_layout_show_footer_stats"
                                        class="form-control"
                                        required>
                                    <option value="Yes" <?php if ($footerShowStats == 'Yes') echo 'selected'; ?>>Show
                                        stats on footer
                                    </option>
                                    <option value="No" <?php if ($footerShowStats == 'No') echo 'selected'; ?>>Hide
                                        stats on footer
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Administrator
                            </div>
                        </div>
                        <?php
                        $imitateUser = $db->get_setting('admin_imitate_user');
                        ?>
                        <div class="form-group row">
                            <label for="fld_admin_imitate_user" class="col-sm-4 col-form-label">
                                Imitate User
                                <input type="checkbox" title="Bring On Startup" value="1"
                                       id="startup_fld_admin_imitate_user"
                                       name="startup_fld_admin_imitate_user"
                                    <?php if ($db->get_setting('admin_imitate_user', 'startup') == 1) echo 'checked'; ?>>
                            </label>
                            <div class="col-sm-8">
                                <select name="fld_admin_imitate_user" id="fld_admin_imitate_user"
                                        class="form-control"
                                        required>
                                    <option value="No" <?php if ($imitateUser == 'No') echo 'selected'; ?>>
                                        No
                                    </option>
                                    <?php
                                    $sql = "SELECT * FROM users WHERE usr_active = 1 ORDER BY usr_username";
                                    $result = $db->query($sql);
                                    while ($user = $db->fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $user['usr_users_ID']; ?>" <?php if ($imitateUser == $user['usr_users_ID']) echo 'selected'; ?>>
                                            <?php echo $user['usr_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Addons -->
                    <div class="tab-pane fade show" id="pills-addons" role="tabpanel"
                         aria-labelledby="pills-addons-tab">
                        <!-- STOCK -->
                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Stock
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="fld_stk_stock_enable">
                                    Enable Stock
                                    <input type="checkbox" title="Bring On Startup" value="1"
                                           id="startup_fld_stk_stock_enable" name="startup_fld_stk_stock_enable"
                                        <?php if ($db->get_setting('stk_stock_enable', 'startup') == 1) echo 'checked'; ?>>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="hidden" name="fld_stk_stock_enable" id="fld_stk_stock_enable"
                                       value="<?php echo $db->get_setting('stk_stock_enable');?>">
                                <input type="checkbox"
                                       onchange="fixCheckbox('stk_stock_enable','fld_stk_stock_enable');"
                                       id="stk_stock_enable"
                                       name="stk_stock_enable"
                                       class="form-control"
                                       value="1"
                                    <?php if ($db->get_setting('stk_stock_enable') == 1) echo "checked"; ?>
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Stock Active Year</div>
                            <div class="col-sm-8">
                                <?php echo $db->get_setting('stk_active_year'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Stock Active Period</div>
                            <div class="col-sm-8">
                                <?php echo $db->get_setting('stk_active_month'); ?>
                            </div>
                        </div>


                        <!-- AGREEMENTS -->
                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Agreements
                            </div>
                        </div>

                        <?php
                        $numberPrefix = $db->get_setting('agr_agreement_number_prefix');
                        ?>
                        <div class="form-group row">
                            <label for="fld_agr_agreement_number_prefix" class="col-sm-4 col-form-label">
                                Number Prefix
                                <input type="checkbox" title="Bring On Startup" value="1"
                                       id="startup_fld_agr_agreement_number_prefix"
                                       name="startup_fld_agr_agreement_number_prefix"
                                    <?php if ($db->get_setting('agr_agreement_number_prefix', 'startup') == 1) echo 'checked'; ?>>
                            </label>
                            <div class="col-sm-8">
                                <input name="fld_agr_agreement_number_prefix" type="text"
                                       id="fld_agr_agreement_number_prefix"
                                       class="form-control"
                                       value="<?php echo $numberPrefix; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLeadingZeros = $db->get_setting('agr_agreement_number_leading_zeros');
                        ?>
                        <div class="form-group row">
                            <label for="fld_agr_agreement_number_leading_zeros" class="col-sm-4 col-form-label">Leading
                                Zeros</label>
                            <div class="col-sm-8">
                                <input name="fld_agr_agreement_number_leading_zeros" type="text"
                                       id="fld_agr_agreement_number_leading_zeros"
                                       class="form-control"
                                       value="<?php echo $numberLeadingZeros; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLastUsed = $db->get_setting('agr_agreement_number_last_used');
                        ?>
                        <div class="form-group row">
                            <label for="fld_agr_agreement_number_last_used" class="col-sm-4 col-form-label">Last Number
                                Used</label>
                            <div class="col-sm-4">
                                <input name="fld_agr_agreement_number_last_used" type="text"
                                       id="fld_agr_agreement_number_last_used"
                                       class="form-control"
                                       value="<?php echo $numberLastUsed; ?>">
                            </div>
                            <div class="col-sm-4">
                                <?php echo $db->buildNumber($numberPrefix, $numberLeadingZeros, $numberLastUsed); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fld_agr_agreement_status_on_insert" class="col-sm-4 col-form-label">Status On
                                Insert</label>
                            <div class="col-sm-8">
                                <select name="fld_agr_agreement_status_on_insert"
                                        id="fld_agr_agreement_status_on_insert"
                                        class="form-control"
                                        required>
                                    <option value="Pending">Pending</option>
                                    <option value="Locked">Locked</option>
                                </select>
                            </div>
                        </div>

                        <!-- TICKETS -->
                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Tickets
                            </div>
                        </div>

                        <?php
                        $numberPrefix = $db->get_setting('tck_ticket_number_prefix');
                        ?>
                        <div class="form-group row">
                            <label for="fld_tck_ticket_number_prefix" class="col-sm-4 col-form-label">Number
                                Prefix</label>
                            <div class="col-sm-8">
                                <input name="fld_tck_ticket_number_prefix" type="text"
                                       id="fld_tck_ticket_number_prefix"
                                       class="form-control"
                                       value="<?php echo $numberPrefix; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLeadingZeros = $db->get_setting('tck_ticket_number_leading_zeros');
                        ?>
                        <div class="form-group row">
                            <label for="fld_tck_ticket_number_leading_zeros" class="col-sm-4 col-form-label">Leading
                                Zeros</label>
                            <div class="col-sm-8">
                                <input name="fld_tck_ticket_number_leading_zeros" type="text"
                                       id="fld_tck_ticket_number_leading_zeros"
                                       class="form-control"
                                       value="<?php echo $numberLeadingZeros; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLastUsed = $db->get_setting('tck_ticket_number_last_used');
                        ?>
                        <div class="form-group row">
                            <label for="fld_tck_ticket_number_last_used" class="col-sm-4 col-form-label">Last Number
                                Used</label>
                            <div class="col-sm-4">
                                <input name="fld_tck_ticket_number_last_used" type="text"
                                       id="fld_tck_ticket_number_last_used"
                                       class="form-control"
                                       value="<?php echo $numberLastUsed; ?>">
                            </div>
                            <div class="col-sm-4">
                                <?php echo $db->buildNumber($numberPrefix, $numberLeadingZeros, $numberLastUsed); ?>
                            </div>
                        </div>

                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Schedules
                            </div>
                        </div>
                        <?php
                        $numberPrefix = $db->get_setting('sch_schedule_number_prefix');
                        ?>
                        <div class="form-group row">
                            <label for="fld_sch_schedule_number_prefix" class="col-sm-4 col-form-label">Number
                                Prefix</label>
                            <div class="col-sm-8">
                                <input name="fld_sch_schedule_number_prefix" type="text"
                                       id="fld_sch_schedule_number_prefix"
                                       class="form-control"
                                       value="<?php echo $numberPrefix; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLeadingZeros = $db->get_setting('sch_schedule_number_leading_zeros');
                        ?>
                        <div class="form-group row">
                            <label for="fld_sch_schedule_number_leading_zeros" class="col-sm-4 col-form-label">Leading
                                Zeros</label>
                            <div class="col-sm-8">
                                <input name="fld_sch_schedule_number_leading_zeros" type="text"
                                       id="fld_sch_schedule_number_leading_zeros"
                                       class="form-control"
                                       value="<?php echo $numberLeadingZeros; ?>">
                            </div>
                        </div>
                        <?php
                        $numberLastUsed = $db->get_setting('sch_schedule_number_last_used');
                        ?>
                        <div class="form-group row">
                            <label for="fld_sch_schedule_number_last_used" class="col-sm-4 col-form-label">Last Number
                                Used</label>
                            <div class="col-sm-4">
                                <input name="fld_sch_schedule_number_last_used" type="text"
                                       id="fld_sch_schedule_number_last_used"
                                       class="form-control"
                                       value="<?php echo $numberLastUsed; ?>">
                            </div>
                            <div class="col-sm-4">
                                <?php echo $db->buildNumber($numberPrefix, $numberLeadingZeros, $numberLastUsed); ?>
                            </div>
                        </div>

                    </div>

                    <!-- CUSTOMERS -->
                    <div class="tab-pane fade show" id="pills-customers" role="tabpanel"
                         aria-labelledby="pills-customers-tab">

                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Customers Settings
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="fld_cst_customer_per_user">
                                    Customers Per User
                                    <input type="checkbox" title="Bring On Startup" value="1"
                                           id="startup_fld_cst_customer_per_user"
                                           name="startup_fld_cst_customer_per_user"
                                        <?php if ($db->get_setting('cst_customer_per_user', 'startup') == 1) echo 'checked'; ?>>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control" id="fld_cst_customer_per_user"
                                        name="fld_cst_customer_per_user">
                                    <option value="forAll"
                                        <?php if ($db->get_setting('cst_customer_per_user') == 'forAll') echo 'selected'; ?>>
                                        All user groups can view the customers
                                    </option>
                                    <option value="perUser"
                                        <?php if ($db->get_setting('cst_customer_per_user') == 'perUser') echo 'selected'; ?>>
                                        Each user group has his own customers
                                    </option>
                                </select>
                            </div>


                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="fld_cst_customer_per_user">
                                    Admin Customers
                                    <input type="checkbox" title="Bring On Startup" value="1"
                                           id="startup_fld_cst_admin_customers"
                                           name="startup_fld_cst_admin_customers"
                                        <?php if ($db->get_setting('cst_admin_customers', 'startup') == 1) echo 'checked'; ?>>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control" id="fld_cst_admin_customers"
                                        name="fld_cst_admin_customers">
                                    <option value="viewAll"
                                        <?php if ($db->get_setting('cst_admin_customers') == 'viewAll') echo 'selected'; ?>>
                                        Admin can see all customers
                                    </option>
                                    <option value="own"
                                        <?php if ($db->get_setting('cst_admin_customers') == 'own') echo 'selected'; ?>>
                                        Admin can see only his own customers
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade show" id="pills-insurance" role="tabpanel"
                         aria-labelledby="pills-insurance-tab">
                        <!-- Agent Insurance -->
                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Agent Insurance
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-5">
                                <label for="fld_stk_stock_enable">
                                    Enable Agent Insurance
                                    <input type="checkbox" title="Bring On Startup" value="1"
                                           id="startup_fld_ina_enable_agent_insurance" name="startup_fld_ina_enable_agent_insurance"
                                        <?php if ($db->get_setting('ina_enable_agent_insurance', 'startup') == 1) echo 'checked'; ?>>
                                </label>
                            </div>
                            <div class="col-sm-7">
                                <input type="hidden" name="fld_ina_enable_agent_insurance" id="fld_ina_enable_agent_insurance"
                                       value="<?php echo $db->get_setting('ina_enable_agent_insurance');?>">
                                <input type="checkbox"
                                       onchange="fixCheckbox('ina_enable_agent_insurance','fld_ina_enable_agent_insurance');"
                                       id="ina_enable_agent_insurance"
                                       name="ina_enable_agent_insurance"
                                       class="form-control"
                                       value="1"
                                    <?php if ($db->get_setting('ina_enable_agent_insurance') == 1) echo "checked"; ?>
                                >
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="update">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Update Settings"
                                   class="btn btn-secondary"
                                   onclick="submitForm()">
                        </div>
                    </div>


            </form>
        </div>
    </div>


    <script>
        function submitForm() {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            } else {
                document.getElementById('Submit').disabled = true
            }
        }

        function fixCheckbox(checkField,hiddenField){
            if ($('#' + checkField).prop("checked") == true){
                $('#' + hiddenField).val('1');
            }
            else {
                $('#' + hiddenField).val('0');
            }
        }
    </script>
    <?php
    $db->show_footer();
    ?>
