<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/2/2019
 * Time: 10:04 ΠΜ
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

if ($_GET['action'] == 'completed') {
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
    if ($test->processStatusToPaid()) {
        $db->generateSessionAlertSuccess('Process Status changed successfully to Paid');
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

$disc = new DiscTest($_GET['lid']);
$data = $disc->data;
$tstResult = $disc->getTestResults();

$disc->clearImages();

if ($data['lcsdc_status'] == 'Completed') {
    $pieImage = $disc->getPieImageData('embed');
}


if ($_GET['action'] == 'sendLinkEmail') {

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        /*
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'apikey';                 // SMTP username
        $mail->Password = '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';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        */


        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'agentscyprus@gmail.com';                 // SMTP username
        $mail->Password = 'cqlnjxaqbnhruwjt';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;


        //Recipients
        $mail->setFrom('info@lcsapproach.com', 'www.lcsapproach.com');
        $mail->addAddress($disc->data['lcsdc_email'], $disc->data['lcsdc_name']);     // Add a recipient
        $mail->addReplyTo('info@lcsapproach.com', 'www.lcsapproach.com');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //$mail->addEmbeddedImage('../layout/lcs_eq/images/disc_model.jpg','discmodel','discmodel.jpg');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Tέστ προσωπικότητας (DISC) - ' . $disc->data['lcsdc_name'];
        $mail->Body = getEmailLayoutFillTest($disc->data);
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $db->generateAlertSuccess('Email has been sent');
        $mailSend = true;
    } catch (Exception $e) {
        $db->generateAlertError('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
    }

}
$db->show_header();

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
                            <div class="col-4 alert"><?php echo $data['lcsdc_name']; ?></div>
                            <div class="col-2 alert alert-info">Κατάσταση</div>
                            <div class="col-4 alert"><?php echo $data['lcsdc_status'] . " - " . $data['lcsdc_process_status']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-2 alert alert-info">Email</div>
                            <div class="col-4 alert"><?php echo $data['lcsdc_email']; ?></div>
                            <div class="col-2 alert alert-info">Τηλ.</div>
                            <div class="col-4 alert"><?php echo $data['lcsdc_tel']; ?></div>
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
                    <div class="col-12">
                        <?php if ($data['lcsdc_status'] == 'Completed') { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($pieImage); ?>"/>
                        <?php } ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">&nbsp;</div>
                </div>

                <?php if ($data['lcsdc_status'] == 'Outstanding') { ?>
                    <div class="row">
                        <div class="col-2 alert alert-info">
                            <label for="fld_email" class="col-sm-3 col-form-label text-right">Email</label>
                        </div>
                        <div class="col-4 alert">
                            <?php
                            echo $data["lcsdc_email"];
                            ?>
                        </div>
                        <div class="col-2 alert">
                            <?php

                            if (filter_var($data["lcsdc_email"], FILTER_VALIDATE_EMAIL)) {
                                //valid email
                                ?>
                                <button type="button" class="form-controm btn btn-primary" onclick="viewLinkEmail();">
                                    View
                                    Link Email
                                </button>
                                <?php
                            } else {
                                //invalid email
                                echo "Invalid Email";
                            }

                            ?>

                        </div>
                        <div class="col-4 alert"></div>
                    </div>
                <?php } ?>

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

                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center">
                        <div class="row">
                            <div class="col-12 text-center">
                                <?php
                                if ($data['lcsdc_status'] == 'Outstanding') {
                                    ?>
                                    <button type="button" value="Cancel" style="width: 150px;"
                                            class="btn <?php echo getTestColor('Completed'); ?>"
                                            onclick="makeCompleted();">
                                        Completed
                                    </button>
                                    <?php
                                }
                                if ($data['lcsdc_status'] == 'Completed' && $data['lcsdc_process_status'] == 'UnPaid') {
                                    ?>
                                    <button type="button" value="Cancel" style="width: 150px;" class="btn bgGoldColor"
                                            onclick="makePaid();">
                                        Paid
                                    </button>
                                    <?php
                                }
                                if ($data['lcsdc_status'] == 'Outstanding') {
                                    ?>
                                    <button type="button" value="Cancel" style="width: 150px;"
                                            class="btn <?php echo getTestColor('Deleted'); ?>"
                                            onclick="makeDelete();">
                                        Delete
                                    </button>
                                    <?php
                                }

                                if ($data['lcsdc_status'] == 'Completed') {
                                    ?>
                                    <button type="button" value="SendEmail" style="width: 150px;"
                                            class="btn btn-success"
                                            onclick="sendEmail();">
                                        Send Email
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="height: 15px"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="button" value="Back" style="width: 140px;" class="btn btn-primary"
                                        onclick="goBack();">
                                    Back
                                </button>
                                <button type="button" value="Modify" style="width: 150px;" class="btn btn-success"
                                        onclick="modifyTest();">
                                    <?php if ($data['lcsdc_status'] == 'Pending') echo 'Modify'; else echo 'View'; ?>
                                </button>
                            </div>
                        </div>
                        </p>
                    </div>
                </div>


            </div>

            <div class="col-lg-1"></div>
        </div>
    </div>
    <script>

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
            window.location.assign('disc_modify.php?lid=<?php echo $_GET['lid'];?>&lg=tr');
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

        function sendEmail() {
            window.open('view_email_html.php?lid=<?php echo $_GET['lid'];?>', '_blank');
        }
    </script>
<?php
$db->show_footer();
?>