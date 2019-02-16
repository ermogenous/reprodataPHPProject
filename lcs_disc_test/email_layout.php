<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 8:35 ΜΜ
 */

function getEmailLayoutFillTest($data){
    global $db,$main;

    $id = $db->encrypt($data['ietst_intro_extro_test_ID']);

    $html = '
Please fill the form in the below link.<br>
<a href="'.$main["site_url"].'/lcs_disc_test/disc_modify.php?lid='.$id.'">Click Here</a><br>
If the link does not work then copy paste the below link in to your browser<br>
'.$main["site_url"].'/lcs_disc_test/disc_modify.php?lid='.$id.'
    ';


    return $html;
}

function getEmailLayoutResult($data, $testResults){


$html = '
Thank you for using our system<br>
Read below your results<br>
High Dominance: '.$testResults['HighDominance'].' ['.$testResults['HighDominance-per'].']<br>
Low Dominance:'.$testResults['LowDominance'].' ['.$testResults['LowDominance-per'].']<br>
High Social: '.$testResults['HighSocial'].' ['.$testResults['HighSocial-per'].']<br>
Low Social: '.$testResults['LowSocial'].' ['.$testResults['LowSocial-per'].']<br>';



return $html;
}

?>