<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/10/2019
 * Time: 4:48 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
include("reports_menu.php");
$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Settings";

$db->show_header();
?>


<?php
$db->show_footer();
?>