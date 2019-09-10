<?php
//shows the tables for each section (item)
//the name of the field is OQIT_ITEMS_ID"_"FIELD_NAME
function tr_travel_information()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter;

    //check if the clients age is over 18 and max 75.99
    $formValidator->includeYearsFrom2DatesFunction();
    $formValidator->addCustomCode('
        
        let todayDate = new Date();
        let clientAge = getYearsFromDates(
            $("#birthdate").val(),
            (todayDate.getDate() + "/" + todayDate.getMonth() + "/" + todayDate.getFullYear())
        );
        
        if (clientAge < 18){
            $("#birthdate-invalid-text").html("Age must be over 18");
            $("#birthdate").addClass("is-invalid");
            $("#birthdate").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("birthdate -> Lower than 18 ");
        }
        
        if (clientAge > 75){
            $("#birthdate-invalid-text").html("Age must under 76");
            $("#birthdate").addClass("is-invalid");
            $("#birthdate").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("birthdate -> Higher than 75 ");
        }
        
    
    ');

    ?>

    <div class="form-group row">
        <label for="5_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Πακέτο", "Package"); ?>
        </label>
        <div class="col-sm-8">


            <select name="5_oqqit_rate_4" id="5_oqqit_rate_4" onchange="packageSelection();"
                    class="form-control">
                <?php if (strpos($underwriter['oqun_tr_package_selection'], '#basic#') !== false) { ?>
                    <option value="Basic" <?php if ($qitem_data['oqqit_rate_4'] == 'Basic') echo 'selected'; ?>>
                        Basic
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'], '#standard#') !== false) { ?>
                    <option value="Standard" <?php if ($qitem_data['oqqit_rate_4'] == 'Standard') echo 'selected'; ?>>
                        Standard
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'], '#luxury#') !== false) { ?>
                    <option value="Luxury" <?php if ($qitem_data['oqqit_rate_4'] == 'Luxury') echo 'selected'; ?>>
                        Luxury
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'], '#schengen#') !== false) { ?>
                    <option value="Schengen" <?php if ($qitem_data['oqqit_rate_4'] == 'Schengen') echo 'selected'; ?>>
                        Schengen
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'], '#limited#') !== false) { ?>
                    <option value="Limited" <?php if ($qitem_data['oqqit_rate_4'] == 'Limited') echo 'selected'; ?>>
                        Limited
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_4',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <script>
        function packageSelection(){
            let selectedPackage = $('#5_oqqit_rate_4').val();
            //console.log(selectedPackage);
            if (selectedPackage == 'Limited'){
                $('#limitedPackText').show();
                //limit destination to russia
                $('#5_oqqit_rate_1').val(309);
                $('#5_oqqit_rate_1').attr('readonly', true);
            }
            else {
                $('#5_oqqit_rate_1').attr('readonly', false);
            }
        }
    </script>

    <div class="row form-group">

        <label for="5_oqqit_date_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Ημ. Αναχώρησης", "Departure Date"); ?>
        </label>
        <div class="col-sm-3">
            <input name="5_oqqit_date_1" type="text" id="5_oqqit_date_1"
                   class="form-control text-center">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convertDateToEU($qitem_data['oqqit_date_1']),
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">

        <label for="5_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Περίοδος Ασφάλισης (μέρες)", "Period of Insurance (days)"); ?>
        </label>
        <div class="col-sm-3">
            <input name="5_oqqit_rate_5" type="text" id="5_oqqit_rate_5"
                   class="form-control text-center" value="<?php echo $qitem_data['oqqit_rate_5'];?>">
            <?php
            $limitedText = $quotationUnderwriter['oqun_tr_limited_premiums'];
            $limitedOptions = explode('||',$limitedText);
            $daysOutput = '';
            $validatorCustCode = '';
            $validatorCustCodeList = [];
            foreach($limitedOptions as $value){
                $list = explode('#',$value);
                $daysOutput .= $list[0].',';
                $validatorCustCodeList[] = $list[0];
            }
            $daysOutput = $db->remove_last_char($daysOutput);

            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_5',
                    'fieldDataType' => 'number',
                    'minNumber' => 1,
                    'required' => true,
                    'invalidTextAutoGenerate' => true,
                    'allowedNumberList' => $validatorCustCodeList,
                    'allowedNumberListCSCode' => '&& $("#5_oqqit_rate_4").val() == "Limited"'
                ]);
            ?>
        </div>
        <div class="col-sm-4" id="limitedPackText" style="display: none;">Only <?php echo $daysOutput; ?> days</div>
    </div>

    <div class="form-group row">
        <label for="5_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Προορισμός", "Destination"); ?>
        </label>
        <div class="col-sm-8">
            <select name="5_oqqit_rate_1" id="5_oqqit_rate_1"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($dest = $db->fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $dest['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_1'] == $dest['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $dest['cde_value']; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_1',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>


    <div class="form-group row">
        <label for="5_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Γεωγραφική Περιοχή", "Geographical Area"); ?>
        </label>
        <div class="col-sm-8">


            <select name="5_oqqit_rate_2" id="5_oqqit_rate_2"
                    class="form-control">
                <option value=""></option>
                <option value="WorldExcl" <?php if ($qitem_data['oqqit_rate_2'] == 'WorldExcl') echo 'selected'; ?>>
                    <?php echo $db->showLangText('Worldwide (Excluding U.S.A & Canada)', 'Παγκόσμια (εκτός Η.Π.Α & Καναδά)'); ?>
                </option>
                <option value="WorldWide" <?php if ($qitem_data['oqqit_rate_2'] == 'WorldWide') echo 'selected'; ?>>
                    <?php echo $db->showLangText('Worldwide', 'Παγκόσμια'); ?>
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_2',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="5_oqqit_rate_3" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Χειμερινά Σπόρ", "Winter Sports"); ?>
        </label>
        <div class="col-sm-8">


            <select name="5_oqqit_rate_3" id="5_oqqit_rate_3"
                    class="form-control">
                <option value="No" <?php if ($qitem_data['oqqit_rate_3'] == 'No') echo 'selected'; ?>>
                    <?php echo $db->showLangText('No', 'Οχι'); ?>
                </option>
                <option value="Yes" <?php if ($qitem_data['oqqit_rate_3'] == 'Yes') echo 'selected'; ?>>
                    <?php echo $db->showLangText('Yes', 'Ναί'); ?>
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_3',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>


    <?php

}//section 5

