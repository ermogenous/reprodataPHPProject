<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 2/11/2019
 * Time: 2:39 ΜΜ
 */

class TableList
{
    //SQL
    private $tableName;
    private $uniqueID;
    private $sqlSelect = '';
    private $sqlFrom = '';
    private $sqlWhere = '';
    private $sqlOrderBy = '';
    private $sqlGroupBy = '';
    private $sqlHaving = '';
    private $sql = '';
    private $sqlResult;
    private $sqlTotalResults;
    private $tableTotalResults;
    private $sqlTotalFields = 0;
    private $allFieldsArray = [];

    private $sqlGenerated = false;
    private $sqlDataGenerated = false;

    //for table generation
    private $mainIDField;
    private $topTitle;
    private $topTitleClass;
    private $leftColumnClass = '';
    private $mainColumnClass = 'col-sm-8';
    private $rightColumnClass = '';
    private $topContainer = 'container';
    private $tableHtml = '';
    private $showPagesLinksTop = false;
    private $showPagesLinksBottom = false;
    private $createNewLink;
    private $modifyLink;
    private $modifyLinkTarget;
    private $deleteLink;
    private $enableEditOnTouch = false;
    private $deleteConfirmText = 'Are you sure you want to delete this record?';
    private $disableModifyIcon = false;
    private $disableDeleteIcon = false;
    private $disableIconColumn = false;
    private $disableClickRowLink = false;
    private $functionIconArea; //Set a function name here and will be called passed the row data
    private $extraColumns = [];

    //output
    private $outputAsPDF = false;

    //pages links
    private $perPage = 50; //to set this must be before generateSql
    private $pagesLinksGenerated = false;
    private $pagesLinksHtml;
    private $totalPages;
    private $currentPage;

    //Main object variable
    private $mainObjectVar = 'db'; /*if not defined it will use $db or else the defined one note: it will execute sql functions from this object*/

    function __construct()
    {

    }

    /**
     * @param $tableName The name of the db table
     * @param $uniqueID A unique ID for this instance so it will keep the session data
     * @return $this
     */
    public function setTable($tableName, $uniqueID)
    {
        $this->tableName = $tableName;
        $this->uniqueID = $uniqueID;
        return $this;
    }

    /**
     * @param $fieldName
     * @param $asName
     * @param array $settings
     * @return $this
     */
    public function setSqlSelect($fieldName, $asName, $settings = [])
    {
        /**
         * Settings: ex: [
         * 'functionName' => 'convertDateToEu'
         * 'IgnoreField' => true
         * 'thAlign' => left,right,center -> align of the header td
         * 'tdAlign' => left,right,center -> align of the row td
         * ]
         */
        if ($this->sqlSelect != '') {
            $this->sqlSelect .= ',';
        }
        $this->sqlSelect .= PHP_EOL . $fieldName . " as `" . $asName . "`";
        $this->sqlTotalFields++;
        $this->allFieldsArray[$this->sqlTotalFields]['name'] = $asName;
        $this->allFieldsArray[$this->sqlTotalFields]['ignoreField'] = $settings['ignoreField'];
        $this->allFieldsArray[$this->sqlTotalFields]['thAlign'] = $settings['thAlign'];
        $this->allFieldsArray[$this->sqlTotalFields]['tdAlign'] = $settings['tdAlign'];
        if ($settings['functionName'] != '') {
            $this->allFieldsArray[$this->sqlTotalFields]['function'] = $settings['functionName'];
        }
        return $this;
    }

    public function setSqlFrom($from)
    {
        $this->sqlFrom .= PHP_EOL . $from;
        return $this;
    }

    public function setSqlWhere($where)
    {
        $this->sqlWhere .= PHP_EOL . $where;
        return $this;
    }

    public function setSqlOrder($order, $orderType)
    {
        if ($this->sqlOrderBy != '') {
            $this->sqlOrderBy .= ", ";
        }
        $this->sqlOrderBy .= PHP_EOL . $order . " " . $orderType;
        return $this;
    }

    public function setSqlGroup($group)
    {
        $this->sqlGroupBy .= PHP_EOL . $group;
        return $this;
    }

