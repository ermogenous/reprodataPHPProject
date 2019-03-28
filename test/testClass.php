<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 8:43 PM
 */

class MyClass {

    function __construct()
    {
    }

    function insertData(MyType $values){

        echo $values->name;

    }

}

class MyType {

    public $name;
    public $surname;

}


$test = new MyClass();
$data = new MyType();
$data->name = 'mic';
$data->surname = 'Ermos';
$test->insertData($data);