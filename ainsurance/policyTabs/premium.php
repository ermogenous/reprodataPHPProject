<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 1:13 ΜΜ
 */

include("../../include/main.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Items Premium";

$data = $db->query_fetch("SELECT * FROM ina_policies WHERE inapol_policy_ID = ".$_GET['pid']);


$db->show_empty_header();

echo $db->prepare_text_as_html(print_r($data,true));
?>


<?php
$db->show_empty_footer();
?>