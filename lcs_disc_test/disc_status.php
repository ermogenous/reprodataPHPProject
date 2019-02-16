<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/2/2019
 * Time: 10:04 ΠΜ
 */

include("../include/main.php");
include('questions_list.php');
include('disc_class.php');
include('email_layout.php');


$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test List";

if ($_GET['lid'] == '' || is_numeric($_GET['lid']) == false) {
    header("Location: disc_list.php");
    exit();
}

if ($_GET['action'] == 'outstanding') {
    $test = new DiscTest($_GET['lid']);
    if ($test->statusToOutstanding()) {
        $db->generateSessionAlertSuccess('Status changed successfully to Outstanding');
    } else {
        $db->generateSessionAlertError($test->errorDescription);
    }
    header("Location: disc_status.php?lid=" . $_GET['lid']);
    exit();
} else if ($_GET['action'] == 'link') {
    $test = new DiscTest($_GET['lid']);
    if ($test->statusToLink()) {
        $db->generateSessionAlertSuccess('Status changed successfully to Link');
    } else {
        $db->generateSessionAlertError($test->errorDescription);
    }
    header("Location: disc_status.php?lid=" . $_GET['lid']);
    exit();
} else if ($_GET['action'] == 'completed') {
    $test = new DiscTest($_GET['lid']);
    if ($test->statusToCompleted()) {
        $db->generateSessionAlertSuccess('Status changed successfully to Completed');
    } else {
        $db->generateSessionAlertError($test->errorDescription);
    }
    header("Location: disc_status.php?lid=" . $_GET['lid']);
    exit();
} else if ($_GET['action'] == 'paid') {
    $test = new DiscTest($_GET['lid']);
    if ($test->statusToPaid()) {
        $db->generateSessionAlertSuccess('Status changed successfully to Paid');
    } else {
        $db->generateSessionAlertError($test->errorDescription);
    }
    header("Location: disc_status.php?lid=" . $_GET['lid']);
    exit();
} else if ($_GET['action'] == 'delete') {
    $test = new DiscTest($_GET['lid']);
    if ($test->deleteTest()) {
        $db->generateSessionAlertSuccess('Test successfully Deleted');
    } else {
        $db->generateSessionAlertError($test->errorDescription);
    }
    header("Location: disc_status.php?lid=" . $_GET['lid']);
    exit();
}

$db->show_header();

$data = $db->query_fetch('SELECT * FROM lcs_intro_extro_test WHERE ietst_intro_extro_test_ID = ' . $_GET['lid']);
$tstResult = getDiSCResults($data);


if ($_GET['action'] == 'sendLinkEmail') {
    echo "Sending email";

    $db->sendMailTo('Me@gmail.com', 'LCS EQ', 'micacca@gmail.com', 'Fill the form', getEmailLayoutFillTest($data));

}


