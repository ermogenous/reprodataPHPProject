<?php
$result_amount_values = '';

function insert_quotation_data_to_db($quotation_id, $quotation_type_id)
{
    global $db;

    $changeStatus = '';
    //new quotation use insert
    $sql2 = '';
    if ($quotation_id == "") {

        $sql = "INSERT INTO `oqt_quotations` SET 
		oqq_users_ID = '" . $db->user_data["usr_users_ID"] . "',
		oqq_status = 'Outstanding',";

    }//insert
    //exists use update
    else {

        $sql = "UPDATE oqt_quotations SET ";
        $sql2 = " WHERE oqq_quotations_ID = " . $quotation_id;

        //get quotation current data
        $data = $db->query_fetch("SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = " . $quotation_id);
        if ($data['oqq_status'] == 'Copy'){
            $changeStatus = "oqq_status = 'Outstanding',";
        }

    }//use update

    if ($_POST['nationality_ID'] == ''){
        $_POST['nationality_ID'] = 0;
    }
    if ($_POST['birthdate'] == ''){
        $birthdate = '0000-00-00';
    }
    else {
        $birthdate = addslashes($db->convertDateToUS($_POST['birthdate']));
    }
    if ($_POST['starting_date'] == ''){
        $startingDate = '0000-00-00';
    }
    else {
        $startingDate = addslashes($db->convert_date_format($_POST['starting_date'],'dd/mm/yyyy','yyyy-mm-dd'));
    }
    if ($_POST['expiry_date'] == ''){
        $expiryDate = '0000-00-00';
    }
    else {
        $expiryDate = addslashes($db->convert_date_format($_POST['expiry_date'],'dd/mm/yyyy','yyyy-mm-dd'));
    }
    if ($_POST['insureds_city'] == ''){
        $_POST['insureds_city'] = 0;
    }

//echo "Expiry:".$expiryDate;
//print_r($_POST);
//    exit();




    $sql .= "
".$changeStatus."
oqq_language = '" . $_SESSION["oq_quotations_language"] . "', 
oqq_quotations_type_ID = " . $quotation_type_id . ",
oqq_person_company = '" . addslashes($_POST["person_company"]) . "',
oqq_insureds_name = '" . addslashes($_POST["insureds_name"]) . "',
oqq_insureds_id = '" . addslashes($_POST["insureds_id"]) . "',
oqq_nationality_ID = '".addslashes($_POST['nationality_ID'])."',
oqq_birthdate = '".$birthdate."',
oqq_insureds_tel = '" . addslashes($_POST["insureds_tel"]) . "',
oqq_insureds_mobile = '" . addslashes($_POST["insureds_mobile"]) . "',
oqq_insureds_address = '" . addslashes($_POST["insureds_address"]) . "',
oqq_insureds_city = '" . addslashes($_POST["insureds_city"]) . "',
oqq_insureds_email = '" . addslashes($_POST["insureds_email"]) . "',
oqq_insureds_contact_person = '" . addslashes($_POST["insureds_contact_person"]) . "',
oqq_insureds_postal_code = '" . addslashes($_POST["insureds_postal_code"]) . "',
oqq_situation_address = '" . addslashes($_POST["situation_address"]) . "',
oqq_situation_postal_code = '" . addslashes($_POST["situation_postal_code"]) . "',
oqq_extra_details = '" . addslashes($_POST["situations_extra_details"]) . "',
oqq_starting_date = '".$startingDate."',
oqq_expiry_date = '".$expiryDate."',
oqq_extra_field_1 = '".addslashes($_POST['extra_field_1'])."',
oqq_extra_field_2 = '".addslashes($_POST['extra_field_2'])."',
oqq_extra_field_3 = '".addslashes($_POST['extra_field_3'])."',
oqq_extra_field_4 = '".addslashes($_POST['extra_field_4'])."',
oqq_extra_field_5 = '".addslashes($_POST['extra_field_5'])."',
oqq_unique_identifier = '".$db->encrypt(date('G:i:s'))."',
oqq_created_date_time = '".date("Y-m-d G:i:s")."',
oqq_created_by = ".$db->originalUserData['usr_users_ID']."

";
    //created by. If imitating user is enabled then use the original user
    $sql .= $sql2;

    //echo $sql."<hr>";exit();
    $db->query($sql);

    if ($quotation_id == "")
        return $db->insert_id();
    else
        return $quotation_id;
}//function insert_quotation_data_to_db($quotation_id) {


