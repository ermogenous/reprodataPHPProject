<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:19 ΜΜ
 */

//header("Location:synthesis/accounts/accounts.php");
//exit();

include_once("include/main.php");
include_once("../../synthesis/synthesis_class.php");
$db = new Main(0);

$syn = new Synthesis();

$db->show_header();
?>
Synthesis Home
<?php
$db->show_footer();
