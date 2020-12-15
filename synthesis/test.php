<?php
include("../include/main.php");
include("synthesis_class.php");

$db = new Main(1);
$db->admin_title = "Synthesis Inventory List";


$syn = new Synthesis();

if ($syn->error == true) {
    $db->generateAlertError($syn->errorDescription);
}

print_r($db->user_data);

//$db->show_header();



/*


$company = $db->query_fetch('SELECT * FROM sy_companies WHERE syco_company_ID = 1');
$syn->setUrl($company['syco_database_ip'])
    ->setUsername($company['syco_admin_user_name'])
    ->setPassword($company['syco_admin_password'])
    ->setCompanyName($company['syco_name']);

$data = $syn->getWebUser('micacca@gmail.com');
print_r($data);
*/

?>


<?php
//$db->show_footer();
?>
