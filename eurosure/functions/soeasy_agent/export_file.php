<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 28/05/2020
 * Time: 13:51
 */

include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "";


if ($_POST['action'] == 'export') {
    $db->start_transaction();
    $error = false;
    $errorDescription = '';
    $batchNumber = 0;

    //first check if no records are pending fixes
    //1. check lapsations
    $sql = "SELECT
            count(*)as clo_total_lapsations
            FROM es_soeasy_import_data 
            WHERE
            (essesid_export_batch = '' || essesid_export_batch is null)
            AND essesid_status = 'VALIDATED'
            AND essesid_validation_status = 'LAPSE'";
    $checkRes1 = $db->query_fetch($sql);
    if ($checkRes1['clo_total_lapsations'] > 0) {
        $error = true;
        $errorDescription = 'Found total ' . $checkRes1['clo_total_lapsations'] . ' policies that need to be lapsed. Fix those first to be able to export';
    }


    if ($error == false) {
        $sql = "
    SELECT * FROM
    es_soeasy_import_data
    WHERE
    essesid_validation_status = 'OK'
    ";
        if ($_POST['batchSelect'] == 'new') {
            $sql .= "
        AND essesid_status = 'VALIDATED'
        AND (essesid_export_batch = '' OR essesid_export_batch is null)
        ";
        } else {
            $sql .= "
        AND essesid_export_batch = " . $_POST['batchSelect'];
            $batchNumber = $_POST['batchSelect'];
        }
        $result = $db->query($sql);

        //echo $sql;exit();


        if ($_POST['batchSelect'] == 'new') {
            //find the last batch export number
            //echo "Find the last export batch";
            $resBatch = $db->query_fetch('SELECT MAX(essesid_export_batch)as clo_max_export_batch FROM es_soeasy_import_data');
            $newBatch = $resBatch['clo_max_export_batch'];
            $newBatch++;
            if ($newBatch == '' || $newBatch == 0) {
                $newBatch = 1;
            }
            $batchNumber = $newBatch;
        }
        $header = 'Client Person/Company|Client I.D/Company Registration|Client Salutation|Client First Name|Client Surname|Client D.O.B|Client Nationality|Client Occupation|Client Address Post Code|Client Address Street Number|Client Address Street Name|Client Address Line 2|Client Address Area|Client Address District|Client Address Country|Client Telephone Home|Client Telephone Work|Client Telephone Mobile|Client Email|Policy Refund|Policy Product Code|Policy Plan Code|Policy Number|Policy Start Date|Policy Start Time|Policy Expiry Date|Policy Transaction Date|Policy Transaction Time|Policy Issue Date|Policy Issue Time|Policy Premium|Policy Stamps|Policy MIF|Policy Cover Note Number|Policy Cover Note Duration|Policy Version|Policy Certificate Number|Policy Related Number|EL Work Place|EL A.M.E|EL Business Use|EL Employees (String delimited)|FMD Name|FMD Surname|FMD ID/Passport|FMD D.O.B.|FMD Occupation|FMD Nationality|FMD Gender|FMD Wages|FMD Address Post Code|FMD Address Street Number|FMD Address Street Name|FMD Address Line 2|FMD Address Area|FMD Address District|FMD Address Country|MOT Cover|MOT Registration Number|MOT CC|MOT Car Type|MOT Body Type|MOT PS / KW Power|MOT Weight|MOT Seats|MOT Convertible|MOT Hard Top|MOT Make|MOT Model|MOT Year Of Manufacture|MOT Imported|MOT Chassis|MOT Steering Position|MOT Value|MOT Excess|MOT Drivers (String delimited)|MOT Premium Analysis (String delimited)|PROPERTY Type of Risk|PROPERTY Type of Property|PROPERTY Class of Risk|PROPERTY Address Post Code|PROPERTY Address Street Number|PROPERTY Address Street Name|PROPERTY Address Line 2|PROPERTY Address Area|PROPERTY Address District|PROPERTY Address Country|PROPERTY Use of Premises|PROPERTY Owner or Tenant|PROPERTY Number of Floors|PROPERTY Type of Construction|PROPERTY Year of Construction|PROPERTY Year of Renovation|PROPERTY Building Value|PROPERTY Auxiliary Buldings Value|PROPERTY Swimming pool Value|PROPERTY Machinery in the open Value|PROPERTY Satellite Dishes Value|PROPERTY Solar Heaters Value|PROPERTY Awnings, pergolas, pavilions|PROPERTY Other Value|PROPERTY Contents Value|PROPERTY Valuables Value|PROPERTY Premium Building|PROPERTY Premium Contents|PROPERTY Premium Valuables|PROPERTY Mortgage|PROPERTY Unoccupied Days|PROPERTY Safety Measures|PROPERTY Endorsements Applicable|';
        $body = '';
        $i = 0;
        while ($row = $db->fetch_assoc($result)) {
            //update the record
            if ($_POST['batchSelect'] == 'new') {
                $updateBatchSql = 'UPDATE es_soeasy_import_data 
                SET essesid_export_batch = ' . $newBatch . '
                ,essesid_status = "EXPORTED"
                WHERE essesid_soeasy_import_data_ID = ' . $row['essesid_soeasy_import_data_ID'];
                $db->query($updateBatchSql);
            }

            //fill the bussiness use on EUEL
            //check if the field EL_AME is not empty then fill the bussiness use if empty
            if ($row['EL_AME'] != '' && $row['EL_Business_Use'] == ''){
                $row['EL_Business_Use'] = 'EMPTY';
            }

            //make MOT CC into integer remove decimals if any
            $row['MOT_CC'] = round($row['MOT_CC'],0);

            //check policy transaction date if empty
            if ($row['Policy_Transaction_Date'] == '' || $row['Policy_Transaction_Date'] == ' '){
                $row['Policy_Transaction_Date'] = $row['Policy_Start_Date'];
            }
            if ($row['Policy_Transaction_Time'] == '' || $row['Policy_Transaction_Time'] == ' '){
                $row['Policy_Transaction_Time'] = $row['Policy_Start_Time'];
            }

            //check if motorcycles and policy product code is empty
            if ($row['Policy_Product_Code'] != '3' && substr($row['Policy_Number'],0,4) == 'MBEU'){
                $row['Policy_Product_Code'] = 3;
            }

            //check for *** MOTOR
            if ($row['MOT_PS_KW_Power'] == '*' || $row['MOT_PS_KW_Power'] == '**' || $row['MOT_PS_KW_Power'] == '***'){
                $row['MOT_PS_KW_Power'] = '';
            }

            //if ()

            $i++;
            $line = $row['Client_Person_Company'] . "|"
                . $row['Client_ID_Company_Registration'] . "|"
                . $row['Client_Salutation'] . "|"
                . $row['Client_First_Name'] . "|"
                . $row['Client_Surname'] . "|"
                . $row['Client_DOB'] . "|"
                . $row['Client_Nationality'] . "|"
                . $row['Client_Occupation'] . "|"
                . $row['Client_Address_Post_Code'] . "|"
                . $row['Client_Address_Street_Number'] . "|"
                . $row['Client_Address_Street_Name'] . "|"
                . $row['Client_Address_Line_2'] . "|"
                . $row['Client_Address_Area'] . "|"
                . $row['Client_Address_District'] . "|"
                . $row['Client_Address_Country'] . "|"
                . $row['Client_Telephone_Home'] . "|"
                . $row['Client_Telephone_Work'] . "|"
                . $row['Client_Telephone_Mobile'] . "|"
                . $row['Client_Email'] . "|"
                . $row['Policy_Refund'] . "|"
                . $row['Policy_Product_Code'] . "|"
                . $row['Policy_Plan_Code'] . "|"
                . $row['Policy_Number'] . "|"
                . $row['Policy_Start_Date'] . "|"
                . $row['Policy_Start_Time'] . "|"
                . $row['Policy_Expiry_Date'] . "|"
                . $row['Policy_Transaction_Date'] . "|"
                . $row['Policy_Transaction_Time'] . "|"
                . $row['Policy_Issue_Date'] . "|"
                . $row['Policy_Issue_Time'] . "|"
                . $row['Policy_Premium'] . "|"
                . $row['Policy_Stamps'] . "|"
                . $row['Policy_MIF'] . "|"
                . $row['Policy_Cover_Note_Number'] . "|"
                . $row['Policy_Cover_Note_Duration'] . "|"
                . $row['Policy_Version'] . "|"
                . $row['Policy_Certificate_Number'] . "|"
                . $row['Policy_Related_Number'] . "|"
                . $row['EL_Work_Place'] . "|"
                . $row['EL_AME'] . "|"
                . $row['EL_Business_Use'] . "|"
                . $row['EL_Employees'] . "|"
                . $row['FMD_Name'] . "|"
                . $row['FMD_Surname'] . "|"
                . $row['FMD_ID_Passport'] . "|"
                . $row['FMD_DOB'] . "|"
                . $row['FMD_Occupation'] . "|"
                . $row['FMD_Nationality'] . "|"
                . $row['FMD_Gender'] . "|"
                . $row['FMD_Wages'] . "|"
                . $row['FMD_Address_Post_Code'] . "|"
                . $row['FMD_Address_Street_Number'] . "|"
                . $row['FMD_Address_Street_Name'] . "|"
                . $row['FMD_Address_Line_2'] . "|"
                . $row['FMD_Address_Area'] . "|"
                . $row['FMD_Address_District'] . "|"
                . $row['FMD_Address_Country'] . "|"
                . $row['MOT_Cover'] . "|"
                . $row['MOT_Registration_Number'] . "|"
                . $row['MOT_CC'] . "|"
                . $row['MOT_Car_Type'] . "|"
                . $row['MOT_Body_Type'] . "|"
                . $row['MOT_PS_KW_Power'] . "|"
                . $row['MOT_Weight'] . "|"
                . $row['MOT_Seats'] . "|"
                . $row['MOT_Convertible'] . "|"
                . $row['MOT_Hard_Top'] . "|"
                . $row['MOT_Make'] . "|"
                . $row['MOT_Model'] . "|"
                . $row['MOT_Year_Of_Manufacture'] . "|"
                . $row['MOT_Imported'] . "|"
                . $row['MOT_Chassis'] . "|"
                . $row['MOT_Steering_Position'] . "|"
                . $row['MOT_Value'] . "|"
                . $row['MOT_Excess'] . "|"
                . $row['MOT_Drivers'] . "|"
                . $row['MOT_Premium_Analysis'] . "|"
                . $row['PROPERTY_Type_of_Risk'] . "|"
                . $row['PROPERTY_Type_of_Property'] . "|"
                . $row['PROPERTY_Class_of_Risk'] . "|"
                . $row['PROPERTY_Address_Post_Code'] . "|"
                . $row['PROPERTY_Address_Street_Number'] . "|"
                . $row['PROPERTY_Address_Street_Name'] . "|"
                . $row['PROPERTY_Address_Line_2'] . "|"
                . $row['PROPERTY_Address_Area'] . "|"
                . $row['PROPERTY_Address_District'] . "|"
                . $row['PROPERTY_Address_Country'] . "|"
                . $row['PROPERTY_Use_of_Premises'] . "|"
                . $row['PROPERTY_Owner_or_Tenant'] . "|"
                . $row['PROPERTY_Number_of_Floors'] . "|"
                . $row['PROPERTY_Type_of_Construction'] . "|"
                . $row['PROPERTY_Year_of_Construction'] . "|"
                . $row['PROPERTY_Year_of_Renovation'] . "|"
                . $row['PROPERTY_Building_Value'] . "|"
                . $row['PROPERTY_Auxiliary_Buldings_Value'] . "|"
                . $row['PROPERTY_Swimming_pool_Value'] . "|"
                . $row['PROPERTY_Machinery_in_the_open_Value'] . "|"
                . $row['PROPERTY_Satellite_Dishes_Value'] . "|"
                . $row['PROPERTY_Solar_Heaters_Value'] . "|"
                . $row['PROPERTY_Awnings_pergolas_pavilions'] . "|"
                . $row['PROPERTY_Other_Value'] . "|"
                . $row['PROPERTY_Contents_Value'] . "|"
                . $row['PROPERTY_Valuables_Value'] . "|"
                . $row['PROPERTY_Premium_Building'] . "|"
                . $row['PROPERTY_Premium_Contents'] . "|"
                . $row['PROPERTY_Premium_Valuables'] . "|"
                . $row['PROPERTY_Mortgage'] . "|"
                . $row['PROPERTY_Unoccupied_Days'] . "|"
                . $row['PROPERTY_Safety_Measures'] . "|"
                . $row['PROPERTY_Endorsements_Applicable'] . "|";
            if ($i > 1) {
                $body .= PHP_EOL;
            }

            $body .= $line;
        }

        if ($i > 0) {
            $db->commit_transaction();
            $db->export_file_for_download($header . PHP_EOL . $body, 'SOEASY_ALL_BATCH_' . $batchNumber . '.txt');
            exit();
        }
        else {
            $db->generateAlertWarning('No records found');
        }
    }
}

