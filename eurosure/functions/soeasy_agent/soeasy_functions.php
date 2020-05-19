<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 14/05/2020
 * Time: 14:52
 */

function fix_field_name($fieldName){

    $fixed = str_replace(" ","_",$fieldName);
    $fixed = str_replace("/","_",$fixed);
    $fixed = str_replace(".","",$fixed);
    $fixed = str_replace(",","",$fixed);
    $fixed = str_replace("__","_",$fixed);
    $fixed = str_replace("__","_",$fixed);
    $fixed = str_replace("_(String_delimited)","",$fixed);

    return $fixed;
}
