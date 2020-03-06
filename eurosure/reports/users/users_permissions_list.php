<?php
include("../../../include/main.php");
include("../../lib/odbccon.php");

$db = new Main();

$sybase = new ODBCCON('SySystem');


$db->show_header();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <table class="table table-responsive" width="100%">
                <tr>
                    <td width="8%">UserName</td>
                    <td width="82%">Name</td>
                    <td width="10%">Insurance Access</td>
                </tr>
                <?php
                $sql = "SELECT * FROM syplogins";
                $res = $sybase->query($sql);
                while($row = $sybase->fetch_assoc($res)){
                    $loginInfo[$row['sylgn_user_idty']] = $row;
                }


                $sql = "SELECT * FROM sypusers 
                        //WHERE syus_user_idty = 'ACCAAS'  
                        ORDER BY syus_user_idty ASC";
                $result = $sybase->query($sql);
                while ($user = $sybase->fetch_assoc($result)) {
                    ?>
                    <tr style="background-color: orange">
                        <td><?php echo $user['syus_user_idty'];?></td>
                        <td>
                            <?php echo $user['syus_user_name'];?>
                            &nbsp;&nbsp;&nbsp;Created on: <?php echo $db->convertDateToEU($user['syus_created_on'],1,0);?>
                            &nbsp;&nbsp;&nbsp;Last Edit: <?php echo $db->convertDateToEU($user['syus_last_edit_on'],1,0);?>
                            &nbsp;&nbsp;&nbsp;Last Login: <?php echo $db->convertDateToEU($loginInfo[$user['syus_user_idty']]['sylgn_last_connected'],1,0);?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-color: lightgrey"><b>Permissions From User</b></td>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM sypacces WHERE syacc_user_idty = '".$user['syus_user_idty']."' ORDER BY syacc_modl_optn ASC";
                    $accResult = $sybase->query($sql);
                    while ($permission = $sybase->fetch_assoc($accResult)){
                        ?>
                        <tr>
                            <td><?php echo $permission['syacc_modl_optn'];?></td>
                            <td><?php echo $permission['syacc_allw_optn'];?></td>
                            <td><?php echo checkInsuranceAccess($permission['syacc_modl_optn'],$permission['syacc_allw_optn']);?></td>
                        </tr>
                        <?php
                    }
                    if ($user['syus_user_grup'] != '') {
                        ?>
                        <tr>
                            <td colspan="3" style="background-color: lightgrey"><b>Permissions From Group <?php echo $user['syus_user_grup'];?></b></td>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM sypacces WHERE syacc_user_idty = '".$user['syus_user_grup']."' ORDER BY syacc_modl_optn ASC";
                        $grpResult = $sybase->query($sql);
                        while ($permission = $sybase->fetch_assoc($grpResult)){
                            ?>
                            <tr>
                                <td><?php echo $permission['syacc_modl_optn'];?></td>
                                <td><?php echo $permission['syacc_allw_optn'];?></td>
                                <td><?php echo checkInsuranceAccess($permission['syacc_modl_optn'],$permission['syacc_allw_optn']);?></td>
                            </tr>
                            <?php
                        }
                    }//if group exists
                }
                ?>
            </table>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<?php
$db->show_footer();

function checkInsuranceAccess($module,$options){
$ret = '';
    if ($module[0].$module[1] == 'IN' && strpos($options,'+') !== false){
        $ret = 'IN+';
    }

    return $ret;
}
?>