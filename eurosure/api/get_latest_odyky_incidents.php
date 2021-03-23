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
 * saves in the settings table the last id esoin_incident_id found
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1800);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure check extranet to get the latests odyky incidents';
$db->update_log_file('Eurosure check extranet to get the latests odyky incidents',0,
    'Eurosure check extranet to get the latests odyky incidents'
    ,'Eurosure check extranet to get the latests odyky incidents');
$log = 'Starting Intranet Get latest odyky incidents'.PHP_EOL;

//connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w','eurosureADMIN_extranet');
if ($extranet -> connect_errno) {
    $log .= 'Failed to connect to Extranet DB: '.$extranet->connect_error;
    $db->update_log_file('import rescueline api',0,$log,'');
    exit();
}
//find the last incident id (primary of the table es_odyky_incidents) saved in the settings table
$lastIncidentID = $db->get_setting('eurosure_last_odyky_incident');

//now find on extranet any new incidents where the primary key is higher
//$sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_incident_id > '.$lastIncidentID;
$sql = 'SELECT * FROM es_odyky_incidents WHERE esoin_processed = 0';

$result = $extranet->query($sql);
$lastID = 0;
while ($row = $result->fetch_assoc()){
    $lastID = $row['esoin_incident_id'];
    //connect to odyky api to get the information and files for this incident
    getOdykyFiles($row['esoin_odyky_incident_id']);

    //update extranet that this record has been processed
    $sql = 'UPDATE es_odyky_incidents 
            SET esoin_processed = 1
            ,esoin_last_update_date_time = "'.date("Y-m-d G:i:s").'"
            WHERE esoin_incident_id = '.$row['esoin_incident_id'];
    $extranet->query($sql);

}

//update settings
if ($lastID > $lastIncidentID){
    //temp disable
    //$db->update_setting('eurosure_last_odyky_incident',$lastID);
}


function getOdykyFiles($odykyID){
    global $main;

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
    foreach ($obj as $document){
        $fileUrl = $document->Documents->document_link."/".$document->Documents->document_file_name;
        $getDocumentUrl = 'https://portal.odyky.com/webservices/eurosure/get_document.json?user=eurosure&pass=Tt04U17paE7WSJvNwFFz';
        $getDocumentUrl .= '&incident_id='.$odykyID.'&doc_id='.$document->Documents->document_id;
        //print_r($document);
        echo "Retrieving Document: ".$document->Documents->document_id;
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
            echo "Success";
            //save the file
            echo " Make File: ";
            if (makeFileOnServer($document->Documents->document_file_name
                ,$documentData
                ,$odykyID,$incidentData,$document)){
                echo "Success";
            }
            else {
                echo "Failed creating the file";
            }
        }
        else {
            echo "[ERROR]Failed making the folder. <br> Skip making the files";
        }

        echo "<hr>";
    }

}

function makeFileOnServer($fileName,$fileData,$claimNumber,$incidentData,$document){
    $fileType = $document->Documents->document_type;
    $folder = getFolder($claimNumber,$incidentData);
    $fullPath = $folder."//".$fileType."-".$fileName;

    if (file_put_contents($fullPath,$fileData) === false){
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
