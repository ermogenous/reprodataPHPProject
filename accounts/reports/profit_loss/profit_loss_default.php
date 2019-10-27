<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/10/2019
 * Time: 1:02 ΜΜ
 */

include("../../../include/main.php");
include("../../../include/tables.php");
include("../search_box.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Reports - Balance Sheet Default";

$db->enable_jquery_ui();
$db->show_header();

$settings['report'] = 'ProfitLossDefault';
$settings['showFromDate'] = 'ProfitLossDefault';
$settings['showToDate'] = 'ProfitLossDefault';
generateSearchBox($settings);


if ($_POST['action'] == 'sbSearch'){
    print_r($_POST);
    $dateFrom = $db->convertDateToUS($_POST['sbDateFrom']);
    $dateTo = $db->convertDateToUS($_POST['sbDateTo']);

    echo "<br><hr>Left: ".$dateFrom." - ".$dateTo;

    //find same period in previous year
    $dateFromSplit = explode('-',$dateFrom);
    $dateToSplit = explode('-',$dateTo);
    $dateFromPrevious = ($dateFromSplit[0] - 1).'-'.$dateFromSplit[1]."-".$dateFromSplit[2];
    $dateToPrevious = ($dateToSplit[0] - 1)."-".$dateToSplit[1]."-".$dateToSplit[2];
    echo "<br><hr>Right: ".$dateFromPrevious." - ".$dateToPrevious;

    $currentSql = getSql($dateFrom, $dateTo);
    $previousSql = getSql($dateFromPrevious,$dateToPrevious);

    echo "<br><br><br></br>".$db->prepare_text_as_html($sql);
    $currentResult = $db->query($currentSql);
    while ($row = $db->fetch_assoc($currentResult)){
        $data[$row['AccountName']] += $row['value'];
    }

    print_r($data);


}

?>




<?php

function getSql($dateFrom, $dateTo){
    $sql = "

    SELECT
    ac_accounts.acacc_name as AccountName
    ,parent.acacc_name as ParentName

		,acc_type.actpe_category as TypeName
    
    ,SUM(actrl_value * actrl_dr_cr)as value
    
    FROM
    ac_transactions
    JOIN ac_transaction_lines ON actrl_transaction_ID = actrn_transaction_ID
    #get the account
    JOIN ac_accounts ON actrl_account_ID = acacc_account_ID
    #get the account type/subtype
    LEFT OUTER JOIN ac_account_types as acc_type ON acacc_account_type_ID = acc_type.actpe_account_type_ID
    LEFT OUTER JOIN ac_account_types as acc_sub_type ON acacc_account_sub_type_ID = acc_sub_type.actpe_account_type_ID
    #get the parent
    JOIN ac_accounts as parent ON ac_accounts.acacc_parent_ID = parent.acacc_account_ID
    
    WHERE
    actrn_status = 'Active'
    AND actrn_transaction_date >= '".$dateFrom."'
    AND actrn_transaction_date <= '".$dateTo."'
    AND acc_type.actpe_category IN ('OperatingRevenue','OperatingExpenses')
    
    GROUP BY
    AccountName
    ,ParentName
		,TypeName
    
    ";
    return $sql;
}

$db->show_footer();
?>