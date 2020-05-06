<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 05/05/2020
 * Time: 11:41
 */

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MEBuildExcel
{

    private $spreadsheet;
    private $propCreator = 'Creator';
    private $PropTitle = 'Title';
    private $propSubject = 'Subject';
    private $propDescription = 'Description';
    private $propKeywords = 'Keywords another';
    private $propCateogory = 'Category';
    private $currentRow = 1;


    function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        // Set document properties
        $this->spreadsheet->getProperties()
            ->setCreator($this->propCreator)
            ->setLastModifiedBy($this->propCreator)
            ->setTitle($this->PropTitle)
            ->setSubject($this->propSubject)
            ->setDescription($this->propDescription)
            ->setKeywords($this->propKeywords)
            ->setCategory($this->propCateogory);
        $this->spreadsheet->setActiveSheetIndex(0);
    }

    public function buildTopRowFromFieldNames($array)
    {

        $str = 'A';
        foreach($array as $name => $value){
            $this->spreadsheet->getActiveSheet()
                ->setCellValue($str . '1', $name);
            $this->spreadsheet->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);
            ++$str;
        }
        return $this;
    }

    public function addRowFromArray($array)
    {
        $str = 'A';
        $this->currentRow++;
        foreach($array as $name => $value){
            $this->spreadsheet->getActiveSheet()
                ->setCellValue($str . $this->currentRow, $value);
            $this->spreadsheet->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);
            ++$str;
        }
    }

    public function outputAsDownload($filename)
    {
        $this->spreadsheet->setActiveSheetIndex(0);
        //$writer = IOFactory::createWriter($spreadsheet, 'Xls');
        //$writer->save('output.xls');
        //$file = file_get_contents('output.xls');


        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    /**
     * @param string $propCreator
     * @return $this
     */
    public function setPropCreator($propCreator)
    {
        $this->propCreator = $propCreator;
        return $this;
    }

    /**
     * @param string $PropTitle
     * @return $this
     */
    public function setPropTitle($PropTitle)
    {
        $this->PropTitle = $PropTitle;
        return $this;
    }

    /**
     * @param string $propSubject
     * @return $this
     */
    public function setPropSubject($propSubject)
    {
        $this->propSubject = $propSubject;
        return $this;
    }

    /**
     * @param string $propDescription
     * @return $this
     */
    public function setPropDescription($propDescription)
    {
        $this->propDescription = $propDescription;
        return $this;
    }

    /**
     * @param string $propKeywords
     * @return $this
     */
    public function setPropKeywords($propKeywords)
    {
        $this->propKeywords = $propKeywords;
        return $this;
    }

    /**
     * @param string $propCateogory
     * @return $this
     */
    public function setPropCateogory($propCateogory)
    {
        $this->propCateogory = $propCateogory;
        return $this;
    }
}