<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 13/7/2021
 * Time: 4:36 μ.μ.
 */

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Functions - Odyky Incidents Manual system";

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


//connect to extranet
$extranet = new mysqli('136.243.227.37', 'mic.ermogenous', '4Xd3l5&w', 'eurosureADMIN_extranet');
if ($extranet->connect_errno) {
    $db->generateAlertError('Error connecting to Extranet');
} else {
}


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

?>

<div class="container-fluid">
    <form name="myForm" id="myForm" method="post" action="" onsubmit=""
        <?php $formValidator->echoFormParameters(); ?>>

        <div class="row">
            <div class="col alert alert-primary text-center font-weight-bold">
                ODYKY Incidents
            </div>
        </div>

        <div class="row">
            <div class="col">
                <a href="../../api/verify_odyky_incidents_by_day.php" target="_blank">Check if any new incidents exists for the past 2 days</a>
                <br>
                <a href="../../api/get_latest_odyky_incidents.php" target="_blank">Download All Pending</a>
            </div>
        </div>

        <div class="row">
            <?php
            $formB = new FormBuilder();
            $formB->setFieldName('sch_search_type')
            ->setFieldDescription('Search Type')
            ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
            ->setFieldType('select')
            ->setInputValue($_POST['sch_search_type'])
            ->setInputSelectArrayOptions([
                    'NotProcessed' => 'Not Processed',
                    'NotCompletedByOdyky' => 'Not Completed By ODYKY',
                    'NotProcessedNotCompletedByOdyky' => 'Not Processed & Not Completed By ODYKY',
                    'AllAccidents' => 'All Accidents',
                    'ALL' => 'ALL Accidents and any other road assistance'
            ])
            ->setInputSelectAddEmptyOption(true)
            ->buildLabel();
            ?>
            <div class="col-xs-12 col-sm-3">
                <?php
                $formB->buildInput();
                $formValidator->addField(
                    [
                        'fieldName' => $formB->fieldName,
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidTextAutoGenerate' => true
                    ]);
                ?>
            </div>

            <div class="col-12-12 col-sm-3">
                <input type="hidden" id="action" name="action" value="search">
                <input type="submit" name="Submit" id="Submit" class="btn btn-primary" value="Search">
            </div>
        </div>
    </form>

    <?php
    if ($_POST['action'] == 'search'){
    ?>
    <br>
    <div class="row">

        <table width="100%" class="table">
            <tr>
                <td align="center"><strong>#</strong></td>
                <td><strong>ODYKY Incident ID</strong></td>
                <td><strong>Registration</strong></td>
                <td><strong>Odyky Call Type</strong></td>
                <td><strong>Processed</strong></td>
                <td><strong>Odyky Status</strong></td>
                <td><strong>Created Date</strong></td>
                <td></td>
            </tr>
            <?php
            $sql = 'SELECT * FROM es_odyky_incidents WHERE 1=1 ';
            $searchSql = '';
            if ($_POST['sch_search_type'] == 'NotProcessed'){
                $searchSql = 'AND esoin_call_type IN ("Accident","Accident care from Phone") AND esoin_processed = 0';
            }
            else if ($_POST['sch_search_type'] == 'NotCompletedByOdyky'){
                $searchSql = 'AND esoin_call_type IN ("Accident","Accident care from Phone") AND esoin_odyky_status = 0';
            }
            else if ($_POST['sch_search_type'] == 'NotProcessedNotCompletedByOdyky'){
                $searchSql = 'AND esoin_call_type IN ("Accident","Accident care from Phone") AND esoin_processed = 0 AND esoin_odyky_status = 0';
            }
            else if ($_POST['sch_search_type'] == 'AllAccidents'){
                $searchSql = 'AND esoin_call_type IN ("Accident","Accident care from Phone")';
            }
            else if ($_POST['sch_search_type'] == 'ALL'){
                $searchSql = '';
            }
            $sql .= $searchSql." ORDER BY esoin_incident_id DESC LIMIT 0,300";
            $result = $extranet->query($sql);
            $i=0;
            while ($row = $result->fetch_assoc()){
                $i++;
            ?>
            <tr>
                <td align="center"><?php echo $i;?></td>
                <td><?php echo $row['esoin_odyky_incident_id'];?></td>
                <td><?php echo $row['esoin_vehicle_registration'];?></td>
                <td><?php echo $row['esoin_call_type'];?></td>
                <td><?php echo $row['esoin_processed'];?></td>
                <td><?php echo $row['esoin_odyky_status'];?></td>
                <td><?php echo $db->convert_date_format($row['esoin_created_date_time'],'yyyy-mm-dd','dd/mm/yyyy',1,0);?></td>
                <td><a href="../../api/get_latest_odyky_incidents.php?by_incident=<?php echo $row['esoin_incident_id'];?>"
                    target="_blank">Process</a> </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <?php
    }
    ?>



</div>

<?php
$formValidator->output();
$db->show_footer();
?>
