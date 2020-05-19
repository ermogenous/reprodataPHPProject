<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 14/05/2020
 * Time: 14:05
 */

include("../../../include/main.php");
include("soeasy_functions.php");

$db = new Main(1);
$db->admin_title = "Eurosure Function soeasy agent import file";

if ($_POST['action'] == 'upload'){
    @$handle = fopen($_FILES['importFile']['tmp_name'],"r");
    if ($handle) {
        $lineNum = 0;
        $totalExists = 0;
        $totalCreated = 0;
        $htmlOutput = "<div class='container'>";
        while (($line = fgets($handle)) !== false) {
            $lineNum++;
            $fields = explode("|",$line);
            $fieldNum=0;
            //if first row then column names
            if ($lineNum == 1){
                foreach($fields as $field){
                    $fieldNum++;
                    //echo $field;
                    $fixed = fix_field_name($field);
                    $fieldNames[$fieldNum] = $fixed;
                }
            }
            else {
                $sql = "INSERT INTO es_soeasy_import_data SET 
                        essesid_status = 'IMPORT',
                        essesid_process_status = 'NEED_VALIDATION', ".PHP_EOL;
                foreach($fields as $field){
                    $fieldNum++;
                    if (strlen($fieldNames[$fieldNum]) > 2){
                        $sql .= $fieldNames[$fieldNum] .' = "'.$field.'"'.PHP_EOL.',';
                    }

                }
                $htmlOutput .= "<div class='row'><div class='col-10 alert alert-primary'>Line:".$lineNum." Pol:".$fields[22]." Start Date:".$fields[23]." Expiry:".$fields[25]."</div>";
                $sql = $db->remove_last_char($sql);
                //check if the policy already exists in db
                $sqlCheck = 'SELECT COUNT(*)as clo_total FROM es_soeasy_import_data WHERE
                        Policy_Number = "'.$fields[22].'"
                        AND Policy_Start_Date = "'.$fields[23].'"
                        AND Policy_Expiry_Date = "'.$fields[25].'"
                        AND Client_ID_Company_Registration = "'.$fields[1].'"
                        AND MOT_Registration_Number = "'.$fields[58].'"';
                $checkResult = $db->query_fetch($sqlCheck);
                if ($checkResult['clo_total'] > 0){
                    $htmlOutput .= "<div class='col-2 alert alert-danger'>EXISTS</div></div>";
                    $totalExists++;
                }
                else {
                    $htmlOutput .= "<div class='col-2 alert alert-success'>NEW CREATE</div></div>";
                    $totalCreated++;
                    $db->query($sql);
                }
                if ($lineNum >= 2){
                    //break;
                }
            }

        }
        $htmlOutput .= "</div>";
        fclose($handle);
    } else {
        $db->generateAlertError('Error reading the file');
    }
}

$db->show_header();
?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-12 alert alert-primary">
                    Import SoEasy file
                </div>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="hidden" id="action" name="action" value="upload">
                    <input type="file" class="custom-file-input" id="importFile" name="importFile">
                    <label class="custom-file-label" for="importFile">Choose file</label>
                </div>
            </div>
            <div class="row form-group">
                <input type="submit" class="btn btn-primary form-control" value="Upload">
            </div>
        </div>
    </form>
<?php
if ($_POST['action'] == 'upload'){
    echo $htmlOutput;
    ?>
    <div class="row">
        <div class="col-12 alert alert-primary">
            Total Existed: <?php echo $totalExists;?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 alert alert-primary">
            Total Created: <?php echo $totalCreated;?>
        </div>
    </div>
<?php
}
$db->show_footer();
?>