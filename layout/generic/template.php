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
        <title><?php echo $main["conf_title"] . " " . $db->admin_title; ?></title>
        <LINK REL="SHORTCUT ICON" HREF="<?php echo $main["site_url"]; ?>/favicon.png">
        <link rel="stylesheet" href="<?php echo $db->admin_layout_url; ?>style.css" rel="stylesheet">

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
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" style="background-color: #e0a800">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
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
                    <!-- CUSTOMERS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Customers
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/customers/customers.php"><i
                                        class="fas fa-eye"></i> View Customers</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/customers/customers_modify.php"><i
                                        class="fas fa-plus-circle"></i> New Customer</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/customers/customer_groups.php"><i
                                        class="fas fa-eye"></i> View Customer Groups</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/customers/customer_groups_modify.php"><i
                                        class="fas fa-plus-circle"></i> New Customer Group</a>
                        </div>
                    </li>

                    <!-- AGREEMENTS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-handshake"></i> Agreements
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/agreements/agreements.php"><i
                                        class="fas fa-eye"></i> View Agreements</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/agreements/agreements_modify.php"><i
                                        class="fas fa-plus-circle"></i> New Agreement</a>
                        </div>
                    </li>

                    <!-- PRODUCTS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Products
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/products/products.php"><i
                                        class="fas fa-eye"></i> View Products</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/products/products_modify.php"><i
                                        class="fas fa-plus-circle"></i> New Product</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/manufacturers/manufacturers.php"><i
                                        class="fas fa-eye"></i> View Manufacturers</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/manufacturers/manufacturers_modify.php"><i
                                        class="fas fa-plus-circle"></i> New Manufacturer</a>
                        </div>
                    </li>
                    <!-- STOCK -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i> Stock
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/stock/stock_transactions_list.php"><i
                                        class="fas fa-eye"></i> View Stock Transactions</a>
                        </div>
                    </li>

                    <!-- Tickets -->
                    <?php
                    //get number of tickets not assigned
                    $notAssignedTicketsNum = $db->query_fetch("SELECT COUNT(*) as clo_total FROM tickets WHERE tck_status = 'Open' AND tck_assigned_user_ID = '-1'");
                    $notAssignedTicketsNum = $notAssignedTicketsNum['clo_total'];
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tags"></i> Tickets
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/tickets/tickets.php">
                                <i class="fas fa-eye"></i> View Tickets</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/tickets/ticket_modify.php">
                                <i class="fas fa-plus-circle"></i> Insert New Ticket</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/tickets/ticket_assignments.php">
                                <i class="fas fa-map-marked-alt"></i> Ticket Placements
                                <span class="badge badge-light"><?php echo $notAssignedTicketsNum;?></span>
                            </a>
                        </div>
                    </li>

                    <!-- Schedules -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i> Schedules
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/schedules/my_schedule_day.php">
                                <i class="far fa-calendar-alt"></i> My Day</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/schedules/my_schedule_diary.php">
                                <i class="far fa-calendar-alt"></i> My Calendar</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/schedules/schedules.php">
                                <i class="fas fa-eye"></i> View Schedules</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/schedules/schedule_modify.php">
                                <i class="fas fa-plus-circle"></i> Insert New Schedule</a>
                        </div>
                    </li>

                    <?php if ($db->dbSettings['ina_enable_agent_insurance']['value'] == 1) { ?>
                        <!-- Agent Insurance -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-clipboard-list"></i> Agent Insurance
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/ainsurance/policies.php">
                                    <i class="far fa-calendar-alt"></i> View Policies</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/ainsurance/policy_modify.php">
                                    <i class="far fa-calendar-alt"></i> New Policy</a>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if ($db->dbSettings['ina_enable_agent_insurance']['value'] == 1) { ?>
                        <!-- Accounts -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-clipboard-list"></i> Accounts
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/accounts/accounts/accounts.php">
                                    <i class="far fa-calendar-alt"></i> View Accounts</a>
                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/accounts/transactions/transactions.php">
                                    <i class="far fa-calendar-alt"></i> View Transactions</a>
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
                    <!-- Insurance Agents Settings -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            IA<i class="fas fa-cogs"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/ainsurance/codes/insurance_companies.php">
                                <i class="fab fa-linode"></i> Insurance Companies</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/send_auto_emails/send_auto_emails.php">
                                <i class="fas fa-envelope"></i> Auto Emails</a>
                            <a class="dropdown-item"
                               href="<?php echo $main["site_url"]; ?>/settings/settings_update.php">
                                <i class="fas fa-screwdriver"></i> System Settings</a>
                        </div>

                    </li>
                    <!-- Settings -->
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

                <!--
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">Disabled</a>
                            </li>
                 -->
            </ul>
            <img src="<?php echo $main["site_url"]; ?>/images/logo_transparent.gif" height="40">
        </div>
    </nav>

    <br>
    <?php
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


}//printer layout
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
        <div class="row glyphicon-copyright-mark navbar-custom <?php if ($db->imitationMode === true) echo 'alert alert-danger'; ?>">
            Welcome:
            <?php if ($db->imitationMode === true) echo '<b> &nbsp;Imitating &nbsp;</b>'; ?>
            <?php echo $db->user_data['usr_name']; ?>
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