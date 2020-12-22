<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 1/12/2020
 * Time: 4:49 ΜΜ
 */

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(1);
$db->working_section = 'Eurosure vehicles Rescueline update extranet table';


//step 1 collect the data from sybase
$syn = new ODBCCON();
$sql = "
SELECT
sp_registration_num,
sp_make,
sp_model,
sp_body_type,
sp_colour,
sp_engineCC,
sp_weight,
sp_firstdate,
sp_expireddate,
sp_price,
sp_Breakdown,
sp_Accident,
sp_car_type,
sp_begindate,
sp_city_home
FROM
sp_rescueline_export('".date("Y-m-d")."','Y','N')
WHERE
sp_registration_num = 'LBN217'
";

$result = $syn->query($sql);
while ($row = $syn->fetch_assoc($result)){
    $output[] = $row;
}

print_r($output);
echo "\n\n\n\n";
//$json = json_encode($output);
//echo $json."\n\n\n\n<hr>";

//The URL that you want to send your XML to.
$url = 'http://www.eurosure.net/eurosure/api/rescueline_receive_data.php';
$data_string = json_encode($output);
print_r($data_string);
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, array("customer"=>$data_string));
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array(
        'Content-Type:application/json',
        'Content-Length: ' . strlen($data_string)
    )
);

$result = curl_exec($ch);
curl_close($ch);
print_r($result);
