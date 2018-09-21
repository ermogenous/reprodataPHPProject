<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/9/2018
 * Time: 7:31 ΜΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Agreements Modify";
$db->check_restriction_area('insert');

$db->working_section = 'Agreements Delete Start';

if ($_GET['lid'] == '') {
    header("Location: agreements.php");
    exit();
}

$data = $db->query_fetch("SELECT * FROM agreements WHERE agr_agreement_ID = ".$_GET['lid']);
if ($data['agr_agreement_ID'] > 0){
    echo "HERE<br>";

    if ($data['agr_status'] == 'Pending'){
        echo "HERE2<br>";
        $newData['status'] = 'Deleted';
        $db->start_transaction();
        $db->db_tool_update_row('agreements', $newData, "agr_agreement_ID = ".$_GET['lid'],
            $_GET['lid'], '', 'execute', 'agr_' );
        $db->commit_transaction();
        $db->generateSessionDismissSuccess("Agreement #".$_GET['lid']." Deleted Successfully");
        header("Location: agreements.php");
        exit();
    }
    else {
        $db->generateSessionAlertError("Can only delete Pending Agreements");
        header("Location: agreements.php");
        exit();
    }

}else {
    header("Location: agreements.php");
    exit();
}