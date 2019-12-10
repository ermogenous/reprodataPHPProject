<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/12/2019
 * Time: 12:37 μ.μ.
 */

include("../../include/main.php");
include('../policy_class.php');
require_once '../../vendor/autoload.php';

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Policy Document View File";

if ($_GET['pid'] == '') {
    //no file is defined for certificate
    $db->generateSessionAlertError('Policy not defined');
    header("Location: ../../home.php");
    exit();
}
$policy = new Policy($_GET['pid']);
if ($_GET['type'] != 'certificate' && $_GET['type'] != 'schedule') {
    //no file is defined for certificate
    $db->generateSessionAlertError('Document Type is not defined');
    header("Location: documents.php?pid=" . $_GET['pid']);
    exit();
}
if ($_GET['action'] != 'viewHTML' && $_GET['action'] != 'viewPDF') {
    //no file is defined for certificate
    $db->generateSessionAlertError('Document action is not defined');
    header("Location: documents.php?pid=" . $_GET['pid']);
    exit();
}
if ($policy->policyData['inapol_issue_ID'] == 0 || $policy->policyData['inapol_issue_ID'] == '') {
    //no issue is connected to this policy
    $db->generateSessionAlertError('This policy is not connected to issue policy.');
    header("Location: documents.php?pid=" . $_GET['pid']);
    exit();
}
//check if files exists
if ($_GET['type'] == 'certificate'){
    if ($policy->policyData['inaiss_certificate_issue_file'] == ''){
        $db->generateSessionAlertError('Certificate file is not defined for '.$policy->policyData['inaiss_name']);
        header("Location: documents.php?pid=" . $_GET['pid']);
        exit();
    }
    else {
        $certificateFile = $main['local_url']."/ainsurance/documents/".$policy->policyData['inaiss_certificate_issue_file'];
        if (file_exists($certificateFile)){
            include($certificateFile);
            if (!function_exists('ainsuranceCertificate')){
                $db->generateSessionAlertError('Certificate function does not exists for '.$policy->policyData['inaiss_name']);
                header("Location: documents.php?pid=" . $_GET['pid']);
                exit();
            }
        }
        else {
            $db->generateSessionAlertError('Certificate file does not exists for '.$policy->policyData['inaiss_name']);
            header("Location: documents.php?pid=" . $_GET['pid']);
            exit();
        }
    }
}

if ($_GET['type'] == 'schedule'){
    if ($policy->policyData['inaiss_schedule_issue_file'] == ''){
        $db->generateSessionAlertError('Schedule file is not defined for '.$policy->policyData['inaiss_name']);
        header("Location: documents.php?pid=" . $_GET['pid']);
        exit();
    }
    else {
        $scheduleFile = $main['local_url']."/ainsurance/documents/".$policy->policyData['inaiss_schedule_issue_file'];
        if (file_exists($scheduleFile)){
            include($scheduleFile);
            if (!function_exists('ainsuranceSchedule')){
                $db->generateSessionAlertError('Schedule function does not exists for '.$policy->policyData['inaiss_name']);
                header("Location: documents.php?pid=" . $_GET['pid']);
                exit();
            }
        }
        else {
            $db->generateSessionAlertError('Schedule file does not exists for '.$policy->policyData['inaiss_name']);
            header("Location: documents.php?pid=" . $_GET['pid']);
            exit();
        }
    }
}



if ($_GET['type'] == 'certificate') {

    if ($_GET['action'] == 'viewHTML') {
        $db->show_empty_header();
        echo ainsuranceCertificate($policy);
        $db->show_empty_footer();
    }
    if ($_GET['action'] == 'viewPDF') {
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'dejavusans'
        ]);
        $mpdf->WriteHTML(ainsuranceCertificate($policy));
        $mpdf->Output();
    }

} else if ($_GET['type'] == 'schedule') {

    if ($_GET['action'] == 'viewHTML') {

    }
    if ($_GET['action'] == 'viewPDF') {

    }

}



