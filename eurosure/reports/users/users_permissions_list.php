<?php
include("../../../include/main.php");
include("../../lib/odbccon.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');

$db = new Main();

$sybase = new ODBCCON('SySystem');


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Synthesis Users</b>
                    </div>
                </div>
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row form-group">
                        <?php
                        $searchTypeOptions = [
                            'showUser' => 'Show User',
                            'showPermissions' => 'Show Users Permissions'
                        ];

                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_search_type')
                            ->setFieldDescription('Search Type')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('select')
                            ->setInputValue($_POST['sch_search_type'])
                            ->setInputSelectArrayOptions($searchTypeOptions)
                            ->setInputSelectAddEmptyOption(true)
                            ->buildLabel();
                        ?>
                        <div class="col-3">
                            <?php
                            $formB->buildInput();
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_search_user_desc')
                            ->setFieldDescription('Search Name')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_search_user_desc'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_search_user_name')
                            ->setFieldDescription('Search User Name')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_search_user_name'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_search_user_group')
                            ->setFieldDescription('Search User Group')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_search_user_group'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('sch_search_user_menu')
                            ->setFieldDescription('Search User Menu')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setInputValue($_POST['sch_search_user_menu'])
                            ->buildLabel();
                        ?>
                        <div class="col-2">
                            <?php
                            $formB->buildInput();
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <input type="hidden" id="action" name="action" value="search">
                            <input type="submit" name="Submit" id="Submit" value="Search" class="btn btn-primary" style="width: 150px;">
                        </div>
                    </div>

                </form>

                <?php
                if ($_POST['action'] == 'search') {
                    ?>
                    <table class="table table-responsive" width="100%">
                        <tr>
                            <td width="20%">UserName</td>
                            <td width="60%">Name</td>
                            <td width="20%">Insurance Access</td>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM syplogins";
                        $res = $sybase->query($sql);
                        while ($row = $sybase->fetch_assoc($res)) {
                            $loginInfo[$row['sylgn_user_idty']] = $row;
                        }

                        $where = '';

                        if ($_POST['sch_search_user_desc'] != ''){
                            $where .= " AND syus_user_name LIKE '%".$_POST['sch_search_user_desc']."%'";
                        }
                        if ($_POST['sch_search_user_name'] != ''){
                            $where .= " AND syus_user_idty LIKE '%".$_POST['sch_search_user_name']."%'";
                        }
                        if ($_POST['sch_search_user_group'] != ''){
                            $where .= " AND syus_user_grup LIKE '%".$_POST['sch_search_user_group']."%'";
                        }
                        if ($_POST['sch_search_user_menu'] != ''){
                            $where .= " AND syus_user_menu LIKE '%".$_POST['sch_search_user_menu']."%'";
                        }

                        $sql = "SELECT * FROM sypusers 
                        WHERE 1=1 
                        ".$where."  
                        ORDER BY syus_user_idty ASC";
                        $result = $sybase->query($sql);
                        while ($user = $sybase->fetch_assoc($result)) {
                            ?>
                            <tr style="background-color: orange">
                                <td><b><?php echo $user['syus_user_idty']; ?></b></td>
                                <td>
                                    <?php echo $user['syus_user_name']; ?>
                                    &nbsp;&nbsp;&nbsp;Created
                                    on: <?php echo $db->convertDateToEU($user['syus_created_on'], 1, 0); ?>
                                    &nbsp;&nbsp;&nbsp;Last
                                    Edit: <?php echo $db->convertDateToEU($user['syus_last_edit_on'], 1, 0); ?>
                                    &nbsp;&nbsp;&nbsp;Last
                                    Login: <?php echo $db->convertDateToEU($loginInfo[$user['syus_user_idty']]['sylgn_last_connected'], 1, 0); ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Group:[<?php echo $user['syus_user_grup']; ?>]</td>
                                <td>Menu:[<?php echo $user['syus_user_menu']; ?>] &nbsp;&nbsp;
                                    Companies Allowed:[<?php echo $user['syus_allw_comp'];?>]</td>
                                <td></td>
                            </tr>

                            <?php
                            if ($_POST['sch_search_type'] == 'showPermissions') {
                            ?>
                            <tr>
                                <td colspan="3" style="background-color: lightgrey"><b>Permissions From User</b></td>
                            </tr>
                            <?php
                                $sql = "SELECT * FROM sypacces WHERE syacc_user_idty = '" . $user['syus_user_idty'] . "' ORDER BY syacc_modl_optn ASC";
                                $accResult = $sybase->query($sql);
                                while ($permission = $sybase->fetch_assoc($accResult)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $permission['syacc_modl_optn']; ?></td>
                                        <td><?php echo $permission['syacc_allw_optn']; ?></td>
                                        <td><?php echo checkInsuranceAccess($permission['syacc_modl_optn'], $permission['syacc_allw_optn']); ?></td>
                                    </tr>
                                    <?php
                                }

                                if ($user['syus_user_grup'] != '') {
                                    ?>
                                    <tr>
                                        <td colspan="3" style="background-color: lightgrey"><b>Permissions From
                                                Group <?php echo $user['syus_user_grup']; ?></b></td>
                                    </tr>
                                    <?php
                                    $sql = "SELECT * FROM sypacces WHERE syacc_user_idty = '" . $user['syus_user_grup'] . "' ORDER BY syacc_modl_optn ASC";
                                    $grpResult = $sybase->query($sql);
                                    while ($permission = $sybase->fetch_assoc($grpResult)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $permission['syacc_modl_optn']; ?></td>
                                            <td><?php echo $permission['syacc_allw_optn']; ?></td>
                                            <td><?php echo checkInsuranceAccess($permission['syacc_modl_optn'], $permission['syacc_allw_optn']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }//if group exists
                            }
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
<?php
$formValidator->output();
$db->show_footer();

function checkInsuranceAccess($module, $options)
{
    $ret = '';
    if ($module[0] . $module[1] == 'IN' && strpos($options, '+') !== false) {
        $ret = 'IN+';
    }

    return $ret;
}

?>