<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 27/11/2019
 * Time: 1:17 ΜΜ
 */

include("../../include/main.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include('../../tools/autoFilesClass.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "Event Events Images";

if ($_POST['action'] == 'upload') {
    $db->start_transaction();
    $file = new AutoFiles();
    $fileInfo = explode(".", $_FILES['imageFile']['name']);
    $file->setSourceFile($_FILES['imageFile']['tmp_name'])
        ->setDestinationFileName($fileInfo[0])
        ->setFileExtention($fileInfo[1])
        ->setFileType($fileInfo[1])
        ->setFileTitle($_POST['fld_title'])
        ->setFileAltName($_POST['fld_alt_name'])
        ->setAddon('EventsEvent')
        ->setAddonID($_POST['lid'])
        ->createNewFileFromFile();

    if ($file->error == false) {
        $db->generateSessionAlertSuccess('Image uploaded successfully.');
        $db->commit_transaction();
    } else {
        $db->generateSessionAlertError($file->errorDescription);
        $db->rollback_transaction();
    }
    header("Location: event_images.php?lid=" . $_POST['lid']);
    exit();
}

if ($_GET['action'] == 'up') {
    $db->start_transaction();
    $file = new AutoFiles($_GET['img']);
    $file->changeOrderUp();

    if ($file->error == false) {
        $db->generateSessionAlertSuccess('Image order updated.');
        $db->commit_transaction();
    } else {
        $db->generateSessionAlertError($file->errorDescription);
        $db->rollback_transaction();
    }

    header("Location: event_images.php?lid=" . $_GET['lid']);
    exit();
}

if ($_GET['action'] == 'down') {
    $db->start_transaction();
    $file = new AutoFiles($_GET['img']);
    $file->changeOrderDown();

    if ($file->error == false) {
        $db->generateSessionAlertSuccess('Image order updated.');
        $db->commit_transaction();
    } else {
        $db->generateSessionAlertError($file->errorDescription);
        $db->rollback_transaction();
    }

    header("Location: event_images.php?lid=" . $_GET['lid']);
    exit();
}
if ($_GET['action'] == 'makePrimary') {
    $db->start_transaction();
    $file = new AutoFiles($_GET['img']);
    $file->makePrimary();

    if ($file->error == false) {
        $db->generateSessionAlertSuccess('Image made to primary.');
        $db->commit_transaction();
    } else {
        $db->generateSessionAlertError($file->errorDescription);
        $db->rollback_transaction();
    }

    header("Location: event_images.php?lid=" . $_GET['lid']);
    exit();
}
if ($_GET['action'] == 'delete') {
    $db->start_transaction();
    $file = new AutoFiles($_GET['img']);
    $file->deleteFile();

    if ($file->error == false) {
        $db->generateSessionAlertSuccess('Image deleted.');
        $db->commit_transaction();
    } else {
        $db->generateSessionAlertError($file->errorDescription);
        $db->rollback_transaction();
    }

    header("Location: event_images.php?lid=" . $_GET['lid']);
    exit();
}

$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-2');

$db->enable_jquery_ui();
$db->show_empty_header();
FormBuilder::buildPageLoader();
?>

    <div class="container-fluid">
        <form target="" method="post" enctype="multipart/form-data">

            <div class="row">
                <?php
                $formB->setFieldName('fld_title')
                    ->setFieldDescription('Title')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->buildLabel();
                ?>
                <div class="col-sm-4">
                    <?php
                    $formB->buildInput();
                    ?>
                </div>

                <?php
                $formB->setFieldName('fld_alt_name')
                    ->setFieldDescription('Alt Name')
                    ->setFieldType('input')
                    ->setFieldInputType('text')
                    ->buildLabel();
                ?>
                <div class="col-sm-4">
                    <?php
                    $formB->buildInput();
                    ?>
                </div>
            </div>

            <div class="row">


                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imageFile" name="imageFile">
                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Upload</button>
                    </div>
                </div>
                <input type="hidden" id="action" name="action" value="upload">
                <input type="hidden" id="lid" name="lid" value="<?php echo $_GET['lid']; ?>">


            </div>

        </form>
    </div>

    <div class="container-fluid">
        <?php
        $sql = 'SELECT * FROM _files WHERE
                fle_addon = "EventsEvent"
                AND fle_addon_ID = ' . $_GET['lid'] . " ORDER BY fle_primary DESC, fle_order ASC";
        $result = $db->query($sql);
        $totalRows = $db->num_rows($result);
        $i = 0;
        while ($row = $db->fetch_assoc($result)) {
            $i++;

            if ($i % 2 == 1) {
                ?>

                <div class="row">

            <?php } ?>
            <div class="col-sm-6">
                <div class="card">
                    <img class="card-img-top"
                         src="<?php echo $main['site_url'] . "/" . $row['fle_file_location'] . "/" . $row['fle_file_name'] ?>"
                         alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">
                            <?php if ($row['fle_primary'] == 1) { ?>
                                <i class="fas fa-star"></i>
                            <?php } else { ?>
                                <a href="event_images.php?lid=<?php echo $_GET['lid']; ?>&img=<?php echo $row['fle_file_ID']; ?>&action=makePrimary">
                                    <i class="far fa-star"></i>
                                </a>
                            <?php } if ($i > 1) { ?>
                                <a href="event_images.php?lid=<?php echo $_GET['lid']; ?>&img=<?php echo $row['fle_file_ID']; ?>&action=up">
                                    <i class="fas fa-arrow-up"></i>
                                </a>
                            <?php }
                            if ($i < $totalRows && $row['fle_primary'] != 1) { ?>
                                <a href="event_images.php?lid=<?php echo $_GET['lid']; ?>&img=<?php echo $row['fle_file_ID']; ?>&action=down">
                                    <i class="fas fa-arrow-down"></i>
                                </a>
                            <?php } ?>
                            <a href="event_images.php?lid=<?php echo $_GET['lid']; ?>&img=<?php echo $row['fle_file_ID']; ?>&action=delete"
                               onclick="return confirm('Are you sure you want to delete this image?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="event_image_modify.php?lid=<?php echo $_GET['lid']; ?>&img=<?php echo $row['fle_file_ID']; ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                            <br>
                            <strong>Title:</strong><?php echo $row['fle_title'];?><br>
                            <strong>Alt.Name:</strong><?php echo $row['fle_alt_name'];?><br>



                        </p>
                    </div>
                </div>
            </div>
            <?php if ($i % 2 != 1 || $totalRows == $i) { ?>
                </div>
            <?php }
        } ?>

    </div>

<?php
$db->show_empty_footer();
?>