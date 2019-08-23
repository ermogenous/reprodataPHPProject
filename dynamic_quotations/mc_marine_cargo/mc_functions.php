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
        <label for="3_oqqit_rate_9" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Conditions Of Insurance", "Conditions Of Insurance"); ?>
        </label>
        <div class="col-sm-8">
            <div class="container custom-control-inline">
                <div class="input-group">
                    <div class="custom-control custom-radio"
                    ">
                    <input type="radio" id="ClauseA" name="3_oqqit_rate_13" value="Clause A"
                           class="custom-control-input"
                        <?php if ($qitem_data['oqqit_rate_13'] == 'Clause A') echo 'checked'; ?>>
                    <label class="custom-control-label" for="ClauseA">
                        &nbsp;Institute Clause A
                    </label>
                </div>
                &nbsp;
            </div>

            <div class="input-group">
                <div class="custom-control custom-radio">
                    <input type="radio" id="ClauseC" name="3_oqqit_rate_13" value="Clause C"
                           class="custom-control-input"
                        <?php if ($qitem_data['oqqit_rate_13'] == 'Clause C') echo 'checked'; ?> >
                    <label class="custom-control-label" for="ClauseC">
                        &nbsp;Institute Clause C
                    </label>
                </div>

            </div>
        </div>

        <?php
        $formValidator->addField(
            [
                'fieldName' => '3_oqqit_rate_13',
                'fieldDataType' => 'radio',
                'required' => true,
                'invalidText' => show_quotation_text("Επιλέξτε Conditions Of Insurance.", "Must select Conditions Of Insurance", 'Return')
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
                    Other [Requires Approval]
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
            <script>
                function Approval3_oqqit_rate_4() {

                    //console.log('executed');

                    let result = [];
                    if ($('#3_oqqit_rate_4').val() == 'Other') {
                        result['result'] = 1;
                        result['info'] = 'Commodity: Requires Approval';
                    }
                    else {
                        result['result'] = 0;
                        result['info'] = '';
                    }
                    return result;
                }

            </script>
        </div>
    </div>


    <?php
    //remove type of shipment
    if (1 == 2) {
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
    <?php } ?>


    <div class="form-group row">
        <label for="3_oqqit_rate_2" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Insured Value Currency", "Insured Value Currency"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_2" id="3_oqqit_rate_2"
                    class="form-control" onchange="autoUpdateExchangeRate();">
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

    <script>
        //update the exchange rate to 1 only if currency selected is EUR
        function autoUpdateExchangeRate(){
            let currency = $('#3_oqqit_rate_2').val();
            console.log('#' + currency + '#');
            if (currency == 'EUR'){
                console.log('EUR');
                $('#3_oqqit_rate_5').val('1');
            }
        }
    </script>

    <div class="form-group row">
        <label for="3_oqqit_rate_3" class="col-sm-4">
            <?php show_quotation_text("Insured Value", "Insured Value"); ?>
        </label>
        <div class="col-sm-3">
            <input name="3_oqqit_rate_3" type="text" id="3_oqqit_rate_3"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_3',
                    'fieldDataType' => 'integer',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Insured Value.", "Must Enter Insured Value (Integer)no comma`s, no dots.", 'Return')
                ]);
            ?>
        </div>

        <label for="3_oqqit_rate_5" class="col-sm-3">
            <?php show_quotation_text("Exchange Rate", "Exchange Rate"); ?>
        </label>
        <div class="col-sm-2">
            <input name="3_oqqit_rate_5" type="text" id="3_oqqit_rate_5"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_5"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_5',
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Exchange Rate.", "Must Enter Exchange Rate (Decimal)", 'Return')
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
                <option value="Multimode" <?php if ($qitem_data['oqqit_rate_6'] == 'Multimode') echo 'selected'; ?>>
                    Multimode
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

    <!-- removed
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
    -->

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
                    if ($country['cde_option_value'] == 'Reject') {
                        $reffered = ' - <b>Country Not Allowed</b>';
                    } else if ($country['cde_option_value'] == 'Approval') {
                        $reffered = ' - <b>Country Needs Approval</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_10'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'] . $reffered; ?>
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
            $jsCode = activate_custom_validation('', true);
            ?>
            <script>
                function Approval3_oqqit_rate_10() {
                    var result = {"result": "0", "info": ""};
                    <?php echo $jsCode['origin']['approval'];?>
                    return result;
                }

                function Reject3_oqqit_rate_10() {
                    var result = {"result": "0", "info": ""};
                    <?php echo $jsCode['origin']['reject'];?>
                    return result;
                }
            </script>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_14" class="col-4">
            <?php show_quotation_text("City of Origin", "City of Origin"); ?>
        </label>
        <div class="col-8">
            <input name="3_oqqit_rate_14" type="text" id="3_oqqit_rate_14"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_14"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_14',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε City of Origin.", "Must Enter City of Origin", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_11" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Via Country", "Via Country"); ?>
        </label>
        <div class="col-sm-8">
            <input name="3_oqqit_rate_11" type="text" id="3_oqqit_rate_11"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_11"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_11',
                    'fieldDataType' => 'text',
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
                    if ($country['cde_option_value'] == 'Reject') {
                        $reffered = ' - <b>Country Not Allowed</b>';
                    } else if ($country['cde_option_value'] == 'Approval') {
                        $reffered = ' - <b>Country Needs Approval</b>';
                    }
                    ?>
                    <option value="<?php echo $country['cde_code_ID']; ?>"
                        <?php if ($qitem_data['oqqit_rate_12'] == $country['cde_code_ID']) echo 'selected'; ?>>
                        <?php echo $country['cde_value'] . $reffered; ?>
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
            <script>
                function Approval3_oqqit_rate_12() {
                    var result = {"result": "0", "info": ""};
                    <?php echo $jsCode['destination']['approval'];?>
                    return result;
                }

                function Reject3_oqqit_rate_12() {
                    var result = {"result": "0", "info": ""};
                    <?php echo $jsCode['destination']['reject'];?>
                    return result;
                }
            </script>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_rate_15" class="col-4">
            <?php show_quotation_text("Destination City", "Destination City"); ?>
        </label>
        <div class="col-8">
            <input name="3_oqqit_rate_15" type="text" id="3_oqqit_rate_15"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_15"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_15',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Destination City.", "Must Enter Destination City", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="3_oqqit_date_1" class="col-4">
            <?php show_quotation_text("Shipment Date", "Shipment Date"); ?>
        </label>
        <div class="col-8">
            <input name="3_oqqit_date_1" type="text" id="3_oqqit_date_1"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_date_1"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_1"],'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'required' => true,
                    'invalidText' => show_quotation_text("Καταχωρήστε Shipment Date.", "Must supply Shipment Date", 'Return')
                ]);
            ?>
        </div>
    </div>

    <?php
}

function mc_cargo_details_4()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;
    ?>

    <div class="form-group row">
        <label for="4_oqqit_rate_7" class="col-4">
            <?php show_quotation_text("Reference", "Reference"); ?>
        </label>
        <div class="col-8">
            <input name="4_oqqit_rate_7" type="text" id="4_oqqit_rate_7"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_7"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_7',
                    'fieldDataType' => 'text',
                    'required' => false
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="4_oqqit_rate_5" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Supplier", "Supplier"); ?>
        </label>
        <div class="col-sm-8">
            <textarea name="4_oqqit_rate_5" id="4_oqqit_rate_5"
                      class="form-control"><?php echo $qitem_data['oqqit_rate_5']; ?></textarea>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_5',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Supplier.", "Must Fill Supplier", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="4_oqqit_rate_1" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Full Description of Cargo", "Full Description of Cargo/Goods Insured"); ?>
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
                    'required' => false,
                    'invalidText' => show_quotation_text("Συμπληρώστε Letter of Credit Conditions.", "Must Fill Letter of Credit Conditions", 'Return')
                ]);
            ?>
        </div>
    </div>

    <?php if ($db->user_data['usr_user_rights'] <= 2 || $underwriter['oqun_show_excess_replace'] == 1) { ?>
    <div class="form-group row">
        <label for="4_oqqit_rate_6" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Excess Replace", "Excess Replace"); ?>
        </label>
        <div class="col-sm-8">
            <textarea name="4_oqqit_rate_6" id="4_oqqit_rate_6"
                      class="form-control"><?php echo $qitem_data['oqqit_rate_6']; ?></textarea>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_6',
                    'fieldDataType' => 'text',
                    'required' => false
                ]);
            ?>
        </div>
    </div>
    <?php }//show if user rights <= 2 ?>

    <?php
    if ($db->user_data['usr_user_rights'] <= 2) { ?>
    <div class="form-group row">
        <label for="4_oqqit_rate_8" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Rate", "Rate"); ?>
        </label>
        <div class="col-sm-8">
            <input type="text" name="4_oqqit_rate_8" id="4_oqqit_rate_8"
                      class="form-control" value="<?php echo $qitem_data['oqqit_rate_8']; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_8',
                    'fieldDataType' => 'number',
                    'required' => false,
                    'invalidText' => show_quotation_text("Συμπληρώστε Rate.", "Must Fill Rate", 'Return')
                ]);
            ?>
        </div>
    </div>
    <?php }//show if user rights <= 2
    else {
        ?>
        <input type="hidden" id="4_oqqit_rate_8" name="4_oqqit_rate_8" value="<?php echo $qitem_data['oqqit_rate_8']; ?>">
        <?php
    }//if user rights > 2 then show this
    ?>

        <script>
            function updateRate(){
                let commodity = $('#3_oqqit_rate_4').val();
                let clause = $('input[name=3_oqqit_rate_13]:checked', '#myForm').val();
                let rate = 0;
                if (commodity == 'General Cargo & Merchandise'){
                    rate = '<?php echo $underwriter["oqun_excess_general_cargo_rate"];?>';
                }
                else if (commodity == 'New/Used Vehicles'){
                    rate = '<?php echo $underwriter["oqun_excess_vehicles_rate"];?>';
                }
                else if (commodity == 'Machinery'){
                    rate = '<?php echo $underwriter["oqun_excess_machinery_rate"];?>';
                }
                else if (commodity == 'Temp. Controlled Cargo other than meat'){
                    rate = '<?php echo $underwriter["oqun_excess_temp_no_meat_rate"];?>';
                }
                else if (commodity == 'Temp. Controlled Cargo Meat'){
                    rate = '<?php echo $underwriter["oqun_excess_temp_meat_rate"];?>';
                }
                else if (commodity == 'Special Cover Mobile Phones, Electronic Equipment'){
                    rate = '<?php echo $underwriter["oqun_excess_special_cover_rate"];?>';
                }
                else if (commodity == 'Personal Effects professionally packed'){
                    rate = '<?php echo $underwriter["oqun_excess_pro_packed_rate"];?>';
                }
                else if (commodity == 'Personal Effects owner packed'){
                    rate = '<?php echo $underwriter["oqun_excess_owner_packed_rate"];?>';
                }
                else if (commodity == 'Other'){
                    rate = '<?php echo $underwriter["oqun_excess_other_rate"];?>';
                }

                if (clause == 'Clause C'){
                    rate = '<?php echo $underwriter["oqun_icc_c_rate"];?>';
                }
                $('#4_oqqit_rate_8').val(rate);
            }
            //add event to commodity and conditions of insurance on change
            $("#3_oqqit_rate_4").change(function(){
                updateRate();
            });
            $("input[name=3_oqqit_rate_13]","#myForm").change(function(){
                updateRate();
            });
        </script>


    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

function activate_custom_validation($data, $returnJS = false)
{
    global $db;

    $result['error'] = false;
    $result['errorDescription'] = '';


    if ($returnJS == false) {
        //get item 3 data
        $sql = 'SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ' . $data['oqq_quotations_ID'] . ' AND oqqit_items_ID = 3';
        $item3 = $db->query_fetch($sql);

        if ($item3['oqqit_rate_10'] == '' || $item3['oqqit_rate_11'] == '' || $item3['oqqit_rate_12'] == '') {
            $result['error'] = true;
            $result['errorDescription'] = 'Missing data';
            return $result;
        }


        //get all 3 countries from codes
        $sql = "
        SELECT * FROM codes WHERE cde_type = 'Countries' AND (";

        if ($item3['oqqit_rate_10'] > 0) {
            $sql .= " cde_code_ID = " . $item3['oqqit_rate_10'] . " OR";
        }
        /*if ($item3['oqqit_rate_11'] > 0) {
            $sql .= " cde_code_ID = " . $item3['oqqit_rate_11'] . " OR";
        }*/
        if ($item3['oqqit_rate_12'] > 0) {
            $sql .= " cde_code_ID = " . $item3['oqqit_rate_12'];
        }
        $sql .= ")";
        $countriesResult = $db->query($sql);
        while ($country = $db->fetch_assoc($countriesResult)) {
            $countries[$country['cde_code_ID']] = $country;
        }

        //check origin country
        $originCountryID = $item3['oqqit_rate_10'];
        if ($countries[$originCountryID]['cde_option_value'] == 'Reject') {
            $result['error'] = true;
            $result['errorDescription'] = 'Origin Country: ' . $countries[$originCountryID]['cde_value'] . " Cannot be used.<br>";

        }

        /*
        //check via country
        $viaCountryID = $item3['oqqit_rate_11'];
        if ($countries[$viaCountryID]['cde_option_value'] == 'Reject') {
            $result['error'] = true;
            $result['errorDescription'] .= 'Via Country: ' . $countries[$viaCountryID]['cde_value'] . " Cannot be used.<br>";
        }*/

        //check destination country
        $destinationCountryID = $item3['oqqit_rate_12'];
        if ($countries[$destinationCountryID]['cde_option_value'] == 'Reject') {
            $result['error'] = true;
            $result['errorDescription'] .= 'Destination Country: ' . $countries[$destinationCountryID]['cde_value'] . " Cannot be used.<br>";
        }


        return $result;
    } else {
        $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' AND cde_option_value IN ('Approval','Reject')";
        $result = $db->query($sql);
        $approvalList = '';
        $rejectList = '';
        $jsCheck = [];
        while ($row = $db->fetch_assoc($result)) {
            if ($row['cde_option_value'] == 'Approval') {
                $approvalList .= "'" . $row['cde_code_ID'] . "',";
            }
            if ($row['cde_option_value'] == 'Reject') {
                $rejectList .= "'" . $row['cde_code_ID'] . "',";
            }
        }
        $approvalList = $db->remove_last_char($approvalList);
        $approvalList = "[" . $approvalList . "]";

        $rejectList = $db->remove_last_char($rejectList);
        $rejectList = "[" . $rejectList . "]";

        $jsCheck['origin']['approval'] = "
        if (" . $approvalList . ".indexOf($('#3_oqqit_rate_10').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Country of Origin: Needs approval.';
        }";
        /*
        $jsCheck['via']['approval'] = "
        if (" . $approvalList . ".indexOf($('#3_oqqit_rate_11').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Via Country: Needs approval.';
        }";
        */
        $jsCheck['destination']['approval'] = "
        if (" . $approvalList . ".indexOf($('#3_oqqit_rate_12').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Destination Country: Needs approval.';
        }
        ";

        $jsCheck['origin']['reject'] = "
        if (" . $rejectList . ".indexOf($('#3_oqqit_rate_10').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Country of Origin:' + $('#3_oqqit_rate_10 option:selected').text() + '';
        }";
        /*
        $jsCheck['via']['reject'] = "
        if (" . $rejectList . ".indexOf($('#3_oqqit_rate_11').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Via Country: Needs approval.';
        }";*/

        $jsCheck['destination']['reject'] = "
        if (" . $rejectList . ".indexOf($('#3_oqqit_rate_12').val()) >= 0)
        {
            result['result'] = 1;
            result['info'] = 'Destination Country: Needs approval.';
        }
        ";

        return $jsCheck;
    }

}

function customCheckForApproval($data)
{
    global $db;

    $result['error'] = false;
    $result['errorDescription'] = '';

    //get item 3 data
    $item3 = $db->query_fetch('SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = ' . $data['oqq_quotations_ID'] . ' AND oqqit_items_ID = 3');

    //get all 3 countries from codes
    $sql = "
        SELECT * FROM codes WHERE cde_type = 'Countries' AND (";

    if ($item3['oqqit_rate_10'] > 0) {
        $sql .= " cde_code_ID = " . $item3['oqqit_rate_10'] . " OR";
    }
    /*
    if ($item3['oqqit_rate_11'] > 0) {
        $sql .= " cde_code_ID = " . $item3['oqqit_rate_11'] . " OR";
    }*/

    if ($item3['oqqit_rate_12'] > 0) {
        $sql .= " cde_code_ID = " . $item3['oqqit_rate_12'];
    }
    $sql .= ")";
    $countriesResult = $db->query($sql);





    /*$countriesResult = $db->query("
        SELECT * FROM codes WHERE cde_type = 'Countries' AND (
            cde_code_ID = " . $item3['oqqit_rate_10'] . " OR
            cde_code_ID = " . $item3['oqqit_rate_11'] . " OR
            cde_code_ID = " . $item3['oqqit_rate_12'] . " 
        )");
    */
    while ($country = $db->fetch_assoc($countriesResult)) {
        $countries[$country['cde_code_ID']] = $country;
    }

    //check origin country
    $originCountryID = $item3['oqqit_rate_10'];
    if ($countries[$originCountryID]['cde_option_value'] == 'Approval') {
        $result['error'] = true;
        $result['errorDescription'] = 'Origin Country: ' . $countries[$originCountryID]['cde_value'] . " Needs Approval.<br>";
    }

    /*
    //check via country
    $viaCountryID = $item3['oqqit_rate_11'];
    if ($countries[$viaCountryID]['cde_option_value'] == 'Approval') {
        $result['error'] = true;
        $result['errorDescription'] .= 'Via Country: ' . $countries[$viaCountryID]['cde_value'] . " Needs Approval.<br>";
    }
    */

    //check destination country
    $destinationCountryID = $item3['oqqit_rate_12'];
    if ($countries[$destinationCountryID]['cde_option_value'] == 'Approval') {
        $result['error'] = true;
        $result['errorDescription'] .= 'Destination Country: ' . $countries[$destinationCountryID]['cde_value'] . " Needs Approval.<br>";
    }

    if ($item3['oqqit_rate_4'] == 'Other') {
        $result['error'] = true;
        $result['errorDescription'] .= 'Commodity Other Needs Approval.<br>';
    }

    return $result;
}

?>