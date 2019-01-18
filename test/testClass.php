<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 8:43 PM
 */

Class sqlBuilder{

    private $table;
    private $select;
    private $from;
    private $where;
    private $order;

    function __construct($table)
    {
        $this->table = $table;
    }

    public function select($select){
        $this->select = $select;
    }

    public function from($from){
        $this->from = $from;
    }

    public function buildQuery(){
        $sql = "SELECT ".$this->select."\n FROM ".$this->from."\n WHERE ".$this->where;
        return $sql;
    }
}