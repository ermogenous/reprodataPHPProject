<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 07-Jan-19
 * Time: 13:11 PM
 */

include("../include/main.php");
include("../include/tables.php");
include("schedules_functions.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "My Schedule Diary";
$db->enable_jquery();
$db->include_js_file('../scripts/fullcalendar-3.9.0/lib/moment.min.js');
$db->include_js_file('../scripts/fullcalendar-3.9.0/fullcalendar.min.js');
$db->include_css_file('../scripts/fullcalendar-3.9.0/fullcalendar.min.css');
$db->include_css_file('../scripts/fullcalendar-3.9.0/fullcalendar.print.min.css',"media='print'");

$startDate = date('Y-m-d',mktime(0,0,0,date('m')-6,1,date('Y')));

$db->admin_more_head .= "
<script>

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            //defaultDate: '2018-03-12',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow \"more\" link when too many events
            events: [
                ".generateMyscheduleDataScript($db->user_data['usr_users_ID'], $startDate)."
            ]
        });

    });

</script>
<style>

    body {
        margin: 0px 10px;
        padding: 0;
        font-family: \"Lucida Grande\",Helvetica,Arial,Verdana,sans-serif;
        font-size: 14px;
    }

    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }

</style>
";

//echo generateMyscheduleDataScript($db->user_data['usr_users_ID'],'2018-01-01');

$db->show_header();
?>


<div id='calendar'></div>

<?php
$db->show_footer();
?>