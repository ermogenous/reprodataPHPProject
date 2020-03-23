<?php

set_time_limit (2400);

include("../../include/main.php");
include("../lib/odbccon.php");
include("../../scripts/form_validator_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/meBuildDataTable.php");

$db = new Main();
$sybase = new ODBCCON();

$sql = "
SELECT
incl_reference as tda_cde,
incl_identity_card as tda_short_desc,
'CA' as  tda_type,
TRIM(incl_first_name||' '||incl_long_description) as tda_desc,
incl_alpha_key3 as tda_link_acct,
incl_alpha_key4 as tda_link_acc2,
incl_identity_card as tda_acc1_id,
incl_street_no as tda_address2,
incl_address_line1 as tda_address3,
incl_address_line2 as tda_spare,
'' as tda_address1,
'' as tda_floor,
incl_district as tda_address4,
incl_city as tda_city,
incl_country as tda_country,
incl_update_ac_static as tda_holder,
'' as tda_state,
TRIM(incl_mail_address_line1||' '||incl_mail_street_no) as tda_pobox,
incl_mail_postal_code as tda_pobox_zip,
incl_mail_district as tda_pobox_area,
incl_postal_code as tda_zip,
'N/A' as tda_occy_cde,
'Y' as tda_flag1,
'N' as tda_flag2,
'Y' as tda_flag3,
'N' as tda_flag4,
'N' as tda_flag5,
'N' as tda_flag6,
'N' as tda_flag7,
'N' as tda_flag8,
'N' as tda_flag9,
'E' as tda_flag10,
'CYP' as tda_acc1_natily,
'1' as tda_icflag,
incl_last_update as tda_trans
FROM inclients
--where DATE(tda_trans)>='01-01-2018'
WHERE incl_status_flag = 'N'
--AND   tda_link_acct <> 'AG488'
--AND tda_cde < '5284850'
order by tda_cde,tda_short_desc
    ";

$result = $sybase->query($sql);
$header = '';
$data = '';
$i=0;
$handle = fopen('clientList.txt',"w+");
while ($row = $sybase->fetch_assoc($result)){
    $i++;
    $line = '';
    foreach($row as $name => $item){
        if ($i == 1){
            $header .= '"'.$name.'";';
        }
        $line.= '"'.$item.'";';
    }
    $line = $db->remove_last_char($line).PHP_EOL;
    if ($i==1){
        $header = $db->remove_last_char($header).PHP_EOL;
        fwrite($handle,$header);
    }
    fwrite($handle,$line);

}

echo "<a href='clientList.txt'>Download</a>";
echo "<br>Total Time: ".$db->get_script_time()." Seconds";