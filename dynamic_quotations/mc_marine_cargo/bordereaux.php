<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 2/8/2019
 * Time: 10:56 ΠΜ
 */

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

include("../../include/main.php");
include('../../scripts/form_validator_class.php');

$db = new Main();
$db->admin_title = "Dynamic Quotations Marine Cargo Bordereaux";

if ($_POST['action'] == 'search') {
    if ($_POST['type'] == 'Marine') {
        $where = 'AND oqq_quotations_type_ID = 2 ';
    }

    if ($_POST['status'] != '') {
        $where .= "AND oqq_status = '" . $_POST['status'] . "' ";
    }

    if ($_POST['numberFrom'] != '') {
        $where .= "AND oqq_number BETWEEN '" . $_POST['numberFrom'] . "' AND '" . $_POST['numberTo'] . "' ";
    }

    if ($_POST['effectiveFrom'] != '') {
        $where .= "AND oqq_effective_date BETWEEN 
        '" . $db->convertDateToUS($_POST['effectiveFrom']) . "' AND '" . $db->convertDateToUS($_POST['effectiveTo']) . "' ";
    }

    $sql = "
  SELECT
  oqt_quotations.*
  ,ship.oqqit_date_1 as shipmentDate
  ,ship.oqqit_rate_1 as typeOfShipment
  ,ship.oqqit_rate_2 as valueCurrency
  ,ship.oqqit_rate_3 as insuredValue 
  ,ship.oqqit_rate_4 as commodity
  ,ship.oqqit_rate_5 as exchangeRate
  ,ship.oqqit_rate_6 as conveyance
  ,ship.oqqit_rate_7 as convVesselName
  ,ship.oqqit_rate_9 as packShipMethod
  ,(SELECT cde_value FROM codes WHERE ship.oqqit_rate_10 = cde_code_ID)as countOrigin
  ,ship.oqqit_rate_11 as viaCountry
  ,(SELECT cde_value FROM codes WHERE ship.oqqit_rate_12 = cde_code_ID)as destCountry
  ,ship.oqqit_rate_13 as conditions
  ,ship.oqqit_rate_14 as cityOrigin
  ,ship.oqqit_rate_15 as cityDestination
  
  ,cargo.oqqit_rate_1 as fullDescription 
  ,cargo.oqqit_rate_2 as marksNumbers
  ,cargo.oqqit_rate_3 as letterCredit
  ,cargo.oqqit_rate_5 as supplier
  ,cargo.oqqit_rate_6 as excess
  ,cargo.oqqit_rate_7 as reference
  ,cargo.oqqit_rate_8 as rate
  FROM 
  oqt_quotations
  JOIN oqt_quotations_items as ship ON oqq_quotations_ID = ship.oqqit_quotations_ID AND ship.oqqit_items_ID = 3
  JOIN oqt_quotations_items as cargo ON oqq_quotations_ID = cargo.oqqit_quotations_ID AND cargo.oqqit_items_ID = 4
  
  WHERE
  1=1
  " . $where . "
  ORDER BY oqq_number ASC";

    if ($_POST['results'] == 'excel') {

        outputExcel($sql);

    }//if to output results in excel
}


$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');

