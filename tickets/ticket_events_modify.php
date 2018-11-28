<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 14/11/2018
 * Time: 3:32 ΜΜ
 */

include("../include/main.php");

$db = new Main();
$db->admin_title = "Tickets events Modify";


$db->show_empty_header();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;Event</b>
                </div>


                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('tickets.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> & Exit"
                               class="btn btn-secondary"
                               onclick="submitForm('exit')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Create"; else echo "Save"; ?> Ticket"
                               class="btn btn-secondary"
                               onclick="submitForm('save')">
                        <input name="subAction" id="subAction" type="hidden" value="">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$db->show_empty_footer();
?>
