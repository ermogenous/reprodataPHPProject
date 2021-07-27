<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 4:52 μ.μ.
 */

/*
 * SITS ON INTRANET
 * checks the extranet if there is any new incidents in the table es_odyky_incidents
 * creates a folder for the incident and downloads all the image files
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1800);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure check extranet to get the latests odyky incidents';
$db->update_log_file('Get latest odyky incidents',0,
    'Eurosure check extranet to get the latests odyky incidents'
    ,'Eurosure check extranet to get the latests odyky incidents');
$log = 'Starting Intranet Get latest odyky incidents'.PHP_EOL;

//connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= PHP_EOL.'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('import Odyky api',0,$log,'');
    exit();
}
else {
    $log .= PHP_EOL.'Connected to extranet ok.';
}

//now find on extranet any new incidents
if ($_GET['by_incident'] > 0){
    $sql = 'SELECT * FROM es_odyky_incidents 
            WHERE esoin_incident_id = '.$_GET['by_incident'];
}
else {
    $sql = 'SELECT * FROM es_odyky_incidents 
            WHERE esoin_processed = 0
            AND esoin_call_type IN ("Accident","Accident care from Phone")
            ORDER BY esoin_incident_id ASC ';
}

$result = $extranet->query($sql);
$lastID = 0;
$incidentData = '';
$log .= PHP_EOL.'FOUND '.mysqli_num_rows($result)." Incidents:";
while ($row = $result->fetch_assoc()){

    $lastID = $row['esoin_incident_id'];
    //connect to odyky api to get the information and files for this incident
    $log .= PHP_EOL.'Checking documents for Incident ID:'.$row['esoin_odyky_incident_id']." REG:".$incidentData->Incident->InsurancePolicy->vehicle_registration;
    echo "<hr>Downloading for Incident ID:".$row['esoin_odyky_incident_id']." REG:".$incidentData->Incident->InsurancePolicy->vehicle_registration."<hr>";
    $totalDocuments = getOdykyFiles($row['esoin_odyky_incident_id']);
    $log .= PHP_EOL.'Found '.$totalDocuments;
    if ($totalDocuments > 0) {
        $log .= ' Proceed to download the files. REG:'.$incidentData->Incident->InsurancePolicy->vehicle_registration;
        //update extranet that this record has been processed - and odyky considers this incident as completed
        if ($row['esoin_odyky_status'] == 1) {
            $sql = 'UPDATE es_odyky_incidents 
            SET esoin_processed = 1
            ,esoin_vehicle_registration = "' . $incidentData->Incident->InsurancePolicy->vehicle_registration . '"
            ,esoin_last_update_date_time = "' . date("Y-m-d G:i:s") . '"
            ,esoin_odyky_status = 1
            WHERE esoin_incident_id = ' . $row['esoin_incident_id'];
            $log .= ' Update extranet incidents as completed';
        }
        else {
            $log .= ' Found documents but odyky status is not completed';
        }
    }
    else {
        $log .= ' No Records skip and check again later';
    }

    $extranet->query($sql);

}
$db->update_log_file_custom($log,'import Odyky api Result');
$time_elapsed_secs = microtime(true) - $startTime;
echo "<br>Total Seconds:".$time_elapsed_secs;

function getOdykyFiles($odykyID){
    global $main,$incidentData,$log;

    //retrieve the incidents data
    $ch = curl_init();
    // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
    // in most cases, you should set it to true
    $url = 'https://portal.odyky.com/webservices/eurosure/search_by_id.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz&incident='.$odykyID;
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $incidentData = json_decode(curl_exec($ch));
    curl_close($ch);
    //return '';
    //print_r($incidentData);exit();

    //retrieve the list of documents
    $ch = curl_init();
    // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
    // in most cases, you should set it to true
    $url = 'https://portal.odyky.com/webservices/eurosure/search_documents_by_id.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz&incident='.$odykyID;
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($result);
    //echo $obj->access_token;
    $totalFilesFound = 0;
    foreach ($obj as $document){
        $totalFilesFound++;
        $fileUrl = $document->Documents->document_link."/".$document->Documents->document_file_name;
        $getDocumentUrl = 'https://portal.odyky.com/webservices/eurosure/get_document.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz';
        $getDocumentUrl .= '&incident_id='.$odykyID.'&doc_id='.$document->Documents->document_id;
        //print_r($document);
        echo "Retrieving Document: ".$document->Documents->document_id." For Incident ID:".$odykyID;
        echo "<br>";
        echo "GetDocumentURL Api: ".$getDocumentUrl;
        echo "<br>";
        echo "Downloading file:";

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $getDocumentUrl);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $documentData = curl_exec($curlSession);
        curl_close($curlSession);

        echo "Checking/Creating Folder: ";
        //check for the folder on the server first
        if (makeCheckFolderOnServer($odykyID,$incidentData)){
            echo " Success.";
            //save the file
            echo " Make File: ";
            if (makeFileOnServer($document->Documents->document_file_name
                ,$documentData
                ,$odykyID,$incidentData,$document)){
                echo "Success";
            }
            else {
                echo "Failed creating the file. Maybe the file is open by someone. Leave the incident uncompleted to try again later.";
                echo "<hr>";
                //better to return 0 so it will try again later
                return 0;
            }
        }
        else {
            echo "[ERROR]Failed making the folder. <br> Skip making the files";
        }

        echo "<hr>";
    }
    if ($totalFilesFound == 0){
        echo PHP_EOL.'No Documents Found for the Incident: '.$odykyID.'<hr>';
    }
    else {
        echo PHP_EOL.'Total Documents Processed:'.$totalFilesFound."<hr>";
    }
    return $totalFilesFound;

}

function makeFileOnServer($fileName,$fileData,$claimNumber,$incidentData,$document){
    $fileType = $document->Documents->document_type;
    $folder = getFolder($claimNumber,$incidentData);
    $fullPath = $folder."//".$fileType."-".$fileName;

    if (@file_put_contents($fullPath,$fileData) === false){
        //echo "Failed making the file";
        return false;
    }
    else {
        //echo "File was created: ".$fullPath;
        return true;
    }
}

function makeCheckFolderOnServer($claimNumber,$incidentData){
    global $main;

    //first check if the folder exists
    $folder = getFolder($claimNumber,$incidentData);
    echo " Checking Folder: ".$folder;
    if (is_dir($folder)){
        //echo "Folder Exists";
        return true;
    }
    else {
        //Folder does not exists
        if (mkdir($folder)){
            //echo "Made folder ok";
            return true;
        }
        else {
            //echo "Error making folder";
            return false;
        }
    }

}

function getFolder($claimNumber,$incidentData){
    $incidentDate = $incidentData->Incident->AccidentData->accepted_at;
    $incidentDateParts = explode(' ',$incidentDate);
    $incidentDateParts = explode('-',$incidentDateParts[0]);
    $folderName = $incidentDateParts[2].$incidentDateParts[1].$incidentDateParts[0];
    $folderName .= "_".$incidentData->Incident->InsurancePolicy->vehicle_registration;
    $folderName .= "-".$incidentData->Incident->VehiclesInformation->vehicles_information[0]->Vehicle->vehicle_registration;
    $folderName .= "_".$claimNumber;
    $folder = '//126.0.0.3//Eurosure Assist//ODYKY//'.$folderName;
    return $folder;
}


