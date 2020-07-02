<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 23/06/2020
 * Time: 14:59
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Synthesis Users Connections";

$db->show_header();

?>

    <div class="container-fluid">


                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Synthesis Eurosure Database Connections & Connection Info</b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-1 font-weight-bold">Number</div>
                    <div class="col-3 font-weight-bold">Comp.Details</div>
                    <div class="col-2 font-weight-bold">User Details</div>
                    <div class="col-2 font-weight-bold">NodeAddress</div>
                    <div class="col-1 font-weight-bold text-center">Blocked ON</div>
                    <div class="col-1 font-weight-bold text-center">Blocked RowID</div>
                    <div class="col-1 font-weight-bold text-center">Blocked Index</div>
                    <div class="col-1 font-weight-bold text-center">Blocked Table</div>
                </div>

                <?php
                $sybase = new ODBCCON();
                $sql = 'SELECT
                    number,NodeAddr,connection_property(\'AppInfo\', sci.number)as connInfo,BlockedOn,LockRowID,LockIndexID,LockTable
                    from sa_conn_info() sci
                    ORDER BY BlockedOn DESC, number ASC';
                $result = $sybase->query($sql);
                $blockedID = 0;
                while ($row = $sybase->fetch_assoc($result)) {
                    if ($row['BlockedOn'] > 0){
                        $blockedID = $row['BlockedOn'];
                    }
                    $infoSplit = explode(";",$row['connInfo']);

                    if ($row['number'] == $blockedID){
                        $red = 'alert-danger';
                    }
                    else {
                        $red = '';
                    }
                    ?>
                    <div class="row <?php echo $red;?>">
                        <div class="col-1"><?php echo $row['number'];?></div>
                        <div class="col-3"><?php echo $infoSplit[0].$infoSplit[1];?></div>
                        <div class="col-2"><?php echo $infoSplit[2];?></div>
                        <div class="col-2"><?php echo $row['NodeAddr'];?></div>
                        <div class="col-1 text-center"><?php echo $row['BlockedOn'];?></div>
                        <div class="col-1 text-center"><?php echo $row['LockRowID'];?></div>
                        <div class="col-1 text-center"><?php echo $row['LockIndexID'];?></div>
                        <div class="col-1 text-center"><?php echo $row['LockTable'];?></div>
                    </div>

                    <?php
                }
                ?>



    </div>

<?php
$db->show_footer();
?>