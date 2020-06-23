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
$db->start_transaction();
    //find the last import batch
    $sql = 'select essesid_import_batch from es_soeasy_import_data ORDER BY essesid_import_batch desc LIMIT 1';
    $res = $db->query_fetch($sql);
    $batchNumber = $res['essesid_import_batch'];
    if ($batchNumber == ''){
        $batchNumber = 0;
    }
    $batchNumber++;

    @$handle = fopen($_FILES['importFile']['tmp_name'],"r");
    if ($handle) {
        $lineNum = 0;
        $totalExists = 0;
        $totalCreated = 0;
        $htmlOutput = "<div class='container'>";
        while (($line = fgets($handle)) !== false) {
            $lineNum++;
            //remove any " that exists
            $line = str_replace('"','',$line);
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
                        essesid_validation_status = '',
                        essesid_import_batch = ".$batchNumber.", ".PHP_EOL;
                foreach($fields as $field){
                    $fieldNum++;
                    if (strlen($fieldNames[$fieldNum]) > 2){

                        //the below fields should always be capitals
                        if ($fieldNames[$fieldNum] == 'MOT_Registration_Number'
                            || $fieldNames[$fieldNum] == 'Client_ID_Company_Registration'
                            || $fieldNames[$fieldNum] == 'Policy_Number'
                            || $fieldNames[$fieldNum] == 'Policy_Plan_Code'
                            || $fieldNames[$fieldNum] == 'Policy_Cover_Note_Number'
                            || $fieldNames[$fieldNum] == 'Policy_Certificate_Number'){
                            /*if (preg_match('/[^ a-zA-Z0-9.\-&]+/', $field))
                            {
                                echo "Iligal character found in ".$fieldNames[$fieldNum]." = ".$field;
                                exit();
                            }*/
                            $field = strtoupper($field);
                        }

                        //no spaces in client ID
                        if ($fieldNames[$fieldNum] == 'Client_ID_Company_Registration'){
                            $field = str_replace(' ','',$field);
                        }

                        $sql .= $fieldNames[$fieldNum] .' = "'.$field.'"'.PHP_EOL.',';
                    }

                }
                //echo $sql."\n\n\n\n<br><br><br>";
                $htmlOutput .= "<div class='row'><div class='col-10 alert alert-primary'>Line:".$lineNum." Pol:".$fields[22]." Start Date:".$fields[23]." Expiry:".$fields[25]."</div>";
                $sql = $db->remove_last_char($sql);
                //check if the line has the proper fields. check policy number/starting/expiry
                if ($fields[22] == '' || $fields[23] == '' || $fields[25] == ''){
                    //check if not the last line which is completely empty
                    echo "Length".count($fields)."<br>";
                    echo "Line:".$lineNum."<br>";
                    echo "Policy:".$fields[22]."<br>";
                    echo "Starting:".$fields[23]."<br>";
                    echo "Expiry:".$fields[25]."<br>";
                    echo "Found one or more lines that are incorrect. The whole process has been rollback. Fix the file and try again";
                    $db->rollback_transaction();
                    exit();
                }



                //check if the policy already exists in db
                $sqlCheck = 'SELECT COUNT(*)as clo_total FROM es_soeasy_import_data WHERE
                        Policy_Number = "'.$fields[22].'"
                        AND Policy_Start_Date = "'.$fields[23].'"
                        AND Policy_Expiry_Date = "'.$fields[25].'"
                        AND Client_ID_Company_Registration = "'.$fields[1].'"
                        AND MOT_Registration_Number = "'.$fields[58].'"
                        AND Policy_Refund = "'.$fields[19].'"';
                //echo $sqlCheck.PHP_EOL.PHP_EOL;
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
        $db->commit_transaction();
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
?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <a href="validate_records.php">Validate Records</a>
        </div>
    </div>
</div>
<?php
$db->show_footer();
?>