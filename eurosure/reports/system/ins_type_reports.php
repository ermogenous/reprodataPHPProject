<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 30/06/2020
 * Time: 09:17
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Synthesis Reports - System - InsTypes Reports";

$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row form-group">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Insurance Types Info</b>
                    </div>
                </div>

                <?php
                $sybase = new ODBCCON();
                $sql = 'SELECT
                        (select incd_layout_name from inpcodes where incd_pcode_serial = inity_schedule_layout)as clo_schedule_object
                        ,(select incd_layout_name from inpcodes where incd_pcode_serial =inity_certificate_layout)as clo_certificate_object
                        ,*
                        
                        FROM ininsurancetypes ORDER BY inity_insurance_type ASC';
                $result = $sybase->query($sql);
                while ($row = $sybase->fetch_assoc($result)) {
                    ?>
                    <div class="row form-group">
                        <div class="col-12 alert alert-secondary">
                            <?php
                            echo $row['inity_insurance_type']." - ".$row['inity_long_description'];
                            ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-2">Schedule Object</div>
                        <div class="col-4"><?php echo $row['clo_schedule_object'];?></div>
                        <div class="col-2">Certificate Object</div>
                        <div class="col-4"><?php echo $row['clo_certificate_object'];?></div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <div class="col-1"></div>
        </div>
    </div>


<?php
$db->show_footer();
?>