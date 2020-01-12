<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/1/2020
 * Time: 2:08 μ.μ.
 */

include("../../../include/main.php");

$db = new Main(1, 'UTF-8');


//$db->show_header();

$xml=simplexml_load_file("../insa_policy.xml") or die("Error: Cannot create object");

foreach ($xml->Worksheet->Table->Row as $row){
    //print_r($row->Cell[1]);

    echo "Working On Policy:".$row->Cell[1]->Data." StartDate:".$row->Cell[13]->Data." To:".$row->Cell[14]->Data ;


    echo "<hr>";
}


//$db->show_footer();
?>