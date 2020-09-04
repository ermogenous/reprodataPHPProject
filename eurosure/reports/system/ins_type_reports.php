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
            <div class="col-12">
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
                        <div class="col-12 alert alert-secondary text-center">
                            <b>
                            <?php
                            echo $row['inity_insurance_type']." - ".$row['inity_long_description'];
                            ?>
                            </b>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">Schedule Object</div>
                        <div class="col-3"><?php echo $row['clo_schedule_object'];?></div>
                        <div class="col-3">Certificate Object</div>
                        <div class="col-3"><?php echo $row['clo_certificate_object'];?></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3"><?php echo $row['inity_user_defined_doc1_title'];?></div>
                        <div class="col-3"><?php echo $row['inity_user_defined_doc1_layout'];?></div>
                        <div class="col-3"><?php echo $row['inity_user_defined_doc2_title'];?></div>
                        <div class="col-3"><?php echo $row['inity_user_defined_doc2_layout'];?></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">Pol.Aux: <?php echo $row['inity_policy_aux_input_dw'];?></div>
                        <div class="col-3">Sit.Obj: <?php echo $row['inity_situation_layout'];?></div>
                        <div class="col-3">Pit.Obj: <?php echo $row['inity_detailed_policy_item_layout'];?></div>
                        <div class="col-3">C.Note.Obj: <?php echo $row['inity_cover_note_layout'];?></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-3">Attachments RTF:</div>
                        <div class="col-3"><?php echo $row['inity_shedule_rtf'];?></div>
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>


<?php
$db->show_footer();
?>