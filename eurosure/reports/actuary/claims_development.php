<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 07/05/2020
 * Time: 14:38
 */

ini_set('max_execution_time', 1800);
ini_set('memory_limit','4096M');

include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
include('../../lib/odbccon.php');
include('../../../tools/MEBuildExcel.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Actuary - Policy Transactions";

if ($_POST['action'] == 'execute'){
    $sybase = new ODBCCON();

    if ($_POST['fld_report_type'] == 'GrossClaimsLOB') {
        makeReport($_POST['fld_as_at_date'],'ALLLOB', true);
    }
    else if ($_POST['fld_report_type'] == 'GrossClaimsLOBRI'){
        makeReport($_POST['fld_as_at_date'],'ALLLOBRI', true);
    }
    else if ($_POST['fld_report_type'] == 'GrossClaimsMotor'){
        makeReport($_POST['fld_as_at_date'],'MOTOR', true);
    }
    else if ($_POST['fld_report_type'] == 'GrossClaimsMotorRI'){
        makeReport($_POST['fld_as_at_date'],'MOTORRI', true);
    }

    exit();
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit="" target="_blank"
                    <?php $formValidator->echoFormParameters(); ?>>

                    <div class="row">
                        <div class="col-12 alert alert-primary text-center"><b>Reports - Actuary - Policy Transactions</b></div>
                    </div>
                    <div class="row form-group">
                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_report_type')
                            ->setFieldDescription('Report Type')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('select')
                            ->setInputSelectArrayOptions([
                                'GrossClaimsLOB' => 'Gross Claims All LOB',
                                'GrossClaimsLOBRI' => 'Gross Claims All LOB R/I',
                                'GrossClaimsMotor' => 'Gross Claims Motor',
                                'GrossClaimsMotorRI' => 'Gross Claims Motor R/I',
                            ])
                            ->setInputValue($_POST['fld_report_type'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                        <?php
                        $formB = new FormBuilder();
                        $formB->setFieldName('fld_as_at_date')
                            ->setFieldDescription('As At Date')
                            ->setLabelClasses('col-sm-2')
                            ->setFieldType('input')
                            ->setFieldInputType('text')
                            ->setInputValue($_POST['fld_as_at_date'])
                            ->buildLabel();
                        ?>
                        <div class="col-4">
                            <?php
                            $formB->buildInput();
                            $formValidator->addField(
                                [
                                    'fieldName' => $formB->fieldName,
                                    'fieldDataType' => 'date',
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['fld_as_at_date'],
                                    'required' => true,
                                    'invalidTextAutoGenerate' => true
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                        <div class="col-sm-8">
                            <input name="action" type="hidden" id="action" value="execute">
                            <input type="button" value="Back" class="btn btn-secondary"
                                   onclick="window.location.assign('index.php')">
                            <input type="submit" name="Submit" id="Submit"
                                   value="Submit Form"
                                   class="btn btn-primary">
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>

<?php
$formValidator->output();
$db->show_footer();


function makeReport($asAtDate,$type, $excelFile = true){
    global $sybase,$db;

    $paidAc = '';
    $osAc = '';
    $coverSelect = '';
    $coverGroupBy = '';
    $filename = '';

    $asAtSplit = explode("/",$asAtDate);
    $asAtSpaces = $asAtSplit[0].' '.$asAtSplit[1].' '.$asAtSplit[2];
    $asAtUnderscore = $asAtSplit[0].'_'.$asAtSplit[1].'_'.$asAtSplit[2];

    if($type == 'ALLLOB'){
        $paidAc = '511001';
        $osAc = '211001';
        $coverSelect = '';
        $coverGroupBy = '';
        $filename = 'CLAIMS DEVELOPMENT AS AT '.$asAtSpaces.' ALL LOBS CLAIMS BY COVER GROSS ';
        $lobTo = 'F';
    }
    else if ($type == 'ALLLOBRI'){
        $paidAc = '511002';
        $osAc = '211002';
        $coverSelect = '';
        $coverGroupBy = '';
        $filename = 'CLAIMS DEVELOPMENT AS AT '.$asAtSpaces.' ALL LOBS CLAIMS BY COVER GROSS RI';
        $lobTo = 'F';
    }
    else if ($type == 'MOTOR'){
        $paidAc = '511001';
        $osAc = '211001';
        $coverSelect = 'actln_anls_cod5 as clo_cover,';
        $coverGroupBy = ',clo_cover';
        $filename = 'CLAIMS DEVELOPMENT AS AT '.$asAtSpaces.' MOTOR CLAIMS BY COVER GROSS ';
        $lobTo = 'A';
    }
    else if ($type == 'MOTORRI'){
        $paidAc = '511002';
        $osAc = '211002';
        $coverSelect = 'actln_anls_cod5 as clo_cover,';
        $coverGroupBy = ',clo_cover';
        $filename = 'CLAIMS DEVELOPMENT AS AT '.$asAtSpaces.' MOTOR CLAIMS BY COVER GROSS RI';
        $lobTo = 'A';
    }

    $sql = "
    SELECT 
LEFT(actln_anls_cod3,1) as clo_lob,
(actln_anls_cod1) as clo_yoo,
SUBSTR(actln_anls_cod3, 2,3) as clo_class,
(actln_refe_nmbr) as clo_claim_no, 
(actln_anls_cod9) as clo_ibnr,
STRING(SUBSTR(actln_anls_cod3,2,3)+'/'+actln_refe_nmbr+'/'+SUBSTR(actln_anls_cod1,3,2)+' '+actln_anls_cod9) as clo_claim_ref,
MIN(actln_docu_year*100+actln_docu_perd) as clo_first_period_year,
".$coverSelect."
'".$asAtDate."' as xclo_as_at_date,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200512) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2005,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200601 AND actln_docu_year*100+actln_docu_perd<=200612) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2006,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200701 AND actln_docu_year*100+actln_docu_perd<=200712) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2007,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200801 AND actln_docu_year*100+actln_docu_perd<=200812) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2008,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200901 AND actln_docu_year*100+actln_docu_perd<=200912) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2009,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201001 AND actln_docu_year*100+actln_docu_perd<=201012) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2010,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201101 AND actln_docu_year*100+actln_docu_perd<=201112) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2011,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201201 AND actln_docu_year*100+actln_docu_perd<=201212) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2012,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201301 AND actln_docu_year*100+actln_docu_perd<=201312) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2013,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201401 AND actln_docu_year*100+actln_docu_perd<=201412) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2014,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201501 AND actln_docu_year*100+actln_docu_perd<=201512) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2015,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201601 AND actln_docu_year*100+actln_docu_perd<=201612) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2016,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201701 AND actln_docu_year*100+actln_docu_perd<=201712) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2017,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201801 AND actln_docu_year*100+actln_docu_perd<=201812) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2018,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201901 AND actln_docu_year*100+actln_docu_perd<=201912) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2019,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=202001 AND actln_docu_year*100+actln_docu_perd<=202012) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2020,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=".$asAtSplit[2].$asAtSplit[1].") THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_".$asAtUnderscore.",

SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200512) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2005,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200612) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2006,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200712) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2007,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200812) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2008,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=200912) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2009,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=201501 AND actln_docu_year*100+actln_docu_perd<=201012) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2010,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=201501 AND actln_docu_year*100+actln_docu_perd<=201112) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2011,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=201501 AND actln_docu_year*100+actln_docu_perd<=201212) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2012,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=201501 AND actln_docu_year*100+actln_docu_perd<=201312) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2013,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201412) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2014,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201512) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2015,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201612) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2016,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201712) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2017,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201812) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2018,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=201912) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2019,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=202012) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2020,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=".$asAtSplit[2].$asAtSplit[1].") THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_".$asAtUnderscore.",
(clo_paid_cy+clo_os_cy-clo_os_py) as clo_incurred,
(clo_paid_ytd_py+clo_paid_cy+clo_os_cy) as clo_incurredT,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=".$asAtSplit[2].$asAtSplit[1].") THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_upto".$asAtUnderscore.",
'END' as_clo_end,

'A' as xclo_lob,   
'".$lobTo."' as xclo_lob_to, 
2020 as xclo_upto_year,
(xclo_upto_year-1) as clo_prev_year,

((xclo_upto_year)*100+xclo_upto_period) as clo_curr_year_period,
((xclo_upto_year-1)*100+'12') as clo_prev_year_period,

