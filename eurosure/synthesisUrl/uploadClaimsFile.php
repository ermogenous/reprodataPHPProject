<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 5/7/2021
 * Time: 11:38 π.μ.
 */

//http://hayageek.com/docs/jquery-upload-file.php#events

include("../../include/main.php");
$db = new Main();
$info = '';



$output_dir = "uploads/";

$output_dir = $_POST['folder'];


if(isset($_FILES["myfile"]))
{
    $ret = array();
    $ret['folder'] = $output_dir;
//	This is for custom errors;
    /*	$custom_error= array();
        $custom_error['jquery-upload-file-error']="File already exists";
        echo json_encode($custom_error);
        die();
    */
    $error =$_FILES["myfile"]["error"];
    $info = $error;
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData()
    if(!is_array($_FILES["myfile"]["name"])) //single file
    {
        $fileName = $_FILES["myfile"]["name"];

        if (is_file($output_dir.$fileName)){
            $ret['jquery-upload-file-error'] = 'FileName Already Exists';
            $ret[]= $fileName;
        }
        else {

            $result = move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
            $ret['result'] = $result;
            if (!$result){
                $ret[]= $fileName;
                $ret['jquery-upload-file-error'] = 'File failed to be uploaded';
                $ret['status'] = 0;
            }
            else {
                $ret[]= $fileName;
            }
        }
        $info .= PHP_EOL.'SingleFile';
    }
    else  //Multiple files, file[]
    {
        $info .= PHP_EOL.'MultiFile'.PHP_EOL;
        $fileCount = count($_FILES["myfile"]["name"]);
        for($i=0; $i < $fileCount; $i++)
        {

            $fileName = $_FILES["myfile"]["name"][$i];

            if (is_file($output_dir.$fileName)){
                $ret['jquery-upload-file-error'] = 'FileName Already Exists';
                $ret[]= $fileName;
            }
            else {
                $result = move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
                $ret['result'] = $result;
                if (!$result){
                    $ret[]= $fileName;
                    $ret['jquery-upload-file-error'] = 'File failed to be uploaded';
                    $ret['status'] = 0;
                }
                else {
                    $ret[]= $fileName;
                }
            }
        }//for

    }
    $db->update_log_file_custom(print_r($ret,true),json_encode($ret));
    echo json_encode($ret);
}
?>