$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <b>Export file to use in synthesis import process</b>
            </div>
        </div>
        <form action="" method="post" target="_blank">

            <div class="row form-group">
                <div class="col-4">
                    Batch to export
                </div>
                <div class="col-8">
                    <?php
                    $sql = "SELECT 
                    COUNT(*)as clo_total_records
                    FROM
                    es_soeasy_import_data
                    WHERE
                    essesid_status = 'VALIDATED'
                    AND (essesid_export_batch = '' OR essesid_export_batch is null)
                    AND essesid_validation_status = 'OK'";
                    $totalNonExported = $db->query_fetch($sql);

                    $sql = "
                SELECT
                essesid_export_batch,
                max(essesid_last_update_date_time)as last_update,
                count(*)as clo_total_records
                FROM
                es_soeasy_import_data
                WHERE
                essesid_export_batch > 0
                GROUP BY essesid_export_batch
                ORDER BY essesid_export_batch DESC
                ";
                    $result = $db->query($sql);
                    ?>
                    <select id="batchSelect" name="batchSelect" class="form-control">
                        <option value="new">All non exported [<?php echo $totalNonExported['clo_total_records'];?>]</option>
                        <?php
                        while ($row = $db->fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $row['essesid_export_batch']; ?>">
                                <?php echo $row['essesid_export_batch'] . " Last Update: " . $row['last_update'] . " Total Records: [" . $row['clo_total_records'] . "]"; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="row form-group">
                <div class="col-12 text-center">
                    <input type="hidden" value="export" id="action" name="action">
                    <input type="submit" class="form-control btn btn-primary" value="Export File"
                           style="width: 300px;">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12">
                    Safe File to F:\SynImport <br>
                    C:\SynInSys\synthesi.exe /schedule:FUSINIMP:FUS123456:EUROSURE:BROKERIMPORT
                </div>
            </div>
        </form>
        <?php
        if ($_POST['action'] == 'export' && $error == true) {
            ?>
            <div class="row">
                <div class="col-12 alert alert-danger">
                    <?php echo $errorDescription;?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

<?php
$db->show_footer();
?>