$db->enable_jquery_ui();
$db->show_header();
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>

            <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                    <?php $formValidator->echoFormParameters(); ?>>
                    <div class="row">
                        <div class="col-12 alert alert-primary text-center">
                            <strong>Bordereaux</strong>
                        </div>
                    </div>
                    <div class="row d-none d-md-block" style="height: 35px;"></div>

                    <div class="row">
                        <label for="type" class="col-sm-2">Type</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="type" name="type">
                                <option value="Marine" <?php if ($_POST['type'] == 'Marine') echo 'selected'; ?>>Marine
                                    Cargo
                                </option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'type',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => 'Must select Type'
                                ]);
                            ?>
                        </div>
                        <label for="status" class="col-sm-2">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="status" name="status">
                                <option value="Active" <?php if ($_POST['status'] == 'Active') echo 'selected'; ?>>
                                    Active
                                </option>
                                <option value="Outstanding" <?php if ($_POST['status'] == 'Outstanding') echo 'selected'; ?>>
                                    Outstanding
                                </option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'status',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => 'Must select Status'
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <label for="numberFrom" class="col-sm-2">Number From:</label>
                        <div class="col-sm-2">
                            <input type="text" id="numberFrom" name="numberFrom"
                                   class="form-control" value="<?php echo $_POST['numberFrom']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'numberFrom',
                                    'fieldDataType' => 'text',
                                    'required' => false
                                ]);
                            ?>
                        </div>

                        <label for="numberTo" class="col-sm-1 text-right">To:</label>
                        <div class="col-sm-2">
                            <input type="text" id="numberTo" name="numberTo"
                                   class="form-control" value="<?php echo $_POST['numberTo']; ?>">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'numberTo',
                                    'fieldDataType' => 'text',
                                    'required' => false
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="row">
                        <label for="effectiveFrom" class="col-sm-2">Effective Date From:</label>
                        <div class="col-sm-2">
                            <input type="text" id="effectiveFrom" name="effectiveFrom"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'effectiveFrom',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['effectiveFrom'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>

                        <label for="effectiveTo" class="col-sm-1 text-right">To:</label>
                        <div class="col-sm-2">
                            <input type="text" id="effectiveTo" name="effectiveTo"
                                   class="form-control" value="">
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'effectiveTo',
                                    'fieldDataType' => 'date',
                                    'required' => false,
                                    'enableDatePicker' => true,
                                    'datePickerValue' => $_POST['effectiveTo'],
                                    'invalidText' => ''
                                ]);
                            ?>
                        </div>

                    </div>

                    <div class="row">
                        <label for="results" class="col-sm-2">Results</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="results" name="results">
                                <option value="Show" <?php if ($_POST['results'] == 'Show') echo 'selected'; ?>>Show
                                </option>
                                <option value="excel" <?php if ($_POST['results'] == 'excel') echo 'selected'; ?>>Output
                                    as Excel File
                                </option>
                            </select>
                            <?php
                            $formValidator->addField(
                                [
                                    'fieldName' => 'results',
                                    'fieldDataType' => 'select',
                                    'required' => true,
                                    'invalidText' => 'Must select Results'
                                ]);
                            ?>
                        </div>
                    </div>


                    <!-- BUTTONS -->
                    <div class="row d-none d-sm-block" style="height: 15px;"></div>
                    <div class="form-group row">
                        <label for="name" class="col-md-5 col-form-label"></label>
                        <div class="col-md-7">
                            <input name="action" type="hidden" id="action"
                                   value="search">
                            <input type="submit"
                                   value="Search"
                                   class="btn btn-secondary" id="Submit">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php
