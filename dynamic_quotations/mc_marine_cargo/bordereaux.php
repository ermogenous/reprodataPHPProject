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
    } else if ($_POST['type'] == 'Travel') {
        $where = 'AND oqq_quotations_type_ID = 3 ';
    }

    if ($_POST['status'] != '') {
        $where .= "AND oqq_status = '" . $_POST['status'] . "' ";
    }

    if ($_POST['numberFrom'] != '') {
        $where .= "AND oqq_number BETWEEN '" . $_POST['numberFrom'] . "' AND '" . $_POST['numberTo'] . "' ";
    }

    if ($_POST['effectiveFrom'] != '') {
        $where .= "AND oqq_effective_date BETWEEN 
        '" . $db->convertDateToUS($_POST['effectiveFrom']) . " 00:00:00' AND '" . $db->convertDateToUS($_POST['effectiveTo']) . " 23:59:59' ";
    }



    if ($_POST['type'] == 'Marine') {
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
    } else if ($_POST['type'] == 'Travel') {
        $sql = "
          SELECT
          oqt_quotations.*
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = oqq_nationality_ID) as clo_client_nationality
          
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = tr_info.oqqit_rate_1)as clo_destination_country
          ,tr_info.oqqit_rate_2 as clo_geographical_area
          ,tr_info.oqqit_rate_3 as clo_winter_sports
          ,tr_info.oqqit_rate_4 as clo_package
          ,tr_info.oqqit_rate_5 as clo_period_days
          ,tr_info.oqqit_date_1 as clo_departure_date
          
          ,members13.oqqit_rate_2 as clo_1_name
          ,members13.oqqit_rate_3 as clo_1_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members13.oqqit_rate_4) as clo_1_nationality
          ,members13.oqqit_date_1 as clo_1_birthdate
          
          ,members13.oqqit_rate_7 as clo_2_name
          ,members13.oqqit_rate_8 as clo_2_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members13.oqqit_rate_9) as clo_2_nationality
          ,members13.oqqit_date_2 as clo_2_birthdate
          
          ,members13.oqqit_rate_12 as clo_3_name
          ,members13.oqqit_rate_13 as clo_3_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members13.oqqit_rate_14) as clo_3_nationality
          ,members13.oqqit_date_3 as clo_3_birthdate

          
          ,members46.oqqit_rate_2 as clo_4_name
          ,members46.oqqit_rate_3 as clo_4_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members46.oqqit_rate_4) as clo_4_nationality
          ,members46.oqqit_date_1 as clo_4_birthdate
          
          ,members46.oqqit_rate_7 as clo_5_name
          ,members46.oqqit_rate_8 as clo_5_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members46.oqqit_rate_9) as clo_5_nationality
          ,members46.oqqit_date_2 as clo_5_birthdate
          
          ,members46.oqqit_rate_12 as clo_6_name
          ,members46.oqqit_rate_13 as clo_6_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members46.oqqit_rate_14) as clo_6_nationality
          ,members46.oqqit_date_3 as clo_6_birthdate
          
          
          ,members79.oqqit_rate_2 as clo_7_name
          ,members79.oqqit_rate_3 as clo_7_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members79.oqqit_rate_4) as clo_7_nationality
          ,members79.oqqit_date_1 as clo_7_birthdate
          
          ,members79.oqqit_rate_7 as clo_8_name
          ,members79.oqqit_rate_8 as clo_8_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members79.oqqit_rate_9) as clo_8_nationality
          ,members79.oqqit_date_2 as clo_8_birthdate
          
          ,members79.oqqit_rate_12 as clo_9_name
          ,members79.oqqit_rate_13 as clo_9_id
          ,(SELECT cde_value FROM codes WHERE cde_code_ID = members79.oqqit_rate_14) as clo_9_nationality
          ,members79.oqqit_date_3 as clo_9_birthdate
          
          ,usr_name
          ,oqun_tr_open_cover_number
          
          FROM 
          oqt_quotations
          JOIN oqt_quotations_items as tr_info ON oqq_quotations_ID = tr_info.oqqit_quotations_ID AND tr_info.oqqit_items_ID = 5
          JOIN oqt_quotations_items as members13 ON oqq_quotations_ID = members13.oqqit_quotations_ID AND members13.oqqit_items_ID = 6
          JOIN oqt_quotations_items as members46 ON oqq_quotations_ID = members46.oqqit_quotations_ID AND members46.oqqit_items_ID = 7
          JOIN oqt_quotations_items as members79 ON oqq_quotations_ID = members79.oqqit_quotations_ID AND members79.oqqit_items_ID = 8
          JOIN users ON usr_users_ID = oqq_users_ID
          JOIN oqt_quotations_underwriters ON oqun_user_ID = oqq_users_ID
          WHERE
          1=1
          " . $where . "
          ORDER BY oqq_number ASC";
    }


    //echo $sql;

    if ($_POST['results'] == 'excel') {

        if ($_POST['type'] == 'Marine') {
            outputExcelMarine($sql);
        }
        else if ($_POST['type'] == 'Travel') {
            outputExcelTravel($sql);
        }

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
                                <option value="Marine" <?php if ($_POST['type'] == 'Marine') echo 'selected'; ?>>
                                    Marine Cargo
                                </option>
                                <option value="Travel" <?php if ($_POST['type'] == 'Travel') echo 'selected'; ?>>
                                    Travel
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
                                <th scope="col">
                                    <?php
                                    if ($_POST['type'] == 'Marine') {
                                        echo 'Shipment Date';
                                    }
                                    else if ($_POST['type'] == 'Travel') {
                                        echo "Departure Date";
                                    }
                                    ?>
                                </th>
                                <th scope="col">Client</th>
                                <th scope="col">
                                    <?php
                                    if ($_POST['type'] == 'Marine') {
                                        echo 'Comodity';
                                    }
                                    else if ($_POST['type'] == 'Travel') {
                                        echo "Package";
                                    }
                                    ?>

                                </th>
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
                                    <td><?php
                                        if ($_POST['type'] == 'Marine') {
                                            echo $db->convertDateToEU($row['shipmentDate']);
                                        }
                                        else if ($_POST['type'] == 'Travel') {
                                            echo $db->convertDateToEU($row['clo_departure_date']);
                                        }
                                        ?></td>
                                    <td><?php echo $row['oqq_insureds_name']; ?></td>
                                    <td><?php
                                        if ($_POST['type'] == 'Marine') {
                                            echo $row['commodity'];
                                        }
                                        else if ($_POST['type'] == 'Travel') {
                                            echo $row['clo_package'];
                                        }
                                        ?></td>
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

function outputExcelMarine($sql)
{
    global $db;

    $result = $db->query($sql);

    $spreadsheet = new Spreadsheet();
// Set document properties
    $spreadsheet->getProperties()
        ->setCreator('Kemter')
        ->setLastModifiedBy('Kemter')
        ->setTitle('Kemter Borderaux')
        ->setSubject('Kemter Borderaux')
        ->setDescription('Kemter Borderaux.')
        ->setKeywords('Kemter Borderaux')
        ->setCategory('Kemter Borderaux');

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
        ->setCellValue(++$str . '1', 'Rate')
        ->setCellValue(++$str . '1', 'SI Euro')
        ->setCellValue(++$str . '1', 'Premium');
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
            ->setCellValue(++$str . $line, $row['rate'])
            ->setCellValue(++$str . $line, round(($row['insuredValue'] * $row['exchangeRate']),2))
            ->setCellValue(++$str . $line, round((($row['insuredValue'] * $row['exchangeRate']) * ($row['rate']/100)),2) );

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

function outputExcelTravel($sql)
{
    global $db;

    $result = $db->query($sql);

    $spreadsheet = new Spreadsheet();
// Set document properties
    $spreadsheet->getProperties()
        ->setCreator('Kemter')
        ->setLastModifiedBy('Kemter')
        ->setTitle('Kemter Borderaux')
        ->setSubject('Kemter Borderaux')
        ->setDescription('Kemter Borderaux.')
        ->setKeywords('Kemter Borderaux')
        ->setCategory('Kemter Borderaux');

// add first line header data
    $str = 'A';
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue($str . '1', 'Type')
        ->setCellValue(++$str . '1', '#')
        ->setCellValue(++$str . '1', 'Agent')
        ->setCellValue(++$str . '1', 'Open Cover Number')
        ->setCellValue(++$str . '1', 'Number')
        ->setCellValue(++$str . '1', 'Premium')
        ->setCellValue(++$str . '1', 'Fees')
        ->setCellValue(++$str . '1', 'Stamps')
        ->setCellValue(++$str . '1', 'Activation Date')
        ->setCellValue(++$str . '1', 'Departure Date')
        ->setCellValue(++$str . '1', 'Return Date')
        ->setCellValue(++$str . '1', 'Client Name')
        ->setCellValue(++$str . '1', 'Client Nationality')
        ->setCellValue(++$str . '1', 'Client Birthdate')
        ->setCellValue(++$str . '1', 'Client Address')
        ->setCellValue(++$str . '1', 'Client City')
        ->setCellValue(++$str . '1', 'Client Postal Code')
        ->setCellValue(++$str . '1', 'Client Tel')
        ->setCellValue(++$str . '1', 'Destination')
        ->setCellValue(++$str . '1', 'Geographical')
        ->setCellValue(++$str . '1', 'Winter Sports')
        ->setCellValue(++$str . '1', 'Package')
        ->setCellValue(++$str . '1', 'Total Days')
        ->setCellValue(++$str . '1', 'Sum Insured')
        ->setCellValue(++$str . '1', '1-Name')
        ->setCellValue(++$str . '1', '1-ID')
        ->setCellValue(++$str . '1', '1-Nationality')
        ->setCellValue(++$str . '1', '1-Birthdate')
        ->setCellValue(++$str . '1', '2-Name')
        ->setCellValue(++$str . '1', '2-ID')
        ->setCellValue(++$str . '1', '2-Nationality')
        ->setCellValue(++$str . '1', '2-Birthdate')
        ->setCellValue(++$str . '1', '3-Name')
        ->setCellValue(++$str . '1', '3-ID')
        ->setCellValue(++$str . '1', '3-Nationality')
        ->setCellValue(++$str . '1', '3-Birthdate')
        ->setCellValue(++$str . '1', '4-Name')
        ->setCellValue(++$str . '1', '4-ID')
        ->setCellValue(++$str . '1', '4-Nationality')
        ->setCellValue(++$str . '1', '4-Birthdate')
        ->setCellValue(++$str . '1', '5-Name')
        ->setCellValue(++$str . '1', '5-ID')
        ->setCellValue(++$str . '1', '5-Nationality')
        ->setCellValue(++$str . '1', '5-Birthdate')
        ->setCellValue(++$str . '1', '6-Name')
        ->setCellValue(++$str . '1', '6-ID')
        ->setCellValue(++$str . '1', '6-Nationality')
        ->setCellValue(++$str . '1', '6-Birthdate')
        ->setCellValue(++$str . '1', '7-Name')
        ->setCellValue(++$str . '1', '7-ID')
        ->setCellValue(++$str . '1', '7-Nationality')
        ->setCellValue(++$str . '1', '7-Birthdate')
        ->setCellValue(++$str . '1', '8-Name')
        ->setCellValue(++$str . '1', '8-ID')
        ->setCellValue(++$str . '1', '8-Nationality')
        ->setCellValue(++$str . '1', '8-Birthdate')
        ->setCellValue(++$str . '1', '9-Name')
        ->setCellValue(++$str . '1', '9-ID')
        ->setCellValue(++$str . '1', '9-Nationality')
        ->setCellValue(++$str . '1', '9-Birthdate');
//make all align of the row LEFT
    $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
//make all row Bold
    $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . '1')->getFont()->setBold(true);


    $line = 1;
    while ($row = $db->fetch_assoc($result)) {

        $str = 'A';
        $line++;
        $spreadsheet->getActiveSheet()
            ->setCellValue($str . $line, 'Travel')
            ->setCellValue(++$str . $line, $row['oqq_quotations_ID'])
            ->setCellValue(++$str . $line, $row['usr_name'])
            ->setCellValue(++$str . $line, $row['oqun_tr_open_cover_number'])
            ->setCellValue(++$str . $line, $row['oqq_number'])
            ->setCellValue(++$str . $line, $row['oqq_premium'])
            ->setCellValue(++$str . $line, $row['oqq_fees'])
            ->setCellValue(++$str . $line, $row['oqq_stamps'])
            ->setCellValue(++$str . $line, $db->convert_date_format($row['oqq_last_update_date_time'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 1))
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_departure_date']))
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['oqq_expiry_date'],1,0))
            ->setCellValue(++$str . $line, $row['oqq_insureds_name'])
            ->setCellValue(++$str . $line, $row['clo_client_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['oqq_birthdate']))
            ->setCellValue(++$str . $line, $row['oqq_insureds_address'])
            ->setCellValue(++$str . $line, cityToEnglish($row['oqq_insureds_city']))
            ->setCellValue(++$str . $line, $row['oqq_insureds_postal_code'])
            ->setCellValue(++$str . $line, $row['oqq_insureds_tel'])
            ->setCellValue(++$str . $line, $row['clo_destination_country'])
            ->setCellValue(++$str . $line, $row['clo_geographical_area'])
            ->setCellValue(++$str . $line, $row['clo_winter_sports'])
            ->setCellValue(++$str . $line, $row['clo_package'])
            ->setCellValue(++$str . $line, $row['clo_period_days'])
            ->setCellValue(++$str . $line, getSumInsured($row['clo_package']))/*Sum Insured*/
            ->setCellValue(++$str . $line, $row['clo_1_name'])
            ->setCellValue(++$str . $line, $row['clo_1_id'])
            ->setCellValue(++$str . $line, $row['clo_1_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_1_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_2_name'])
            ->setCellValue(++$str . $line, $row['clo_2_id'])
            ->setCellValue(++$str . $line, $row['clo_2_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_2_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_3_name'])
            ->setCellValue(++$str . $line, $row['clo_3_id'])
            ->setCellValue(++$str . $line, $row['clo_3_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_3_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_4_name'])
            ->setCellValue(++$str . $line, $row['clo_4_id'])
            ->setCellValue(++$str . $line, $row['clo_4_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_4_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_5_name'])
            ->setCellValue(++$str . $line, $row['clo_5_id'])
            ->setCellValue(++$str . $line, $row['clo_5_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_5_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_6_name'])
            ->setCellValue(++$str . $line, $row['clo_6_id'])
            ->setCellValue(++$str . $line, $row['clo_6_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_6_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_7_name'])
            ->setCellValue(++$str . $line, $row['clo_7_id'])
            ->setCellValue(++$str . $line, $row['clo_7_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_7_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_8_name'])
            ->setCellValue(++$str . $line, $row['clo_8_id'])
            ->setCellValue(++$str . $line, $row['clo_8_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_8_birthdate']))
            ->setCellValue(++$str . $line, $row['clo_9_name'])
            ->setCellValue(++$str . $line, $row['clo_9_id'])
            ->setCellValue(++$str . $line, $row['clo_9_nationality'])
            ->setCellValue(++$str . $line, $db->convertDateToEU($row['clo_9_birthdate']));

        $spreadsheet->getActiveSheet()->getStyle('A1:' . $str . $line)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    }
    //set autosize from A-Z
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
    $str = 'A';
    $stop = false;
    while ($stop == false) {
        //set columns to autosize the width
        $spreadsheet->getActiveSheet()->getColumnDimension('A'.$str)->setAutoSize(true);
        ++$str;
        if ($str == 'U') {
            $stop = true;
        }
    }
    //set autosize A?
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);

//$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


    $spreadsheet->getActiveSheet()
        ->setTitle('Travel Bordereaux');

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

function cityToEnglish($cityGr){
    if ($cityGr == 'Λεμεσός'){
        return 'Limassol';
    }
    if ($cityGr == 'Λευκωσία'){
        return 'Nicosia';
    }
    if ($cityGr == 'Λάρνακα'){
        return 'Larnaca';
    }
    if ($cityGr == 'Πάφος'){
        return 'Paphos';
    }
    if ($cityGr == 'Αμμόχωστος'){
        return 'Famagusta';
    }
    if ($cityGr == 'Κερύνεια'){
        return 'Kerynia';
    }
}

function getSumInsured($package){
    if ($package == 'Basic'){
        return '50000';
    }
    if ($package == 'Standard'){
        return '100000';
    }
    if ($package == 'Luxury'){
        return '150000';
    }
    if ($package == 'Special'){
        return '100000';
    }
    if ($package == 'Schengen'){
        return '20000';
    }
    if ($package == 'Limited'){
        return '20000';
    }
}

?>
