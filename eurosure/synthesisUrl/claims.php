<?php

include("../../include/main.php");
include("../lib/odbccon.php");
include("../../scripts/form_validator_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/meBuildDataTable.php");
$db = new Main();

$sybase = new ODBCCON();
$claimData = '';
$data = findClaimFolder();
$subFolders = [];

$db->enable_jquery();
$db->include_js_file('../../scripts/uploadfile/jquery.uploadfile.min.js');
$db->include_css_file('../../scripts/uploadfile/uploadfile.css');


$db->show_header();

$claimFolder = '';
?>

<div class="container">

    <div class="row">
        <div class="col alert alert-primary text-center font-weight-bold">
            Claim: <?php echo $claimData['inclm_claim_number'] . " Event Date: " . $db->convertDateToEU($claimData['inclm_date_of_event']); ?>
        </div>
    </div>

    <!-- CLIENT INFO HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center" onclick="showHide('clientBalances');"
             style="cursor: pointer">
            Policy Client Balances
            <i class="far fa-plus-square" id="clientBalances_plus"></i>
            <i class="far fa-minus-square" id="clientBalances_minus" style="display: none;"></i>
            <input type="hidden" id="clientBalances_status" value="closed">
        </div>
    </div>
    <!-- CLIENT BALANCES -->
    <?php
    $balanceData = $sybase->query_fetch("
        SELECT 
        acmblnce.acbl_acct_serl ,
        acmblnce.acbl_fncl_year ,
        acmblnce.acbl_crcy_code ,
        acmblnce.acbl_year_bfrw ,
        acmblnce.acbl_drmv_prd01 ,
        acmblnce.acbl_drmv_prd02 ,
        acmblnce.acbl_drmv_prd03 ,
        acmblnce.acbl_drmv_prd04 ,
        acmblnce.acbl_drmv_prd05 ,
        acmblnce.acbl_drmv_prd06 ,
        acmblnce.acbl_drmv_prd07 ,
        acmblnce.acbl_drmv_prd08 ,
        acmblnce.acbl_drmv_prd09 ,
        acmblnce.acbl_drmv_prd10 ,
        acmblnce.acbl_drmv_prd11 ,
        acmblnce.acbl_drmv_prd12 ,
        acmblnce.acbl_drmv_prd13 ,
        acmblnce.acbl_crmv_prd02 ,
        acmblnce.acbl_crmv_prd03 ,
        acmblnce.acbl_crmv_prd04 ,
        acmblnce.acbl_crmv_prd05 ,
        acmblnce.acbl_crmv_prd06 ,
        acmblnce.acbl_crmv_prd07 ,
        acmblnce.acbl_crmv_prd08 ,
        acmblnce.acbl_crmv_prd09 ,
        acmblnce.acbl_crmv_prd10 ,
        acmblnce.acbl_crmv_prd11 ,
        acmblnce.acbl_crmv_prd12 ,
        acmblnce.acbl_crmv_prd13 ,
        acmblnce.acbl_crmv_prd01 ,
        acbl_year_bfrw ,
        acmblnce.acbl_last_mvnt ,
        acmblnce.acbl_drmv_otst ,
        acmblnce.acbl_crmv_otst ,
        acmblnce.acbl_rect_otst ,
        acmblnce.acbl_paym_otst ,
        ccmaccts.ccac_acct_code ,
        ccmaccts.ccac_long_desc ,
        ccmaccts.ccac_allc_flag ,
        acmblnce.acbl_last_interest_post_serial ,
        acmblnce.acbl_last_interest_balance ,
        acmblnce.acbl_last_interest_date ,
        space(1) AS clo_cash_on_off,
        COALESCE((IF ccac_addr_type IN ('1','2') THEN (SELECT ccde_reco_code FROM ccmaddrs, ccpdecod WHERE ccad_addr_type = ccac_addr_type 
            AND ccad_addr_code = ccac_addr_code 
            AND ccde_reco_type = 'WC' 
            AND ccde_reco_code = ccad_warning_code 
            AND ccde_status_flag = '3') ELSE '' ENDIF), '') AS clo_warning_animated
        FROM
        acmblnce ,
        ccmaccts
        WHERE
        ( ccmaccts.ccac_acct_serl = acmblnce.acbl_acct_serl )
        and ccac_acct_code = '" . $claimData['incl_account_code'] . "'
        //and ccac_acct_code = '1615AG477E012115' 
        and acbl_fncl_year = ".date("Y")."
        
        ORDER BY
        acbl_fncl_year DESC
    ");
    ?>
    <div class="container" id="clientBalances" style="display: none">
        <div class="row">
            <div class="col-2">Client Name:</div>
            <div class="col-5"><?php echo $claimData['incl_first_name'] . " " . $claimData['incl_long_description']; ?></div>
            <div class="col-2">Client ID:</div>
            <div class="col-3"><?php echo $claimData['incl_identity_card']; ?></div>
        </div>
        <br>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Financial Period <?php echo $balanceData['acbl_fncl_year']; ?></th>
                    <th scope="col">Outstanding Dr</th>
                    <th scope="col"></th>
                    <th scope="col">Outstanding Cr</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Period</th>
                    <td align="center"><strong>Period B/F</strong></td>
                    <td align="center"><strong>Period Debits</strong></td>
                    <td align="center"><strong>Period Credits</strong></td>
                    <td align="center"><strong>Period Balance</strong></td>
                </tr>
                <?php
                $periodBalance = 0;
                for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <tr>
                        <?php
                        if ($i <= 9) {
                            $prd = '0' . $i;
                        } else {
                            $prd = $i;
                        }
                        if ($i == 1) {
                            $periodBF = $balanceData['acbl_year_bfrw'];
                            $periodBalance = $balanceData['acbl_year_bfrw'] + $balanceData['acbl_drmv_prd' . $prd] - $balanceData['acbl_crmv_prd' . $prd];
                        } else {
                            $periodBF = $periodBalance;
                            $periodBalance += $balanceData['acbl_drmv_prd' . $prd] - $balanceData['acbl_crmv_prd' . $prd];
                        }
                        ?>
                        <td><?php echo showMonthName($i); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($periodBF); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($balanceData['acbl_drmv_prd' . $prd]); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($balanceData['acbl_crmv_prd' . $prd]); ?></td>
                        <td align="center"><?php echo $db->fix_int_to_double($periodBalance); ?></td>
                    </tr>
                    <?php
                }
                function showMonthName($period)
                {
                    switch ($period) {
                        case 1:
                            return 'January';
                            break;
                        case 2:
                            return 'February';
                            break;
                        case 3:
                            return 'March';
                            break;
                        case 4:
                            return 'April';
                            break;
                        case 5:
                            return 'May';
                            break;
                        case 6:
                            return 'June';
                            break;
                        case 7:
                            return 'July';
                            break;
                        case 8:
                            return 'August';
                            break;
                        case 9:
                            return 'September';
                            break;
                        case 10:
                            return 'October';
                            break;
                        case 11:
                            return 'November';
                            break;
                        case 12:
                            return 'December';
                            break;
                    }
                }

                ?>

                </tbody>
            </table>
        </div>
        <br>
    </div>

    <!-- POLICY DOCUMENTS HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center" onclick="showHide('policyDocuments');"
             style="cursor: pointer">
            Policy Documents
            <i class="far fa-plus-square" id="policyDocuments_plus"></i>
            <i class="far fa-minus-square" id="policyDocuments_minus" style="display: none;"></i>
            <input type="hidden" id="policyDocuments_status" value="closed">
        </div>
    </div>
    <!-- POLICY DOCUMENTS -->
    <div class="container" id="policyDocuments" style="display: none">
        <?php
        //find all policy records of the same policy, same period starting date and serial less or equal of the claim/policy
        $sql = "
            SELECT
            inpol_policy_serial,
            inpol_policy_folder,
            inag_agent_code,
            inpol_policy_number,
            inpol_status,
            inpol_starting_date,
            case inpol_process_status
                WHEN 'E' then 'Endorsement'
                WHEN 'N' then 'New'
                WHEN 'R' then 'Renewal'
                WHEN 'D' then 'Declaration'
                WHEN 'C' then 'Cancellation'
                ELSE inpol_process_status
            end as clo_process_status,
                   
            String(inpol_policy_folder,'\', IF ccusp_company_code = 'EUROSURE' THEN '' ELSE '--TEST-- ' ENDIF,
            DATEFORMAT(inped_status_changed_on,'YYYY-MM-DD'),' ',
            (CASE inped_process_status 
                 WHEN 'E' THEN 'END'
                 WHEN 'N' THEN 'NEW'
                 WHEN 'R' THEN 'REN'
                 WHEN 'C' THEN 'CNL'
                 WHEN 'D' THEN 'DEC'
                 ELSE '' END), ' (',inpol_policy_serial,') ', inpol_policy_number) as clo_filename
                   
            FROM
            inpolicies JOIN inagents ON inag_agent_serial = inpol_agent_serial
            JOIN inpolicyendorsement ON  inpol_policy_serial = inped_policy_serial AND inpol_last_endorsement_serial = inped_endorsement_serial
            LEFT OUTER JOIN ccuserparameters ON 1=1
            WHERE 
            inpol_policy_number = '" . $claimData['inpol_policy_number'] . "'
            AND inpol_period_starting_date = '" . $claimData['inpol_period_starting_date'] . "'
            AND inpol_policy_serial <= " . $claimData['inpol_policy_serial'] . "
            ORDER BY inpol_policy_serial ASC
        ";
        $pdocResult = $sybase->query($sql);
        ?>
        <div class="row">
            <?php
        while ($policy = $sybase->fetch_assoc($pdocResult)) {
            //check if the pdf file exists
            $PDFDoc = $policy['clo_filename'].".pdf";
            //fix the path
            $PDFDoc = str_replace('X:','\\\\hq-terminal\\Documents',$PDFDoc);
            if (is_file($PDFDoc)){
                ?>
                    <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <?php
                            echo $policy['clo_process_status']." On: ".$db->convertDateToEU($policy['inpol_starting_date']);
                            ?>
                        </div>
                        <div class="card-body">
                            <a href="show_file.php?file=<?php echo $PDFDoc; ?>" target="_blank"
                               title="Policy Documents PDF">
                                <?php showImage($PDFDoc, 'Policy-'.$policy['inpol_policy_number'].'-Documents'); ?>
                            </a>
                        </div>
                    </div>
                    </div>
                <?php
            }
            else {
                echo "Cannot find any file";
            }

            ?>

            <?php
        }
        ?>
        </div>
    </div>

    <!-- CLAIMS IMAGES HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center"
             onclick="showHide('claimsContainer');" style="cursor: pointer">
            Claim Images
            <i class="far fa-plus-square" id="claimsContainer_plus"></i>
            <i class="far fa-minus-square" id="claimsContainer_minus" style="display: none"></i>
            <input type="hidden" id="claimsContainer_status" value="closed">
        </div>
    </div>

    <script>
        function showHide(field) {
            if ($('#' + field + '_status').val() == 'closed') {
                $('#' + field).show();
                $('#' + field + '_plus').hide();
                $('#' + field + '_minus').show();
                $('#' + field + '_status').val('open')
            } else {
                $('#' + field).hide();
                $('#' + field + '_plus').show();
                $('#' + field + '_minus').hide();
                $('#' + field + '_status').val('closed')
            }
        }
    </script>
    <!-- CLAIMS IMAGES -->
    <div class="row" id="claimsContainer" style="display: none">
        <div class="col">
            <div class="container">


                <?php
                //show only the first folder found
                $claimFolder = $data[0];
                listFolderItems($data[0]);
                //Also find all subfolders
                findSubFolders($data[0]);
                //now show all the subfolders
                foreach ($subFolders as $sbFolder) {
                    //echo $sbFolder." MICMIC- ";
                    listFolderItems($sbFolder);
                }

                ?>
            </div>
        </div>
    </div>

    <!-- CLIENT CLAIMS PROFILE HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center"
             onclick="showHide('clientClaimsProfileContainer');" style="cursor: pointer">
            Client Claims Profile
            <i class="far fa-plus-square" id="clientClaimsProfileContainer_plus"></i>
            <i class="far fa-minus-square" id="clientClaimsProfileContainer_minus" style="display: none"></i>
            <input type="hidden" id="clientClaimsProfileContainer_status" value="closed">
        </div>
    </div>
    <!-- CLIENT CLAIMS PROFILE BODY -->
    <div class="row" id="clientClaimsProfileContainer" style="display: none">
        <iframe src="claims_client_profile.php?claimID=<?php echo $_GET['claimID'];?>&clientID=<?php echo $claimData['incl_identity_card'];?>"
        frameborder="0" width="100%" height="250px"></iframe>
    </div>


    <!-- VEHICLE CLAIMS PROFILE HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center"
             onclick="showHide('vehicleClaimsProfileContainer');" style="cursor: pointer">
            Vehicle Claims Profile
            <i class="far fa-plus-square" id="vehicleClaimsProfileContainer_plus"></i>
            <i class="far fa-minus-square" id="vehicleClaimsProfileContainer_minus" style="display: none"></i>
            <input type="hidden" id="vehicleClaimsProfileContainer_status" value="closed">
        </div>
    </div>
    <!-- VEHICLE CLAIMS PROFILE BODY -->
    <div class="row" id="vehicleClaimsProfileContainer" style="display: none">
        <iframe src="claims_vehicle_profile.php?claimID=<?php echo $_GET['claimID'];?>&vehicle=<?php echo $claimData['initm_item_code'];?>"
                frameborder="0" width="100%" height="250px"></iframe>
    </div>



    <!-- UPLOAD FILE HEADER -->
    <div class="row">
        <div class="col alert alert-primary font-weight-bold text-center"
             onclick="showHide('UploadContainer');" style="cursor: pointer">
            Upload Files
            <i class="far fa-plus-square" id="UploadContainer_plus"></i>
            <i class="far fa-minus-square" id="UploadContainer_minus" style="display: none"></i>
            <input type="hidden" id="UploadContainer_status" value="closed">
        </div>
    </div>
    <!-- UPLOAD FILE BODY -->
    <div class="row" id="UploadContainer" style="display: none">
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    if ($claimFolder == '') {
                        ?>
                        No Folder found to upload
                        <?php
                    }
                    else {
                    ?>
                    <div id="fileuploader" style="width: 100%">Upload</div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>

        <script>
            $(document).ready(function()
            {
                $("#fileuploader").uploadFile({
                    url:"uploadClaimsFile.php",
                    multiple:true,
                    dragDrop:true,
                    fileName:"myfile",
                    formData: {"folder":"<?php echo str_replace('\\','/',$claimFolder)."/";?>"},
                    returnType:"json",
                    showDone:true
            });
            });
        </script>
    </div>

</div>

<?php
function findClaimFolder()
{
    global $sybase, $claimData,$db;
    if (!$_GET['claimID'] > 0) {
        exit();
    }
    $sql = "SELECT 
            initm_item_code,
            inclm_claim_serial,
            inclm_claim_number,
            inclm_status,
            inclm_process_status,
            inclm_date_of_event,
            inclm_claim_date,
            incl_first_name,
            incl_long_description,
            incl_identity_card,
            incl_account_code,
            inpol_policy_number,
            inpol_policy_serial,
            inpol_period_starting_date,
            if inclm_date_of_event < '2021-03-01' then 'rescueline' else 'odyky' endif as clo_handler
            FROM 
            inclaims 
            join initems on initm_item_serial = inclm_item_serial
            JOIN inpolicies ON inclm_policy_serial = inpol_policy_serial
            JOIN inclients ON incl_client_serial = inpol_client_serial
            WHERE inclm_claim_serial = " . $_GET['claimID'];

    $claimData = $sybase->query_fetch($sql);

    //if the claim is before 1/3/2021 the redirect to the old claims file
    if ($claimData['clo_handler'] == 'rescueline') {
        //header("Location: claims_old.php?claimID=" . $_GET['claimID']);
        //exit();
    }

    $vehicleReg = $claimData['initm_item_code'];
    $claimEventDate = $claimData['inclm_date_of_event'];
    //fix event date
    $eventDateParts = explode('-', $claimEventDate);
    $claimEventDate = $eventDateParts[2] . $eventDateParts[1] . $eventDateParts[0];
    //find the third party vehicle
    $sql = "
        select
        inctp_regno_id
        from
        inclaimthirdparty
        WHERE
        inctp_claim_serial = " . $claimData['inclm_claim_serial'];
    $tpResult = $sybase->query($sql);
    while ($tp = $sybase->fetch_assoc($tpResult)) {
        $tpVehicle[] = $tp['inctp_regno_id'];
    }

    $db->admin_echo("<hr>Looking for: ".$vehicleReg." Event Date: ".$claimEventDate." TP: ".$tpVehicle[0]."<hr>");

    //search in folders to find this claim
    $mainFolder = '\\\\esapps2\\Eurosure Assist\\ODYKY';
    $folders = scandir($mainFolder, 1);
    $foldersFound = [];
    //echo $claimEventDate."\\".$vehicleReg;

    foreach ($folders as $name) {

        //first check if the event date is found
        if (strpos($name, $claimEventDate) !== false) {
            //echo $claimEventDate;
            //$db->admin_echo($name."<br>");

            //now check to find the policy vehicle
            if (strpos($name, $vehicleReg) !== false) {

                $foldersFound[] = $mainFolder . "\\" . $name;
            }
        }
    }

    //check if more than one folders is found
    if (count($foldersFound) > 1) {
        foreach ($foldersFound as $name => $value) {
            //check also the third party
            if (strpos($value, $tpVehicle[0]) === false) {
                //does not exists should remove it from the list
                unset($foldersFound[$name]);
            } else {
                //is found so do nothing, keep it in the list
            }
        }
    }

    //if none found find it using different methods
    if (count($foldersFound) == 0) {
        //echo "None found";
    }

    //print_r($foldersFound);
    return $foldersFound;
}

function findSubFolders($folder)
{
    global $subFolders;
    if ($folder != '') {
        $mainFolder = scandir($folder);

        foreach ($mainFolder as $item) {
            if ($item != '.' && $item != '..')
                if (is_dir($folder . "\\" . $item)) {
                    //echo "Folder:->".$item;
                    //add it in the list
                    $subFolders[] = $folder . "\\" . $item;
                    //recursive find if sub folders exists
                    findSubFolders($folder . "\\" . $item);
                }
        }
    }

}

function listFolderItems($folder)
{
    global $subFolders;
    if ($folder == '') {
        echo "No Folder Found";
        return false;
    }
    $folderNameSplit = explode("\\", $folder);
    $folderName = $folderNameSplit[count($folderNameSplit) - 1];
    //$folder = '\\\\esapps2\\Eurosure Assist\\ODYKY\\' . $fld;
    //echo $folder."<hr>";
    $scan = scandir($folder);

    $i = 0;
    foreach ($scan as $name) {
        $ignoreList = array('.', '..', 'Thumbs.db', 'desktop.ini');
        //show only files
        if (!in_array($name, $ignoreList)) {
            //if its folder ignore it
            if (is_dir($folder . "\\" . $name)) {
                //add this folder to the list to show later
                //$subFolders[] = $folder."\\".$name;
            } else {
                //show this items
                $i++;
                if ($i == 1) {
                    //show the folder
                    ?>
                    <div class="row">
                        <div class="col alert alert-secondary text-center font-weight-bold">
                            Folder: <?php echo $folderName; ?>
                        </div>
                    </div>


                    <?php
                }
                if ($i % 4 == 1) {
                    ?>
                    <ul class="list-inline">
                    <?php
                }
                ?>
                <li class="list-inline-item">
                    <a href="show_file.php?file=<?php echo $folder . "\\" . $name; ?>" target="_blank"
                       title="<?php echo $name; ?>">
                        <?php showImage($folder . "\\" . $name, $name); ?>
                    </a>
                </li>
                <?php


                if ($i % 4 == 0) {
                    ?>
                    </ul>
                    <?php
                }

            }//show only files

        }


    }
    return true;
}

function showImage($file, $fileName = '')
{
    //get file type
    $fileNameParts = explode(".", $file);
    $fileType = $fileNameParts[count($fileNameParts) - 1];
    //read the file
    $contents = file_get_contents($file);
    if ($fileType == 'jpg' || $fileType == 'png') {
        echo '<img src="data:image/jpeg;base64, ' . base64_encode($contents) . '" height="190">';
    } else if ($fileType == 'pdf') {
        echo '<i class="fas fa-file-pdf fa-3x"></i><br>' . $fileName;
    } else if ($fileType == 'docx' || $fileType == 'doc') {
        echo '<i class="far fa-file-word fa-3x"></i><br>' . $fileName;
    } else {
        echo '<i class="fas fa-file-pdf fa-3x"></i><br>' . $fileName;
    }
    //firefox enable local files
    //in url about:config
    //set to false security.fileuri.strict_origin_policy
    //echo '<img src="file:///'.$file.'" height="50">';
}

$db->show_footer();
?>