function tr_travel_item_2()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;


    //member 1
    $fieldNames = [
        "name" => "6_oqqit_rate_2",
        "id" => "6_oqqit_rate_3",
        "nationality" => "6_oqqit_rate_4",
        "dob" => "6_oqqit_date_1"
    ];
    showMemberHTML(1, "6_oqqit_rate_1", $fieldNames);

    //member 2
    $fieldNames = [
        "name" => "6_oqqit_rate_7",
        "id" => "6_oqqit_rate_8",
        "nationality" => "6_oqqit_rate_9",
        "dob" => "6_oqqit_date_2"
    ];
    showMemberHTML(2, "6_oqqit_rate_6", $fieldNames);

    //member 3
    $fieldNames = [
        "name" => "6_oqqit_rate_12",
        "id" => "6_oqqit_rate_13",
        "nationality" => "6_oqqit_rate_14",
        "dob" => "6_oqqit_date_3"
    ];
    showMemberHTML(3, "6_oqqit_rate_11", $fieldNames);
}

function tr_travel_item_3()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;

    //member 4
    $fieldNames = [
        "name" => "7_oqqit_rate_2",
        "id" => "7_oqqit_rate_3",
        "nationality" => "7_oqqit_rate_4",
        "dob" => "7_oqqit_date_1"
    ];
    showMemberHTML(4, "7_oqqit_rate_1", $fieldNames);

    //member 5
    $fieldNames = [
        "name" => "7_oqqit_rate_7",
        "id" => "7_oqqit_rate_8",
        "nationality" => "7_oqqit_rate_9",
        "dob" => "7_oqqit_date_2"
    ];
    showMemberHTML(5, "7_oqqit_rate_6", $fieldNames);

    //member 6
    $fieldNames = [
        "name" => "7_oqqit_rate_12",
        "id" => "7_oqqit_rate_13",
        "nationality" => "7_oqqit_rate_14",
        "dob" => "7_oqqit_date_3"
    ];
    showMemberHTML(6, "7_oqqit_rate_11", $fieldNames);

}

