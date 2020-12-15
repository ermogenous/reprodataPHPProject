<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/11/2020
 * Time: 17:27
 */

include("../../include/main.php");
include("../synthesis_class.php");

$db = new Main();
$db->admin_title = "Synthesis - Update All Web Users";

//get all the companies (Active) and loop in them to get all their webusers
$sql = 'SELECT * FROM sy_companies WHERE syco_status = "Active" ORDER BY syco_company_ID ASC';
$result = $db->query($sql);
while ($company = $db->fetch_assoc($result)){
    $syn = new Synthesis();
    $syn->setUrl($company['syco_database_ip'])
        ->setUsername($company['syco_admin_user_name'])
        ->setPassword($company['syco_admin_password'])
        ->setCompanyID($company['syco_company_ID'])
        ->setCompanyName($company['syco_name']);
    $res = $syn->updateCompanyWebUsers();
    echo $company['syco_name'];
    if ($res){
        echo " Updated Successfully.<br>";
    }
    else {
        echo " Error updating <br>";
    }
}



