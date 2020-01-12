<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/1/2020
 * Time: 5:46 μ.μ.
 */

function getCodesArray(){
    global $main;
    $handle = fopen($main['local_url'].'/test/akd/core_code_table_item_l.csv','r');
    if ($handle){
        $i=0;
        while (($line = fgets($handle)) !== false) {
            $i++;
            $data = explode(';',$line);
            foreach($data as $name => $value){
                $data[$name] = substr($value, 1, strlen($value) - 2);
            }
            if ($data[1] == 'ENG') {
                $out[$data[0]]['lang'] = $data[1];
                $out[$data[0]]['value'] = $data[2];
            }

        }
    }else{
        echo "Error opening codes file";
        exit();
    }

    return $out;
}

function getEntitiesArray(){
    global $main;
    $handle = fopen($main['local_url'].'/test/akd/cor_entity.csv','r');
    if ($handle){
        $i=0;
        while (($line = fgets($handle)) !== false) {
            $i++;
            $data = explode(';',$line);
            foreach($data as $name => $value){
                $data[$name] = substr($value, 1, strlen($value) - 2);
            }
            $data[8] = substr($data[8],0,10);
            $out[$data[0]] = $data[8];

        }
    }else{
        echo "Error opening codes file";
        exit();
    }

    return $out;
}