?>

    <div class="container">

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">

                <div class="row">
                    <div class="col-12 alert alert-primary text-center">Test Results & Functions</div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                        <div class="row">
                            <div class="col-2 alert alert-info">Όνομα</div>
                            <div class="col-4 alert"><?php echo $data['ietst_name']; ?></div>
                            <div class="col-2 alert alert-info">Κατάσταση</div>
                            <div class="col-4 alert"><?php echo $data['ietst_status']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-2 alert alert-info">Email</div>
                            <div class="col-4 alert"><?php echo $data['ietst_email']; ?></div>
                            <div class="col-2 alert alert-info">Τηλ.</div>
                            <div class="col-4 alert"><?php echo $data['ietst_tel']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-3 alert alert-info">Υψηλη Κυριαρχία</div>
                            <div class="col-3 alert"><?php echo $tstResult['HighDominance'] . " [" . $tstResult['HighDominance-per'] . "%]"; ?></div>
                            <div class="col-3 alert alert-info">Υψηλή Κοινωνικότητα</div>
                            <div class="col-3 alert"><?php echo $tstResult['HighSocial'] . " [" . $tstResult['HighSocial-per'] . "%]"; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['HighDominance-per']; ?>%"
                                         aria-valuenow="<?php echo $tstResult['HighDominance-per']; ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br>
                            </div>
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['HighSocial-per']; ?>%"
                                         aria-valuenow="<?php echo $tstResult['HighSocial-per']; ?>" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 alert alert-info">Χαμηλή Κυριαρχία</div>
                            <div class="col-3 alert"><?php echo $tstResult['LowDominance'] . " [" . $tstResult['LowDominance-per'] . "%]"; ?></div>
                            <div class="col-3 alert alert-info">Χαμηλή Κοινωνικότητα</div>
                            <div class="col-3 alert"><?php echo $tstResult['LowSocial'] . " [" . $tstResult['LowSocial-per'] . "%]"; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['LowDominance-per']; ?>%"
                                         aria-valuenow="<?php echo $tstResult['LowDominance-per']; ?>" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <br>
                            </div>
                            <div class="col-6">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $tstResult['LowSocial-per']; ?>%"
                                         aria-valuenow="<?php echo $tstResult['LowSocial-per']; ?>" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <?php if ($data['ietst_status'] == 'Link') { ?>

                    <div class="row">
                        <div class="col-2 alert alert-info">
                            <label for="fld_email" class="col-sm-3 col-form-label text-right">Email</label>
                        </div>
                        <div class="col-4 alert">
                            <input name="fld_email" type="text" id="fld_email"
                                   class="form-control"
                                   value="<?php echo $data["ietst_email"]; ?>">
                        </div>
                        <div class="col-2 alert">
                            <button type="button" class="form-controm btn btn-primary" onclick="viewLinkEmail();">View
                                Link Email
                            </button>
                        </div>
                        <div class="col-4 alert"></div>
                    </div>

                    <?php if ($_GET['action'] == 'viewLinkEmail') { ?>
                        <div class="row">
                            <div class="col-12"><?php echo getEmailLayoutFillTest($data); ?><br><br></div>
                        </div>

                        <div class="row">
                            <div class="col-5"></div>
                            <div class="col-3">
                                <button type="button" class="btn btn-primary" onclick="sendLinkEmail();">Send Link
                                    Email
                                </button>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>
                <?php } ?>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center">
                            <button type="button" value="Back" style="width: 140px;" class="btn btn-primary"
                                    onclick="goBack();">
                                Back
                            </button>
                            <?php
                            if ($data['ietst_status'] == 'Link') {
                                ?>
                                <button type="button" value="Activate" style="width: 140px;"
                                        class="btn <?php echo getTestColor('Outstanding'); ?>"
                                        onclick="makeOutstanding();">
                                    Outstanding
                                </button>
                                <?php
                            }
                            if ($data['ietst_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Delete" style="width: 140px;"
                                        class="btn <?php echo getTestColor('Link'); ?>"
                                        onclick="makeLink();">
                                    Link
                                </button>
                                <?php
                            }
                            if ($data['ietst_status'] == 'Outstanding' || $data['agr_status'] == 'Link') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;"
                                        class="btn <?php echo getTestColor('Completed'); ?>"
                                        onclick="makeCompleted();">
                                    Completed
                                </button>
                                <?php
                            }
                            if ($data['ietst_status'] == 'Completed') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;"
                                        class="btn <?php echo getTestColor('Paid'); ?>"
                                        onclick="makePaid();">
                                    Paid
                                </button>
                                <?php
                            }
                            if ($data['ietst_status'] == 'Outstanding') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;"
                                        class="btn <?php echo getTestColor('Deleted'); ?>"
                                        onclick="makeDelete();">
                                    Delete
                                </button>
                                <?php
                            }
                            if ($data['ietst_status'] == 'Completed' || $data['ietst_status'] == 'Paid') {
                                ?>
                                <button type="button" value="Cancel" style="width: 150px;" class="btn bgGoldColor"
                                        onclick="viewEmail();">
                                    View Email
                                </button>
                                <?php
                            }
                            ?>
                            <button type="button" value="Modify" style="width: 150px;" class="btn btn-success"
                                    onclick="modifyTest();">
                                <?php if ($data['ietst_status'] == 'Pending') echo 'Modify'; else echo 'View'; ?>
                            </button>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-lg-1"></div>
        </div>
    </div>
    <script>
        function makeOutstanding() {
            if (confirm('Are you sure you want to change the status to Outstanding?')) {
                window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=outstanding');
            }
        }

        function makeLink() {
            if (confirm('Are you sure you want to change the status to Link?')) {
                window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=link');
            }
        }

        function makeCompleted() {
            if (confirm('Are you sure you want to change the status to Completed?')) {
                window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=completed');
            }
        }

        function makePaid() {
            if (confirm('Are you sure you want to change the status to Paid?')) {
                window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=paid');
            }
        }

        function makeDelete() {
            if (confirm('Are you sure you want to Delete this test??')) {
                window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=delete');
            }
        }

        function modifyTest() {
            window.location.assign('disc_modify.php?lid=<?php echo $_GET['lid'];?>');
        }

        function viewEmail() {
            window.open('view_email_html.php?lid=<?php echo $_GET['lid'];?>&lg=tr');
        }

        function viewLinkEmail() {
            window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=viewLinkEmail');
        }

        function sendLinkEmail() {
            window.location.assign('disc_status.php?lid=<?php echo $_GET['lid'];?>&action=sendLinkEmail');
        }

        function goBack() {
            window.location.assign('disc_list.php');
        }
    </script>
<?php
$db->show_footer();
?>