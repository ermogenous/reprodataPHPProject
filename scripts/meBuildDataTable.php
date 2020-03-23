<?php
class MEBuildDataTable {
    private $outputType = 'div';//DIV/TABLE
    /**
     * @var an array of data. First row is the header names
     */
    private $data;
    private $dataHeader;
    private $dataLines;
    private $whereAreHeaders = 'FirstRow';

    //for table options
    private $tableCustomSettings = 'border="0" class="table table-striped"';

    function __construct()
    {
        return $this;
    }

    public function makeOutput(){
        if ($this->outputType == 'div'){
            return $this->makeDiv();
        }
        else {
            return $this->makeTable();
        }
    }

    private function makeTable(){
        $html = '
        <table '.$this->tableCustomSettings.'>
            <tr>
                ';

        if (!empty($this->dataHeader)) {
            foreach ($this->dataHeader as $value) {
                $html .= "<td>" . $value . "</td>";
            }
        }

        $html .='
            </tr>
            ';
        foreach($this->dataLines as $line){
            $html .= "<tr>".PHP_EOL;
            foreach($line as $field){
                $html.= "<td>".$field."</td>".PHP_EOL;
            }
            $html .= "</tr>".PHP_EOL;
        }
        $html .='
        
        </table>
        ';

        return $html;
    }

    private function makeDiv(){

    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        if ($this->whereAreHeaders == 'firstRow'){

            $i=0;
            foreach($this->data as $name => $value){
                //the first row is the headers
                if ($i == 0){
                    foreach($value as $firstName => $firstValue){
                        $this->dataHeader[] = $firstName;
                    }
                }
                //the rest of the rows are the lines
                else {
                    $this->dataLines[] = $value;
                }
                $i++;
            }

        }
        else if ($this->whereAreHeaders == 'fieldNames'){
            $this->dataLines = $this->data;
            if (!empty($this->dataLines)) {
                foreach ($this->data[0] as $name => $value) {
                    $this->dataHeader[] = $name;
                }
            }
        }


        return $this;
    }

    public function getHeadersFromFirstRow(){
        $this->whereAreHeaders = 'firstRow';
        return $this;
    }
    public function getHeadersFromFieldNames(){
        $this->whereAreHeaders = 'fieldNames';
        return $this;
    }

    public function makeTableOutput(){
        $this->outputType = 'table';
        return $this;
    }
    public function makeDivOutput(){
        $this->outputType = 'div';
        return $this;
    }

    /**
     * @param string $tableCustomSettings
     * @return $this
     */
    public function setTableCustomSettings($tableCustomSettings)
    {
        $this->tableCustomSettings = $tableCustomSettings;
        return $this;
    }



}