<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 25/2/2021
 * Time: 10:47 π.μ.
 */

include("../../include/main.php");
include("../lib/odbccon.php");
$db = new Main(0);
$db->working_section = 'Eurosure Test API';

//$db->update_log_file('TEST API',0,'TEST API','TEST API');
$syn = new ODBCCON();
$sql = 'SELECT * FROM inclients WHERE
incl_client_serial < 63450
order by incl_client_serial asc';
$result = $syn->query($sql);
while ($row = $syn->fetch_assoc($result)){
    print_r($row);
}
