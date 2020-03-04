<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 4/3/2020
 * Time: 12:02 μ.μ.
 */
?>

APPROVALS HOW IT WORKS
Make the below function in the functions file
function customCheckForApproval($data)
{
global $db;
$result['error'] = true;
$result['errorDescription'] = 'All CMR needs approval';
return $result;
}