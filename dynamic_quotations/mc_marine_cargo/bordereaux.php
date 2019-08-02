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

$db = new Main();
$db->admin_title = "Dynamic Quotations Marine Cargo Bordereaux";


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
    ->setCellValue($str.'1', 'Type')
    ->setCellValue(++$str.'1', '#')
    ->setCellValue(++$str.'1', 'Number')
    ->setCellValue(++$str.'1', 'Activation Date')
    ->setCellValue(++$str.'1', 'Shipment Date')
    ->setCellValue(++$str.'1', 'Client Name')
    ->setCellValue(++$str.'1', 'Client ID')
    ->setCellValue(++$str.'1', 'Insured Val Cur.')
    ->setCellValue(++$str.'1', 'Insured Val')
    ->setCellValue(++$str.'1', 'Commodity')
    ->setCellValue(++$str.'1', 'Conveyance')
    ->setCellValue(++$str.'1', 'Conv.Vessel Name')
    ->setCellValue(++$str.'1', 'Pack/Ship Method')
    ->setCellValue(++$str.'1', 'Count.Origin')
    ->setCellValue(++$str.'1', 'City Of Origin')
    ->setCellValue(++$str.'1', 'Via.Country')
    ->setCellValue(++$str.'1', 'Des.Country')
    ->setCellValue(++$str.'1', 'Dest.City')
    ->setCellValue(++$str.'1', 'Conditions')
    ->setCellValue(++$str.'1', 'Cargo Description')
    ->setCellValue(++$str.'1', 'Marks&Numbers')
    ->setCellValue(++$str.'1', 'Letter of Credit')
    ->setCellValue(++$str.'1', 'Notes')
    ->setCellValue(++$str.'1', 'Supplier')
    ->setCellValue(++$str.'1', 'Excess');
//make all align of the row LEFT
$spreadsheet->getActiveSheet()->getStyle('A1:'.$str.'1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
//make all row Bold
$spreadsheet->getActiveSheet()->getStyle('A1:'.$str.'1')->getFont()->setBold(true);

$sql = "
  SELECT
  oqt_quotations.*
  ,ship.oqqit_date_1 as shipmentDate
  ,ship.oqqit_rate_1 as typeOfShipment
  ,ship.oqqit_rate_2 as valueCurrency
  ,ship.oqqit_rate_3 as insuredValue 
  ,ship.oqqit_rate_4 as commodity
  ,ship.oqqit_rate_5 as coverageOption
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
  FROM 
  oqt_quotations
  JOIN oqt_quotations_items as ship ON oqq_quotations_ID = ship.oqqit_quotations_ID AND ship.oqqit_items_ID = 3
  JOIN oqt_quotations_items as cargo ON oqq_quotations_ID = cargo.oqqit_quotations_ID AND cargo.oqqit_items_ID = 4
  
  WHERE
  oqq_quotations_type_ID = 2
  AND oqq_status = 'Active'
  ";
$result = $db->query($sql);
$line = 1;
while ($row = $db->fetch_assoc($result)){
    $str = 'A';
    $line++;
    $spreadsheet->getActiveSheet()
        ->setCellValue($str.$line, 'Marine Cargo')
        ->setCellValue(++$str.$line, $row['oqq_quotations_ID'])
        ->setCellValue(++$str.$line, $row['oqq_number'])
        ->setCellValue(++$str.$line, $db->convert_date_format($row['oqq_last_update_date_time'],'yyyy-mm-dd','dd/mm/yyyy',1,1))
        ->setCellValue(++$str.$line, $db->convertDateToEU($row['shipmentDate']))
        ->setCellValue(++$str.$line, $row['oqq_insureds_name'])
        ->setCellValue(++$str.$line, $row['oqq_insureds_id'])
        ->setCellValue(++$str.$line, $row['valueCurrency'])
        ->setCellValue(++$str.$line, $row['insuredValue'])
        ->setCellValue(++$str.$line, $row['commodity'])
        ->setCellValue(++$str.$line, $row['conveyance'])
        ->setCellValue(++$str.$line, $row['convVesselName'])
        ->setCellValue(++$str.$line, $row['packShipMethod'])
        ->setCellValue(++$str.$line, $row['countOrigin'])
        ->setCellValue(++$str.$line, $row['cityOrigin'])
        ->setCellValue(++$str.$line, $row['viaCountry'])
        ->setCellValue(++$str.$line, $row['destCountry'])
        ->setCellValue(++$str.$line, $row['cityDestination'])
        ->setCellValue(++$str.$line, $row['conditions'])
        ->setCellValue(++$str.$line, $row['fullDescription'])
        ->setCellValue(++$str.$line, $row['marksNumbers'])
        ->setCellValue(++$str.$line, $row['letterCredit'])
        ->setCellValue(++$str.$line, $row['oqq_extra_details'])
        ->setCellValue(++$str.$line, $row['supplier'])
        ->setCellValue(++$str.$line, $row['excess']);

    $spreadsheet->getActiveSheet()->getStyle('A1:'.$str.$line)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

}

$str = 'A';
$stop = false;
while ($stop == false){
    //set columns to autosize the width
    $spreadsheet->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);

    ++$str;
    if ($str == 'Z'){
        $stop = true;
    }
}

