<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/7/2019
 * Time: 2:12 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Backup DB";

$db->show_header();


echo $db->backup_tables($main['db_host'], $main['db_username'], $main['db_password'], $main['db_database']);

?>




<?php
$db->show_footer();
?>