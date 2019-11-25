<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 25/11/2019
 * Time: 1:09 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
//include("schedules_functions.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "My Schedule Diary";
$db->enable_jquery();
$db->include_js_file('../../scripts/fullcalendar-4.3.1/packages/core/main.js');
$db->include_js_file('../../scripts/fullcalendar-4.3.1/packages/daygrid/main.js');
$db->include_css_file('../../scripts/fullcalendar-4.3.1/packages/core/main.css');
$db->include_css_file('../../scripts/fullcalendar-4.3.1/packages/daygrid/main.css', "media='print'");

$startDate = date('Y-m-d', mktime(0, 0, 0, date('m') - 6, 1, date('Y')));

$db->admin_more_head .= "
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid' ],
          navLinks: true, // can click day/week names to navigate views
          editable: true,
          events: [
                " . generateMyscheduleDataScript($db->user_data['usr_users_ID'], $startDate) . "
            ]
        });

        calendar.render();
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

function generateMyscheduleDataScript($userID, $startDate)
{
    global $db;
    //echo "Here";
    //get the data from db
    $sql = "SELECT * FROM 
            ev_events";
    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data .= "
        {
            id:" . $row['evevt_event_ID'] . ",
            title: '" . $row['evevt_name'] . "',
            start: '" . $row['evevt_starting_date_time'] . "',
            duration: '05:00',
            url: 'event_modify.php?lid=" . $row['evevt_event_ID'] . "'
        },\n";
    }
    $data = $db->remove_last_char($data);
    $data = $db->remove_last_char($data);
    return $data;

}

?>