1 as xclo_from_period,   
".($asAtSplit[1]*1)." as xclo_upto_period,   

//SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=201701 AND actln_docu_year*100+actln_docu_perd<=201712) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_2017,

SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=(xclo_upto_year-1)*100+xclo_from_period AND actln_docu_year*100+actln_docu_perd<=clo_prev_year_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_py,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=xclo_upto_year*100+xclo_from_period AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_cy,

//SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200909 AND actln_docu_year*100+actln_docu_perd<=201712) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_2017,

SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200909 AND actln_docu_year*100+actln_docu_perd<=clo_prev_year_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_py,
SUM(IF actln_acct_code = '".$osAc."' AND (actln_docu_year*100+actln_docu_perd>=200909 AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv*-1) ELSE 0 ENDIF ) as clo_os_cy,

SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=clo_prev_year_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_ytd_py,
SUM(IF actln_acct_code = '".$paidAc."' AND (actln_docu_year*100+actln_docu_perd>=200501 AND actln_docu_year*100+actln_docu_perd<=xclo_upto_year*100+xclo_upto_period) THEN (actln_line_amnt * actln_drmv_crmv) ELSE 0 ENDIF ) as clo_paid_ytd_cy

FROM acmtline LEFT OUTER JOIN ccpdecod ON actln_anls_cod4 = ccde_reco_code AND ccde_reco_type = 'L4'
WHERE actln_acct_code IN ('".$osAc."','".$paidAc."')
AND LEFT(actln_anls_cod3,1) >= xclo_lob AND LEFT(actln_anls_cod3,1) <= xclo_lob_to
AND actln_docu_stat <> '9'
AND actln_docu_type = '1'
/*AND LEN(clo_class) = '3'*/
AND actln_refe_nmbr NOT IN ('30/06/2006','BALANCE','Q1/2005','Q2/2005','Q3/2005','Q4/2005')
//AND actln_refe_nmbr IN ('00073/98','00102/94')

GROUP BY LEFT(actln_anls_cod3,1),actln_anls_cod1,actln_refe_nmbr,actln_anls_cod3,xclo_lob,xclo_lob_to, xclo_as_at_date, xclo_upto_year,xclo_upto_period,xclo_from_period,actln_anls_cod9/*,actln_anls_cod4,ccde_shrt_desc,ccde_long_desc*/
".$coverGroupBy."
ORDER BY LEFT(actln_anls_cod3,1),actln_anls_cod1,actln_refe_nmbr,actln_anls_cod3,xclo_lob,xclo_lob_to, xclo_as_at_date, xclo_upto_year,xclo_upto_period,xclo_from_period,actln_anls_cod9/*,actln_anls_cod4,ccde_shrt_desc*/

    ";

    $result = $sybase->query($sql);

    if($excelFile) {
        $spreadSheet = new MEBuildExcel();
        $i = 0;
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $spreadSheet->buildTopRowFromFieldNames($row);
            }
            $spreadSheet->addRowFromArray($row);
            //print_r($row);
        }

        $spreadSheet->outputAsDownload($filename);
    }
    else {
        $i=0;
        $data = '';
        $line = '';
        while ($row = $sybase->fetch_assoc($result)) {
            $i++;
            if ($i == 1) {
                $line = '';
                foreach($row as $name => $value){
                    $line .= $name.",";
                }
                $line = $db->remove_last_char($line);
                $data = $line.PHP_EOL;
            }
            $line = '';
            foreach($row as $name => $value){
                $line .= $value.",";
            }
            $line = $db->remove_last_char($line);
            $data .= $line.PHP_EOL;
        }
        $db->export_file_for_download($data,$filename.".txt");
    }
}

?>