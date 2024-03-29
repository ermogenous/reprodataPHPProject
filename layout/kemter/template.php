<?php
function template_header()
{
//template used
//https://blackrockdigital.github.io/startbootstrap-sb-admin-2/pages/index.html
global $main, $db;
if ($db->user_data['usr_users_ID'] > 0) {
    $underwriter = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = ' . $db->user_data['usr_users_ID']);
}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kemter Insurance Agencies Sub-Agencies &amp; Consultants, Limassol -
        Cyprus <?php if ($main["conf_title"] == 'KemterTest') echo "TEST"; ?></title>
    <LINK REL="SHORTCUT ICON" HREF="<?php echo $main["site_url"]; ?>/favicon-kemter.png">
    <link rel="stylesheet" href="<?php echo $db->admin_layout_url; ?>style.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
          crossorigin="anonymous">

    <script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/jquery-3.3.1.min.js"></script>
    <!--Fall back to a local copy of jQuery if the CDN fails-->
    <script>
        window.jQuery || document.write('<script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/jquery-3.3.1.min.js"><\/script>');
    </script>
    <!-- More Head -->
    <?php echo $db->admin_more_head; ?>

</head>
<body onload="<?php echo $db->admin_on_load; ?>">
<?php if ($db->admin_layout_printer != 'yes') { ?>
    <nav class="navbar navbar-expand-lg navbar-mycustom">
        &nbsp;&nbsp;&nbsp;
        <img src="<?php echo $db->admin_layout_url; ?>images/Kemter-Icon.png" height="40">
        &nbsp;&nbsp;&nbsp;
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $main["site_url"]; ?>/home.php"><i class="fas fa-home"></i>
                        <span class="sr-only">(current)</span></a>
                </li>
                <?php
                if ($_SESSION[$main["environment"] . "_admin_username"] == "") {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <?php
                }
                if ($_SESSION[$main["environment"] . "_admin_username"] != "") {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main["site_url"]; ?>/login.php?action=logout"><i
                                    class="fas fa-sign-out-alt"></i> </a>
                    </li>

                    <!-- Quotations -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i> Quotations
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations.php">
                                <i class="far fa-eye"></i> View Quotations</a>
                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#1-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=1">
                                    <i class="fas fa-briefcase-medical"></i> New Medical For Foreigners</a>
                            <?php } ?>
                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#2-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=2">
                                    <i class="fas fa-truck-moving"></i> New Marine Cargo</a>
                            <?php } ?>

                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#3-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=3">
                                    <i class="fas fa-plane-departure"></i> New Travel</a>
                            <?php } ?>

                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#4-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=4">
                                    <i class="fas fa-home"></i> New HouseHold</a>
                            <?php } ?>

                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#5-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=5">
                                    <i class="fas fa-truck-moving"></i> New CMR</a>
                            <?php } ?>

                            <?php
                            if (strpos($underwriter['oqun_allow_quotations'], '#6-1#') !== false) {
                                ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations_modify.php?quotation_type=6">
                                    <i class="fas fa-bolt"></i> New Foreigners P.A.</a>
                            <?php } ?>

                            <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/approvals.php">
                                    <i class="far fa-thumbs-up"></i> Approvals</a>
                            <?php } ?>

                            <?php if ($db->user_data["usr_user_rights"] == 0) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations/index.php">
                                    <i class="fas fa-cogs"></i> Administration</a>
                            <?php } ?>

                            <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/quotations/underwriters.php">
                                    <i class="fas fa-cogs"></i> Underwriters</a>
                            <?php } ?>

                            <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/send_auto_emails/send_auto_emails.php">
                                    <i class="fas fa-envelope"></i> AutoEmails</a>
                            <?php } ?>

                            <?php if ($db->user_data["usr_user_rights"] <= 2 || $db->user_data['usr_users_groups_ID'] == 2) { ?>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/dynamic_quotations/mc_marine_cargo/bordereaux.php">
                                    <i class="fas fa-signal"></i> Bordereaux</a>
                            <?php } ?>

                        </div>
                    </li>

                    <?php
                    if ($db->user_data['usr_users_groups_ID'] == 2
                        || $db->user_data['usr_user_rights'] == 0
                        || $db->imitationMode === true) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $main["site_url"]; ?>/settings/imitate_user.php"><i
                                        class="fas fa-user-secret"></i> </a>
                        </li>
                        <?php
                    }
                    ?>


                    <!-- MY USERS -->
                    <?php if ($db->user_data["usr_user_rights"] <= 2 || $db->user_data['usr_users_groups_ID'] == 2) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-friends"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo $main["site_url"]; ?>/my_users/users.php"><i
                                            class="fas fa-eye"></i> View Users</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/my_users/user_modify.php"><i
                                            class="fas fa-plus-circle"></i> New User</a>
                            </div>
                        </li>
                    <?php } ?>

                    <!-- USERS -->
                    <?php if ($db->user_data["usr_user_rights"] == 0) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo $main["site_url"]; ?>/users/users.php"><i
                                            class="fas fa-eye"></i> View Users</a>
                                <a class="dropdown-item" href="<?php echo $main["site_url"]; ?>/users/users_modify.php"><i
                                            class="fas fa-plus-circle"></i> New User</a>
                                <?php if ($db->user_data["usr_user_rights"] == 0) { ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $main["site_url"]; ?>/users/groups.php"><i
                                                class="fas fa-eye"></i> View Groups</a>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/users/groups_modify.php"><i
                                                class="fas fa-plus-circle"></i> New Group</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/users/permissions.php"><i
                                                class="fas fa-eye"></i> View Permissions</a>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/users/permissions_modify.php"><i
                                                class="fas fa-plus-circle"></i> New Permission</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $main["site_url"]; ?>/users/codes.php"><i
                                                class="fas fa-eye"></i> View Codes</a>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/users/codes_modify.php"><i
                                                class="fas fa-plus-circle"></i> New Code</a>
                                <?php } ?>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if ($db->user_data["usr_user_rights"] <= 2) { ?>
                        <!-- Advanced Users Settings -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/codes/codesVessels.php">
                                    <i class="fab fa-linode"></i> Codes - Ocean Vessels</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/codes/codesOccupations.php">
                                    <i class="fab fa-linode"></i> Codes - Occupations</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/send_auto_emails/send_auto_emails.php">
                                    <i class="fas fa-envelope"></i> Auto Emails</a>
                            </div>

                        </li>
                    <?php } ?>

                    <?php if ($db->user_data["usr_user_rights"] == 0) { ?>
                        <!-- Administrator Settings -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/codes/codes.php">
                                    <i class="fab fa-linode"></i> Codes</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/send_auto_emails/send_auto_emails.php">
                                    <i class="fas fa-envelope"></i> Auto Emails</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/settings/settings_update.php">
                                    <i class="fas fa-screwdriver"></i> System Settings</a>

                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/tools/backup_db.php">
                                    <i class="fas fa-database"></i> Backup DB</a>

                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/tools/log_file_view.php">
                                    <i class="fas fa-exclamation-triangle"></i> View Log File</a>
                            </div>

                        </li>
                    <?php } ?>
                <?php } ?>

                <!--
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">Disabled</a>
                            </li>
                 -->

            </ul>
            <span class="nav-item d-none d-lg-block d-md-block d-sm-block d-xl-block">
                <img src="<?php echo $db->admin_layout_url; ?>images/LLOYDS-Logo.png"
                     height="35">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
        </div>
    </nav>
    <?php
    if ($db->imitationMode === true) {
        ?>
        <div class="row">
            <div class="col alert alert-danger text-center font-weight-bold">
                User: <u><?php echo $db->originalUserData['usr_name']; ?></u>
                Imitating: <u><?php echo $db->user_data['usr_name']; ?></u>
                <a href="<?php echo $main['site_url']; ?>/settings/imitate_user.php">Disable</a>
            </div>
        </div>
    <?php } ?>

    <?php if ($main["db_database"] == 'kemter_extranet_test') { ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center alert alert-danger">
                    <b>TEST DATABASE</b>
                </div>
            </div>
        </div>
    <?php } ?>

    <br>
    <?php

}//printer layout

