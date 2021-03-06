<?php


class ODBCCON
{

    private $databaseHandler;
    private $result;
    private $error = false;
    private $errorDescription = '';
    private $database='';

    private $startTransaction = false;

    function __construct($database = 'EUROSURE', $charset = 'UTF-8')
    {
        global $db;
        $this->database = $database;
        $this->databaseHandler = @odbc_connect('dsn=' . $database . ';charset=' . $charset . ';', 'PHPINTRANET', 'Php$Intranet');
        if ($this->databaseHandler == false){
            echo "Could not connect to odbc";
            exit();
        }
        else {
            odbc_autocommit($this->databaseHandler, false);
        }
    }

    public function query($sql)
    {
        global $db;
        //set_error_handler(function($errno, $errstr, $errfile, $errline ) {
        //    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        //});
        try{
            //echo $sql;
            $result = odbc_exec($this->databaseHandler, $sql);
            $this->checkSqlForLog($sql);
            return $result;
        }
        catch (Exception $e){
            $this->error = true;
            $this->errorDescription = odbc_errormsg($this->databaseHandler);

            $i=0;
            $traceFiles = '';
            foreach($e->getTrace() as $trace){
                if ($i>0){
                    $traceFiles .= $trace['file']."  Line: ".$trace['line'].PHP_EOL;
                    //print_r($trace);
                }
                $i++;
            }
            ;
            $fullDescription = "ODBC[SyBase][".$this->database."] SQL: ".PHP_EOL.$sql.PHP_EOL.PHP_EOL.$e->getFile()." Line:".$e->getLine().PHP_EOL.$this->errorDescription
            .PHP_EOL."TraceFiles:".PHP_EOL.$traceFiles;
            $db->update_log_file_custom($fullDescription);
            if ($db->user_data['usr_user_rights'] == 0) {
                echo "<div class='container alert alert-danger'>[".$this->database."] ". $this->errorDescription . "
                        <br>
                        Log files has been updated with ID:".$db->insert_id()." 
                        <br>ROLLBACK
                        </div>";
            }
            else {
                echo "<div class='container alert alert-danger'>An error has been found. Please contact administrator. Error Log ID = ".$db->insert_id()."</div>";
            }
            $this->rollback();
            exit();
        }

    }

    private function checkSqlForLog($sql){
        global $db;
        $explode = explode(" ",$sql);
        //remove any breaks
        foreach($explode as $word){
            //remove spaces
            $word = str_replace(" ","",$word);
            //remove breaks
            $word = str_replace(PHP_EOL,"",$word);
            //check to find what kind of sql is
            //echo "::".$word."::<br>";
            //convert to lowercase
            $word = strtolower($word);
            if ($word == 'select'){

            }
            else if ($word == 'update'){
                $db->update_log_file('SyBase',0,'SyBase Query','','',$sql);
            }
            else if ($word == 'delete'){
                $db->update_log_file('SyBase',0,'SyBase Query','','',$sql);
            }
        }
    }

    public function beginTransaction(){
        $this->startTransaction = true;
        $this->query('BEGIN TRANSACTION;');
    }

    public function rollback(){
        if ($this->startTransaction) {
            odbc_rollback($this->databaseHandler);
        }
    }

    public function commit(){
        if ($this->startTransaction) {
            odbc_commit($this->databaseHandler);
        }
    }

    public function fetch_array($result)
    {
        return odbc_fetch_array($result);
    }

    public function fetch_assoc($result)
    {
        return odbc_fetch_array($result);
    }

    public function num_rows($result){
        return odbc_num_rows($result);
    }

    public function query_fetch($sql){
        $result = $this->query($sql);
        return $this->fetch_assoc($result);
    }

    public function getDatabaseName(){
        return $this->database;
    }
}
