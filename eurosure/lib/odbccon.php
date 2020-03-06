<?php


class ODBCCON
{

    private $databaseHandler;
    private $result;

    function __construct($database = 'EUROSURE', $charset = 'UTF-8')
    {
        $this->databaseHandler = odbc_connect('dsn=' . $database . ';charset=' . $charset . ';', 'PHPINTRANET', 'Php$Intranet');
    }

    public function query($sql)
    {
        return odbc_exec($this->databaseHandler, $sql);
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
}
