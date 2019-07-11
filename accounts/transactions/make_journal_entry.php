<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/7/2019
 * Time: 4:09 ΜΜ
 */

include("../../include/main.php");
include("../accounts/accounts_class.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts - Make Journal Entry";

$db->show_header();


?>



<?php
$db->show_footer();
?>