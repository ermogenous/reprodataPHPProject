<?php

include("../../include/main.php");
include("../lib/odbccon.php");
include("../../scripts/form_validator_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/meBuildDataTable.php");
$db = new Main();

$sybase = new ODBCCON();
$db->enable_jquery_ui();
$db->show_header();


$formValidator = new customFormValidator();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');
FormBuilder::buildPageLoader();

?>

    <div class="container-fluid">
        <form name="myForm" id="myForm" method="post" action=""
            <?php $formValidator->echoFormParameters(); ?>>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center">
                            Print all docs to PDF functions
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        $formB->setFieldName('fld_policy_serial')
                            ->setFieldDescription('Policy Serial')
                            ->setFieldType('input')
                            ->setInputValue($_POST['fld_policy_serial'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'requiredAddedCustomCode' => ' && $("#fld_policy_number").val() == ""',
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB->setFieldName('fld_policy_number')
                            ->setFieldDescription('Or Policy Number')
                            ->setFieldType('input')
                            ->setInputValue($_POST['fld_policy_number'])
                            ->buildLabel();
                        ?>
                        <div class="col-sm-3">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'text',
                                    'required' => true,
                                    'requiredAddedCustomCode' => ' && $("#fld_policy_serial").val() == ""',
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>


                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="name" class="col-3 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action"
                                   value="showLogs">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Show Prints" class="btn btn-primary">
                        </div>
                    </div>
        </form>
        <?php
        //set print log records to W->withdrawn
        //set  "intransactionheaders"."intrh_document_printed" to N
        //If withdraw all
        if ($_POST['action'] == 'withdrawAll') {
            if ($_POST['fld_policy_serial'] > 0) {
                ?>
                <div class="row">
                    <div class="col-12 alert alert-primary">
                        Updating SCH,CRT,UDD1,END,RNWC Documents to withdrawn
                    </div>
                </div>
                <?php
                $sybase->beginTransaction();
                //withdraw all documents SCH,CRT,UDD1,'END','RNWC'
                $sql = "SELECT
                        indpl_auto_serial,
                        indpl_document_type,
                        indpl_primary_serial,
                        indpl_secondary_serial,
                        indpl_print_user,
                        indpl_filenames 
                        FROM indocumprnlog 
                        WHERE indpl_primary_serial = '" . $_POST['fld_policy_serial'] . "'
                        AND RIGHT(indpl_document_type,1) <> 'W'
                        ORDER BY indpl_auto_serial ASC";
                $resultSelect = $sybase->query($sql);
                while ($line = $sybase->fetch_assoc($resultSelect)) {

                    ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 alert alert-warning">
                                Updating log serial: <?php echo $line['indpl_auto_serial']; ?> DONE
                            </div>
                        </div>
                    </div>
                    <?php

                    //update to withdrawn
                    $sqlW1 = "UPDATE indocumprnlog
                            SET indpl_document_type = STRING(indpl_document_type, 'W'),
                            indpl_withdrawn_by = 'RERPRINT-INT',
                            indpl_withdrawn_on = NOW()
                            WHERE indpl_auto_serial = " . $line['indpl_auto_serial'] . "
                            AND RIGHT(indpl_document_type,1) <> 'W' /*exclude withdrawn to avoid updating again e.g. SCHWW */
                            AND indpl_document_type IN ('SCH', 'CRT', 'UDD1', 'END', 'RNWC') ;/* Only Specific document types */ ";
                    $sybase->query($sqlW1);
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 alert alert-warning">
                                <?php
                                if ($line['indpl_filenames'] != '') {
                                    echo "File/s: -> ";
                                    $files = explode(',', $line['indpl_filenames']);
                                    foreach ($files as $file) {
                                        echo $file;
                                        if (file_exists($file)) {
                                            echo " Exists Deleting";
                                            if (unlink($file)) {
                                                echo " - Deleted";
                                            } else {
                                                echo " - Error deleting file";
                                            }
                                        } else {
                                            echo " - File not found";
                                        }
                                        echo "<br>";
                                    }
                                } else {
                                    echo "No file/s";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo "<hr>";
                }

                //find all dr/cr
                $sql = "SELECT
                        intrh_auto_serial
                        , intrh_document_number
                        , intrd_related_type
                        FROM
                        inpolicies
                        JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial
                        JOIN intransactiondetails ON inped_policy_serial= intrd_policy_serial AND inped_endorsement_serial =
                        intrd_endorsement_serial and COALESCE(intrd_claim_serial, 0) = 0
                        JOIN intransactionheaders ON intrd_trh_auto_serial = intrh_auto_serial
                        JOIN inagents ON inag_agent_serial = inpol_agent_serial
                        WHERE inpol_policy_serial = " . $_POST['fld_policy_serial'] . "
                        AND intrd_related_type = IF inag_internal_external_agent = 'I' THEN 'C' ELSE 'A' ENDIF
                        GROUP BY intrh_document_number, intrh_auto_serial, intrd_related_type";
                //update all this print documents
                $resultDrCr = $sybase->query($sql);
                $drCrHtml = '';
                while ($drCr = $sybase->fetch_assoc($resultDrCr)) {
                    //set the transaction header to print no
                    $sqlTrHeaders = "
                        UPDATE 
                        intransactionheaders
                        SET intrh_document_printed = 'N'
                        WHERE
                        intrh_auto_serial = " . $drCr['intrh_auto_serial'];
                    $sybase->query($sqlTrHeaders);
                    ?>
                    <div class="row">
                        <div class="col-12 alert alert-primary">
                            Updating Dr/Cr note transaction header to printed no
                            : <?php echo $drCr['intrh_document_number'] . " (" . $drCr['intrh_auto_serial'] . ")"; ?>
                            - DONE
                        </div>
                    </div>
                    <?php
                    $sqlLogs = "SELECT
                        indpl_auto_serial,
                        indpl_document_type,
                        indpl_primary_serial,
                        indpl_secondary_serial,
                        indpl_print_user,
                        indpl_filenames 
                        FROM indocumprnlog 
                        WHERE indpl_primary_serial = '" . $drCr['intrh_auto_serial'] . "'
                        AND RIGHT(indpl_document_type,1) <> 'W'
                        AND indpl_document_type IN ('DCN')
                        ORDER BY indpl_auto_serial ASC";
                    $resultSelect = $sybase->query($sqlLogs);
                    while ($line = $sybase->fetch_assoc($resultSelect)) {
                        $sqlDcnUpdate = "UPDATE indocumprnlog
                                    SET indpl_document_type = STRING(indpl_document_type, 'W'),
                                    indpl_withdrawn_by = 'RERPRINT-INT',
                                    indpl_withdrawn_on = NOW()
                                    WHERE indpl_auto_serial = '" . $line['indpl_auto_serial'] . "'
                                    AND RIGHT(indpl_document_type,1) <> 'W' /*exclude withdrawn to avoid updating again e.g. SCHWW */
                                    AND indpl_document_type IN ('DCN') ;/* Only Specific document types */";
                        $sybase->query($sqlDcnUpdate);
                        ?>
                        <div class="row">
                            <div class="col-12 alert alert-primary">
                                Updating Dr/Cr note print log: <?php echo $line['indpl_auto_serial'];?> - DONE
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-12 alert alert-warning">
                                    <?php
                                    if ($line['indpl_filenames'] != '') {
                                        echo "File/s: -> ";
                                        $files = explode(',', $line['indpl_filenames']);
                                        foreach ($files as $file) {
                                            echo $file;
                                            if (file_exists($file)) {
                                                echo " Exists Deleting";
                                                if (unlink($file)) {
                                                    echo " - Deleted";
                                                } else {
                                                    echo " - Error deleting file";
                                                }
                                            } else {
                                                echo " - File not found";
                                            }
                                            echo "<br>";
                                        }
                                    } else {
                                        echo "No file/s";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php

                    }


                }//while all print logs

                //commit the transactions
                $sybase->commit();
                $_POST['action'] = 'showLogs';
            }
        }
        ?>

        <?php
        if ($_POST['fld_policy_serial'] > 0 || $_POST['fld_policy_number'] != '') {
            if ($_POST['action'] == 'showLogs') {

                if ($_POST['fld_policy_serial'] == ''){
                    $sql = "SELECT * FROM 
                            inpolicies 
                            WHERE inpol_policy_number = '".$_POST['fld_policy_number']."'
                            AND inpol_status = 'N'
                            ORDER BY inpol_policy_serial DESC
                            ";
                    $resultPolicyNumber = $sybase->query_fetch($sql);
                    $_POST['fld_policy_serial'] = $resultPolicyNumber['inpol_policy_serial'];

                }

                $policyData = $sybase->query_fetch("SELECT * FROM inpolicies WHERE inpol_policy_serial = ".$_POST['fld_policy_serial']);

                ?>
                <form method="post">
                    <div class="row">
                        <div class="col-12">
                            <!--
                            Show HERE the print logs
                            -->
                            <?php

                            $sql = "

                                        select
                                            indpl_auto_serial as AutoSerial,
                                            indpl_document_type as 'Document Type',
                                            indpl_primary_serial as 'Primary Serial',
                                            indpl_secondary_serial as 'Secondary Serial',
                                            indpl_print_user as 'Print User',
                                            indpl_filenames 
                                            FROM indocumprnlog 
                                            WHERE indpl_primary_serial = '" . $_POST['fld_policy_serial'] . "'
                                            AND RIGHT(indpl_document_type,1) <> 'W'
                                            ORDER BY indpl_auto_serial ASC";
                            $result = $sybase->query($sql);
                            while ($prnt = $sybase->fetch_assoc($result)) {
                                $allRecords[] = $prnt;
                            }
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                        echo "Policy Number: ".$policyData['inpol_policy_number']." [".$policyData['inpol_policy_serial']."]";
                                        echo " Process Status: ".$policyData['inpol_process_status']." Status: ".$policyData['inpol_status'];
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    echo $policyData['inpol_policy_folder'];
                                    ?>
                                </div>
                            </div>

                            <?php

                            $table = new MEBuildDataTable();
                            echo $table->getHeadersFromFieldNames()
                                ->makeTableOutput()
                                ->setData($allRecords)
                                ->makeOutput();

                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 alert alert-secondary text-center">Debit Notes Prints</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?php
                            $sql = "SELECT 
                                        intrh_auto_serial as 'Auto Serial'
                                        , intrh_document_number as 'Document Number'
                                        , intrd_related_type as 'Related Type'
                                        , intrh_document_printed as 'Doc Printed'
                                        FROM
                                        inpolicies
                                        JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial
                                        JOIN intransactiondetails ON inped_policy_serial= intrd_policy_serial AND inped_endorsement_serial = intrd_endorsement_serial and COALESCE(intrd_claim_serial, 0) = 0
                                        JOIN intransactionheaders ON intrd_trh_auto_serial = intrh_auto_serial
                                        JOIN inagents ON inag_agent_serial = inpol_agent_serial
                                        WHERE inpol_policy_serial = " . $_POST['fld_policy_serial'] . "
                                        AND intrd_related_type = IF inag_internal_external_agent = 'I' THEN 'C' ELSE 'A' ENDIF
                                        GROUP BY intrh_document_number, intrh_auto_serial, intrd_related_type, intrh_document_printed";
                            $result = $sybase->query($sql);
                            while ($prnt = $sybase->fetch_assoc($result)) {
                                $drcrRecords[0] = $prnt;
                                $table = new MEBuildDataTable();
                                echo $table->getHeadersFromFieldNames()
                                    ->makeTableOutput()
                                    ->setData($drcrRecords)
                                    ->makeOutput();

                                //show the printed docs for each dr/cr
                                $sql = "SELECT
                                            indpl_auto_serial as AutoSerial,
                                            indpl_document_type as 'Document Type',
                                            indpl_primary_serial as 'Primary Serial',
                                            indpl_secondary_serial as 'Secondary Serial',
                                            indpl_print_user as 'Print User',
                                            indpl_filenames as 'Files'
                                            FROM indocumprnlog 
                                            WHERE indpl_primary_serial = '" . $prnt['Auto Serial'] . "'
                                            AND indpl_document_type = 'DCN'";
                                $resultd = $sybase->query($sql);
                                $allRecordsD = [];
                                while ($prnt = $sybase->fetch_assoc($resultd)) {
                                    $allRecordsD[] = $prnt;
                                }

                                $table = new MEBuildDataTable();
                                echo $table->getHeadersFromFieldNames()
                                    ->makeTableOutput()
                                    ->setData($allRecordsD)
                                    ->makeOutput();

                            }


                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6 text-center">
                            <input type="hidden" id="action" name="action" value="withdrawAll">
                            <input type="hidden" id="fld_policy_serial" name="fld_policy_serial"
                                   value="<?php echo $_POST['fld_policy_serial']; ?>">
                            <input type="submit" value="Withdraw SCH,CRT,UDD1,END,RNWC,DCN"
                                   onclick="return confirm('Are you sure you want to withdraw all this records?');"
                                   class="btn btn-danger">
                        </div>
                        <div class="col-3"></div>
                    </div>
                </form>
                <?php
            }
        }
        ?>
    </div>

    <div class="col-1"></div>
    </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>