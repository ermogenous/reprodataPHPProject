<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 12:34 PM
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Codes Delete";

$db->check_restriction_area('delete');

if ($_GET["lid"] == ''){
    header("Location: codes.php");
    exit();
}

//first check if there is any records being used
//get the code data
$errors = '';
$data = $db->query_fetch('SELECT * FROM codes WHERE cde_code_ID = '.$_GET['lid']);
if ($data['cde_type'] == 'code'){

    //check if any codes with this type exists
    $sql = "SELECT * FROM codes WHERE cde_type = '".$data['cde_value']."'";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        $errors .= "<br>Code ".$row['cde_value']." using this with ID ".$row['cde_code_ID'];
    }

}
else {
    $codeData = $db->query_fetch("SELECT * FROM codes WHERE cde_type = 'code' AND cde_value = '".$data['cde_type']."'");
    fillErrors($codeData['cde_table_field']);
    fillErrors($codeData['cde_table_field2']);
    fillErrors($codeData['cde_table_field3']);
}


if ($errors != ''){

    $db->generateAlertError('Cannot delete. '.$errors.'<br><br><a href="codes.php?type='.$_GET["codeSelection"].'&search_code=search">Go back</a>');

    $db->show_header();
    $db->show_footer();

}
else {
    $db->db_tool_delete_row('codes',$_GET['lid'],'cde_code_ID = '.$_GET['lid']);
    $db->generateSessionDismissSuccess('Code Deleted.');
    header('Location: codes.php?type='.$_GET["codeSelection"].'&search_code=search');
    exit();
}

function fillErrors($tableField){
    global $db,$data,$errors;
    if ($tableField != ''){
        $split = explode('#',$tableField);
        //check if the split is correct
        if (count($split) > 1){
            //get if any rows in the table
            $sql = "SELECT * FROM ".$split[0]." WHERE ".$split[1]." = ".$_GET['lid'];
            $result = $db->query($sql);
            while ($row = $db->fetch_assoc($result)){
                $errors .= "<br>"." Used in ".$split[0]." with ID ".array_values($row)[0];
            }
        }
        else {
            $errors .= 'Table Field is not set correctly -> '.$tableField."<br>Correct format : &lttableName&gt#&ltfieldName&gt";
        }

    }
}