if ($_GET['alert-success'] != '') {
    ?>

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="alert alert-success alert-dismissible fade show col-6" role="alert">
                <?php echo $_GET["alert-success"]; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <?php
}

if ($db->dismissWarning != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning! </strong> <?php echo $db->dismissWarning; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->dismissError != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong> <?php echo $db->dismissError; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->dismissSuccess != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> <?php echo $db->dismissSuccess; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->dismissInfo != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Info! </strong> <?php echo $db->dismissInfo; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->alertWarning != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-warning" role="alert">
                    <strong>Warning! </strong> <?php echo $db->alertWarning; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->alertError != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-danger" role="alert">
                    <strong>Error! </strong> <?php echo $db->alertError; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->alertSuccess != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-success" role="alert">
                    <strong>Success! </strong> <?php echo $db->alertSuccess; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }
if ($db->alertInfo != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-info" role="alert">
                    <strong>Info! </strong> <?php echo $db->alertInfo; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
<?php }


}//template_header
function template_footer()
{
global $db, $main;

if ($db->admin_layout_printer != 'yes') {

    ?>

    <br>

    <div id="footer-extra-space"></div>
    <footer class="footer">
        <div class="container-fluid grey_text" style="background-color: #191A1B;">
            <div class="row">
                <div class="d-xl-block d-lg-block d-none col-1"></div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-12 <?php if ($db->imitationMode === true) echo 'alert alert-danger'; ?>">
                            Welcome:
                            <?php if ($db->imitationMode === true)
                                echo '<b> &nbsp;Imitating </b>&nbsp;'; ?>
                            <?php echo $db->user_data['usr_name']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <a href="<?php echo $main['site_url']; ?>/dynamic_quotations/quotations.php">Cover Notes</a>
                            <br>
                            <a href="<?php echo $main['site_url']; ?>/login.php?action=logout">Logout</a>
                        </div>
                        <div class="col-6 text-center">
                            <img src="<?php echo $db->admin_layout_url; ?>/images/Kemter-Logo-WhiteBG-300x60.png"
                                 height="35">
                            &nbsp;&nbsp;&nbsp;
                            <img src="<?php echo $db->admin_layout_url; ?>/images/LLOYDS-Logo-Dark.png" height="35">
                        </div>
                        <div class="col-3">

                        </div>
                    </div>
                    <div class="row" style="height: 10px;"></div>
                    <div class="row">
                        <div class="col-12 text-center">
                            © Copyright Kemter Insurance Agencies Sub-Agencies and Consultants Ltd 2019. All rights
                            reserved. Developed by Ermogenous.M
                        </div>
                    </div>
                    <div class="row" style="height: 10px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <?php
                            $showStatsFooter = $db->get_setting('layout_show_footer_stats');
                            if ($showStatsFooter == 'Yes' || $showStatsFooter == 'AdminYes') {
                                ?>
                                Time Spend: <?php echo $db->get_script_time(); ?> Seconds. &nbsp;&nbsp;&nbsp;
                                Memory Used: <?php echo memory_get_usage(); ?> Bytes. &nbsp;&nbsp;
                                Memory Peak: <?php echo memory_get_peak_usage(); ?> Bytes.
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="d-xl-block d-lg-block d-none col-1"></div>
            </div>
        </div>
    </footer>

    <script>
        //if the page height is long then the footer sits on top of other elements.
        //this opens a div on top of the footer that fixes the problem.
        //also fires on window resize
        function fix_footer() {
            //console.log('Doc: ' + $(document).height() + ' Win: ' + window.innerHeight);
            if ($(document).height() >= window.innerHeight) {
                $('#footer-extra-space').height(100);
            }
        }

        $(window).resize(function () {
            fix_footer();
        });
        fix_footer();
    </script>

    <?php
}//printer layout
?>

<script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/popper.min.js"></script>
<script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/bootstrap.min.js"></script>

</body>
</html>
<?php
}//template_footer
?>
