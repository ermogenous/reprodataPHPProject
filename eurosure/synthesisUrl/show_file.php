<?php
include("../../include/main.php");
$db = new Main();


//$db->show_header();

$contents = file_get_contents($_GET['file']);
$info = pathinfo($_GET['file']);
if ($info['extension'] == 'jpg') {
    echo '<img src="data:image/jpeg;base64, ' . base64_encode($contents) . '">';
}
else {
    $db->export_file_for_download($contents,$info['basename']);
}
//shell_exec('cd M:/CLAIMS/EUROSURE%20ASSIST');
//shell_exec('start .');
//$db->show_footer();
