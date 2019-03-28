<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 8:45 ΜΜ
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("../include/main.php");
include_once('disc_class.php');
include_once('email_layout.php');

if ($_GET['lid'] == ''){
    header("Location: disc_list.php");
    exit();
}

$db = new Main(1, 'UTF-8');
$db->admin_title = "LCS DiSC Test List";
$disc = new DiscTest($_GET['lid']);
$layout = getEmailLayoutResult($_GET['lid']);
$layoutHtml = getEmailLayoutResult($_GET['lid'],'path');

if ($disc->data['lcsdc_status'] != 'Completed'){
    header("Location: disc_list.php");
    exit();
}


if ($_POST['action'] == 'sendMail'){

//Load Composer's autoloader
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        $mail->CharSet = 'UTF-8';
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'user@example.com';                 // SMTP username
        //$mail->Password = 'secret';                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to


        //google test
        //$mail->IsSMTP(); // enable SMTP

        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only



        //Recipients
        $mail->setFrom('no-reply@lcsapproach.com', 'www.lcsapproach.com');
        $mail->addAddress($disc->data['lcsdc_email'], $disc->data['lcsdc_name']);     // Add a recipient
        $mail->addReplyTo('no-reply@lcsapproach.com', 'www.lcsapproach.com');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->addEmbeddedImage('../layout/lcs_eq/images/disc_model.jpg','discmodel','discmodel.jpg');
        $mail->addEmbeddedImage('../layout/lcs_eq/images/circle_model.jpg','circlemodel','circlemodel.jpg');
        $mail->addEmbeddedImage('../layout/lcs_eq/images/lcs_footer_logo.png','lcsfooterlogo','lcs_footer_logo.png');
        $pieImagePath = $disc->getPieImageData();

        $mail->addEmbeddedImage($pieImagePath,'testpie','testpie.jpg');

        //attach pdf
        $pdfFilePath = $disc->getPdf('GetFilePath');
        $mail->addAttachment($pdfFilePath);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Tέστ προσωπικότητας (DISC) - '.$disc->data['lcsdc_name'];
        $mail->Body    = $layout;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $db->generateAlertSuccess('Email has been sent');
        $mailSend = true;
    } catch (Exception $e) {
        $db->generateAlertError('Message could not be sent. Mailer Error: '. $mail->ErrorInfo);
    }

    unlink($pieImagePath);

}


$db->show_header();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <form name="myForm" id="myForm" method="post" action="" onsubmit="">

                <?php if ($mailSend != true) { ?>
                <input type="hidden" value="sendMail" id="action" name="action">
                <button class="btn btn-primary" type="button" onclick="sendEmail();" value="Send Email">Send Email To: <?php echo $disc->data['lcsdc_email'];?></button>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<br>
<?php
echo $layoutHtml;
?>

<script>
    function sendEmail(){
        if (confirm('Are you sure you want to send the email?')){
            $('#myForm').submit();
        }
    }
</script>

<?php
$db->show_footer();
?>