if ($_POST['action'] == 'search') {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>

            <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <strong>Results</strong>
                    </div>
                </div>

                <div class="row" style="height: 25px;"></div>

                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <?php
                        $result = $db->query($sql);
                        echo "Total Results: " . $db->num_rows($result);
                        ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Number</th>
                                <th scope="col">Activation Date</th>
                                <th scope="col">Shipment Date</th>
                                <th scope="col">Client</th>
                                <th scope="col">Comodity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            while ($row = $db->fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['oqq_quotations_ID']; ?></td>
                                    <td><?php echo $row['oqq_number']; ?></td>
                                    <td><?php echo $db->convert_date_format($row['oqq_last_update_date_time'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 1); ?></td>
                                    <td><?php echo $db->convertDateToEU($row['shipmentDate']); ?></td>
                                    <td><?php echo $row['oqq_insureds_name']; ?></td>
                                    <td><?php echo $row['commodity']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>


    </div>
    <?php
}
?>

<?php
$db->show_footer();

function outputExcel($sql)
{
    global $db;

    $result = $db->query($sql);

    $spreadsheet = new Spreadsheet();
// Set document properties
    $spreadsheet->getProperties()
        ->setCreator('Maarten Balliauw')
        ->setLastModifiedBy('Maarten Balliauw')
        ->setTitle('PhpSpreadsheet Test Document')
        ->setSubject('PhpSpreadsheet Test Document')
        ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
        ->setKeywords('office PhpSpreadsheet php')
        ->setCategory('Test result file');

// add first line header data
    $str = 'A';
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue($str . '1', 'Type')
        ->setCellValue(++$str . '1', '#')
        ->setCellValue(++$str . '1', 'Number')
        ->setCellValue(++$str . '1', 'Activation Date')
        ->setCellValue(++$str . '1', 'Shipment Date')
        ->setCellValue(++$str . '1', 'Client Name')
        ->setCellValue(++$str . '1', 'Client ID')
        ->setCellValue(++$str . '1', 'Insured Val Cur.')
        ->setCellValue(++$str . '1', 'Insured Val')
        ->setCellValue(++$str . '1', 'Exchange Rate')
        ->setCellValue(++$str . '1', 'Commodity')
        ->setCellValue(++$str . '1', 'Conveyance')
        ->setCellValue(++$str . '1', 'Conv.Vessel Name')
        ->setCellValue(++$str . '1', 'Pack/Ship Method')
        ->setCellValue(++$str . '1', 'Count.Origin')
        ->setCellValue(++$str . '1', 'City Of Origin')
        ->setCellValue(++$str . '1', 'Via.Country')
        ->setCellValue(++$str . '1', 'Des.Country')
        ->setCellValue(++$str . '1', 'Dest.City')
        ->setCellValue(++$str . '1', 'Conditions')
        ->setCellValue(++$str . '1', 'Cargo Description')
        ->setCellValue(++$str . '1', 'Marks&Numbers')
        ->setCellValue(++$str . '1', 'Letter of Credit')
        ->setCellValue(++$str . '1', 'Notes')
        ->setCellValue(++$str . '1', 'Supplier')
        ->setCellValue(++$str . '1', 'Excess')
        ->setCellValue(++$str . '1', 'Reference')
        ->setCellValue(++$str . '1', 'Rate');
//make all align of the row LEFT
    $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
//make all row Bold
    $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getFont()->setBold(true);


    $line = 1;
    while ($row = $db->fetch_assoc($result)) {
        $str = 'A';
        $line++;
        $spreadsheet->getActiveSheet()
            ->setCellValue($str . $line, 'Marine Cargo')
            ->setCellValue(++$str . $line, $row['oqq_quotations_ID'])
            ->setCellValue(++$str . $line, $row['oqq_number'])
            ->setCellValue(++$str . $line, $db->convert_date_format($row['oqq_last_update_date_time'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 1))
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['shipmentDate']))
            ->setCellValue(++$str . $line, $row['oqq_insureds_name'])
            ->setCellValue(++$str . $line, $row['oqq_insureds_id'])
            ->setCellValue(++$str . $line, $row['valueCurrency'])
            ->setCellValue(++$str . $line, $row['insuredValue'])
            ->setCellValue(++$str . $line, $row['exchangeRate'])
            ->setCellValue(++$str . $line, $row['commodity'])
            ->setCellValue(++$str . $line, $row['conveyance'])
            ->setCellValue(++$str . $line, $row['convVesselName'])
            ->setCellValue(++$str . $line, $row['packShipMethod'])
            ->setCellValue(++$str . $line, $row['countOrigin'])
            ->setCellValue(++$str . $line, $row['cityOrigin'])
            ->setCellValue(++$str . $line, $row['viaCountry'])
            ->setCellValue(++$str . $line, $row['destCountry'])
            ->setCellValue(++$str . $line, $row['cityDestination'])
            ->setCellValue(++$str . $line, $row['conditions'])
            ->setCellValue(++$str . $line, $row['fullDescription'])
            ->setCellValue(++$str . $line, $row['marksNumbers'])
            ->setCellValue(++$str . $line, $row['letterCredit'])
            ->setCellValue(++$str . $line, $row['oqq_extra_details'])
            ->setCellValue(++$str . $line, $row['supplier'])
            ->setCellValue(++$str . $line, $row['excess'])
            ->setCellValue(++$str . $line, $row['reference'])
            ->setCellValue(++$str . $line, $row['rate']);

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . $line)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    }

    $str = 'A';
    $stop = false;
    while ($stop == false) {
        //set columns to autosize the width
        $spreadsheet->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);

        ++$str;
        if ($str == 'Z') {
            $stop = true;
        }
    }
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);

//$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


    $spreadsheet->getActiveSheet()
        ->setTitle('Marine Cargo Bordereaux');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);
    //$writer = IOFactory::createWriter($spreadsheet, 'Xls');
    //$writer->save('output.xls');
    //$file = file_get_contents('output.xls');


    // Redirect output to a client’s web browser (Xls)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="bordereaux.xls"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save('php://output');

}


?>