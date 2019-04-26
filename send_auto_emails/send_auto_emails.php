<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

/*
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    //$mail->isSMTP();                                      // Set mailer to use SMTP
    //$mail->CharSet="UTF-8";
    //$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    //$mail->SMTPAuth = true;                               // Enable SMTP authentication
    //$mail->Username = 'micacca@gmail.com';                 // SMTP username
    //$mail->Password = 'Kmariou24??';                           // SMTP password
    //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    //$mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('micacca@poutsos.com', 'Mailer');
    $mail->addAddress('ermogenousm@gmail.com', 'Michael Ermogenous');     // Add a recipient
    $mail->addReplyTo('micacca@poutsos.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

$to = 'ermogenousm@gmail.com';
$subject = 'subject';
$body = 'some body';
$headers = 'From: micacca@gmail.com';

if (mail($to, $subject, $body, $headers)){
    echo "Mail sent";
}
else {
    echo 'Error sending mail';
}
*/
include("../include/main.php");
include("../include/tables.php");



$db = new Main(1,'UTF-8');
$db->admin_title = "Send Auto Emails";

$search_sql = '';
if ($_GET["search_action"] == 'search') {
	$_SESSION['send_auto_emails']['search'] = 'search';
	$_SESSION['send_auto_emails']['text'] = $_GET["search_text"];
	$_SESSION['send_auto_emails']['type'] = $_GET["search_type"];
}

if ($_GET["search_action"] == 'clear') {
	$_SESSION['send_auto_emails']['search'] = '';
	$_SESSION['send_auto_emails']['text'] = '';
	$_SESSION['send_auto_emails']['type'] = '';
}

if ($_SESSION['send_auto_emails']['search'] == 'search') {
	$search_sql = $_SESSION['send_auto_emails']['type']." LIKE '%".addslashes($_SESSION['send_auto_emails']['text'])."%'";
	//echo $search_sql;
}


$table = new draw_table('send_auto_emails','sae_send_auto_emails_serial','DESC');
$table->extras = $search_sql;
$table->generate_data();

$db->show_header();
$table->show_pages_links();
?>
<script>
function clear_search() {
	document.getElementById('search_action').value = 'clear';
	document.getElementById('search_form').submit();
}
</script>

<form action="" method="get" id="search_form" name="search_form">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <input name="search_text" type="text" id="search_text" size="50"
                       class="form-control"
                       value="<?php echo $_GET["search_text"];?>" />
            </div>
            <div class="col-3">
                <select name="search_type" id="search_type" class="form-control">
                    <option value="sae_label2" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_label2') echo 'selected="selected"';?>>Policy Numbers</option>
                    <option value="sae_email_to" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_email_to') echo 'selected="selected"';?>>Email to</option>
                    <option value="sae_email_to_name" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_email_to_name') echo 'selected="selected"';?>>Email to Name</option>
                    <option value="sae_email_subject" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_email_subject') echo 'selected="selected"';?>>Email Subject</option>
                    <option value="sae_agent_code" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_agent_code') echo 'selected="selected"';?>>Agent Code</option>
                    <option value="sae_email_body" <?php if ($_SESSION["send_auto_emails"]["type"] == 'sae_email_body') echo 'selected="selected"';?>>Email Body</option>
                </select>
            </div>
            <div class="col-2">
                <input type="submit" name="button" id="button" value="Search" class="form-control btn btn-primary" />
                <input name="search_action" type="hidden" id="search_action" value="search" />
            </div>
            <div class="col-1">
                <input type="button" name="button2" id="button2" value="Clear" onclick="clear_search();"
                class="form-control btn btn-primary"/>
            </div>
        </div>
    </div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">


      </td>
    </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>

</form>
<br />





<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover" id="myTableList">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'sae_send_auto_emails_serial'); ?></th>
                        <th scope="col" width="12%"><?php $table->display_order_links('Type', 'sae_type'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Active', 'sae_active'); ?></th>
                        <th scope="col" width="20%"><?php $table->display_order_links('Send Date/Time', 'sae_send_datetime'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Result', 'sae_send_result'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Email', 'sae_email_to'); ?></th>
                        <th scope="col" class="text-center" width="12%">
                            <a href="policy_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row["sae_send_auto_emails_serial"]; ?></th>
                            <td><?php echo $row["sae_type"]; ?></td>
                            <td><?php echo $row["sae_active"]; ?></td>
                            <td><?php echo $row["sae_send_datetime"]; ?></td>
                            <td><?php echo $row["sae_send_result"]; ?></td>
                            <td><?php echo $row["sae_email_to"]; ?></td>
                            <td>
                                <a href="send_auto_emails_modify.php?lid=<?php echo $row["sae_send_auto_emails_serial"];?>">Modify</a>
                                <a href="send_auto_emails_send.php?lid=<?php echo $row['sae_send_auto_emails_serial']; ?>" target="_blank">Send</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('policy_modify.php?lid=' + id);
        }
        ignoreEdit = false;
    }

    $(document).ready(function() {
        $('#myTableList tr').click(function() {
            var href = $(this).find('input[id=myLineID]').val();
            if(href) {
                editLine(href);
            }
        });
    });
</script>


<div align="center"><a href="send_auto_email_execute_all.php" target="_blank">Execute all pending emails</a></div>
<?php
$db->show_footer();
?>
