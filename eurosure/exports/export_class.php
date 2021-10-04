<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 28/6/2021
 * Time: 10:35 π.μ.
 */

include_once('../lib/odbccon.php');

/*
 * The concept of this class is to feed it with first with policy serials
 * Then build the export with one by one client,items,policy,situations etc by defining the fields of each table
 * the class by itself will know which tables to join and export
 * and finally export file
 */

class synExport
{

    private $policySerials;
    private $policySerialsReadyList;
    private $policySerialsDefined = false;

    //
    private $policiesList;
    private $policiesListDefined = false;
    private $clientsList;
    private $clientsListDefined = false;

    private $fieldsList;
    private $fieldsListDefined;


    private $sybaseCon;
    public $error = false;
    public $errorDescription = '';
    private $exportSql = '';
    private $exportSqlDefined = false;
    //final list -> an array auto build which has all the data which will be exported
    private $finalList;

    public function __construct()
    {
        $this->sybaseCon = new ODBCCON();
    }

    public function setPolicySerials($serials)
    {
        global $db;
        $this->policySerials = $serials;
        $this->policySerialsDefined = true;
        foreach ($this->policySerials as $name => $value) {
            $this->policySerialsReadyList .= $value . ",";
        }
        $this->policySerialsReadyList = $db->remove_last_char($this->policySerialsReadyList);
    }

    /*
     * Provide sql to feed the policy serials, make sure inpol_policy_serial is defined
     */
    public function setPolicySerialsBySql($sql):bool
    {
        $serials = [];
        $result = $this->sybaseCon->query($sql);
        if ($result) {
            //sql is ok
        } else {
            $this->errorDescription = "There was an error in your setPolicySerialsBySql sql";
            $this->error = true;
            return false;
        }
        while ($row = $this->sybaseCon->fetch_assoc($result)) {
            $serials[] = $row['inpol_policy_serial'];
        }
        $this->setPolicySerials($serials);
        return true;
    }

    //DEFINITIONS FOR WHICH TABLES/FIELDS TO EXPORT

    /**
     * @param $list pass array with policy fields you want to export and their names
     */
    public function definePolicies($list){
        $this->fieldsList['policies'] = $list;
        $this->fieldsListDefined['policies'] = true;
    }

    /**
     * @param $list pass array with client fields you want to export
     */
    public function defineClients($list)
    {
        $this->fieldsList['clients'] = $list;
        $this->fieldsListDefined['clients'] = true;
    }

    /**
     * @param $list pass array with situation fields you want to export
     */
    public function defineSituations($list){
        $this->fieldsList['situations'] = $list;
        $this->fieldsListDefined['situations'] = true;
    }

    /**
     * @param $list pass array with policy items fields you want to export
     */
    public function definePolicyItems($list){
        $this->fieldsList['policyitems'] = $list;
        $this->fieldsListDefined['policyitems'] = true;
    }

    //FUNCTIONS THAT GENERATE TABLES FINAL LIST
    //takes the data and filters only the ones necessary
    private function finalizeTable($table,$data):bool
    {

        if ($this->fieldsListDefined[$table] == false) {
            $this->errorDescription = 'To export '.$table.' you need to define the list first (define'.$table.'($list))';
            $this->error = true;
            return false;
        }
        //insert the client in the exportFinalList
        //echo "<hr>".$table."<hr>";
        $i = count($this->finalList[$table]);
        foreach ($this->fieldsList[$table] as $name => $value) {

            echo $name." -> ".$value."<br>";

            //first remove the first 3 characters from the name. The first 3 characters should always be different to stop one field overwrite another
            $name = substr($name,3);
            //echo $name."<HR>";
            $split = explode('[.]',$name);
            //print_r($split);

            foreach($split as $partName => $partValue){
                //echo $partName." -> ".$partValue."<hr>";
                if (substr($partValue,0,5) == '[VAL]'){
                    $this->finalList[$table][$i][$value] .= substr($partValue,5);
                }
                else {
                    $this->finalList[$table][$i][$value] .= $data[$partValue];
                }
            }



            //echo $name." -> ".$value."<br>".PHP_EOL;
        }
        //exit();

        return true;
    }



