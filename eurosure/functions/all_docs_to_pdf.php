<?php
include("../../include/main.php");
include("../lib/odbccon.php");
include("../../scripts/form_validator_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/meBuildDataTable.php");
$db = new Main();

$sybase = new ODBCCON();

$db->show_header();


$formValidator = new customFormValidator();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');
FormBuilder::buildPageLoader();


//set print log records to W->withdrawn

//set  "intransactionheaders"."intrh_document_printed" to N


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

                    <?php
                    if ($_POST['fld_policy_serial'] > 0) {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <!--
                                Show HERE the print logs
                                -->
                                <?php
                                if ($_POST['action'] == 'showLogs') {
                                    $sql = "SELECT
                        indpl_auto_serial as AutoSerial,
                        indpl_document_type as 'Document Type',
                        indpl_primary_serial as 'Primary Serial',
                        indpl_secondary_serial as 'Secondary Serial',
                        indpl_print_user as 'Print User'
                        FROM indocumprnlog WHERE indpl_primary_serial = '" . $_POST['fld_policy_serial'] . "'";
                                    $result = $sybase->query($sql);
                                    while ($prnt = $sybase->fetch_assoc($result)) {
                                        $allRecords[] = $prnt;
                                    }

                                    $table = new MEBuildDataTable();
                                    echo $table->getHeadersFromFieldNames()
                                        ->makeTableOutput()
                                        ->setData($allRecords)
                                        ->makeOutput();

                                }
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
                                        FROM
                                        inpolicies
                                        JOIN inpolicyendorsement ON inped_financial_policy_abs = inpol_policy_serial
                                        JOIN intransactiondetails ON inped_policy_serial= intrd_policy_serial AND inped_endorsement_serial = intrd_endorsement_serial and COALESCE(intrd_claim_serial, 0) = 0
                                        JOIN intransactionheaders ON intrd_trh_auto_serial = intrh_auto_serial
                                        WHERE inpol_policy_serial = " . $_POST['fld_policy_serial'] . "
                                        GROUP BY intrh_document_number, intrh_auto_serial, intrd_related_type";
                                $result = $sybase->query($sql);
                                while ($prnt = $sybase->fetch_assoc($result)) {
                                    $drcrRecords[0] = $prnt;
                                    $table = new MEBuildDataTable();
                                    echo $table->getHeadersFromFieldNames()
                                        ->makeTableOutput()
                                        ->setData($drcrRecords)
                                        ->makeOutput();


                                }


                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="col-1"></div>
            </div>
        </form>
    </div>

<?php
$formValidator->output();
$db->show_footer();
?>