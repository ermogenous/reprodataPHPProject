<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 27/11/2019
 * Time: 4:38 ΜΜ
 */

include("../../include/main.php");
include('../../tools/autoFilesClass.php');
include("../../scripts/form_builder_class.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Events Images";

if ($_POST['action'] == 'update') {
    $db->start_transaction();
    $file = new AutoFiles($_POST['img']);
    $file->setFileTitle($_POST['fld_title'])
        ->setFileAltName($_POST['fld_alt_name'])
        ->updateImageDetails();
    if ($file->error == false){
        $db->commit_transaction();
        $db->generateSessionAlertSuccess('Image Updated');
        header("Location: event_images.php?lid=" . $_GET['lid']);
        exit();
    }
    else {
        $db->rollback_transaction();
        $db->generateSessionAlertError($file->errorDescription);
        header("Location: event_images.php?lid=" . $_GET['lid']);
        exit();
    }

}

if ($_GET['lid'] == '') {
    header("Location: ../home.php");
    exit();
}
if ($_GET['img'] == '') {
    header("Location: event_images.php?lid=" . $_GET['lid']);
    exit();
}

$data = $db->query_fetch("SELECT * FROM _files WHERE fle_file_ID = " . $_GET['img']);
$db->enable_jquery_ui();
$db->show_empty_header();
FormBuilder::buildPageLoader();

$formB = new FormBuilder();
$formB->setLabelClasses('col-4');
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 alert alert-success">Modify Image Details</div>
        </div>
        <form name="myForm" id="myForm" method="post" action="" onsubmit="">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="card">
                        <img class="card-img-top"
                             src="<?php echo $main['site_url'] . "/" . $data['fle_file_location'] . "/" . $data['fle_file_name'] ?>"
                             alt="Card image cap">
                    </div>
                </div>
                <div class="col-sm-2"></div>

            </div>
            <div class="row" style="height: 20px;"></div>
            <div class="row">
                <?php
                $formB->setFieldName('fld_title')
                    ->setFieldDescription('Image Title')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->setInputValue($data['fle_title'])
                    ->buildLabel();
                ?>
                <div class="col-sm-8">
                    <?php
                    $formB->buildInput();
                    ?>
                </div>
            </div>
            <div class="row">
                <?php
                $formB->setFieldName('fld_alt_name')
                    ->setFieldDescription('Image Alt Name')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->setInputValue($data['fle_description'])
                    ->buildLabel();
                ?>
                <div class="col-sm-8">
                    <?php
                    $formB->buildInput();
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                <div class="col-sm-8">
                    <input name="action" type="hidden" id="action" value="update">
                    <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                    <input name="img" type="hidden" id="img" value="<?php echo $_GET["img"]; ?>">
                    <input type="button" value="Back" class="btn btn-secondary"
                           onclick="window.location.assign('event_images.php?lid=<?php echo $_GET['lid']; ?>')">
                    <input type="submit" name="Submit" id="Submit"
                           value="Update Image"
                           class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>

<?php
$db->show_empty_footer();
?>