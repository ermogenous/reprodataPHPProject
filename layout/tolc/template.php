<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 13/11/2019
 * Time: 11:21 ΠΜ
 */

if (isset($_GET['goAdmin'])) {
    echo "admin";
} else {
    //header("Location:" . $main["site_url"] . "/tolc/content/home.php");
    //exit();
}

function template_header()
{

    global $main, $db;
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $main["conf_title"] . " " . $db->admin_title; ?></title>
        <LINK REL="SHORTCUT ICON" HREF="<?php echo $main["site_url"]; ?>/favicon.png">
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
    <?php
    if ($db->admin_layout_printer != 'yes') {
        ?>

        <?php

    }//end of layout printer

}

function template_footer()
{

    ?>
    <script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/popper.min.js"></script>
    <script src="<?php echo $main["site_url"]; ?>/scripts/bootstrap-4/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}
