<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 18/3/2021
 * Time: 11:08 π.μ.
 */

$startTime = microtime(true);
ini_set("memory_limit","2024M");
ini_set('max_execution_time', 1200);

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main();

$sybase = new ODBCCON();

if ($_POST['action'] == 'export') {

    $sql = $_POST['sql'];
    if (mb_stripos($sql, 'INSERT') !== false) {
        echo "Cannot run this sql. Has insert query";
        exit();
    }
    if (mb_stripos($sql, 'UPDATE') !== false) {
        echo "Cannot run this sql. Has update query";
        exit();
    }
    if (mb_stripos($sql, 'DELETE') !== false) {
        echo "Cannot run this sql. Has delete query";
        exit();
    }

    $result = $sybase->query($sql);
    $num = 0;
    $delimiter = '#';
    $lineDelimiter = '@@';
    $exportFile = true;
    $data = '';
    while ($row = $sybase->fetch_assoc($result)) {
        $num++;
        //header record
        if ($num == 1) {
            $line = '';
            //loop in the headers
            foreach ($row as $name => $value) {
                $line .= $name . $delimiter;
            }
            //remove the last char
            $line = $db->remove_last_char($line);
            if ($exportFile){
                $data .= $line.PHP_EOL;
            }
            else {
                echo $line . $lineDelimiter . PHP_EOL;
            }

        }

        $line = '';
        foreach ($row as $name => $value) {
            $line .= $value . $delimiter;
        }
        $line = $db->remove_last_char($line);
        if ($exportFile){
            $data .= $line.PHP_EOL;
        }
        else {
            echo $line . $lineDelimiter . PHP_EOL;
        }

    }
    $db->export_file_for_download($data,'SqlExportedFile.csv');

} else {
    $db->show_header();
    ?>

    <div class="container">
        <div class="row">
            <div class="col alert alert-primary font-weight-bold text-center">Export sql into delimited</div>
        </div>
        <form name="myForm" id="myForm" method="post" action="" onsubmit="">
            <div class="form-group row">
                <div class="col-1">Sql</div>
                <div class="col-11">
                    <textarea id="sql" name="sql" class="form-control" rows="5"></textarea>
                </div>

            </div>
            <div class="form-group row">
                <div class="col-12 text-center">
                    <input type="hidden" id="action" name="action" value="export">
                    <input type="submit" name="Submit" id="Submit" value="Export" class="btn btn-primary"
                           style="width: 150px;">
                </div>
            </div>
        </form>
    </div>

    <?php
    $db->show_footer();
}
?>
