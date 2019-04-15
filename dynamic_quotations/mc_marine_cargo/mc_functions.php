<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/3/2019
 * Time: 10:12 ΠΜ
 */

function mc_shipment_details_3()
{
    global $db, $items_data, $qitem_data, $formValidator;
    ?>

    <div class="form-group row">
        <label for="3_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Type of Shipment", "Type of Shipment"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_1" id="3_oqqit_rate_1"
                    class="form-control">
                <option value=""></option>
                <option value="Incomplete" <?php if ($qitem_data['oqqit_rate_1'] == 'Incomplete') echo 'selected'; ?>>
                    <?php show_quotation_text("Incomplete", "Incomplete"); ?>
                </option>
                <option value="Template" <?php if ($qitem_data['oqqit_rate_1'] == 'Template') echo 'selected'; ?>>
                    <?php show_quotation_text("Template", "Template"); ?>
                </option>
                <option value="Quote" <?php if ($qitem_data['oqqit_rate_1'] == 'Quote') echo 'selected'; ?>>
                    <?php show_quotation_text("Quote", "Quote"); ?>
                </option>
                <option value="Booked/Confirmed/Bound" <?php if ($qitem_data['oqqit_rate_1'] == 'Booked/Confirmed/Bound') echo 'selected'; ?>>
                    <?php show_quotation_text("Booked/Confirmed/Bound", "Booked/Confirmed/Bound"); ?>
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '2_oqqit_rate_1',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Type of Shipment.", "Must select Type of Shipment", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Insured Value Currency", "Insured Value Currency"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_2" id="3_oqqit_rate_2"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Currency' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($currency = $db->fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $currency['cde_value']; ?>" <?php if ($qitem_data['oqqit_rate_2'] == $currency['cde_value']) echo 'selected'; ?>>
                        <?php echo $currency['cde_value'] . " - " . $currency['cde_value_2']; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_2',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Type of Shipment.", "Must select Type of Shipment", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_3" class="col-4">
            <?php show_quotation_text("Insured Value", "Insured Value"); ?>
        </label>
        <div class="col-4">
            <input name="3_oqqit_rate_3" type="text" id="3_oqqit_rate_3"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_3',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Insured Value.", "Must Enter Insured Value", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Commodity", "Commodity"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_4" id="3_oqqit_rate_4"
                    class="form-control">
                <option value=""></option>
                <option value="General Cargo & Merchandise" <?php if ($qitem_data['oqqit_rate_4'] == 'General Cargo & Merchandise') echo 'selected'; ?>>
                    General Cargo & Merchandise
                </option>
                <option value="New/Used Vehicles" <?php if ($qitem_data['oqqit_rate_4'] == 'New/Used Vehicles') echo 'selected'; ?>>
                    New/Used Vehicles
                </option>
                <option value="Machinery" <?php if ($qitem_data['oqqit_rate_4'] == 'Machinery') echo 'selected'; ?>>
                    Machinery
                </option>
                <option value="Temp. Controlled Cargo other than meat" <?php if ($qitem_data['oqqit_rate_4'] == 'Temp. Controlled Cargo other than meat') echo 'selected'; ?>>
                    Temp. Controlled Cargo other than meat
                </option>
                <option value="Temp. Controlled Cargo Meat" <?php if ($qitem_data['oqqit_rate_4'] == 'Temp. Controlled Cargo Meat') echo 'selected'; ?>>
                    Temp. Controlled Cargo Meat
                </option>
                <option value="Special Cover Mobile Phones, Electronic Equipment" <?php if ($qitem_data['oqqit_rate_4'] == 'Special Cover Mobile Phones, Electronic Equipment') echo 'selected'; ?>>
                    Special Cover Mobile Phones, Electronic Equipment
                </option>
                <option value="Personal Effects professionally packed" <?php if ($qitem_data['oqqit_rate_4'] == 'Personal Effects professionally packed') echo 'selected'; ?>>
                    Personal Effects professionally packed
                </option>
                <option value="Personal Effects owner packed" <?php if ($qitem_data['oqqit_rate_4'] == 'Personal Effects owner packed') echo 'selected'; ?>>
                    Personal Effects owner packed
                </option>
                <option value="Other" <?php if ($qitem_data['oqqit_rate_4'] == 'Other') echo 'selected'; ?>>
                    Other
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_4',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Commodity.", "Must select Commodity", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_6" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Conveyance", "Conveyance"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_6" id="3_oqqit_rate_6"
                    class="form-control"
                    onchange="checkConveyanceDropDown();">
                <option value=""></option>
                <option value="Air" <?php if ($qitem_data['oqqit_rate_6'] == 'Air') echo 'selected'; ?>>
                    Air
                </option>
                <option value="Land" <?php if ($qitem_data['oqqit_rate_6'] == 'Land') echo 'selected'; ?>>
                    Land
                </option>
                <option value="Ocean Vessel" <?php if ($qitem_data['oqqit_rate_6'] == 'Ocean Vessel') echo 'selected'; ?>>
                    Ocean Vessel
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_6',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Conveyance.", "Must select Conveyance", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row" id="ocean-vessel-name-div">
        <label for="3_oqqit_rate_7" class="col-5 text-right">
            <?php show_quotation_text("Vessel Name", "Vessel Name"); ?>
        </label>
        <div class="col-7">
            <input name="3_oqqit_rate_7" type="text" id="3_oqqit_rate_7"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_7"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_7',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'requiredAddedCustomCode' => "&& $('#3_oqqit_rate_6').val() == 'Ocean Vessel'",
                    'invalidText' => show_quotation_text("Συμπληρώστε Vessel Name.", "Must Enter Vessel Name", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row" id="ocean-steamer-div">
        <label for="3_oqqit_rate_8" class="col-5 text-right">
            <?php show_quotation_text("Approved Steamer if not known", "Approved Steamer if not known"); ?>
        </label>
        <div class="col-7">
            <input name="3_oqqit_rate_8" type="text" id="3_oqqit_rate_8"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_8"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_8',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'requiredAddedCustomCode' => "&& $('#3_oqqit_rate_6').val() == 'Ocean Vessel'",
                    'invalidText' => show_quotation_text("Συμπληρώστε Approved Steamer.", "Must Enter Approved Steamer", 'Return')
                ]);
            ?>
        </div>
    </div>

    <script>
        function checkConveyanceDropDown() {
            let conv = $('#3_oqqit_rate_6').val();
            if (conv == 'Ocean Vessel') {
                $('#ocean-vessel-name-div').show();
                $('#ocean-steamer-div').show();
            } else {
                $('#ocean-vessel-name-div').hide();
                $('#ocean-steamer-div').hide();
            }
        }
    </script>

    <div class="form-group row">
        <label for="3_oqqit_rate_9" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Packing / Shipment Method", "Packing / Shipment Method"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_9" id="3_oqqit_rate_9"
                    class="form-control">
                <option value=""></option>
                <option value="General" <?php if ($qitem_data['oqqit_rate_9'] == 'General') echo 'selected'; ?>>
                    General
                </option>
                <option value="Loose" <?php if ($qitem_data['oqqit_rate_9'] == 'Loose') echo 'selected'; ?>>
                    Loose
                </option>
                <option value="Bulk" <?php if ($qitem_data['oqqit_rate_9'] == 'Bulk') echo 'selected'; ?>>
                    Bulk
                </option>
                <option value="Other" <?php if ($qitem_data['oqqit_rate_9'] == 'Other') echo 'selected'; ?>>
                    Other
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_9',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Packing / Shipment Method.", "Must select Packing / Shipment Method", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_10" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Country of Origin", "Country of Origin"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_10" id="3_oqqit_rate_10"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($country = $db->fetch_assoc($result)) {
                    $reffered = '';
                    if ($country['cde_option_value'] == 'Reject'){
                        $reffered = ' - <b>Country Not Allowed</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_10'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'].$reffered; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_10',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Country of Origin.", "Must select Country of Origin", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_11" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Via Country", "Via Country"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_11" id="3_oqqit_rate_11"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($country = $db->fetch_assoc($result)) {
                    $reffered = '';
                    if ($country['cde_option_value'] == 'Reject'){
                        $reffered = ' - <b>Country Not Allowed</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_11'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'].$reffered; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_11',
                    'fieldDataType' => 'select',
                    'required' => false,
                    'invalidText' => show_quotation_text("Επιλέξτε Via Country.", "Must select Via Country", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_12" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Destination Country", "Destination Country"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_12" id="3_oqqit_rate_12"
                    class="form-control">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                $result = $db->query($sql);
                while ($country = $db->fetch_assoc($result)) {
                    $reffered = '';
                    if ($country['cde_option_value'] == 'Reject'){
                        $reffered = ' - <b>Country Not Allowed</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_12'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'].$reffered; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_12',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε Destination Country.", "Must select Destination Country", 'Return')
                ]);
            ?>
        </div>
    </div>



    <?php
}

function mc_cargo_details_4()
{
    global $db, $items_data, $qitem_data, $formValidator;
    ?>

    <div class="form-group row">
        <label for="4_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Full Description of Cargo", "Full Description of Cargo"); ?>
        </label>
        <div class="col-sm-8">
            <textarea name="4_oqqit_rate_1" id="4_oqqit_rate_1"
                      class="form-control"><?php echo $qitem_data['oqqit_rate_1']; ?></textarea>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_1',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Full Description of Cargo.", "Must Fill Full Description of Cargo", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="4_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Marks & Numbers", "Marks & Numbers"); ?>
        </label>
        <div class="col-sm-8">
            <textarea name="4_oqqit_rate_2" id="4_oqqit_rate_2"
                      class="form-control"><?php echo $qitem_data['oqqit_rate_2']; ?></textarea>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_2',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Marks & Numbers.", "Must Fill Marks & Numbers", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="4_oqqit_rate_3" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Letter of Credit Conditions", "Letter of Credit Conditions"); ?>
        </label>
        <div class="col-sm-8">
            <textarea name="4_oqqit_rate_3" id="4_oqqit_rate_3"
                      class="form-control"><?php echo $qitem_data['oqqit_rate_3']; ?></textarea>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_3',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Letter of Credit Conditions.", "Must Fill Letter of Credit Conditions", 'Return')
                ]);
            ?>
        </div>
    </div>

    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

function activate_custom_validation($data){
    global $db;
    
    $result['error'] = false;
    $result['errorDescription'] = '';


    //get item 3 data
    $sql = 'SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = '.$data['oqq_quotations_ID'].' AND oqqit_items_ID = 3';
    $item3 = $db->query_fetch($sql);

    if ($item3['oqqit_rate_10'] == '' || $item3['oqqit_rate_11'] == '' || $item3['oqqit_rate_12'] == ''){
        $result['error'] = true;
        $result['errorDescription'] = 'Missing data';
        return $result;
    }


    //get all 3 countries from codes
    $countriesResult = $db->query("
        SELECT * FROM codes WHERE cde_type = 'Countries' AND (
            cde_code_ID = ".$item3['oqqit_rate_10']." OR
            cde_code_ID = ".$item3['oqqit_rate_11']." OR
            cde_code_ID = ".$item3['oqqit_rate_12']." 
        )");
    while ($country = $db->fetch_assoc($countriesResult)){
        $countries[$country['cde_code_ID']] = $country;
    }

    //check origin country
    $originCountryID = $item3['oqqit_rate_10'];
    if ($countries[$originCountryID]['cde_option_value'] == 'Reject'){
        $result['error'] = true;
        $result['errorDescription'] = 'Origin Country: '.$countries[$originCountryID]['cde_value']." Cannot be used.<br>";
    }


    //check via country
    $viaCountryID = $item3['oqqit_rate_11'];
    if ($countries[$viaCountryID]['cde_option_value'] == 'Reject'){
        $result['error'] = true;
        $result['errorDescription'] .= 'Via Country: '.$countries[$viaCountryID]['cde_value']." Cannot be used.<br>";
    }

    //check destination country
    $destinationCountryID = $item3['oqqit_rate_12'];
    if ($countries[$destinationCountryID]['cde_option_value'] == 'Reject'){
        $result['error'] = true;
        $result['errorDescription'] .= 'Destination Country: '.$countries[$destinationCountryID]['cde_value']." Cannot be used.<br>";
    }


    return $result;
}

function customCheckForApproval($data){
    global $db;

    $result['error'] = false;
    $result['errorDescription'] = '';

    //get item 3 data
    $item3 = $db->query_fetch('SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = '.$data['oqq_quotations_ID'].' AND oqqit_items_ID = 3');

    //get all 3 countries from codes
    $countriesResult = $db->query("
        SELECT * FROM codes WHERE cde_type = 'Countries' AND (
            cde_code_ID = ".$item3['oqqit_rate_10']." OR
            cde_code_ID = ".$item3['oqqit_rate_11']." OR
            cde_code_ID = ".$item3['oqqit_rate_12']." 
        )");
    while ($country = $db->fetch_assoc($countriesResult)){
        $countries[$country['cde_code_ID']] = $country;
    }

    //check origin country
    $originCountryID = $item3['oqqit_rate_10'];
    if ($countries[$originCountryID]['cde_option_value'] == 'Approval'){
        $result['error'] = true;
        $result['errorDescription'] = 'Origin Country: '.$countries[$originCountryID]['cde_value']." Needs Approval.<br>";
    }


    //check via country
    $viaCountryID = $item3['oqqit_rate_11'];
    if ($countries[$viaCountryID]['cde_option_value'] == 'Approval'){
        $result['error'] = true;
        $result['errorDescription'] .= 'Via Country: '.$countries[$viaCountryID]['cde_value']." Needs Approval.<br>";
    }

    //check destination country
    $destinationCountryID = $item3['oqqit_rate_12'];
    if ($countries[$destinationCountryID]['cde_option_value'] == 'Approval'){
        $result['error'] = true;
        $result['errorDescription'] .= 'Destination Country: '.$countries[$destinationCountryID]['cde_value']." Needs Approval.<br>";
    }

    return $result;
}

?>