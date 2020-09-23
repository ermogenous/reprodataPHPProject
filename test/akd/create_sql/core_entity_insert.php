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
            $identityNumber = $data[3];
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
            $newEntityID = 0;

            $fullName = $firstName." ".$middleName." ".$lastName;
            $fullName = str_replace('  ', ' ', $fullName);
            if (strlen($fullName) < 5 && strlen($orgName) > 2){
                $fullName = $orgName;
            }

            echo "Working on : [".$idNum."] ID:".$identityNumber." ".$fullName." ".$idNum." -> ";

            $okToProceed = true;
            if (strlen($fullName) < 2){
                echo "<div class='alert alert-danger'>ERROR No name is found for this entity.</div>";
                $okToProceed = false;
            }
            if (strlen($idNum) < 4){
                echo "<div class='alert alert-danger'>ERROR No Foreign ID is found for this entity.</div>";
                $okToProceed = false;
            }

            if (strlen($identityNumber) < 4){
                echo "<div class='alert alert-danger'>ERROR No ID is found for this entity.</div>";
                $okToProceed = false;
            }


            if ($okToProceed == true) {
                //check if entity already exists
                $sql = 'SELECT * FROM ac_entities WHERE acet_tmp_import_ID = ' . $idNum;
                $result = $db->query($sql);
                $resultData = $db->fetch_assoc($result);
                if ($db->num_rows($result) > 0) {
                    echo "<span class='alert-danger'>WARNING Already Exists - ID " . $resultData['acet_entity_ID'] . "</span>";
                    $newEntityID = $resultData['acet_entity_ID'];
                } else {

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
                    $newEntityID = $db->db_tool_insert_row('ac_entities', $newData, 'fld_', 1, 'acet_', 'execute');
                    echo "Created! - ID " . $newEntityID . "<br>";
                    //echo $sql."<br>";
                }

                //customers
                //check if the customer already exists
                $sqlCustomers = "SELECT * FROM customers WHERE cst_foreign_import_ID = '".$idNum."'";
                $resultCustomer = $db->query($sqlCustomers);
                $resultCustomerData = $db->fetch_assoc($resultCustomer);
                if ($db->num_rows($resultCustomer) > 0){
                    echo "<span class='alert-danger'>WARNING Customer Already Exists - ID " . $resultCustomerData['cst_customer_ID'] . "</span>";
                }
                else {
                    $proceedToInsertCustomer = true;
                    if ($identityNumber == '' || strlen($identityNumber) < 4){
                        echo "<span class='alert-danger'>ERROR Customer Identity is empty or less than 4 chars</span>";
                        $proceedToInsertCustomer = false;
                    }

                    if (strlen($fullName) < 2){
                        echo "<span class='alert-danger'>ERROR Customer Name/Surname is empty or less than 4 chars</span>";
                        $proceedToInsertCustomer = false;
                    }

                    if ($proceedToInsertCustomer) {
                        $cstNewData['fld_entity_ID'] = $newEntityID;
                        $cstNewData['fld_foreign_import_ID'] = $idNum;
                        $cstNewData['fld_identity_card'] = $identityNumber;
                        $cstNewData['fld_name'] = $firstName . " " . $middleName;
                        $cstNewData['fld_surname'] = $lastName;
                        $cstNewData['fld_mobile_1'] = $mobileTel;
                        $cstNewData['fld_work_tel_1'] = $workTel;
                        $cstNewData['fld_fax'] = $faxTel;
                        $cstNewData['fld_email'] = $email;
                        $cstNewData['fld_email_newsletter'] = $email;
                        $cstNewData['fld_birthdate'] = $birthDate;
                        $cstNewData['fld_business_type_code_ID'] = 5;
                        $cstNewData['fld_city_code_ID'] = 8;

                        $newCustomerID = $db->db_tool_insert_row('customers', $cstNewData,
                            'fld_', 1, 'cst_', 'execute');
                        echo " - Customer Created ID:" . $newCustomerID . "<br>";
                        //print_r($cstNewData);exit();
                    }
                }



            }//ok to proceed/insert
            echo "<hr>\n";

        }


    }

}
else {
    echo "Error opening the file cor_entity.csv";
}
$db->show_footer();
?>