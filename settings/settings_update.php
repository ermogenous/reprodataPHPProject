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


if ($db->user_data["usr_user_rights"] > 0) {

    header("Location: home.php");
    exit();

}

if ($_POST["action"] == "update") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Settings Update';

    //loop into all the fld`s
    foreach ($_POST as $name => $value) {

        if (substr($name, 0, 4) == 'fld_') {

            //check if the settings exists
            $check = $db->query_fetch("SELECT stg_settings_ID FROM settings WHERE stg_section = '" . substr($name, 4) . "'");
            if ($check['stg_settings_ID'] > 0) {
                $db->update_setting(substr($name, 4), $value);
            } else {
                $setData['section'] = substr($name, 4);
                $setData['value'] = $value;
                $db->db_tool_insert_row('settings', $setData, '', 0, 'stg_');
            }


        }

    }


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
                                Stats</label>
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


                    </div>
                    <!-- Addons -->
                    <div class="tab-pane fade show" id="pills-addons" role="tabpanel"
                         aria-labelledby="pills-addons-tab">

                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Stock
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

                        <div class="row alert alert-primary">
                            <div class="col-12">
                                Agreements
                            </div>
                        </div>

                        <?php
                        $numberPrefix = $db->get_setting('agr_agreement_number_prefix');
                        ?>
                        <div class="form-group row">
                            <label for="fld_agr_agreement_number_prefix" class="col-sm-4 col-form-label">Number
                                Prefix</label>
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
