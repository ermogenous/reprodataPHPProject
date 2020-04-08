<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 03/04/2020
 * Time: 16:18
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');

$db = new Main();
$db->admin_title = "Ainsurance Overwrites";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Ainsurance Overwrites Inserting';

    $db->start_transaction();

    $db->db_tool_insert_row('ina_overwrites', $_POST, 'fld_', 0, 'inaovr_');

    $db->commit_transaction();
    header("Location: overwrites.php");
    exit();

} else if ($_POST['action'] == 'update') {

}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM ina_overwrites WHERE inaovr_overwrite_ID = ' . $_GET['lid']);
}

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
        <div class="col-1 d-none d-md-block"></div>
        <div class="col-12 col-md-10">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Overwrites</b></div>
                </div>
                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder([
                        "fieldName" => "fld_underwriter_ID",
                        "fieldDescription" => "Agent/Underwriter",
                        "labelClasses" => "col-sm-2",
                        "fieldType" => "select",
                        "inputValue" => $data['inaovr_underwriter_ID'],
                        "inputSelectAddEmptyOption" => true
                    ]);
                    $formB->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->setInputSelectQuery($db->query('SELECT inaund_underwriter_ID as value, usr_name as name
                            FROM ina_underwriters JOIN users ON usr_users_ID = inaund_user_ID WHERE inaund_status = "Active"'))
                            ->buildInput();
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

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder([
                        "fieldName" => "fld_status",
                        "fieldDescription" => "Status",
                        "labelClasses" => "col-sm-2",
                        "fieldType" => "select",
                        "inputValue" => $data['inaovr_status'],
                        "inputSelectAddEmptyOption" => false
                    ]);
                    $formB->buildLabel();
                    ?>
                    <div class="col-4">
                        <?php
                        $formB->setInputSelectArrayOptions([
                            'Active' => 'Active',
                            'InActive' => 'InActive'
                        ])
                        ->buildInput();
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('overwrites.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Overwrite"
                               class="btn btn-primary">
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>
<?php
if ($_GET["lid"] > 0) {
    ?>
    <div class="row">
        <div class="col-12">
            <iframe name="overwrite_agents" id="overwrite_agents"
                    src="overwrite_agents.php?oid=<?php echo $_GET["lid"]; ?>"
                    width="100%" height="620" frameborder="0"></iframe>
        </div>
    </div>
    <?php
}//overwrite agents if lid exists
?>

<?php
$formValidator->output();
$db->show_footer();
?>
