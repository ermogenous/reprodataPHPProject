<?php
function template_header()
{
    //template used
    //https://blackrockdigital.github.io/startbootstrap-sb-admin-2/pages/index.html
    global $main, $db;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>LCS Approach Extranet</title>
        <LINK REL="SHORTCUT ICON" HREF="<?php echo $main["site_url"]; ?>/favicon.png">
        <link rel="stylesheet" href="<?php echo $db->admin_layout_url; ?>style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $db->admin_layout_url; ?>main.css" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/css/bootstrap.min.css"
              rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
              crossorigin="anonymous">

        <script language="JavaScript" type="text/javascript"
                src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/jquery-3.3.1.min.js"></script>
        <!-- More Head -->
        <?php echo $db->admin_more_head; ?>

    </head>
    <body>
    <?php if ($db->admin_layout_printer != 'yes') { ?>

    <nav class="navbar navbar-expand-lg navbar-light ">

        <a class="navbar-brand" href="#"><img src="<?php echo $db->admin_layout_url; ?>images/lcs_logo.png" height="84"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

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
                    <!-- DiSC -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i> DiSC
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/lcs_disc_test/disc_list.php">
                                <i class="far fa-calendar-alt"></i> View DiSC Tests</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/lcs_disc_test/disc_modify.php">
                                <i class="far fa-calendar-alt"></i> New DiSC Test</a>
                        </div>
                    </li>

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

                    <!-- Settings -->
                    <?php if ($db->user_data['usr_user_rights'] == 0) {;?>
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
                            </div>

                        </li>
                    <?php } ?>

                <?php } ?>
            </ul>
        </div>
    </nav>

    <br>
    <?php

}//printer layout

    if ($_GET['alert-success'] != '') {
        ?>

        <br>
        <div class="container">
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
    <?php }
    if ($db->dismissError != '') { ?>
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
    <?php }
    if ($db->dismissSuccess != '') { ?>
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
    <?php }
    if ($db->dismissInfo != '') { ?>
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
    <?php }
    if ($db->alertWarning != '') { ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-warning" role="alert">
                    <strong>Warning! </strong> <?php echo $db->alertWarning; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    <?php }
    if ($db->alertError != '') { ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-danger" role="alert">
                    <strong>Error! </strong> <?php echo $db->alertError; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    <?php }
    if ($db->alertSuccess != '') { ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-success" role="alert">
                    <strong>Success! </strong> <?php echo $db->alertSuccess; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    <?php }
    if ($db->alertInfo != '') { ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="alert alert-info" role="alert">
                    <strong>Info! </strong> <?php echo $db->alertInfo; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    <?php }


}//template_header
function template_footer()
{
    global $db, $main;

if ($db->admin_layout_printer != 'yes')
{

    ?>

<br>
    <div class="container-fluid">
        <div class="row">&nbsp</div>
        <div class="row glyphicon-copyright-mark bg-light <?php if ($db->imitationMode === true) echo 'alert alert-danger'; ?>" >
            <?php if ($db->user_data['user_rights'] != '') { ?>
                Welcome:
                <?php if ($db->imitationMode === true) echo '<b> &nbsp;Imitating &nbsp;</b>'; ?>
                <?php echo $db->user_data['usr_name'];
            }
            ?>
        </div>
    </div>
    <?php
    $showStatsFooter = $db->get_setting('layout_show_footer_stats');
if ($showStatsFooter == 'Yes') {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                Time Spend: <?php echo $db->get_script_time(); ?> Seconds. &nbsp;&nbsp;&nbsp;
                Memory Used: <?php echo memory_get_usage(); ?> Bytes. &nbsp;&nbsp;
                Memory Peak: <?php echo memory_get_peak_usage(); ?> Bytes.
            </div>
        </div>
    </div>
<?php
}
}//printer layout
?>

    <script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/popper.min.js"></script>
    <script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}//template_footer
?>