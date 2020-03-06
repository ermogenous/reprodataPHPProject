<?php

include('../include/main.php');
include('lib/odbccon.php');
$db = new Main(1);


$db->show_header();



//$databaseHandler = odbc_connect('dsn=EUROTEST;charset=UTF-8;','PHPINTRANET','Php$Intranet');
//$result = odbc_exec($databaseHandler,'SELECT * FROM ininsurancetypes');
//$data = odbc_fetch_array($result);
//echo $data['inity_long_description_alt'];
//echo "<br>";


$syn = new ODBCCON('EUROTEST');
$result = $syn->query('SELECT * FROM ininsurancetypes');
echo "Num Rows:".$syn->num_rows($result);
while ($row = $syn->fetch_array($result)){
    echo $row['inity_long_description_alt']."<br>";
}
/*
while(odbc_fetch_row($result)){
    for($i=1;$i<=odbc_num_fields($result);$i++){
        echo "Result is ".odbc_result($result,$i);
    }
}
*/

$db->show_footer();