    public function setSqlHaving($having)
    {
        $this->sqlHaving .= PHP_EOL . $having;
        return $this;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function setMainFieldID($field)
    {
        $this->mainIDField = $field;
        return $this;
    }

    public function setTopTitle($title, $class = 'alert alert-primary')
    {
        $this->topTitle = $title;
        $this->topTitleClass = $class;
        return $this;
    }

    /**
     * @param $class if you set this a left column will be added with the defined class
     */
    public function setLeftColumn($class)
    {
        $this->leftColumnClass = $class;
        return $this;
    }

    //Table Builder

    public function setMainColumn($class)
    {
        $this->mainColumnClass = $class;
        return $this;
    }

    public function setRightColumn($class)
    {
        $this->rightColumnClass = $class;
        return $this;
    }

    public function setTopContainerToFluid()
    {
        $this->topContainer = 'container-fluid';
        return $this;
    }

    //-->For header

    public function showPagesLinksTop()
    {
        $this->showPagesLinksTop = true;
        return $this;
    }

    public function showPagesLinksBottom()
    {
        $this->showPagesLinksBottom = true;
        return $this;
    }

    /**
     * @param $link The link for create new - set to false if dont want the link
     * @return $this
     */
    public function setCreateNewLink($link)
    {
        $this->createNewLink = $link;
        return $this;
    }

    /** At the end of the modifyLink the lid will be added automatically
     * ->setModifyLink('policy_item_modify.php?pid='.$_GET['pid'].'&type='.$_GET['type'].'&lid=')
     * @param $link
     * @param string $target
     * @return $this
     */
    public function setModifyLink($link, $target = '_self')
    {
        $this->modifyLink = $link;
        $this->modifyLinkTarget = $target;
        return $this;
    }

    /**At the end of the deleteyLink the lid will be added automatically
     * ->setDeleteLink('policy_item_delete.php?pid='.$_GET['pid'].'&type='.$_GET['type'].'&lid=')
     * @param $link
     * @return $this
     */
    public function setDeleteLink($link)
    {
        $this->deleteLink = $link;
        return $this;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setEnableEditOnTouch()
    {
        $this->enableEditOnTouch = true;
        return $this;
    }

    public function setDeleteConfirmText($text)
    {
        $this->deleteConfirmText = $text;
        return $this;
    }

    public function setDisableModifyIcon()
    {
        $this->disableModifyIcon = true;
        return $this;
    }

    public function setDisableDeleteICon()
    {
        $this->disableDeleteIcon = true;
        return $this;
    }

    public function setDisableIconColumn()
    {
        $this->disableIconColumn = true;
        return $this;
    }

    public function setDisableClickRowLink(){
        $this->disableClickRowLink = true;
        return $this;
    }

    public function setFunctionIconArea($function)
    {
        $this->functionIconArea = $function;
        return $this;
    }

    public function setOutputAsPDF()
    {
        $this->outputAsPDF = true;
    }

    /** Adds extra column after the fields. Executes the defined function to get the data to show
     * @param $title
     * @param $functionName the name of the function to execute
     * @param $settings
     * @return $this
     */
    public function addTableColumn($title, $functionName, $settings = [])
    {
        $total = count($this->extraColumns);
        $total++;
        $this->extraColumns[$total]['title'] = $title;
        $this->extraColumns[$total]['function'] = $functionName;
        $this->extraColumns[$total]['thAlign'] = $settings['thAlign'];
        $this->extraColumns[$total]['tdAlign'] = $settings['tdAlign'];
        return $this;
    }

    public function tableFullBuilder()
    {
        if ($this->sqlDataGenerated == false) {
            $this->generateData();
        }
        //need to re-execute to get the total records in this page.
        $this->buildPagesLinks();

        //global $db;
        $mainObjectVar = $this->mainObjectVar;
        global $$mainObjectVar;
        //Main container
        $this->tableHtml .= '
        <div class="' . $this->topContainer . '">
            <div class="row">' . PHP_EOL;
        //LEFT COLUMN
        if ($this->leftColumnClass != '') {
            $this->tableHtml .= '
                <div class="' . $this->leftColumnClass . '"></div>
            ';
        }
        //main column open
        $this->tableHtml .= '
                <div class="' . $this->mainColumnClass . '">
        ';

        $this->tableHtml .= '
                <div class="row">
                    <div class="col-12 text-center ' . $this->topTitleClass . '"><strong>' . $this->topTitle . '</strong></div>
                </div>';

        //pages links top
        if ($this->showPagesLinksTop == true) {
            $this->tableHtml .= '
                <div class="row">
                    <div class="col-12 text-center">' . $this->showPagesLinks() . '</div>
                </div>
            ';
        }

        //main Table header
        $this->tableHtml .= '
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
        ';
        //loop into all the columns for the headers
        for ($i = 1; $i <= $this->sqlTotalFields; $i++) {
            if ($this->allFieldsArray[$i]['ignoreField'] != true) {
                $this->tableHtml .= '
                                    <td scope="col" align="' . $this->allFieldsArray[$i]['thAlign'] . '"><strong>';
                $this->tableHtml .= '<a href="?TlSetOrder=' . $this->allFieldsArray[$i]['name'] . '">' . $this->allFieldsArray[$i]['name'] . '</a></strong></td>
            ';
            }
        }
        //loop into all the extra columns
        if (count($this->extraColumns) > 0) {
            foreach ($this->extraColumns as $columnData) {
                $this->tableHtml .= '
                                    <td scope="col" align="' . $columnData['thAlign'] . '"><strong>' . $columnData['title'] . '</strong></td>
                                ';
            }
        }
        if ($this->disableIconColumn == false) {
            //show the create new table column
            $this->tableHtml .= '
                                    <td scope="col">
                                    ';
            if ($this->createNewLink != false) {
                $this->tableHtml .= '
                                        <a href="' . $this->createNewLink . '">
                                        <i class="fas fa-plus-circle"></i>
                                        </a>
                                        ';
            }
            $this->tableHtml .= '
                                    </td>';
        }

        $this->tableHtml .= '
                                 </tr>
                                </thead>
                                <tbody>
        ';

        //loop into all the rows and columns for the data
        while ($row = $$mainObjectVar->fetch_assoc($this->sqlResult)) {
            $this->tableHtml .= '<tr onclick="editLine(' . $row[$this->mainIDField] . ');">' . PHP_EOL;
            for ($i = 1; $i <= $this->sqlTotalFields; $i++) {
                $fieldData = $row[$this->allFieldsArray[$i]['name']];
                if ($this->allFieldsArray[$i]['function'] != '') {
                    $fieldDataFunction = $this->allFieldsArray[$i]['function'];
                    $fieldData = $fieldDataFunction($fieldData);
                }
                if ($this->allFieldsArray[$i]['ignoreField'] != true) {
                    $this->tableHtml .= '
                                        <td scope="row" align="' . $this->allFieldsArray[$i]['tdAlign'] . '">' . $fieldData . '</td>
                    ';
                }

            }

            //output any extra columns if exists
            if (count($this->extraColumns) > 0) {
                foreach ($this->extraColumns as $columnData) {
                    $columnFunction = $columnData['function'];
                    $this->tableHtml .= '
                                        <td scope="row" align="' . $columnData['tdAlign'] . '">' . $columnFunction($row) . '</td>
                ';
                }
            }

            if ($this->disableIconColumn == false) {
                $this->tableHtml .= '       <td>
       ';


                if ($this->disableModifyIcon == false) {
                    $this->tableHtml .= '
                    <a href="' . $this->modifyLink . $row[$this->mainIDField] . '" target="' . $this->modifyLinkTarget . '">
                    <i class="fas fa-edit"></i></a>';
                }
                if ($this->disableDeleteIcon == false) {
                    $this->tableHtml .= '
                <a href="' . $this->deleteLink . $row[$this->mainIDField] . '"
                   onclick="ignoreEdit = true; return confirm(\'' . $this->deleteConfirmText . '\');">
                   <i class="fas fa-minus-circle"></i></a>
                ';
                }
                if ($this->functionIconArea != '') {
                    $funName = $this->functionIconArea;
                    $this->tableHtml .= $funName($row);
                }

                $this->tableHtml .= '
                                        </td>
                                        ';
            }
            $this->tableHtml .= '
                                    </tr>' . PHP_EOL;
        }
        $this->tableHtml .= '
                                </tbody>
                             </table>
                          </div>';
        //pages links bottom
        if ($this->showPagesLinksBottom == true) {
            $this->tableHtml .= '
                    <div class="text-center">' . $this->showPagesLinks() . '</div>
            ';
        }
        //main column close
        $this->tableHtml .= '
                </div>
        ';
        //Right Column
        if ($this->rightColumnClass != '') {
            $this->tableHtml .= '
                <div class="' . $this->rightColumnClass . '"></div>
            ';
        }
        //closing main container
        $this->tableHtml .= '</div>
        </div>';
        $this->tableHtml .= '
        <script>

        var ignoreEdit = false;
        function editLine(id) {
            if (ignoreEdit === false) {
                ';

        if ($this->disableClickRowLink == false) {
            if ($this->modifyLinkTarget == '_self') {
                $this->tableHtml .= '
                window.location.assign("' . $this->modifyLink . '" + id);
                ';
            } else if ($this->modifyLinkTarget == '_parent') {
                $this->tableHtml .= '
                parent.document.location.href = "' . $this->modifyLink . '" + id;
                ';
            } else if ($this->modifyLinkTarget == '_blank') {
                $this->tableHtml .= '
                window.open("' . $this->modifyLink . '" + id);
                ';
            }
        }
        $this->tableHtml .= '
            }
        }

</script >
';
        if ($this->outputAsPDF == true) {
            $this->createPDF($this->tableHtml);
        } else {
            echo $this->tableHtml;
        }
    }

    private function buildFullTableDiv()
    {

    }

    private function buildFullTableTable()
    {

    }

    private function createPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function generateData()
    {
        //global $db;
        $mainObjectVar = $this->mainObjectVar;
        global $$mainObjectVar;
        if ($this->sqlGenerated == false) {
            $this->generateSQL();
        }

        echo $this->sql;

        $this->sqlResult = $$mainObjectVar->query($this->sql);
        $this->sqlTotalResults = $$mainObjectVar->num_rows($this->sqlResult);
        $this->sqlDataGenerated = true;
        return $this;
    }

    public function generateSQL()
    {
        $mainObjectVar = $this->mainObjectVar;
        global $$mainObjectVar;
        $this->sql = "SELECT ";

        if ($this->perPage > 0) {
            if ($this->mainObjectVar == 'syn'){
                //$this->sql .= "LIMIT " . (($this->currentPage - 1) * $this->perPage) . ", " . $this->perPage;
                if ((($this->currentPage - 1) * $this->perPage) <= 0){
                    $startPageNum = 1;
                }
                else {
                    $startPageNum = (($this->currentPage - 1) * $this->perPage);
                }
                $this->sql .= "TOP ".$this->perPage." START AT ".$startPageNum." ";
            }
        }

        if ($this->sqlSelect != '') {
            $this->sql .= $this->sqlSelect . PHP_EOL;
        } else {
            $this->sql .= ' * ' . PHP_EOL;
        }

        $this->sql .= "FROM " . $this->tableName . PHP_EOL . $this->sqlFrom . PHP_EOL;

        if ($this->sqlWhere != '') {
            $this->sql .= "WHERE " . $this->sqlWhere . PHP_EOL;
        }
        if ($this->sqlGroupBy != '') {
            $this->sql .= 'GROUP BY ' . $this->sqlGroupBy . PHP_EOL;
        }
        if ($this->sqlHaving != '') {
            $this->sql .= 'HAVING ' . $this->sqlHaving . PHP_EOL;
        }
        $this->getOrdering();
        if ($this->sqlOrderBy != '') {
            $this->sql .= 'ORDER BY ' . $this->sqlOrderBy . PHP_EOL;
        }
        //get here the total of table results
        $totalResults = $$mainObjectVar->query($this->sql);
        $this->tableTotalResults = $$mainObjectVar->num_rows($totalResults);

        //add here the limit and pages
        $this->buildPagesLinks();
        if ($this->perPage > 0) {
            if ($this->mainObjectVar == 'db'){
                $this->sql .= "LIMIT " . (($this->currentPage - 1) * $this->perPage) . ", " . $this->perPage;
            }
        }

        $this->sqlGenerated = true;
        return $this;
    }

    public function getOrdering()
    {
        if ($_GET['TlSetOrder'] != '') {
            $_SESSION['tableList-' . $this->uniqueID]['order'] = $_GET['TlSetOrder'];
            if ($_SESSION['tableList-' . $this->uniqueID]['orderType'] == '') {
                $_SESSION['tableList-' . $this->uniqueID]['orderType'] = 'ASC';
            } else if ($_SESSION['tableList-' . $this->uniqueID]['orderType'] == 'ASC') {
                $_SESSION['tableList-' . $this->uniqueID]['orderType'] = 'DESC';
            } else if ($_SESSION['tableList-' . $this->uniqueID]['orderType'] == 'DESC') {
                $_SESSION['tableList-' . $this->uniqueID]['orderType'] = 'ASC';
            }
        }

        if ($_SESSION['tableList-' . $this->uniqueID]['order'] != '') {
            $this->sqlOrderBy = PHP_EOL . '`' . $_SESSION['tableList-' . $this->uniqueID]['order'] . "` " . $_SESSION['tableList-' . $this->uniqueID]['orderType'];
        }
    }

    private function buildPagesLinks()
    {

        if ($this->perPage > 0) {
            $this->totalPages = ceil($this->tableTotalResults / $this->perPage);
        }
        else {
            $this->totalPages = $this->tableTotalResults;
        }
        //if session current page is empty then set to one
        $this->currentPage = $_SESSION['tableList-' . $this->uniqueID]['currentPage'];

        if ($this->currentPage == '' || $this->currentPage == 0 || $this->currentPage > $this->totalPages) {
            $this->currentPage = 1;
        }
        //if set page to ??
        if ($_GET['TlGoToPage'] > 0) {
            $this->currentPage = $_GET['TlGoToPage'];
        }

        //update the session with the current page
        $_SESSION['tableList-' . $this->uniqueID]['currentPage'] = $this->currentPage;

        //echo "Total Table:".$this->tableTotalResults." Per Page:".$this->perPage.' Total Pages: '.$this->totalPages;
        //echo " < br>Current Page:".$this->currentPage." Session CurrentPage:".$_SESSION['tableList-'.$this->uniqueID]['currentPage'];
        //echo " < br>";
        $this->pagesLinksHtml = 'Showing ' . $this->sqlTotalResults . ' of ' . $this->tableTotalResults . '.';
        if ($this->totalPages > 1) {
            $this->pagesLinksHtml .= ' Go to page ';

            if ($this->totalPages < 11) {
                for ($i = 1; $i <= $this->totalPages; $i++) {
                    if ($i != $this->currentPage)
                        $this->pagesLinksHtml .= " <a href = \"?TlGoToPage=" . $i . "\">" . $i . "</a>&nbsp;&nbsp;";
                    else
                        $this->pagesLinksHtml .= $i . "&nbsp;&nbsp;";
                }
            }// <6
            else {

                for ($i = 1; $i <= 5; $i++) {
                    $this->pagesLinksHtml .= "<a href=\"?TlGoToPage=" . $i . "\">" . $i . "</a>&nbsp;&nbsp;";
                }
                $this->pagesLinksHtml .= " - ";

                for ($i = $this->pages_current - 1; $i <= $this->pages_current + 1; $i++) {
                    if ($i > 5 && $i < $this->pages_total - 1) {
                        $this->pagesLinksHtml .= "<a href=\"?TlGoToPage=" . $i . "\">" . $i . "</a>&nbsp;&nbsp;";

                    }
                }
                $this->pagesLinksHtml .= " - ";
                for ($i = $this->pages_total - 1; $i <= $this->pages_total; $i++) {

                    $this->pagesLinksHtml .= "<a href=\"?TlGoToPage=" . $i . "\">" . $i . "</a>&nbsp;&nbsp;";

                }

                if ($this->pages_current != $this->pages_total)
                    $this->pagesLinksHtml .= "<a href=\"?TlGoToPage=" . $i . "\">" . $i . "</a>&nbsp;&nbsp;";

            }


        }
        $this->pagesLinksGenerated = true;
    }

    private function showPagesLinks()
    {
        if ($this->pagesLinksGenerated == false) {
            $this->buildPagesLinks();
        }
        return $this->pagesLinksHtml;
    }

    /**
     * @param $varName
     * @return $this
     */
    public function defineMainObjectVar($varName){
        //first check if this variable exists
        //make it global to be able to access it
        global $$varName;
        if (isset($$varName)){
            $this->mainObjectVar = $varName;
        }
        else {
            $this->mainObjectVar = 'db';
        }
        return $this;
    }
}
