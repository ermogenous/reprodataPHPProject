<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 3:32 ΜΜ
 */

include("../include/main.php");

$db = new Main();
$db->admin_title = "Tickets events Modify";


$db->show_empty_header();
?>



<?php
$db->show_empty_footer();
?>
