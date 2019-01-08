<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 08-Jan-19
 * Time: 11:36 AM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "My Schedule Diary";

$yesterdayButton = 'btn-secondary';
$todayButton = 'btn-secondary';
$tomorrowButton = 'btn-secondary';
$backButton = 'btn-secondary';
$nextButton = 'btn-secondary';
$today = date('Y-m-d');
$yesterday = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$tomorrow = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));


if ($_GET['changeday'] == '') {
    $currentDate = $today;
    $todayButton = 'btn-primary';
} else {
    if ($_GET['changeday'] == 'yesterday') {
        $currentDate = $yesterday;
        $yesterdayButton = 'btn-primary';
    } else if ($_GET['changeday'] == 'today') {
        $currentDate = $today;
        $todayButton = 'btn-primary';
    } else if ($_GET['changeday'] == 'tomorrow') {
        $currentDate = $tomorrow;
        $tomorrowButton = 'btn-primary';
    } else if ($_GET['changeday'] == 'back') {
        $previousDate = $_GET['currentday'];
        $pieces = explode('-', $previousDate);
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $pieces[1], $pieces[2] - 1, $pieces[0]));
    } else if ($_GET['changeday'] == 'next') {
        $previousDate = $_GET['currentday'];
        $pieces = explode('-', $previousDate);
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $pieces[1], $pieces[2] + 1, $pieces[0]));
    }
}
//check the buttons
if ($yesterday == $currentDate) {
    $yesterdayButton = 'btn-primary';
} else if ($today == $currentDate) {
    $todayButton = 'btn-primary';
} else if ($tomorrow == $currentDate) {
    $tomorrowButton = 'btn-primary';
}

//fix the current date format
$currentDatePieces = explode('-', $currentDate);
$currentDateFormat = $currentDatePieces[2] . "/" . $currentDatePieces[1] . "/" . $currentDatePieces[0];

$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-info"><?php echo $currentDateFormat; ?></button>
            <button type="button" class="btn <?php echo $yesterdayButton; ?>" onclick="changeDay('yesterday')">
                Yesterday
            </button>
            <button type="button" class="btn <?php echo $todayButton; ?>" onclick="changeDay('today')">Today</button>
            <button type="button" class="btn <?php echo $tomorrowButton; ?>" onclick="changeDay('tomorrow')">Tomorrow
            </button>
            <button type="button" class="btn <?php echo $backButton; ?>" onclick="changeDay('back')"><<</button>
            <button type="button" class="btn <?php echo $nextButton; ?>" onclick="changeDay('next')">>></button>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="height: 30px"></div>
    </div>


    <?php
    $sql = "SELECT * FROM schedules WHERE sch_user_ID = " . $db->user_data['usr_users_ID'] . " AND sch_schedule_date = '" . $currentDate . "'";
    $result = $db->query($sql);
    while ($schedule = $db->fetch_assoc($result)) {
        ?>
        <div class="row alert alert-dark">
            <div class="col-12 ">Schedule <?php echo $schedule['sch_schedule_number']; ?></div>


        </div>

        <?php
        //Tickets
        $sql = "SELECT * FROM 
                            schedule_ticket 
                            JOIN tickets ON tck_ticket_ID = scht_ticket_ID
                            JOIN customers ON cst_customer_ID = tck_customer_ID
                            LEFT OUTER JOIN codes ON cde_code_ID = cst_city_code_ID
                            
                            WHERE
                            scht_schedule_ID = " . $schedule['sch_schedule_ID'];
        $resultTickets = $db->query($sql);
        while ($ticket = $db->fetch_assoc($resultTickets)) {
            ?>
            <div class="container">
                <div class="row alert alert-secondary">
                    <div class="col-12">
                        <?php echo $ticket['tck_ticket_number']." ".$ticket['cst_name']." ".$ticket['cst_surname']." - ".$ticket['cde_value']." - ".$ticket['cst_address_line_1']." ".$ticket['cst_address_line_2'];?><br>
                    </div>
                </div>

                <?php
                //EVENTS
                $sql = "SELECT * FROM
                        tickets
                        JOIN ticket_events ON tck_ticket_ID = tke_ticket_ID
                        JOIN unique_serials ON uqs_unique_serial_ID = tke_unique_serial_ID
                        JOIN products ON prd_product_ID = uqs_product_ID
                        WHERE tck_ticket_ID = ".$ticket['tck_ticket_ID'];
                $resultEvents = $db->query($sql);
                while ($event = $db->fetch_assoc($resultEvents)) {
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <u><b>
                                Event: <?php echo "[" . $event['tke_ticket_event_ID'] . "] " . $event['tke_type'] . " - " . $event['prd_description']; ?>
                                Incident
                                Date: <?php echo $db->convert_date_format($event['tke_incident_date'], 'yyyy-mm-dd', 'dd/mm/yyyy'); ?>
                                    </b></u>
                            </div>
                        </div>
                    </div>
                    <?php

                    for ($i = 1; $i <= 3; $i++) {
                        if ($i == 1) {
                            $sqlType = 'SparePart';
                            $label = 'Spare Parts';
                        } else if ($i == 2) {
                            $sqlType = 'Consumable';
                            $label = 'Consumable';
                        } else if ($i == 3) {
                            $sqlType = 'Other';
                            $label = 'Other';
                        }
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <u><?php echo $label; ?>:</u>
                                </div>
                            </div>
                            <?php

                            $sql = "SELECT * FROM 
                                ticket_products 
                                JOIN products ON prd_product_ID = tkp_product_ID
                                WHERE tkp_ticket_ID = " . $ticket['tck_ticket_ID'] . " 
                                AND tkp_ticket_event_ID = " . $event['tke_ticket_event_ID'] . "
                                AND tkp_type = '" . $sqlType . "'";
                            //echo $sql;
                            $resultProducts = $db->query($sql);
                            while ($product = $db->fetch_assoc($resultProducts)) {
                                ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12"><i class="fas fa-angle-right"></i>
                                            <?php echo $product['prd_description'] . " X " . $product['tkp_amount']; ?>
                                            <?php
                                            for ($am = 1; $am <= $product['tkp_amount']; $am++) {
                                                ?>
                                                <i class="far fa-square"></i>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }//while products loop
                            ?>
                        </div>
                        <?php
                    }//for loop
                }//while Events
                ?>
            </div>
            <?php
        }//tickets->events

        ?>


    <?php }//schedules ?>
</div>


<script>
    function changeDay(day) {
        window.location.assign('my_schedule_day.php?currentday=<?php echo $currentDate;?>&changeday=' + day);
    }
</script>
<?php
$db->show_footer();
?>

