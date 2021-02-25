<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 11/2/2021
 * Time: 1:09 μ.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Agents- Agents commissions list";

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

$syn = new ODBCCON();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-10">

            <div class="row">
                <div class="col-12 alert alert-primary text-center">
                    <b>Agents Report - Permission Profile</b>
                </div>
            </div>
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>
                <div class="row">
                    <?php

                    $sql = "SELECT * FROM inagents
                            WHERE
                            inag_agent_type = 'A'
                            AND inag_status_flag = 'N'";
                    $result = $syn->query($sql);
                    $allAgents = [];
                    while ($agent = $syn->fetch_assoc($result)) {
                        $allAgents[$agent['inag_agent_code']] = $agent['inag_agent_code'] . " - " . $agent['inag_long_description'];
                    }

                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_agent_from')
                        ->setFieldDescription('Select Agent From')
                        ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                        ->setFieldType('select')
                        ->setInputValue($_POST['sch_agent_from'])
                        ->setInputSelectArrayOptions($allAgents)
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

                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('sch_agent_to')
                        ->setFieldDescription('Select Agent To')
                        ->setLabelClasses('col-xs-12 col-sm-3 com-md-2 col-lg-2')
                        ->setFieldType('select')
                        ->setInputValue($_POST['sch_agent_to'])
                        ->setInputSelectArrayOptions($allAgents)
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
                </div>

                <div class="row" style="height: 25px;"></div>

                <div class="row">
                    <div class="col-12 text-center">
                        <input type="hidden" id="action" name="action" value="show">
                        <input type="submit" value="Show Profile/s" class="form-control btn btn-primary"
                               style="width: 180px;">
                    </div>
                </div>
        </div>
        </form>
    </div>
    <div class="col-1 d-none d-md-block"></div>
</div>
<br>

<?php
if ($_POST['action'] == 'show') {

    //get all agents based on user options
    $sql = "
        SELECT
        *
        FROM
        inagents
        WHERE
        inag_agent_code >= '".$_POST['sch_agent_from']."'
        AND inag_agent_code <= '".$_POST['sch_agent_to']."'
        ORDER BY inag_agent_code ASC
    ";
    //echo $sql;
    $allAgentsResult = $syn->query($sql);
    while ($agent = $syn->fetch_assoc($allAgentsResult)){
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col alert alert-primary text-center font-weight-bold">
                    <?php echo $agent['inag_agent_code']." - ".$agent['inag_long_description'];?>
                </div>
            </div>

            <?php
            $sysUsersFound = $syn->query_fetch(
                    "SELECT 
                    LIST(
                        syus_user_idty
                        || ' Group:' || syus_user_grup || ' Menu:' || syus_user_menu || ' Restrictions:' || syus_restriction_codes
                        ,' / ')as clo_user_list FROM sypusers where syus_user_idty LIKE '%".$agent['inag_agent_code']."%'"
            );
            ?>
            <div class="row">
                <div class="col"><strong>System Users Found:</strong> <?php echo $sysUsersFound['clo_user_list'];?></div>
            </div>

        </div><!-- Agent Container Fluid -->
        <?php
    }
?>



<?php
}//if show
?>


<?php
$formValidator->output();
$db->show_footer();
?>
