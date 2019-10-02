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
        let todayDateEU = (todayDate.getDate() + "/" + todayDate.getMonth() + "/" + todayDate.getFullYear());
        let clientAge = getYearsFromDates(
            $("#birthdate").val(),
            (todayDate.getDate() + "/" + todayDate.getMonth() + "/" + todayDate.getFullYear())
        );
        
        '.($db->user_data['usr_user_rights'] <= 2? '/*Advanced user - Allow any age*/clientAge = 20;':'').'
        
        if (clientAge < 18){
            $("#birthdate-invalid-text").html("Age must be over 18");
            $("#birthdate").addClass("is-invalid");
            $("#birthdate").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("birthdate -> Lower than 18 ");
        }
        
        if (clientAge >= 75){
            $("#birthdate-invalid-text").html("Age must under 75");
            $("#birthdate").addClass("is-invalid");
            $("#birthdate").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("birthdate -> Higher than 74 ");
        }
        
        //fill the expiration date
        let departure = $("#5_oqqit_date_1").val();
        let departureSplit = departure.split("/");
        let expiry = new Date(departureSplit[2],departureSplit[1]-1,departureSplit[0]);
        let totalDays = $("#5_oqqit_rate_5").val();
        let clientDestError = false;
        expiry.setDate(expiry.getDate() + (totalDays*1));
        $("#expiry_date").val(expiry.getDate() + "/" + ((expiry.getMonth()*1)+1) + "/" + expiry.getFullYear());
        
        //if destination = client/member nationality generate error
        let destinationError = "'.show_quotation_text('Ο προορισμός και η ιθαγένεια συμβαλλομένου δεν μπορούν να είναι οι ίδιοι', 'Destination & Policyholder Nationality cannot be the same','return').'";
        if ($("#5_oqqit_rate_1").val() == $("#nationality_ID").val()){
            console.log("Client error");
            $("#destination-invalid-text").html(destinationError);
            $("#destination").addClass("is-invalid");
            $("#destination").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("destination -> Client Nationality is equal to Destination");
            clientDestError = true;
        }
        
        //members - destination = nationality generate error
        let memebrsList = [
            "6_oqqit_rate_4",
            "6_oqqit_rate_9",
            "6_oqqit_rate_14",
            "7_oqqit_rate_4",
            "7_oqqit_rate_9",
            "7_oqqit_rate_14",
            "8_oqqit_rate_4",
            "8_oqqit_rate_9",
            "8_oqqit_rate_14",
        ];
        destinationError = "'.show_quotation_text('Ο προορισμός και η ιθαγένεια μέλους δεν μπορούν να είναι οι ίδιοι', 'Destination & Member Nationality cannot be the same','return').'";
        let destMemberError = false;
        var i;
        for (i=0; i<=8; i++){
        
            if ( $("#" + memebrsList[i]).val() == $("#5_oqqit_rate_1").val()){
                //console.log(memebrsList[i] + " => " + $("#" + memebrsList[i]).val() + " == " + $("#6_oqqit_rate_4").val());
                destMemberError = true;
            }
        }
        if (destMemberError == true){
            //console.log("Member error");
            $("#destination-invalid-text").html(destinationError);
            $("#destination").addClass("is-invalid");
            $("#destination").removeClass("is-valid");
            FormErrorFound = true;
            ErrorList.push("destination -> Client Nationality is equal to Destination");
        }
        else if (clientDestError == false){
            $("#destination-invalid-text").html(destinationError);
            $("#destination").addClass("is-valid");
            $("#destination").removeClass("is-invalid");
        }
        
    ');

    ?>

    <div class="form-group row">

        <input type="hidden" name="expiry_date" id="expiry_date" value="">

        <label for="5_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Πακέτο", "Package"); ?>
        </label>
        <div class="col-sm-8">


            <select name="5_oqqit_rate_4" id="5_oqqit_rate_4" onchange="packageSelection();"
                    class="form-control" title="<?php show_quotation_text("Πακέτο", "Package"); ?>">
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
        function packageSelection() {
            let selectedPackage = $('#5_oqqit_rate_4').val();
            //console.log(selectedPackage);
            if (selectedPackage == 'Limited') {
                //limit destination to russia
                $('#destination').val(309);
                destinationOnChange();
                $('#destination').attr('disabled', true);

                //limit geographical area to worldwide excluding
                $('#geographicalArea').val('WorldExcl');
                $('#geographicalArea').attr('disabled', true);

                //limit winter sports
                $('#winterSports').val('No');
                $('#winterSports').attr('disabled', true);
            }
            else if (selectedPackage == 'Schengen') {
                $('#winterSports').val('No');
                $('#winterSports').attr('disabled', true);

                $('#destination').attr('disabled', false);
                $('#geographicalArea').attr('disabled', false);
            }
            else {
                $('#destination').attr('disabled', false);
                $('#geographicalArea').attr('disabled', false);
                $('#winterSports').attr('disabled', false);

            }
            destinationOnChange();
            geographicalAreaOnChange();
            winterSportsOnChange();
        }
    </script>

    <div class="row form-group">

        <label for="5_oqqit_date_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Ημ. Αναχώρησης", "Departure Date"); ?>
        </label>
        <div class="col-sm-3">
            <input name="5_oqqit_date_1" type="text" id="5_oqqit_date_1"
                   class="form-control text-center" title="<?php show_quotation_text("Ημ. Αναχώρησης", "Departure Date"); ?>">
            <?php

            $minDate = '';
            if ($db->user_data['usr_user_rights'] <= 2){
                $minDate = '01/01/1900';
            }
            else {
                $minDate = date('d/m/Y');
            }

            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convertDateToEU($qitem_data['oqqit_date_1']),
                    'required' => true,
                    'invalidTextAutoGenerate' => show_quotation_text('Καταχώρησε Ημ. Αναχώρησης', 'Must enter Departure Date'),
                    'dateMinDate' => $minDate,
                    'dateMaxDate' => date('d/m/Y', mktime(0, 0, 0, date('m'), (date('d') + 45), date('Y'))),
                ]);
            ?>
        </div>
        <div class="col-sm-5 text-danger">
            <?php echo show_quotation_text("Όχι προγενέστερη απο Σήμερα. <br>Όχι μεταγενέστερη 45 μέρες απο σήμερα.","Not before today. Not after 45 days from today.");?>
        </div>
    </div>

    <div class="row form-group">

        <label for="5_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Περίοδος Ασφάλισης (μέρες)", "Period of Insurance (days)"); ?>
        </label>
        <div class="col-sm-3">
            <input name="5_oqqit_rate_5" type="text" id="5_oqqit_rate_5" title="<?php show_quotation_text("Περίοδος Ασφάλισης (μέρες)", "Period of Insurance (days)"); ?>"
                   class="form-control text-center" value="<?php echo $qitem_data['oqqit_rate_5']; ?>">
            <?php

            $formValidator->addField(
                [
                    'fieldName' => '5_oqqit_rate_5',
                    'fieldDataType' => 'number',
                    'minNumber' => 1,
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="5_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Προορισμός", "Destination"); ?>
        </label>
        <div class="col-sm-8">
            <input type="hidden" id="5_oqqit_rate_1" name="5_oqqit_rate_1" title="<?php show_quotation_text("Προορισμός", "Destination"); ?>"
                   value="<?php echo $qitem_data['oqqit_rate_1']; ?>">
            <select name="destination" id="destination" onchange="destinationOnChange();"
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
                    'fieldName' => 'destination',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>
    <script>
        function destinationOnChange() {
            var destinationID = $('#destination').val();
            $('#5_oqqit_rate_1').val(destinationID);
        }
    </script>


    <div class="form-group row">
        <label for="5_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Γεωγραφική Περιοχή", "Geographical Area"); ?>
        </label>
        <div class="col-sm-8">

            <input type="hidden" name="5_oqqit_rate_2" id="5_oqqit_rate_2"
                   value="<?php echo $qitem_data['oqqit_rate_2']; ?>">
            <select name="geographicalArea" id="geographicalArea" title="<?php show_quotation_text("Γεωγραφική Περιοχή", "Geographical Area"); ?>"
                    class="form-control" onchange="geographicalAreaOnChange();">
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
                    'fieldName' => 'geographicalArea',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
            <script>
                function geographicalAreaOnChange() {
                    var geoArea = $('#geographicalArea').val();
                    $('#5_oqqit_rate_2').val(geoArea);
                }
            </script>
        </div>
    </div>

    <div class="form-group row">
        <label for="5_oqqit_rate_3" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Χειμερινά Σπόρ", "Winter Sports"); ?>
        </label>
        <div class="col-sm-8">

            <input type="hidden" id="5_oqqit_rate_3" name="5_oqqit_rate_3" title="<?php show_quotation_text("Χειμερινά Σπόρ", "Winter Sports"); ?>"
                   value="<?php echo $qitem_data['oqqit_rate_3']; ?>">
            <select name="winterSports" id="winterSports"
                    class="form-control" onchange="winterSportsOnChange();">
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
                    'fieldName' => 'winterSports',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidTextAutoGenerate' => true
                ]);
            ?>
        </div>
    </div>
    <script>
        function winterSportsOnChange() {
            var winterSports = $('#winterSports').val();
            $('#5_oqqit_rate_3').val(winterSports);
        }

        let membersError = [];
        function validateMemberAge(dobName){

            let dob = $('#' + dobName).val();
            //validate if prober date
            dobSplit = dob.split('/');
            let day = false;
            let month = false;
            let year = false;
            if (dobSplit[0] > 0 && dobSplit[0] <= 31){
                day = true;
            }
            if (dobSplit[1] > 0 && dobSplit[1] <= 12){
                month = true;
            }
            if (dobSplit[2] > 1900 && dobSplit[2] <= 2100){
                year = true;
            }

            if (day && month && year){

                let todayDate = new Date();
                let todayDateEU = (todayDate.getDate() + "/" + todayDate.getMonth() + "/" + todayDate.getFullYear());
                let totalDays = getYearsFromDates($("#" + dobName).val(),todayDateEU,"totalDays");
                let years = getYearsFromDates($("#" + dobName).val(),todayDateEU);

                //check if less than 14 days
                if (totalDays <= 14){
                    $('#' + dobName + '-invalid-text').html("Age must be more than 14 days");
                    $('#' + dobName).addClass('is-invalid');
                    $('#' + dobName).removeClass('is-valid');

                    membersError[dobName] = true;

                }
                else if (years >= 75){
                    $('#' + dobName + '-invalid-text').html("Age must be less than 75");
                    $('#' + dobName).addClass('is-invalid');
                    $('#' + dobName).removeClass('is-valid');

                    membersError[dobName] = true;
                }
                else {
                    $('#' + dobName).addClass('is-valid');
                    $('#' + dobName).removeClass('is-invalid');
                    membersError[dobName] = false;
                }
            }


        }

        //make red info under client-address
        $('#insureds_address_invalid_tooltip').html("<?php echo show_quotation_text('Μόνιμοι κάτοικοι Κύπρου μόνο', 'Cyprus permanent residents only');?>");
        $('#insureds_address_invalid_tooltip').show();
    </script>

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
        <div class="col-sm-12 text-center" onclick="showHideMembers(<?php echo $id; ?>,'manual');"
             style="cursor: pointer;">
            <strong>
                <?php echo show_quotation_text('Μέλος ' . $id, 'Member ' . $id); ?>
            </strong>
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
                       class="form-control" title="<?php show_quotation_text("Μέλος ".$id." Όνομα", "Member ".$id." Name"); ?>"
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
                       class="form-control" title="<?php show_quotation_text("Μέλος ".$id." Αρ. Διαβατηρίου η Ταυτότητα", "Member ".$id." Passport No. or I.D."); ?>"
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
                <select class="form-control" title="<?php show_quotation_text("Μέλος ".$id." Ιθαγένεια", "Member ".$id." Nationality"); ?>"
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
                <?php show_quotation_text(" Ημ. Γέννησης", " Date of Birth"); ?>
            </label>
            <div class="col-sm-8">
                <input name="<?php echo $fieldNames['dob']; ?>" type="text" id="<?php echo $fieldNames['dob']; ?>"
                       title="<?php show_quotation_text("Μέλος ".$id." Ημ. Γέννησης", "Member ".$id." Date of Birth"); ?>"
                       class="form-control" onkeyup="validateMemberAge('<?php echo $fieldNames['dob'];?>');">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => $fieldNames['dob'],
                        'fieldDataType' => 'date',
                        'enableDatePicker' => true,
                        'datePickerValue' => $db->convertDateToEU($qitem_data[substr($fieldNames['dob'], 2)]),
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#' . $selectionField . '").val() == "1" || membersError["'.$fieldNames['dob'].'"] == true'
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
    $packageRate = $quotationUnderwriter['oqun_tr_' . $package . '_premium'];

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

    //check the members
    $totalMembers = 1; //policy holder is always counted
    for ($i = 1; $i <= 9; $i++) {
        if ($values[$membersArray[$i]['item']][$membersArray[$i]['selected']]['rate'] == '1') {
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
    $minPremium = $quotationUnderwriter['oqun_tr_' . $package . '_min_premium'];

    $totalPremium = 0;
    //find premium per client/member
    //1.Client
    $array[5][6] = ($totalDays * $packageRate);
    //worldwide loading 50%
    if ($values[5][2]['rate'] == 'WorldWide') {
        $array[5][6] += $array[5][6] * 0.5;
    }

    //wintersport loading 100%
    if ($values[5][3]['rate'] == 'Yes') {
        $array[5][6] += $array[5][6];
    }
    //check limited min premium
    if ($values[5][4]['rate'] == 'Limited') {
        if ($minPremium > $array[5][6]) {
            $array[5][6] = $minPremium;
        }
    }
    $totalPremium += $array[5][6];


    //2. Members
    for ($i = 1; $i <= 9; $i++) {
        if ($members[$i]['used'] == 1) {
            $memberPremium = $totalDays * $packageRate;
            //echo "Total Days:" . $totalDays . " Rate:" . $packageRate . "<br>";//exit();

            //if worldwide then 50% loading
            if ($values[5][2]['rate'] == 'WorldWide') {
                //echo "Worldwide applied<br>";
                $memberPremium += $memberPremium * 0.5;
            }

            //if wintersport then 100% loading
            if ($values[5][3]['rate'] == 'Yes') {
                //echo "Wintersport applied<br>";
                $memberPremium += $memberPremium;
            }

            //if age < 16 then 50% discount
            if ($members[$i]['age'] < 16) {
                //echo "Age Discount applied<br>";
                $memberPremium = $memberPremium * 0.5;
            }

            //if package = limited then the min premium applies to each person
            if ($values[5][4]['rate'] == 'Limited') {
                if ($minPremium > $memberPremium) {
                    //echo "Limited min premium applied:" . $memberPremium . " -> " . $minPremium;
                    //exit();
                    $memberPremium = $minPremium;
                }
            }


            $array[$membersArray[$i]['item']][$membersArray[$i]['prem']] = $memberPremium;
            $totalPremium += $memberPremium;
        }
    }

    //3. Check policy min premium. Applies when package is not limited
    if ($values[5][4]['rate'] != 'Limited') {
        if ($minPremium > $totalPremium){
            $array[5][7] = $minPremium - $totalPremium;
        }
    }

    return $array;
}

function get_custom_fees_amount($data)
{

    global $quotationUnderwriter,$result_amount_values;

    $package = strtolower($result_amount_values[5][4]['rate']);
    $dbFeesFieldName = 'oqun_tr_'.$package.'_fees';
    $dbStampsFieldName = 'oqun_tr_'.$package.'_stamps';

    $data['stamps'] = $quotationUnderwriter[$dbStampsFieldName];
    $data['fees'] = $quotationUnderwriter[$dbFeesFieldName];

    return $data;
}

?>