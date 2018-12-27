<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 12/12/2018
 * Time: 4:21 ΜΜ
 */

include("../include/main.php");
$db = new Main();

$db->admin_title = "Agreements Change Status";

$db->check_restriction_area('extra_1');

$db->working_section = 'Agreements Change Status';

include('tickets_functions.php');


if ($_GET['action'] == 'outstanding'){
    $ticket = new Tickets($_GET['lid']);
    if ($ticket->makeOutstanding() == true) {
        $db->generateSessionAlertSuccess('Ticket Outstanding Successfully');
        header("Location: ticket_status_change.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError('<br>'.$ticket->getErrorDescription());
    }
}
else if ($_GET['action'] == 'pending'){
    $ticket = new Tickets($_GET['lid']);
    if ($ticket->makePending() == true) {
        $db->generateSessionAlertSuccess('Ticket Pending Successfully');
        header("Location: ticket_status_change.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError('<br>'.$ticket->getErrorDescription());
    }

}
else if ($_GET['action'] == 'completed'){
    $ticket = new Tickets($_GET['lid']);
    if ($ticket->makeCompleted() == true) {
        $db->generateSessionAlertSuccess('Ticket Completed Successfully');
        header("Location: ticket_status_change.php?lid=".$_GET['lid']);
        exit();
    }else {
        $db->generateAlertError('<br>'.$ticket->getErrorDescription());
    }
}
else if ($_GET['action'] == 'delete'){

}


if ($_GET['lid'] > 0) {
    $data = $db->query_fetch('
  SELECT * FROM 
  tickets
  JOIN customers ON tck_customer_ID = cst_customer_ID
  WHERE tck_ticket_ID = ' . $_GET['lid']);
} else {
    header("Location: tickets.php");
    exit();
}
//print_r($data);
$db->show_header();
?>

<div class="container">

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">

            <div class="row">
                <div class="col-12 alert alert-primary text-center">Ticket Change Status</div>
            </div>

            <div class="row">
                <div class="col-12">&nbsp;</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                    <div class="row">
                        <div class="col-3 alert alert-info">Number</div>
                        <div class="col-3 alert"><?php echo $data['tck_ticket_number']; ?></div>
                        <div class="col-3 alert alert-info">Status</div>
                        <div class="col-3 alert tck<?php echo $data['tck_status'];?>Color"><?php echo $data['tck_status']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-3 alert alert-info">Customer</div>
                        <div class="col-9 alert"><?php echo $data['cst_name'] . " " . $data['cst_surname'] . " " . $data['cst_identity_card']; ?></div>
                    </div>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">&nbsp;</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="card-text text-center">
                        <button type="button" value="Back" style="width: 140px;" class="btn btn-primary" onclick="goBack();">
                            Back
                        </button>
                        <?php
                        if ($data['tck_status'] == 'Outstanding') {
                            ?>
                            <button type="button" value="Lock" style="width: 140px;" class="btn tckPendingColor" onclick="MakePending();">
                                Make Pending
                            </button>
                            <button type="button" value="Lock" style="width: 140px;" class="btn tckDeletedColor" onclick="MakeDelete();">
                                Delete
                            </button>
                            <?php
                        }
                        if ($data['tck_status'] == 'Pending') {
                            ?>
                            <button type="button" value="UnLock" style="width: 160px;" class="btn tckOutstandingColor" onclick="MakeOutstanding();">
                                Make Outstanding
                            </button>
                            <button type="button" value="UnLock" style="width: 160px;" class="btn tckCompletedColor" onclick="MakeCompleted();">
                                Make Completed
                            </button>
                            <?php
                        }
                        if ($data['tck_status'] == 'Completed') {
                            ?>

                            <?php
                        }
                        if ($data['tck_status'] == 'Deleted') {
                            ?>

                            <?php
                        }
                        ?>
                        <button type="button" value="Modify" style="width: 150px;" class="btn btn-success" onclick="viewTicket();">
                            <?php if ($data['tck_status'] == 'Outstanding') echo 'Modify'; else echo 'View'; ?>
                        </button>
                    </p>
                </div>
            </div>


        </div>

        <div class="col-lg-2"></div>
    </div>
</div>

<script>

    function MakeOutstanding() {
        if (confirm('Are you sure you want to go back to ounstanding?\n This action will update the stock.')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=outstanding');
        }
    }
    function MakePending(){
        if (confirm('Are you sure you want to make Pending? \nThis action will update the stock.')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=pending');
        }
    }
    function MakeCompleted() {
        if (confirm('Are you sure you want to complete this ticket?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=completed');
        }
    }

    function MakeDelete() {
        if (confirm('Are you sure you want to delete this ticket?')){
            window.location.assign('?lid=<?php echo $_GET['lid'];?>&action=delete');
        }
    }

    function viewTicket() {
        window.location.assign('ticket_modify.php?lid=<?php echo $_GET['lid'];?>');
    }

    function goBack() {
        window.location.assign('tickets.php');
    }
</script>
<?php
$db->show_footer();
?>