function tr_travel_item_4()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;

    //member 7
    $fieldNames = [
        "name" => "8_oqqit_rate_2",
        "id" => "8_oqqit_rate_3",
        "nationality" => "8_oqqit_rate_4",
        "dob" => "8_oqqit_date_1"
    ];
    showMemberHTML(7, "8_oqqit_rate_1", $fieldNames);

    //member 8
    $fieldNames = [
        "name" => "8_oqqit_rate_7",
        "id" => "8_oqqit_rate_8",
        "nationality" => "8_oqqit_rate_9",
        "dob" => "8_oqqit_date_2"
    ];
    showMemberHTML(8, "8_oqqit_rate_6", $fieldNames);

    //member 9
    $fieldNames = [
        "name" => "8_oqqit_rate_12",
        "id" => "8_oqqit_rate_13",
        "nationality" => "8_oqqit_rate_14",
        "dob" => "8_oqqit_date_3"
    ];
    showMemberHTML(9, "8_oqqit_rate_11", $fieldNames);
}

function showMemberHTML($id, $selectionField, $fieldNames)
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;

    ?>

    <div class="row form-group alert alert-success" id="member_<?php echo $id; ?>_line">
        <div class="col-sm-12 text-center" onclick="showHideMembers(<?php echo $id; ?>);" style="cursor: pointer;">
            <strong>Member <?php echo $id; ?></strong>
            <i class="far fa-plus-square" id="member_<?php echo $id; ?>_plus" style="display: none"></i>
            <i class="far fa-minus-square" id="member_<?php echo $id; ?>_minus" style="display: none"></i>
            <input type="hidden" id="<?php echo $selectionField; ?>" name="<?php echo $selectionField; ?>"
                   value="<?php echo $qitem_data[substr($selectionField, 2)]; ?>">
        </div>
    </div>
    <div id="member_<?php echo $id; ?>_contents" style="display: none;">
        <div class="row form-group">

            <label for="<?php echo $fieldNames['name']; ?>" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Όνομα", "Name"); ?>
            </label>
            <div class="col-sm-8">
                <input name="<?php echo $fieldNames['name']; ?>" type="text" id="<?php echo $fieldNames['name']; ?>"
                       class="form-control"
                       value="<?php echo $qitem_data[substr($fieldNames['name'], 2)]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => $fieldNames['name'],
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#' . $selectionField . '").val() == "1"'
                    ]);
                ?>
            </div>

        </div>

        <div class="row form-group">

            <label for="<?php echo $fieldNames['id']; ?>" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Αρ. Διαβατηρίου η Ταυτότητα", "Passport No. or I.D."); ?>
            </label>
            <div class="col-sm-8">
                <input name="<?php echo $fieldNames['id']; ?>" type="text" id="<?php echo $fieldNames['id']; ?>"
                       class="form-control"
                       value="<?php echo $qitem_data[substr($fieldNames['id'], 2)]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => $fieldNames['id'],
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#' . $selectionField . '").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="<?php echo $fieldNames['nationality']; ?>" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Ιθαγένεια", "Nationality"); ?>
            </label>
            <div class="col-sm-8">
                <select class="form-control"
                        id="<?php echo $fieldNames['nationality']; ?>" name="<?php echo $fieldNames['nationality']; ?>">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                    $result = $db->query($sql);
                    while ($count = $db->fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $count['cde_code_ID']; ?>"
                            <?php if ($qitem_data[substr($fieldNames['nationality'], 2)] == $count['cde_code_ID']) echo "selected"; ?>
                        ><?php echo $count['cde_value']; ?></option>
                    <?php } ?>
                </select>
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => $fieldNames['nationality'],
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#' . $selectionField . '").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="<?php echo $fieldNames['dob']; ?>" class="col-sm-4 col-form-label">
                <?php show_quotation_text(" Ημ. Γέννησης", "Date of Birth"); ?>
            </label>
            <div class="col-sm-8">
                <input name="<?php echo $fieldNames['dob']; ?>" type="text" id="<?php echo $fieldNames['dob']; ?>"
                       class="form-control">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => $fieldNames['dob'],
                        'fieldDataType' => 'date',
                        'enableDatePicker' => true,
                        'datePickerValue' => $db->convertDateToEU($qitem_data[substr($fieldNames['dob'], 2)]),
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#' . $selectionField . '").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

    </div>
    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    global $db, $quotationUnderwriter;
    //print_r($quotationUnderwriter);
    //exit();

    //print_r($values);
    //print_r($array);exit();

    //$array[5][4] = 10;

    //get the rate based on the package
    $package = strtolower($values[5][4]['rate']);
    $packageRate = 0;
    if ($package == 'limited'){
        $packageRate = $quotationUnderwriter['oqun_tr_limited_premiums'];
    }
    else {
        $packageRate = $quotationUnderwriter['oqun_tr_' . $package . '_premium'];
    }

    //array of the field to use
    $membersArray[1] = ['item' => 6, 'selected' => 1, 'prem' => 2, 'bod' => 'date_1'];
    $membersArray[2] = ['item' => 6, 'selected' => 6, 'prem' => 7, 'bod' => 'date_2'];
    $membersArray[3] = ['item' => 6, 'selected' => 11, 'prem' => 12, 'bod' => 'date_3'];
    $membersArray[4] = ['item' => 7, 'selected' => 1, 'prem' => 2, 'bod' => 'date_1'];
    $membersArray[5] = ['item' => 7, 'selected' => 6, 'prem' => 7, 'bod' => 'date_2'];
    $membersArray[6] = ['item' => 7, 'selected' => 11, 'prem' => 12, 'bod' => 'date_3'];
    $membersArray[7] = ['item' => 8, 'selected' => 1, 'prem' => 2, 'bod' => 'date_1'];
    $membersArray[8] = ['item' => 8, 'selected' => 6, 'prem' => 7, 'bod' => 'date_2'];
    $membersArray[9] = ['item' => 8, 'selected' => 11, 'prem' => 12, 'bod' => 'date_3'];

    //calculate the members
    $totalMembers = 1; //policy holder is always counted
    for($i=1; $i <= 9; $i++){
        if ($values[$membersArray[$i]['item']][$membersArray[$i]['selected']]['rate'] == '1'){
            $totalMembers++;
            $members[$i]['used'] = 1;
            //check age
            $memberAge = $db->dateDiff(
                $db->convertDateToEU($values[$membersArray[$i]['item']][$membersArray[$i]['bod']]['rate']),
                date('d/m/Y')
            );
            $members[$i]['age'] = $memberAge->y;
        }
    }
    //print_r($members);exit();

    //find the total days
    $totalDays = $values[5][5]['rate'];

    //find the minimum policy premium
    $minPremium = $quotationUnderwriter['oqun_tr_'.$package.'_min_premium'];

    //check if the package is limited
    if ($package == 'limited') {
        $allRates = explode('||',$packageRate);
        //find the one used
        foreach($allRates as $rate){
            $rateSplit = explode('#',$rate);
            if ($rateSplit[0] == $totalDays){
                $packageRate = $rateSplit[1];
            }
        }
        //set the total days to 1 cause the rate of limited is not per day
        $totalDays = 1;
    }

    //find premium per client/member
    //1.Client
    $array[5][6] = ($totalDays * $packageRate);
    //worldwide loading 50%
    if ($values[5][2]['rate'] == 'WorldWide'){
        $array[5][6] += ($totalDays * $packageRate) * 0.5;
    }

    //wintersport loading 100%
    if ($values[5][3]['rate'] == 'Yes'){
        $array[5][6] += ($totalDays * $packageRate);
    }


    //2. Members
    for ($i=1; $i <= 9 ; $i++){
        if ($members[$i]['used'] == 1){
            $basicPremium = $totalDays * $packageRate;
            $memberPremium = $basicPremium;

            //if age < 16 then 50% discount
            if ($members[$i]['age'] < 16){
                $basicPremium = $basicPremium * 0.5;
                $memberPremium = $basicPremium;
            }

            //if worldwide then 50% loading
            if ($values[5][2]['rate'] == 'WorldWide'){
                $memberPremium += $basicPremium * 0.5;
            }

            //if wintersport then 100% loading
            if ($values[5][3]['rate'] == 'Yes'){
                $memberPremium += $basicPremium;
            }

            $array[$membersArray[$i]['item']][$membersArray[$i]['prem']] = $memberPremium;
        }
    }



















    echo "Package: ".$package."<br>";
    echo "Package Rate: ".$packageRate."<br>";
    echo "Total Members: ".$totalMembers."<br>";
    echo "Total Days: ".$totalDays."<br>";
    echo "Min Premium: ".$minPremium."<br>";


    //CHECK FOR LOADINGS

    //winter sport loading
    if ($values[5][3]['rate'] == 'Yes'){
        //$winterSportsLoading = $totalPremium * .5;
        //$array[5][3] = $winterSportsLoading;
    }


    return $array;
}

function get_custom_fees_amount($data){

    global $quotationUnderwriter;
    $data['stamps'] = $quotationUnderwriter['oqun_tr_stamps'];
    $data['fees'] = $quotationUnderwriter['oqun_tr_fees'];

    return $data;
}

?>