    //this will generate all the data which are one record per policy
    private function loadAllSingleData():bool
    {
        //set the SELECT CLAUSE
        $exportSql = "
        SELECT * FROM
        inpolicies
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        ";

        //SET ONE BY ONE THE EXTRA TABLES NEEDED
        if ($this->fieldsListDefined['clients']) {
            $exportSql .= "JOIN inclients ON incl_client_serial = inpol_client_serial " . PHP_EOL;
        }

        //set the WHERE CLAUSE
        $exportSql .= "WHERE inpol_policy_serial IN (" . $this->policySerialsReadyList . ")" . PHP_EOL;
        $result = $this->sybaseCon->query($exportSql);

        if ($result) {
            //sql is ok
        } else {
            //error in sql
            $this->errorDescription = "Error in loadAllSingleData SQL<br>" . $exportSql;
            $this->error = true;
            return false;
        }
        $totalRecords = 0;
        while ($row = $this->sybaseCon->fetch_assoc($result)) {
            $totalRecords++;

            //policies
            if ($this->fieldsListDefined['policies']){
                if (!$this->finalizeTable('policies',$row)){
                    return false;
                }
            }

            //clients
            if ($this->fieldsListDefined['clients']) {
                if (!$this->finalizeTable('clients',$row)){
                    return false;
                }
                //exit();
            }
        }
        //print_r($this->finalList);
        //echo $totalRecords;
        return true;

    }

    /**
     * @return bool
     */
    private function loadAllMultipleData():bool
    {

        //situations
        if ($this->fieldsListDefined['situations']) {
            if (!$this->loadAllMultipleDataSections('situations')) {
                return false;
            }
        }

        //policyitems

        if ($this->fieldsListDefined['policyitems']) {
            if (!$this->loadAllMultipleDataSections('policyitems')) {
                return false;
            }
        }

        return true;
    }

    private function loadAllMultipleDataSections($section) :bool{
        //load multiple data like situations/items/loadings etc
        //set the SELECT CLAUSE
        $exportSql = "
        SELECT * FROM
        inpolicies
        JOIN inagents ON inag_agent_serial = inpol_agent_serial
        ";

        //SET ONE BY ONE THE EXTRA TABLES NEEDED
        if ($section == 'situations') {
            $exportSql .= "JOIN inpolicysituations ON inpst_policy_serial = inpol_policy_serial " . PHP_EOL;
        }

        if ($section == 'policyitems') {
            $exportSql .= "JOIN inpolicysituations ON inpst_policy_serial = inpol_policy_serial " . PHP_EOL;
            $exportSql .= "JOIN inpolicyitems ON inpit_situation_serial = inpst_situation_serial " . PHP_EOL;
            $exportSql .= "JOIN initems ON inpit_item_serial = initm_item_serial " . PHP_EOL;
        }

        //set the WHERE CLAUSE
        $exportSql .= "WHERE inpol_policy_serial IN (" . $this->policySerialsReadyList . ")" . PHP_EOL;
        $result = $this->sybaseCon->query($exportSql);

        if ($result) {
            //sql is ok
        } else {
            //error in sql
            $this->errorDescription = "Error in loadAllMultipleDataSections SQL<br>" . $exportSql;
            $this->error = true;
            return false;
        }
        $totalRecords = 0;
        while ($row = $this->sybaseCon->fetch_assoc($result)) {
            $totalRecords++;

            //situations
            if ($section == 'situations') {
                if (!$this->finalizeTable('situations',$row)){
                    return false;
                }
            }
            //policyitems
            if ($section == 'policyitems') {
                if (!$this->finalizeTable('policyitems',$row)){
                    return false;
                }
            }

        }
        return true;
    }

    public function generateExport():bool
    {
        //load all the single data
        if (!$this->loadAllSingleData()) {
            return false;
        }
        //load all the multiple data
        if (!$this->loadAllMultipleData()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $type -> array/file(prepares the data for file export delimited)
     * @return mixed
     */
    public function exportTable($table = '', $type = 'array',$delimiter = '#'){
        global $db;

        if ($table == ''){
            $this->error = true;
            $this->errorDescription = 'For exportTable you need to define a correct table name like policies, clients etc';
            return false;
        }
        $dataFile = $this->finalList[$table];
        //print_r($dataFile);exit();

        if ($type == 'array') {
            return $dataFile;
        }//if array
        else if ($type == 'file'){
            $i=0;
            $header = '';
            $body = '';

            //print_r($this->finalList[$table]);
            foreach($this->finalList[$table] as $data){
                $i++;
                $fieldNum = 0;
                $totalFields = count($data);

                foreach($data as $name => $value){
                    //print_r($data);
                    //echo $name."->".$value."<br>";
                    $fieldNum++;

                    //HEADER if the first record
                    if ($i == 1) {
                        $header .= $name;
                        if ($fieldNum < $totalFields){
                            $header .= $delimiter;
                        }
                    }

                    //BODY
                    $body .= $value;
                    if ($fieldNum < $totalFields){
                        $body .= $delimiter;
                    }

                }
                $body .= PHP_EOL;
            }


            return $header.PHP_EOL.$body;
        }//if file

    }//function exportTable
}
