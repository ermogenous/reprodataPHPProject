<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/10/2019
 * Time: 9:52 ΠΜ
 */

include("../../../include/main.php");
include("../../../include/tables.php");
include("../search_box.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Reports - Balance Sheet Default";

$db->enable_jquery_ui();
$db->show_header();


$settings['report'] = 'BalanceSheetDefault';
$settings['showAsAtDate'] = true;
generateSearchBox($settings);



if ($_POST['action'] == 'sbSearch'){
    //print_r($_POST);
    $asAtDate = $db->convertDateToUS($_POST['sbAsAtDate']);
    //echo $asAtDate;



    $sql = "

    SELECT
    #ac_accounts.acacc_name as AccountName
    #,parent.acacc_name as ParentName
		acc_type.actpe_category as TypeName
    
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
    AND actrn_transaction_date <= '".$asAtDate."'
    AND acc_type.actpe_category != 'OperatingRevenue'
    AND acc_type.actpe_category != 'OperatingExpenses'
    
    GROUP BY
    #AccountName
    #,ParentName
		TypeName
    
    ";
    //echo "<br><br><br></br>".$db->prepare_text_as_html($sql);
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)){
        $data[$row['TypeName']] += $row['value'];
    }


    $totalAssets = $data['FixedAsset'] + $data['CurrentAsset'] + $data['Investment'];
    $totalLiabilities = $data['CurrentLiability'] + $data['LongTermLiability'];
    $netAssets = $totalAssets + $totalLiabilities;
    $capitalReserves = $data['CapitalReserves'];

}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">

            <div class="row">
                <div class="col-sm-12 alert alert-primary">
                    Balance Sheet As At <?php echo $_POST['sbAsAtDate'];?>
                </div>
            </div>

            <div class="container-fluid border">
                <div class="row">
                    <div class="col-sm-8">
                        Fixed Assets
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['FixedAsset'] > 0){
                            echo $data['FixedAsset'];
                        }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['FixedAsset'] < 0){
                            echo $data['FixedAsset'];
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        Current Assets
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['CurrentAsset'] > 0){
                            echo $data['CurrentAsset'];
                        }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['CurrentAsset'] < 0){
                            echo $data['CurrentAsset'];
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        Investments
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['Investment'] > 0){
                            echo $data['Investment'];
                        }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if ($data['Investment'] < 0){
                            echo $data['Investment'];
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <strong>Total Assets</strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                            <?php
                            if ($totalAssets > 0){
                                echo $totalAssets;
                            }
                            ?>
                            </u></strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                            <?php
                            if ($totalAssets < 0){
                                echo $totalAssets;
                            }
                            ?>
                            </u></strong>
                    </div>
                </div>

            </div>

            <br>

            <div class="container-fluid border">
                <div class="row">
                    <div class="col-sm-8">
                        Liabilites
                    </div>
                    <div class="col-sm-2">
                                <?php
                                if ($data['CurrentLiability'] > 0){
                                    echo $data['CurrentLiability'] * -1;
                                }
                                ?>
                    </div>
                    <div class="col-sm-2">
                                <?php
                                if ($data['CurrentLiability'] < 0){
                                    echo $data['CurrentLiability'] * -1;
                                }
                                ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        Long Term Liabilites
                    </div>
                    <div class="col-sm-2">
                                <?php
                                if ($data['LongTermLiability'] > 0){
                                    echo $data['LongTermLiability'] * -1;
                                }
                                ?>
                    </div>
                    <div class="col-sm-2">
                                <?php
                                if ($data['LongTermLiability'] < 0){
                                    echo $data['LongTermLiability'] * -1;
                                }
                                ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <strong>Total Liabilites</strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                                <?php
                                if ($totalLiabilities > 0){
                                    echo $totalLiabilities * -1;
                                }
                                ?>
                            </u></strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                                <?php
                                if ($totalLiabilities < 0){
                                    echo $totalLiabilities * -1;
                                }
                                ?>
                            </u></strong>
                    </div>
                </div>

            </div>

            <br>

            <div class="container-fluid border">
                <div class="row alert-secondary">
                    <div class="col-sm-8">
                        <strong>Net Assets</strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                                <?php
                                if ($netAssets > 0){
                                    echo $netAssets;
                                }
                                ?>
                            </u></strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                                <?php
                                if ($netAssets < 0){
                                    echo $netAssets;
                                }
                                ?>
                            </u></strong>
                    </div>
                </div>
            </div>

            <br>

            <div class="container-fluid border">
                <div class="row alert-secondary">
                    <div class="col-sm-8"><strong>
                        Capital & Reserves
                        </strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                        <?php
                        if ($capitalReserves > 0){
                            echo $capitalReserves * -1;
                        }
                        ?>
                            </u></strong>
                    </div>
                    <div class="col-sm-2">
                        <strong><u>
                        <?php
                        if ($capitalReserves < 0){
                            echo $capitalReserves * -1;
                        }
                        ?>
                            </u></strong>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-2"></div>
    </div>


</div>

<?php
$db->show_footer();
?>