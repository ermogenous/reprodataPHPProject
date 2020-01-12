<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/1/2020
 * Time: 4:53 μ.μ.
 */

include("../../../include/main.php");

$db = new Main(1, 'UTF-8');


$db->show_header();

//first add the whole file in array for later use
$handle = fopen('../acc_account.csv', "r");
if ($handle) {
    $i = 0;
    while (($line = fgets($handle)) !== false) {
        $i++;
        if ($i > 1){
            $lineSplit = explode(';',$line);
            $lineSplit[0] = substr($lineSplit[0], 1, strlen($lineSplit[0]) - 2);
            $lineSplit[3] = substr($lineSplit[3], 1, strlen($lineSplit[3]) - 2);
            $lineSplit[4] = substr($lineSplit[4], 1, strlen($lineSplit[4]) - 2);
            $lineSplit[6] = substr($lineSplit[6], 1, strlen($lineSplit[6]) - 2);
            $allData[$lineSplit[0]]['parent'] = $lineSplit[3];
            $allData[$lineSplit[0]]['code'] = $lineSplit[4];
            $allData[$lineSplit[0]]['name'] = $lineSplit[6];
        }
    }
}
else {
    echo "Error opening the file";
    exit();
}
fclose($handle);

$handle = fopen('../acc_account.csv', "r");

if ($handle) {
    $lineNum = 0;
    while (($line = fgets($handle)) !== false) {
        $lineNum++;
        $data = explode(";",$line);
        foreach($data as $name => $value){
            $data[$name] = substr($value, 1, strlen($value) - 2);
        }
        if ($lineNum <= 2){

            //print_r($headers);
        }
        else {
            //code -> 2 chars: control level 1, 4 chars control level 2, 7 chars account
            $codeLen = strlen($data[4]);
            if ($codeLen == 2 || $codeLen == 4){
                $type = 'Control';
            }
            else if ($codeLen == 7){
                $type = 'Account';
            }
            else {
                $type = 'ERROR';
            }

            echo $data[0]."# -".$data[4]."- ".$data[6]." -> Parent:".$data['3']." # ".$allData[$data[3]]['name'];

            //check if alteration exists
            $data = checkAlterations($data);
            echo " # ALTER: #".$data[4]." - ".$data[6];
            if ($data['delete']){
                echo "<br><div class='alert alert-warning'>DELETE ACCOUNT - Ignore it</div>";
            }
            else {
                //FIND TYPE
                $type = findType($data[4]);
                echo "<br>Find Type for [".substr($data[4],0,2)."]: -> ";
                if ($type['actpe_name'] == ''){
                    echo "<div class='alert alert-danger'>ERROR - NO TYPE FOUND</div>";
                    $noTypesFound[substr($data[4],0,2)][$data[4]] = $data[6];
                }
                else {
                    echo "#".$type['actpe_account_type_ID']." - ".$type['actpe_name'];
                }

                //FIND SUB TYPE
                $subType = findSubType($data[4]);
                echo "<br>Find SubType for [".substr($data[4],0,4)."]: -> ";
                if ($subType['actpe_name'] == ''){
                    if (strlen($data[4]) < 4){
                        echo "";
                    }else {
                        echo "<div class='alert alert-danger'>ERROR - NO SUBTYPE FOUND</div>";
                        $noSubTypesFound[substr($data[4],0,4)][$data[4]] = $data[6];
                    }

                }
                else {
                    echo "#".$subType['actpe_account_type_ID']." - ".$subType['actpe_name'];
                }
            }




        }

        echo "<hr>".PHP_EOL;

        if ($lineNum > 9){
            //break;
        }
    }
    //show all errors
    print_r($noTypesFound);
    echo "<br><br>";
    print_r($noSubTypesFound);
}
else {
    echo "Error opening the file";
}

function findType($code){
    global $db;

    $first2 = substr($code,0,2);

    $sql = 'SELECT * FROM
            ac_account_types
            WHERE
            actpe_active = "Active"
            AND actpe_type = "Type"
            AND actpe_code = "'.$first2.'"';
    $result = $db->query_fetch($sql);

    return $result;
}

function findSubType($code){
    global $db;

    $first4 = substr($code,0,4);
    $sql = 'SELECT * FROM
            ac_account_types
            WHERE
            actpe_active = "Active"
            AND actpe_type = "SubType"
            AND actpe_code = "'.$first4.'"';
    $result = $db->query_fetch($sql);

    return $result;

}

function checkAlterations($row){
    if ($row[4] == '130020'){
        $row['delete'] = true;
    }
    else if ($row[4] == '130040'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111011'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111012'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111013'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111014'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111015'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111016'){
        $row['delete'] = true;
    }
    else if ($row[4] == '111017'){
        $row['delete'] = true;
    }
    else if ($row[4] == '999'){
        $row['delete'] = true;
    }

    else if ($row[4] == 'PL17'){
        $row[4] = '9000001';
    }
    else if ($row[4] == 'PL18'){
        $row[4] = '9000002';
    }
    else if ($row[4] == 'PL66'){
        $row[4] = '7020001';
    }
    else if ($row[4] == 'PL21'){
        $row[4] = '9040002';
    }
    else if ($row[4] == 'PL152'){
        $row[4] = '9000003';
    }
    else if ($row[4] == 'PL40'){
        $row[4] = '9000004';
    }
    else if ($row[4] == 'PL151'){
        $row[4] = '9000005';
        $row[6] = $row[6]." TAX";
    }
    else if ($row[4] == 'PL2'){
        $row[4] = '9010001';
    }
    else if ($row[4] == 'PL67'){
        $row[4] = '7020002';
        $row[6] = $row[6]." TAX";
    }
    else if ($row[4] == 'PL22'){
        $row[4] = '9040003';
        $row[6] = $row[6]." TAX";
    }
    else if ($row[4] == '910050'){
        $row[4] = '9040001';
    }
    else if ($row[4] == '430010'){
        $row[4] = '4000001';
    }
    else if ($row[4] == '4025'){
        $row[4] = '4010';
    }


    return $row;
}

?>


<?php
$db->show_footer();
?>