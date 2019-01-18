<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 8:52 PM
 */

include('testClass.php');

$builder = new sqlBuilder('myTable');
echo $builder->select('*')
    ->from('frommm')
    ->where('1=1')
    ->buildQuery();