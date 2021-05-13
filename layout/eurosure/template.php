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
    <title>EUROSURE Intranet</title>
    <LINK REL="SHORTCUT ICON" HREF="<?php echo $db->admin_layout_url; ?>/images/favicon.png">
    <link rel="stylesheet" href="<?php echo $db->admin_layout_url; ?>style.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/css/bootstrap.min.css">

    <!--
        <link rel="stylesheet" href="<?php echo $main["site_url"]; ?>/layout/font-awesome.min.css">
        -->

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
    <script src="<?php echo $db->admin_layout_url; ?>customScript.js"></script>


    <style>

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu > a:after {
            content: "\f0da";
            float: right;
            border: none;
            font-family: 'FontAwesome';
        }

        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: 0px;
            margin-left: 0px;
        }

        .dropdown-toggle::after {
            display: none;
        }

    </style>

    <script>

        $(function () {
            // ------------------------------------------------------- //
            // Multi Level dropdowns
            // ------------------------------------------------------ //
            $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
                event.preventDefault();
                event.stopPropagation();

                $(this).siblings().toggleClass("show");


                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

            });
        });

    </script>


</head>
<body>
<?php if ($db->admin_layout_printer != 'yes') { ?>
    <nav class="navbar navbar-expand-lg navbar-mycustom">
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

                    <!--Reports -->
                    <li class="nav-item dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                           class="nav-link dropdown-toggle">
                            <i class="fas fa-chart-line"></i> <?php echo $db->showLangText('Reports', 'Reports'); ?>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">


                            <!--<li class="dropdown-divider"></li>-->

                            <!-- Level two dropdown Reports->Non Motor-->
                            <li class="dropdown-submenu">
                                <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Production', 'Production'); ?>
                                    &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                                <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">

                                    <?php
                                    if ($db->user_data['usr_user_rights'] <= 3
                                        || $db->user_data['usr_users_groups_ID'] == 6) {
                                        ?>
                                        <li>
                                            <a tabindex="-1"
                                               href="<?php echo $main["site_url"]; ?>/eurosure/reports/production/period_production_new.php"
                                               class="dropdown-item">
                                                <i class="fas fa-file-import"></i> Production
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($db->user_data['usr_user_rights'] <= 3
                                        || $db->user_data['usr_users_groups_ID'] == 6) {
                                        ?>
                                        <li>
                                            <a tabindex="-1"
                                               href="<?php echo $main["site_url"]; ?>/eurosure/reports/production/production_full.php"
                                               class="dropdown-item">
                                                <i class="fas fa-file-import"></i> Production Full
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/production/motor_business_production_bands.php"
                                           class="dropdown-item">
                                            <i class="fas fa-exclamation-triangle"></i> Motor Business Production Bands
                                        </a>
                                    </li>


                                    <li class="dropdown-submenu">
                                        <a id="dropdownMenu3" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true"
                                           aria-expanded="false" class="dropdown-item dropdown-toggle">
                                            <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Quarter Export', 'Quarter Export'); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/reports/production/hsr_export_for_quarter.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-exclamation-triangle"></i> HSR Export for quarter
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/reports/production/export_policies_for_quarter.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-exclamation-triangle"></i> Export Policies for
                                                    Quarter
                                                </a>
                                            </li>
                                            <?php
                                            if ($db->user_data['usr_user_rights'] < 3
                                                || $db->user_data['usr_users_groups_ID'] == 6) {
                                                ?>
                                                <li>
                                                    <a tabindex="-1"
                                                       href="<?php echo $main["site_url"]; ?>/eurosure/reports/actuary/index.php"
                                                       class="dropdown-item">
                                                        <i class="fas fa-exclamation-triangle"></i> Actuary Reports
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                            ?>

                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <!-- End Level two -->


                            <!-- Level two dropdown-->
                            <li class="dropdown-submenu">
                                <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Claims', 'Claims'); ?>
                                    &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                                <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/claims/claims_list_full_details.php"
                                           class="dropdown-item">
                                            <i class="fas fa-file-import"></i> Claims Full List
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_records.php"
                                           class="dropdown-item">
                                            <i class="fas fa-tasks"></i> Validate Records
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/lapse_policies.php"
                                           class="dropdown-item">
                                            <i class="fas fa-plug"></i> Lapse Process
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_lapse.php"
                                           class="dropdown-item">
                                            <i class="fas fa-tasks"></i> Validate Lapsed Policies Process
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/export_file.php"
                                           class="dropdown-item">
                                            <i class="fas fa-file-export"></i> Export File
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_policies.php"
                                           class="dropdown-item">
                                            <i class="fas fa-tasks"></i> Validate Policies
                                        </a>
                                    </li>


                                    <li class="dropdown-submenu">
                                        <a id="dropdownMenu3" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true"
                                           aria-expanded="false" class="dropdown-item dropdown-toggle">
                                            <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Reports', 'Reports'); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/reports/error_report.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-exclamation-triangle"></i> Errors
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </li>
                            <!-- End Level two -->


                            <!-- Level two dropdown Reports->Users -->
                            <li class="dropdown-submenu">
                                <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Users', 'Users'); ?>
                                    &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                                <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                    <?php
                                    if ($db->user_data['usr_user_rights'] < 3
                                        || $db->user_data['usr_users_groups_ID'] == 6) {
                                        ?>
                                        <li>
                                            <a tabindex="-1"
                                               href="<?php echo $main["site_url"]; ?>/eurosure/reports/users/users_permissions_list.php"
                                               class="dropdown-item">
                                                <i class="fas fa-file-import"></i> Users Permission List
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($db->user_data['usr_user_rights'] < 3 || $db->user_data['usr_users_groups_ID'] == 7) {
                                        ?>
                                        <li>
                                            <a tabindex="-1"
                                               href="<?php echo $main["site_url"]; ?>/eurosure/reports/users/user_connections.php"
                                               class="dropdown-item">
                                                <i class="fas fa-file-import"></i> Users Connections
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($db->user_data['usr_user_rights'] < 3 || $db->user_data['usr_users_groups_ID'] == 7) {
                                        ?>
                                        <li>
                                            <a tabindex="-1"
                                               href="<?php echo $main["site_url"]; ?>/eurosure/reports/users/underwriters_insurance_types.php"
                                               class="dropdown-item">
                                                <i class="fas fa-file-import"></i> Underwriters Insurance Types
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>


                                </ul>
                            </li>
                            <!-- End Level two -->

                            <!-- Level two dropdown Reports->Agents -->
                            <li class="dropdown-submenu">
                                <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Agents', 'Αντιπροσωποι'); ?>
                                    &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                                <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                    <?php
                                    if ($db->user_data['usr_user_rights'] < 3 || $db->user_data['usr_users_groups_ID'] == 7) {
                                        ?>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/agents/agents_commissions_list.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Agents Commissions List', 'Agents Commissions List'); ?>
                                        </a>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($db->user_data['usr_user_rights'] < 3 || $db->user_data['usr_users_groups_ID'] == 7) {
                                        ?>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/agents/agent_permission_profile.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Agents Permissions Profile', 'Agents Commissions List'); ?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <!-- End Level two -->


                            <?php
                            if ($db->user_data['usr_user_rights'] == 0) {
                                ?>
                                <!-- Level two dropdown Reports->Agents -->
                                <li class="dropdown-submenu">
                                    <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                       aria-haspopup="true"
                                       aria-expanded="false" class="dropdown-item dropdown-toggle">
                                        <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Insurance Types', 'Insurance Types'); ?>
                                        &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">

                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/system/ins_type_reports.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Insurance Types Info', 'Insurance Types Info'); ?>
                                        </a>

                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                            <!-- End Level two -->

                            <!-- Level two dropdown Reports->Agents -->
                            <li class="dropdown-submenu">
                                <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Other', 'Άλλα'); ?>
                                    &nbsp;&nbsp;<i class="fas fa-chevron-right"></i>
                                </a>
                                <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">

                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/reports/claims/claims_list_full_details.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Claims Full List', 'Claims Full List'); ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/all_docs_to_pdf.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Save all docs to PDF', 'Φύλαξη Αρχείων σε PDF'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/update_access_clients.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Clients List for Access Fire', 'Clients List for Access Fire'); ?>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <!-- End Level two -->
                        </ul>
                    </li>


                    <!-- Functions -->
                    <?php
                    if ($db->user_data['usr_user_rights'] <= 2 || $db->user_data['usr_users_groups_ID'] == 2) {
                        ?>

                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               class="nav-link dropdown-toggle">
                                <i class="fas fa-wrench"></i> <?php echo $db->showLangText('Functions', 'Λειτουργίες'); ?>
                                <i class="fas fa-caret-down"></i>
                            </a>
                            <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
                                <?php
                                if ($db->user_data['usr_user_rights'] <= 2) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/fix_sql.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Fix SQL', 'Fix SQL'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/eurosure/functions/all_docs_to_pdf.php"><i
                                                class="fas fa-eye"></i> <?php echo $db->showLangText('Save all docs to PDF', 'Φύλαξη Αρχείων σε PDF'); ?>
                                    </a>
                                </li>
                                <?php
                                if ($db->user_data['usr_user_rights'] <= 2) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/update_access_clients.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Clients List for Access Fire', 'Clients List for Access Fire'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                if ($db->user_data['usr_user_rights'] <= 2) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/export_sql_delimited.php"><i
                                                    class="fas fa-eye"></i> <?php echo $db->showLangText('Export Sql to Delimited', 'Export Sql to Delimited'); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <li class="dropdown-divider"></li>

                                <?php
                                if ($db->user_data['usr_user_rights'] <= 2) {
                                    ?>
                                    <!-- Level two dropdown-->
                                    <li class="dropdown-submenu">
                                        <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true"
                                           aria-expanded="false" class="dropdown-item dropdown-toggle">
                                            <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Agent SoEasy Import Process', 'Agent SoEasy Import Process'); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/import_file.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-file-import"></i> Import File
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_records.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-tasks"></i> Validate Records
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/lapse_policies.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-plug"></i> Lapse Process
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_lapse.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-tasks"></i> Validate Lapsed Policies Process
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/export_file.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-file-export"></i> Export File
                                                </a>
                                            </li>
                                            <li>
                                                <a tabindex="-1"
                                                   href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/validate_policies.php"
                                                   class="dropdown-item">
                                                    <i class="fas fa-tasks"></i> Validate Policies
                                                </a>
                                            </li>


                                            <li class="dropdown-submenu">
                                                <a id="dropdownMenu3" href="#" role="button" data-toggle="dropdown"
                                                   aria-haspopup="true"
                                                   aria-expanded="false" class="dropdown-item dropdown-toggle">
                                                    <i class="far fa-file-alt"></i> <?php echo $db->showLangText('Reports', 'Reports'); ?>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                                <ul aria-labelledby="dropdownMenu2"
                                                    class="dropdown-menu border-0 shadow">
                                                    <li>
                                                        <a tabindex="-1"
                                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/reports/error_report.php"
                                                           class="dropdown-item">
                                                            <i class="fas fa-exclamation-triangle"></i> Errors
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a tabindex="-1"
                                                           href="<?php echo $main["site_url"]; ?>/eurosure/functions/soeasy_agent/reports/view_policy_data.php"
                                                           class="dropdown-item">
                                                            <i class="fas fa-exclamation-triangle"></i> View Policy Data
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>


                                        </ul>
                                    </li>
                                    <!-- End Level two -->
                                <?php } ?>
                            </ul>
                        </li>

                        <?php
                    }
                    ?>
                    <?php
                    if ($db->user_data['usr_user_rights'] <= 2) {
                        ?>
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               class="nav-link dropdown-toggle">
                                <i class="fas fa-wrench"></i> <?php echo $db->showLangText('Agents', 'Αντιπρόσωποι'); ?>
                                <i class="fas fa-caret-down"></i>
                            </a>
                            <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/eurosure/functions/agents/agents_extra_fields.php"><i
                                                class="fas fa-eye"></i>
                                        <?php echo $db->showLangText('Agents Extra Fields', 'Επιπρόσθετα Πεδία Αντιπροσόπων'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>

                    <!-- USERS -->
                    <?php if ($db->user_data["usr_user_rights"] == 0) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users"></i> <i class="fas fa-caret-down"></i>
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

                    <?php
                    if ($db->user_data["usr_user_rights"] == 0 && $db->dbSettings['ina_enable_agent_insurance']['value'] == 1) {
                        ?>
                        <!-- Settings -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i> <i class="fas fa-caret-down"></i>
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

                                <a class="dropdown-item"
                                   href="<?php echo $main["site_url"]; ?>/test/akd/show_file.php">
                                    <i class="fas fa-cloud-upload-alt"></i> Insurance/Accounts Import</a>

                                <?php if ($db->user_data['usr_users_ID'] == 1) { ?>
                                    <a class="dropdown-item"
                                       href="<?php echo $main["site_url"]; ?>/vitamins/vitamins.php">
                                        <i class="fas fa-exclamation-triangle"></i> Vitamins</a>
                                <?php } ?>
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
            <img src="<?php echo $db->admin_layout_url; ?>/images/eurosure_logo.png" height="50">
        </div>
    </nav>

    <br>
    <?php

}//printer layout

$alertsLeftSpace = 1;
$alertCenterSpace = 10;
$alertsRightSpace = 1;
if ($_GET['alert-success'] != '') {
    ?>

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="alert alert-success alert-dismissible fade show col-<?php echo $alertCenterSpace; ?>"
                 role="alert">
                <?php echo $_GET["alert-success"]; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
    <?php
}

if ($db->dismissWarning != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning! </strong> <?php echo $db->dismissWarning; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->dismissError != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong> <?php echo $db->dismissError; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->dismissSuccess != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> <?php echo $db->dismissSuccess; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->dismissInfo != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Info! </strong> <?php echo $db->dismissInfo; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->alertWarning != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-warning" role="alert">
                    <strong>Warning! </strong> <?php echo $db->alertWarning; ?>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->alertError != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-danger" role="alert">
                    <strong>Error!!! </strong> <?php echo $db->alertError; ?>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->alertSuccess != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-success" role="alert">
                    <strong>Success! </strong> <?php echo $db->alertSuccess; ?>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }
if ($db->alertInfo != '') { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-<?php echo $alertsLeftSpace; ?>"></div>
            <div class="col-<?php echo $alertCenterSpace; ?>">
                <div class="alert alert-info" role="alert">
                    <strong>Info! </strong> <?php echo $db->alertInfo; ?>
                </div>
            </div>
            <div class="col-<?php echo $alertsRightSpace; ?>"></div>
        </div>
    </div>
<?php }


}//template_header
function template_footer()
{
global $db, $main, $sybase;

if ($db->admin_layout_printer != 'yes') {

    ?>

    <br>
    <?php
    if (!empty($sybase)) {
        $sybaseConnection = $sybase->getDatabaseName();
    } else {
        $sybaseConnection = '';
    }
    if ($sybaseConnection != '') {
        if ($sybaseConnection == 'EUROTEST') {
            $sybaseClass = 'alert-danger';
        } else {
            $sybaseClass = 'alert-success';
        }
        ?>
        <div class="row ">
            <div class="col-12 alert <?php echo $sybaseClass; ?> text-center">
                <b>Connected to
                    <?php
                    echo $sybaseConnection;
                    ?></b>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="container-fluid">
        <div class="row">&nbsp</div>
        <div class="row glyphicon-copyright-mark footer-bar <?php if ($db->imitationMode === true) echo 'alert alert-danger'; ?>">
            <div class="col-1"></div>
            <div class="col-11">

                <div class="container-fluid">
                    <div class="row" style="height: 5px;"></div>
                    <div class="row">
                        <div class="col-12">
                            Welcome:
                            <?php if ($db->imitationMode === true) echo '<b> &nbsp;Imitating &nbsp;</b>'; ?>
                            <?php echo $db->user_data['usr_name']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="?switchLang=<?php if ($db->user_data['usr_default_lang'] == 'eng') echo 'gre'; else echo 'eng'; ?>">
                                <?php if ($db->user_data['usr_default_lang'] == 'eng') { ?> Αλλαγή Γλώσσας σε Ελληνικά<?php } ?>
                                <?php if ($db->user_data['usr_default_lang'] == 'gre') { ?> Switch Language to English<?php } ?>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            Copyright Eurosure 2020. All rights reserved. Developed by Ermogenous.M
                        </div>
                    </div>
                    <div class="row" style="height: 5px;"></div>
                </div>

            </div>
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
