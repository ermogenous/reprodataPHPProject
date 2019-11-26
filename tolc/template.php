<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/11/2019
 * Time: 4:40 ΜΜ
 */
//https://www.funzing.com/
function show_tolc_header()
{
    global $db,$main;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Tree of Life Center</title>
    <LINK REL="SHORTCUT ICON" HREF="<?php echo $db->admin_layout_url; ?>images/tree-logo.jpg">
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
        <style>
            .mainTemplateText a:link, a:active, a:visited, a:hover{
                color: #068909;
                text-decoration: none;
            }
        </style>
    </head>
    <body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12"
                 style="background-image: url('<?php echo $db->admin_layout_url; ?>images/top_background.jpg'); height: 100px">
                <div class="row">
                    <div class="col-12" style="height: 10px;"></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table width="100%" class="mainTemplateText">
                            <tr>
                                <td width="50"></td>
                                <td><a href="<?php echo $main["site_url"]; ?>/tolc/home.php">
                                    <img src="<?php echo $db->admin_layout_url; ?>images/tree-logo.jpg" height="85">
                                    </a>
                                </td>
                                <td width="500" align="right">
                                    <a href="#">Hosts</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#">Events</a>


                                </td>
                                <td width="50"></td>
                            </tr>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <?php

}//show_tolc_header

function show_tolc_footer()
{
    global $db,$main;
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" style="background-image: url('<?php echo $db->admin_layout_url; ?>images/bottom_background.jpg'); height: 150px">
                <table width="100%" class="mainTemplateText">
                    <tr>
                        <td width="50"></td>
                        <td width="150"><br>
                            <strong>Company</strong><br>
                            <a href="#">Why be a Host?</a>
                            <br><br>
                        </td>
                        <td><br>
                            <strong>About us</strong><br>
                            <a href="<?php echo $main["site_url"]; ?>/tolc/about_us.php">Who are we?</a><br>
                            <a href="#">Contact us</a><br>
                        </td>
                        <td></td>
                        <td width="50"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}