//$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



$spreadsheet->getActiveSheet()
    ->setTitle('Marine Cargo Bordereaux');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('test.xls');


/*
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");


// Add first row header
$str = 'A';
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue($str.'1', 'Type')
    ->setCellValue(++$str.'1', 'Number')
    ->setCellValue(++$str.'1', 'Activation Date')
    ->setCellValue(++$str.'1', 'Shipment Date')
    ->setCellValue(++$str.'1', 'Client Name')
    ->setCellValue(++$str.'1', 'Client ID')
    ->setCellValue(++$str.'1', 'Insured Val Cur.')
    ->setCellValue(++$str.'1', 'Insured Val')
    ->setCellValue(++$str.'1', 'Commodity')
    ->setCellValue(++$str.'1', 'Conveyance')
    ->setCellValue(++$str.'1', 'Conv.Vessel Name')
    ->setCellValue(++$str.'1', 'Pack/Ship Method')
    ->setCellValue(++$str.'1', 'Count.Origin')
    ->setCellValue(++$str.'1', 'City Of Origin')
    ->setCellValue(++$str.'1', 'Via.Country')
    ->setCellValue(++$str.'1', 'Des.Country')
    ->setCellValue(++$str.'1', 'Dest.City')
    ->setCellValue(++$str.'1', 'Conditions')
    ->setCellValue(++$str.'1', 'Cargo Description')
    ->setCellValue(++$str.'1', 'Marks&Numbers')
    ->setCellValue(++$str.'1', 'Letter of Credit')
    ->setCellValue(++$str.'1', 'Notes')
    ->setCellValue(++$str.'1', 'Supplier')
    ->setCellValue(++$str.'1', 'Excess');
$sql = "
  SELECT
  oqt_quotations.*
  ,ship.oqqit_date_1 as shipmentDate
  ,ship.oqqit_rate_1 as typeOfShipment
  ,ship.oqqit_rate_2 as valueCurrency
  ,ship.oqqit_rate_3 as insuredValue 
  ,ship.oqqit_rate_4 as commodity
  ,ship.oqqit_rate_5 as coverageOption
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
  FROM 
  oqt_quotations
  JOIN oqt_quotations_items as ship ON oqq_quotations_ID = ship.oqqit_quotations_ID AND ship.oqqit_items_ID = 3
  JOIN oqt_quotations_items as cargo ON oqq_quotations_ID = cargo.oqqit_quotations_ID AND cargo.oqqit_items_ID = 4
  
  WHERE
  oqq_quotations_type_ID = 2
  AND oqq_status = 'Active'
  ";
$result = $db->query($sql);
$line = 1;

while ($row = $db->fetch_assoc($result)){
    $str = 'A';
    $line++;
    $objPHPExcel->getActiveSheet()
        ->setCellValue($str.$line, $row['oqq_quotations_ID'].'Marine Cargo')
        ->setCellValue(++$str.$line, $row['oqq_number'])
        ->setCellValue(++$str.$line, $db->convert_date_format($row['oqq_last_update_date_time'],'yyyy-mm-dd','dd/mm/yyyy',1,1))
        ->setCellValue(++$str.$line, $db->convertDateToEU($row['shipmentDate']))
        ->setCellValue(++$str.$line, $row['oqq_insureds_name'])
        ->setCellValue(++$str.$line, $row['oqq_insureds_id'])
        ->setCellValue(++$str.$line, $row['valueCurrency'])
        ->setCellValue(++$str.$line, $row['insuredValue'])
        ->setCellValue(++$str.$line, $row['commodity'])
        ->setCellValue(++$str.$line, $row['conveyance'])
        ->setCellValue(++$str.$line, $row['convVesselName'])
        ->setCellValue(++$str.$line, $row['packShipMethod'])
        ->setCellValue(++$str.$line, $row['countOrigin'])
        ->setCellValue(++$str.$line, $row['cityOrigin'])
        ->setCellValue(++$str.$line, $row['viaCountry'])
        ->setCellValue(++$str.$line, $row['destCountry'])
        ->setCellValue(++$str.$line, $row['cityDestination'])
        ->setCellValue(++$str.$line, $row['conditions'])

        ->setCellValue(++$str.$line, $row['fullDescription'])
        ->setCellValue(++$str.$line, $row['marksNumbers'])
        ->setCellValue(++$str.$line, $row['letterCredit'])
        ->setCellValue(++$str.$line, $row['oqq_extra_details'])
        ->setCellValue(++$str.$line, $row['supplier'])
        ->setCellValue(++$str.$line, $row['excess']);

}

$str = 'A';
$stop = false;
while ($stop == false){
    //set columns to autosize the width
    $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);
    ++$str;
    if ($str == 'Z'){
        $stop = true;
    }
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
//$objWriter->save('php://output');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', 'MicTest.xls'));
*/
$db->show_header();
?>



<?php
$db->show_footer();
?>