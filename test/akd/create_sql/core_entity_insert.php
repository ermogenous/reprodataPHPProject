<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/1/2020
 * Time: 8:11 π.μ.
 */
ini_set('max_execution_time', '300');
include("../../../include/main.php");

$db = new Main(1, 'UTF-8');


$db->show_header();

$handle = fopen('../cor_entity.csv', "r");
if ($handle){

    $lineNum = 0;
    while (($line = fgets($handle)) !== false) {
        $lineNum++;
        $data = explode(";",$line);
        foreach($data as $name => $value){
            $data[$name] = substr($value, 1, strlen($value) - 2);
        }
        if ($lineNum > 1){
            //echo $line."<br>";

            $idNum = $data[0];
            $firstName = $data[4];
            $lastName = $data[5];
            $middleName = $data[6];
            $orgName = $data[8];
            $birthDate = explode(' ',$data[9])[0];
            $homeTel = $data[14];
            $workTel = $data[15];
            $faxTel = $data[16];
            $mobileTel = $data[17];
            $email = $data[18];
            $comments = $data[19];

            $fullName = $firstName." ".$middleName." ".$lastName;
            $fullName = str_replace('  ', ' ', $fullName);
            if (strlen($fullName) < 5 && strlen($orgName) > 2){
                $fullName = $orgName;
            }

            echo "Working on : ".$idNum." ".$fullName." -> ";

            if (strlen($fullName) < 2){
                echo "<div class='alert alert-danger'>No name is found for this entity.</div>";
            }

            //check if entity already exists
            $sql = 'SELECT * FROM ac_entities WHERE acet_tmp_import_ID = '.$idNum;
            $result = $db->query($sql);
            $resultData = $db->fetch_assoc($result);
            if ($db->num_rows($result) > 0) {
                echo "<span class='alert-danger'>Already Exists - ID ".$resultData['acet_entity_ID']."</span>";
            }
            else {
                $newData['fld_active'] = 'Active';
                $newData['fld_name'] = $fullName;
                $newData['fld_description'] = '';
                $newData['fld_mobile'] = $mobileTel;
                $newData['fld_work_tel'] = $workTel;
                $newData['fld_fax'] = $faxTel;
                $newData['fld_email'] = $email;
                $newData['fld_birthdate'] = $birthDate;
                $newData['fld_comments'] = $comments;
                $newData['fld_tmp_import_ID'] = $idNum;
                $newID = $db->db_tool_insert_row('ac_entities', $newData,'fld_',1,'acet_','execute');
                echo "Created! - ID ".$newID."<br>";
                //echo $sql."<br>";
            }
            echo "<hr>\n";

        }


    }

}
else {
    echo "Error opening the file cor_entity.csv";
}
$db->show_footer();
?>