//this function checks to find from the $_POST all the fields from the quotation items table with a prefix 'qtbl_'
function insert_item_data_to_db($quotation_type_data, $quotation_id, $item_id)
{
//step1 create the "SET" section of the sql with the fields only that are not empty.
//step2 locate if the query needs insert or update
//step3 execute.
    global $db;
    $sql = '';

    //step1
    //first get the items data for this quotation type to identify all the fields to locate.
    $item_data = $db->query_fetch("SELECT * FROM oqt_items WHERE oqit_items_ID = " . $item_id);
    //LOOP in all the insured amount fields
    foreach ($item_data as $name => $value) {
		//echo $name." -> ".$value."<br>";

        //find the insured amount fields
        if (substr($name, 0, 20) == 'oqit_insured_amount_') {

            //find the insured amount fields that are not empty. We do not need to use the empty fields.
            //fix the field name from oqit to oqqit
            $field_name = "oqq" . substr($name, 2);
            if ($value != "") {

                if ($_POST[$item_id . "_" . $field_name] == "") {
                    $field_value = 0;
                } else {
                    $field_value = $_POST[$item_id . "_" . $field_name];
                }
                $sql .= ",\n" . $field_name . " = \"" . addslashes($field_value) . "\"";

            }//insured amount fields that are not empty.

        }//all the insured amount fields

        //find the rates fields
        if (substr($name, 0, 10) == 'oqit_rate_') {

            //find the insured amount fields that are not empty. We do not need to use the empty fields.
            if ($value != "") {

                //fix the field name from oqit to oqqit
                $field_name = "oqq" . substr($name, 2);

                //if the field in items found to be GET_FROM_FORM then get the value from the form
                if ($value == "GET_FROM_FORM") {
                    $field_value = $_POST[$item_id . "_" . $field_name];
                } else {
                    $field_value = $value;
                }
                $sql .= ",\n" . $field_name . " = \"" . addslashes($field_value) . "\"";
//echo $item_id . "_" . $field_name;//exit();
            }//insured amount fields that are not empty.

        }//all the insured amount fields

        //find the date fields
        if (substr($name, 0, 10) == 'oqit_date_') {
            //find the insured amount fields that are not empty. We do not need to use the empty fields.
            if ($value != "") {

                //fix the field name from oqit to oqqit
                $field_name = "oqq" . substr($name, 2);
                if ($_POST[$item_id . "_" . $field_name] == "") {
                    $field_value = '';
                } else {
                    $field_value = $_POST[$item_id . "_" . $field_name];
                    //convert the date from dd/mm/yyyy to yyyy-mm-dd
                    $field_value = $db->convert_date_format($field_value,'dd/mm/yyyy','yyyy-mm-dd');
                    //echo "IF:".$name."-> #".$field_value."#<br>";
                    $sql .= ",\n" . $field_name . " = \"" . $field_value . "\"";
                }
                //echo $_POST[$item_id . "_" . $field_name];

//echo $item_id . "_" . $field_name;exit();
            }//insured amount fields that are not empty.

        }//all the insured amount fields


    }
    //add the rest of the fields
    $sql .= "\n ,oqqit_quotations_ID = '" . $quotation_id . "', oqqit_items_ID = '" . $item_id . "'";

//echo $sql;exit();
    //remove the first comma from the SQL
    $sql = substr($sql, 1);
    //echo $sql;


    //STEP2
    //$sql_find = "SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID
    //if quotation id is empty then insert
    if ($quotation_id == "") {
        $sql = "INSERT INTO oqt_quotations_items SET " . $sql;
    } else {
        //find the quotation item to update
        $qi = $db->query("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotation_id . " AND oqqit_items_ID =" . $item_id);
        if ($db->num_rows($qi) > 0) {

            $qi_data = $db->fetch_assoc($qi);
            $sql = "UPDATE `oqt_quotations_items` SET " . $sql . " WHERE oqqit_quotations_items_ID = " . $qi_data["oqqit_quotations_items_ID"];

        }//record found use UPDATE
        //not found use insert
        else {
            $sql = "INSERT INTO oqt_quotations_items SET " . $sql;
        }//not found use insert


    }

    $db->query($sql);
//echo $sql."\n\n\n\n\n\n\n\n<hr>";
}//function insert_item_data_to_db($quotation_type_data,$quotation_ID,$item_id)

function show_quotation_text($greek_text, $english_text,$printOrReturn = 'Print')
{

    if ($_SESSION["oq_quotations_language"] == 'en') {
        if ($printOrReturn == 'Print'){
            print $english_text;
        }
        else {
            return $english_text;
        }

    } else {
        if ($printOrReturn == 'Print'){
            print $greek_text;
        }
        else {
            return $greek_text;
        }
    }

}//function show_quotation_text($greek_text,$english_text)


//calculates a quotations price,fees,stamps and inserts in the quotation the results in the appropriate fiedls.
function quotation_price_calculation($quotation_id)
{
    global $db, $result_amount_values;

    $result_amount = array();
    $result_amount_values = array();

//get the quotations,quotations_types details 
    $sql = "SELECT * FROM oqt_quotations JOIN oqt_quotations_types ON oqqt_quotations_types_ID = oqq_quotations_type_ID WHERE oqq_quotations_ID = " . $quotation_id;

    $q_data = $db->query_fetch($sql);

//step 1: Loop into the items.
//step 2: Get the qitems data and extract the appropriate rates values and calculate on insured amount. Store in array result_amount all the results
//step 3: Send the result array to the custom_calculation_function to fix the appropriate rates.
//step 4: Add up all the results from the array $result_amount
//step 5: Find the fees with the rounding specified in the quotation type

    $sql = "SELECT * FROM oqt_items WHERE oqit_quotations_types_ID = " . $q_data["oqq_quotations_type_ID"];
    $res = $db->query($sql);
    while ($item = $db->fetch_assoc($res)) {

        //find the qitem data
        $qitem_data = $db->query_fetch("SELECT * FROM oqt_quotations_items JOIN oqt_items ON oqit_items_ID = oqqit_items_ID WHERE oqqit_quotations_ID = " . $quotation_id . " AND oqqit_items_ID = " . $item["oqit_items_ID"]);
        //print_r($qitem_data);
        //find all the insured_amount_XX fields in the db
        foreach ($item as $name => $value) {
            //find the oqit_insured_amount in the field name
            if (substr($name, 0, 20) == 'oqit_insured_amount_') {

                //get the insured_amount number
                $num = substr($name, 20);
                $rate = $qitem_data["oqqit_rate_" . $num];
                $amount = $qitem_data["oqqit_insured_amount_" . $num];
                $item_amount = $qitem_data["oqit_insured_amount_" . $num];
                $item_rate = $qitem_data["oqit_rate_" . $num];
                $all_rates = '';

                //check first if its an options rate
                if (strpos($rate, '||') !== false) {

                    $all_options = explode("||", $rate);
                    $all_rates = $rate;
                    $rate = $all_options[$qitem_data["oqqit_insured_amount_" . $num] - 1];

                }//options rate


                //put all the amounts and rates in an array for custom usage.
                $result_amount_values[$item["oqit_items_ID"]][$num]['rate'] = $rate;
                $result_amount_values[$item["oqit_items_ID"]][$num]['amount'] = $amount;
                $result_amount_values[$item["oqit_items_ID"]][$num]['all_rates'] = $all_rates;

                //the field details
                $result_amount_values[$item["oqit_items_ID"]][$num]['item_amount'] = $item_amount;
                $result_amount_values[$item["oqit_items_ID"]][$num]['item_rate'] = $item_rate;

                //if rate is empty then no need to calculate
                //if field is empty no need to calculate
                if ($rate != "" /*&& $amount != "" && $amount != 0*/) {

                    $result_amount[$item["oqit_items_ID"]][$num] = quotation_price_calculation_Get_rate_sum($rate, $amount);
                }

            }//insured amount found

            //date values
            if (substr($name,0,10) == 'oqit_date_'){
                $num = substr($name, 10);
                $rate = $qitem_data["oqqit_date_" . $num];
                $result_amount_values[$item["oqit_items_ID"]]['date_'.$num]['rate'] = $rate;
            }

        }//foreach all fields

    }//while loops items

    //step3 Send the result array to the custom_calculation_function to fix the appropriate rates.
    if (function_exists('insured_amount_custom_rates')) {
        $result_amount = insured_amount_custom_rates($result_amount, $result_amount_values, $quotation_id);
    }
    else {
        $db->generateAlertError('Function "insured_amount_custom_rates($result_amount, $result_amount_values, $quotation_id)" is missing from functions file');
        $db->show_header();
        $db->show_footer();
        exit();
    }

    //step 4 add up the values from the array
    $premium = 0;
    $detailed_result = '';
    foreach ($result_amount as $item_id => $qitems_array) {

        foreach ($qitems_array as $section_id => $item_premium) {

            //echo $item_id." -> ".$section_id." = ".$item_premium."<br>";
            //echo "<b>".$item_id."-".$section_id."</b> (".$qitem_data["oqit_insured_amount_".$section_id].") A-><b>".$result_amount_values[$item_id][$section_id]['amount']."</b> Res=>&#8364;<b>".$item_premium."</b><br>";
            if ($result_amount != 'ALL') {
                $premium += $item_premium;
                if ($item_premium != 0 && $item_premium != '') {
                    $detailed_result .= "\n<b>" . $item_id . "-" . $section_id . "</b> A-><b>" . $result_amount_values[$item_id][$section_id]['amount'] . "*(" . $result_amount_values[$item_id][$section_id]['rate'] . ")</b>=>&#8364;<b>" . $item_premium . "</b> (" . $result_amount_values[$item_id][$section_id]['item_amount'] . ")<br>";
                }
            }

        }//foreach all the sections of the item

    }//foreach in all items

    //check the minimum premium. If need to increase add it at position 0-0
    if ($premium < $q_data["oqqt_minimum_premium"]) {

        $premium = $q_data["oqqt_minimum_premium"];
    }

    //step5 Find the fees with the rounding specified in the quotation type
    $fees = $q_data["oqqt_fees"];
    $stamps = $q_data["oqqt_stamps"];
    $premium = round($premium, 2);
    $customFeesStamps = quotation_price_find_fees_stamps($fees, $q_data["oqqt_premium_rounding"], $premium, $stamps);
    $fees = $customFeesStamps['fees'];
    $stamps = $customFeesStamps['stamps'];


//echo "<BR>PREMIUM -> ".$premium."<br> Fees ->".$fees." <br>Stamps ->".$stamps;;

//update the datail_price_array with fees and stamps
    $detailed_result .= "Fees: €" . $fees . "\n<br>Stamps: €" . $stamps . "\n<br>Net Premium: €".$premium."\n<br>Gross Premium: €".($premium+$fees+$stamps);
    $return["premium"] = $premium;
    $return["fees"] = $fees;
    $return["stamps"] = $stamps;
    $return["detailed_result"] = $detailed_result;
    $return["custom_premium1"] = $result_amount["ALL"]["custom_premium1"];
    $return["custom_premium2"] = $result_amount["ALL"]["custom_premium2"];

//print_r($return);
//echo "Total ".($return["premium"] + $return["fees"] + $return["stamps"]);
    return $return;
}


//==================================================Functions in Functions=====================================================================================
function quotation_price_calculation_Get_rate_sum($rate, $amount)
{
    $result = 0;

    //if rate is 0 return 0
    //for the cases of checkboxes
    if ($amount == 0) {
        return 0;
    }
    //continue to calculate
    //get the type of calculation
    //options: A = Amount, * = multiplier
    $type = substr($rate, 0, 1);
    $rate_number = substr($rate, 1);
    if ($type == '*') {
        $result = $amount * $rate_number;
    } else if ($type == 'A') {
        $result = $rate_number;
    }


    return $result;
}

function quotation_price_find_fees_stamps($fees, $fees_rounding_style, $premium, $stamps)
{
    $premium = round($premium, 2);
    $fees = round($fees, 2);
    $stamps = round($stamps, 2);
    $result['fees'] = $fees;
    $result['stamps'] = $stamps;

    if ($fees_rounding_style == "NoRounding") {
        $result['fees'] = $fees;
    } else if ($fees_rounding_style == "RoundUpFees") {

        $total = $fees + $premium + $stamps;
        $total2 = ceil($total);
        $result['fees'] = $total2 - $total + $fees;

    } else if ($fees_rounding_style == "RoundDownFees") {
        //i think this needs fixing
        $result['fees'] = $premium;
    } else if ($fees_rounding_style == "CustomFees") {
        $data['stamps'] = $stamps;
        $data['fees'] = $fees;
        $data['premium'] = $premium;
        $result = get_custom_fees_amount($data);
    }

    $result['fees'] = round($result['fees'], 2);
    $result['stamps'] = round($result['stamps'], 2);

    return $result;
}

?>
