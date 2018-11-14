<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/11/2018
 * Time: 4:19 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Tickets events Modify";

$db->show_empty_header();
?>




<?php
$db->show_empty_footer();
?>