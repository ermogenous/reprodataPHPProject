<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/3/2019
 * Time: 10:12 ΠΜ
 */

include("update_exchange_rates.php");
updateExchangeRates();

function mc_shipment_details_3()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quote, $quotationUnderwriter;
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
        <?php
        //get underwriter clauses restriction to decide which options to show
        $clausesRestrictionList = explode(",", $underwriter['oqun_clauses_restrictions']);
        $clausesRestriction = array();
        foreach ($clausesRestrictionList as $value) {
            if ($value > 0) $clausesRestriction[$value] = 1;
        }

        if ($db->user_data['usr_user_rights'] <= 2 //set this to 2 if you want to activate the restriction
            || ($quote->quotationData()['oqq_status'] != 'Outstanding' && $_GET['quotation'] > 0)
        ) {
            for ($i = 1; $i <= 10; $i++) {
                $clausesRestriction[$i] = 1;
            }
        }
        ?>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_4" id="3_oqqit_rate_4"
                    class="form-control" onchange="updateRate(); calculateTotalInsuredValue();">
                <option value=""></option>
                <?php
                if ($clausesRestriction[1] == 1) {
                    ?>
                    <option value="General Cargo & Merchandise" <?php if ($qitem_data['oqqit_rate_4'] == 'General Cargo & Merchandise') echo 'selected'; ?>>
                        1. General Cargo & Merchandise
                    </option>
                    <?php
                }
                if ($clausesRestriction[2] == 1) {
                    ?>
                    <option value="New/Used Vehicles" <?php if ($qitem_data['oqqit_rate_4'] == 'New/Used Vehicles') echo 'selected'; ?>>
                        2. New/Used Vehicles
                    </option>
                    <?php
                }
                if ($clausesRestriction[3] == 1) {
                    ?>
                    <option value="Machinery" <?php if ($qitem_data['oqqit_rate_4'] == 'Machinery') echo 'selected'; ?>>
                        3. Machinery
                    </option>
                    <?php
                }
                if ($clausesRestriction[4] == 1) {
                    ?>
                    <option value="Temp. Controlled Cargo other than meat" <?php if ($qitem_data['oqqit_rate_4'] == 'Temp. Controlled Cargo other than meat') echo 'selected'; ?>>
                        4. Temp. Controlled Cargo other than meat
                    </option>
                    <?php
                }
                if ($clausesRestriction[5] == 1) {
                    ?>
                    <option value="Temp. Controlled Cargo Meat" <?php if ($qitem_data['oqqit_rate_4'] == 'Temp. Controlled Cargo Meat') echo 'selected'; ?>>
                        5. Temp. Controlled Cargo Meat
                    </option>
                    <?php
                }
                if ($clausesRestriction[6] == 1) {
                    ?>
                    <option value="Special Cover Mobile Phones, Electronic Equipment" <?php if ($qitem_data['oqqit_rate_4'] == 'Special Cover Mobile Phones, Electronic Equipment') echo 'selected'; ?>>
                        6. Special Cover Mobile Phones, Electronic Equipment
                    </option>
                    <?php
                }
                if ($clausesRestriction[7] == 1) {
                    ?>
                    <option value="Personal Effects professionally packed" <?php if ($qitem_data['oqqit_rate_4'] == 'Personal Effects professionally packed') echo 'selected'; ?>>
                        7. Personal Effects professionally packed
                    </option>
                    <?php
                }
                if ($clausesRestriction[8] == 1) {
                    ?>
                    <option value="CPMB - Cyprus Potato Marketing Board" <?php if ($qitem_data['oqqit_rate_4'] == 'CPMB - Cyprus Potato Marketing Board') echo 'selected'; ?>>
                        8. Cyprus Potatoes
                    </option>
                    <?php
                }
                if ($clausesRestriction[9] == 1) {
                    ?>
                    <option value="Other" <?php if ($qitem_data['oqqit_rate_4'] == 'Other') echo 'selected'; ?>>
                        9. Medicine & Pharmaceutical Goods
                    </option>
                    <?php
                }
                if ($clausesRestriction[10] == 1) {
                    ?>
                    <option value="Tobacco" <?php if ($qitem_data['oqqit_rate_4'] == 'Tobacco') echo 'selected'; ?>>
                        10. Tobacco and Manufactured Tobacco Substitutes
                    </option>
                    <?php
                }
                ?>
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
                        //result['result'] = 1;
                        //result['info'] = 'Commodity: Requires Approval';
                    } else {
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
            <?php show_quotation_text("Declared Value Currency", "Declared Value Currency"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_2" id="3_oqqit_rate_2"
                    class="form-control" onchange="autoUpdateExchangeRate(this.value,'3_oqqit_rate_5');">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Currency' ORDER BY cde_value_4 DESC,cde_value ASC";
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
        function autoUpdateExchangeRate(curSelected, fieldToUpdate) {
            <?php
            $sql = 'SELECT * FROM codes WHERE cde_type = "Currency"';
            $result = $db->query($sql);
            echo "let currencies = [];" . PHP_EOL;
            while ($row = $db->fetch_assoc($result)) {
                echo "currencies['" . $row['cde_value'] . "'] = " . $row['cde_value_3'] . " * 1;" . PHP_EOL;
            }

            ?>
            let value = currencies[curSelected];
            $('#' + fieldToUpdate).val(value);
            calculateTotalInsuredValue();

        }
    </script>

    <div class="form-group row">
        <label for="3_oqqit_rate_3" class="col-sm-4">
            <?php show_quotation_text("Declared Value", "Declared Value"); ?>
        </label>
        <div class="col-sm-3">
            <input name="3_oqqit_rate_3" type="text" id="3_oqqit_rate_3"
                   class="form-control" onchange="calculateTotalInsuredValue();"
                   value="<?php echo $qitem_data["oqqit_rate_3"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_3',
                    'fieldDataType' => 'number',
                    'required' => true,
                    'invalidText' => show_quotation_text("Συμπληρώστε Declared Value.", "Must Enter Declared Value.", 'Return')
                ]);
            ?>
        </div>

        <label for="3_oqqit_rate_5" class="col-sm-3">
            <?php show_quotation_text("Exchange Rate", "Exchange Rate"); ?>
        </label>
        <div class="col-sm-2">
            <input name="3_oqqit_rate_5" type="text" id="3_oqqit_rate_5"
                   class="form-control" onchange="calculateTotalInsuredValue();"
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
        <label for="3_oqqit_rate_16" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Freight Value Currency", "Freight Value Currency"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_16" id="3_oqqit_rate_16"
                    class="form-control" onchange="autoUpdateExchangeRate(this.value,'3_oqqit_rate_18');;">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM codes WHERE cde_type = 'Currency' ORDER BY cde_value_4 DESC,cde_value ASC";
                $result = $db->query($sql);
                while ($currency = $db->fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $currency['cde_value']; ?>" <?php if ($qitem_data['oqqit_rate_16'] == $currency['cde_value']) echo 'selected'; ?>>
                        <?php echo $currency['cde_value'] . " - " . $currency['cde_value_2']; ?>
                    </option>
                <?php } ?>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_16',
                    'fieldDataType' => 'select',
                    'required' => false,
                    'invalidText' => show_quotation_text("Επιλέξτε Freight Value Currency.", "Must Input Freight Value Currency", 'Return')
                ]);
            ?>
        </div>
    </div>


    <div class="form-group row">
        <label for="3_oqqit_rate_17" class="col-sm-4">
            <?php show_quotation_text("Freight Value", "Freight Value"); ?>
        </label>
        <div class="col-sm-3">
            <input name="3_oqqit_rate_17" type="text" id="3_oqqit_rate_17" inputmode="decimal"
                   class="form-control" onchange="calculateTotalInsuredValue();"
                   value="<?php echo $qitem_data["oqqit_rate_17"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_17',
                    'fieldDataType' => 'number',
                    'required' => false,
                    'invalidText' => show_quotation_text("Συμπληρώστε Freight Value.", "Must Enter Freight Value.", 'Return')
                ]);
            ?>
        </div>

        <label for="3_oqqit_rate_18" class="col-sm-3">
            <?php show_quotation_text("Exchange Rate", "Exchange Rate"); ?>
        </label>
        <div class="col-sm-2">
            <input name="3_oqqit_rate_18" type="text" id="3_oqqit_rate_18"
                   class="form-control" onchange="calculateTotalInsuredValue();"
                   value="<?php echo $qitem_data["oqqit_rate_18"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_18',
                    'fieldDataType' => 'number',
                    'required' => false,
                    'invalidText' => show_quotation_text("Συμπληρώστε Exchange Rate.", "Must Enter Exchange Rate (Decimal)", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="row form-group">
        <label for="3_oqqit_rate_19" class="col-sm-4 col-form-label">
            <?php show_quotation_text("CIF Increase", "CIF Increase"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_19" id="3_oqqit_rate_19"
                    class="form-control"
                    onchange="checkConveyanceDropDown(); calculateTotalInsuredValue();">
                <option value="0" <?php if ($qitem_data['oqqit_rate_19'] == '0') echo 'selected'; ?>>
                    0%
                </option>
                <option value="10" <?php if ($qitem_data['oqqit_rate_19'] == '10') echo 'selected'; ?>>
                    10%
                </option>
                <option value="20" <?php if ($qitem_data['oqqit_rate_19'] == '20') echo 'selected'; ?>>
                    20% To Be Referred
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_19',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'invalidText' => show_quotation_text("Επιλέξτε CIF Increase.", "Must select CIF Increase", 'Return')
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4">Total Insured Value</div>
        <div class="col-sm-4" id="totalInsuredValue">0</div>
        <div class="col-sm-4" id="indicativePriceDiv">Indicative Price</div>

        <input type="hidden" id="3_oqqit_rate_20" name="3_oqqit_rate_20" value="">
        <?php
        $formValidator->addField(
            [
                'fieldName' => '3_oqqit_rate_20',
                'fieldDataType' => 'number',
                'required' => true
            ]);
        ?>
    </div>

    <?php
    //get the list of max insured amounts from the underwriter
    $maxInsAmount['general'] = $quotationUnderwriter['oqun_mc_general_max_ins_amount'];
    $maxInsAmount['vehicles'] = $quotationUnderwriter['oqun_mc_vehicles_max_ins_amount'];
    $maxInsAmount['machinery'] = $quotationUnderwriter['oqun_mc_machinery_max_ins_amount'];
    $maxInsAmount['no_meat'] = $quotationUnderwriter['oqun_mc_temp_no_meat_max_ins_amount'];
    $maxInsAmount['meat'] = $quotationUnderwriter['oqun_mc_temp_meat_max_ins_amount'];
    $maxInsAmount['special'] = $quotationUnderwriter['oqun_mc_special_cover_max_ins_amount'];
    $maxInsAmount['pro_packed'] = $quotationUnderwriter['oqun_mc_pro_packed_max_ins_amount'];
    $maxInsAmount['owner_packed'] = $quotationUnderwriter['oqun_mc_owner_packed_max_ins_amount'];
    $maxInsAmount['other'] = $quotationUnderwriter['oqun_mc_other_max_ins_amount'];
    $maxInsAmount['tobacco'] = $quotationUnderwriter['oqun_mc_tobacco_max_ins_amount'];

    //get the list of min premium from the underwriter for the calculation of the premium
    $minPremAmount['general'] = $quotationUnderwriter['oqun_mc_general_min_premium'];
    $minPremAmount['vehicles'] = $quotationUnderwriter['oqun_mc_vehicles_min_premium'];
    $minPremAmount['machinery'] = $quotationUnderwriter['oqun_mc_machinery_min_premium'];
    $minPremAmount['no_meat'] = $quotationUnderwriter['oqun_mc_temp_no_meat_min_premium'];
    $minPremAmount['meat'] = $quotationUnderwriter['oqun_mc_temp_meat_min_premium'];
    $minPremAmount['special'] = $quotationUnderwriter['oqun_mc_special_cover_min_premium'];
    $minPremAmount['pro_packed'] = $quotationUnderwriter['oqun_mc_pro_packed_min_premium'];
    $minPremAmount['owner_packed'] = $quotationUnderwriter['oqun_mc_owner_packed_min_premium'];
    $minPremAmount['other'] = $quotationUnderwriter['oqun_mc_other_min_premium'];
    $minPremAmount['tobacco'] = $quotationUnderwriter['oqun_mc_tobacco_min_premium'];

    ?>



    <script>
        function calculateTotalInsuredValue() {
            let total = 0;
            total = ($('#3_oqqit_rate_3').val() / $('#3_oqqit_rate_5').val()) + ($('#3_oqqit_rate_17').val() / $('#3_oqqit_rate_18').val());
            //calculate the cif
            let cif = $('#3_oqqit_rate_19').val() / 100;
            //console.log(cif);
            total = (total * cif) + total;
            total = roundNumber(total, 2);
            $('#totalInsuredValue').html('€' + total);

            //validate with max insured amount
            //get the commodity
            let commodity = $('#3_oqqit_rate_4').val();
            let maxInsAmount = 0;
            let minPremium = 0;
            let premium = 0;
            let fees = <?php echo $quotationUnderwriter['oqun_min_fees'];?> * 1;
            let stamps = <?php echo $quotationUnderwriter['oqun_min_stamps'];?> * 1;
            let rounding = '<?php echo $quotationUnderwriter['oqun_mc_premium_rounding'];?>';

            if (commodity == 'General Cargo & Merchandise') {
                maxInsAmount = <?php echo $maxInsAmount['general'];?>;
                minPremium = <?php echo $minPremAmount['general'];?>;
            } else if (commodity == 'New/Used Vehicles') {
                maxInsAmount = <?php echo $maxInsAmount['vehicles'];?>;
                minPremium = <?php echo $minPremAmount['vehicles'];?>;
            } else if (commodity == 'Machinery') {
                maxInsAmount = <?php echo $maxInsAmount['machinery'];?>;
                minPremium = <?php echo $minPremAmount['machinery'];?>;
            } else if (commodity == 'Temp. Controlled Cargo other than meat') {
                maxInsAmount = <?php echo $maxInsAmount['no_meat'];?>;
                minPremium = <?php echo $minPremAmount['no_meat'];?>;
            } else if (commodity == 'Temp. Controlled Cargo Meat') {
                maxInsAmount = <?php echo $maxInsAmount['meat'];?>;
                minPremium = <?php echo $minPremAmount['meat'];?>;
            } else if (commodity == 'Special Cover Mobile Phones, Electronic Equipment') {
                maxInsAmount = <?php echo $maxInsAmount['special'];?>;
                minPremium = <?php echo $minPremAmount['special'];?>;
            } else if (commodity == 'Personal Effects professionally packed') {
                maxInsAmount = <?php echo $maxInsAmount['pro_packed'];?>;
                minPremium = <?php echo $minPremAmount['pro_packed'];?>;
            } else if (commodity == 'CPMB - Cyprus Potato Marketing Board') {
                maxInsAmount = <?php echo $maxInsAmount['owner_packed'];?>;
                minPremium = <?php echo $minPremAmount['owner_packed'];?>;
            } else if (commodity == 'Other') {
                maxInsAmount = <?php echo $maxInsAmount['other'];?>;
                minPremium = <?php echo $minPremAmount['other'];?>;
            } else if (commodity == 'Tobacco') {
                maxInsAmount = <?php echo $maxInsAmount['tobacco'];?>;
                minPremium = <?php echo $minPremAmount['tobacco'];?>;
            }
            if (maxInsAmount < 1) {
                maxInsAmount = 500000;
            }

            //calculate the premium
            //get the rate
            //rund the update rate first
            updateRate();
            let rate = $('#4_oqqit_rate_8').val();
            premium = (total / 100) * rate;
            premium = premium.toFixed(2);
            if (premium < minPremium){
                premium = minPremium;
            }
            let premiumSplitHtml = 'Premium:' + premium + ' Fees: '+ fees + ' Stamps:' + stamps;
            let totalPremium = (premium * 1) + fees + stamps;
            totalPremium = totalPremium.toFixed(2);

            //rounding
            if (rounding == 'normal'){
                totalPremium = Math.round(totalPremium);
            }
            else if (rounding == 'next') {
                totalPremium = Math.ceil(totalPremium);
            }
            else if (rounding == 'previous'){
                totalPremium = Math.floor(totalPremium);
            }

            console.log("Premium:" + rounding);
            //$('#indicativePriceSplitDiv').html(premiumSplitHtml);
            $('#indicativePriceDiv').html('Indicative Price: €' + totalPremium);

            //send the amount to be saved in database
            $('#3_oqqit_rate_20').val(total);
            if (total > maxInsAmount) {
                let html = '€' + total;
                html = html + ' &nbsp;<span class="alert-danger">Insured Amount is more than allowed. Need Approval (' + maxInsAmount + ')</span>';
                $('#totalInsuredValue').html(html);
                //if you keep the field empty it will generate error
            }
        }



        function ApprovaltotalInsuredValueCheck() {
            var result = {"result": "1", "info": ""};
            alert('ok');
            return result;
        }

    </script>

    <div class="form-group row">
        <label for="3_oqqit_rate_6" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Conveyance", "Conveyance"); ?>
        </label>
        <div class="col-sm-8">
            <select name="3_oqqit_rate_6" id="3_oqqit_rate_6"
                    class="form-control"
                    onchange="checkConveyanceDropDown(); newVesselNameOnChange();">
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


                <option value="By Air" <?php if ($qitem_data['oqqit_rate_6'] == 'By Air') echo 'selected'; ?>>
                    By Air
                </option>
                <option value="Airfreight" <?php if ($qitem_data['oqqit_rate_6'] == 'Airfreight') echo 'selected'; ?>>
                    Airfreight
                </option>
                <option value="By Sea" <?php if ($qitem_data['oqqit_rate_6'] == 'By Sea') echo 'selected'; ?>>
                    By Sea
                </option>
                <option value="By Sea/Air" <?php if ($qitem_data['oqqit_rate_6'] == 'By Sea/Air') echo 'selected'; ?>>
                    By Sea/Air
                </option>
                <option value="By Sea/Truck" <?php if ($qitem_data['oqqit_rate_6'] == 'By Sea/Truck') echo 'selected'; ?>>
                    By Sea/Truck
                </option>
                <option value="By Truck" <?php if ($qitem_data['oqqit_rate_6'] == 'By Truck') echo 'selected'; ?>>
                    By Truck
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

            <select name="3_oqqit_rate_7" id="3_oqqit_rate_7"
                    class="form-control" onchange="newVesselNameOnChange();">
                <option value=""></option>
                <?php
                $sqlVessels = 'SELECT * FROM codes WHERE cde_type = "VesselNames" ORDER BY cde_value';
                $resultVessels = $db->query($sqlVessels);
                while ($vessel = $db->fetch_assoc($resultVessels)) {
                    $vValue = $vessel['cde_value'] . " - " . $vessel['cde_value_2'] . " [" . $vessel['cde_option_value'] . "]";
                    ?>
                    <option value="<?php echo $vValue; ?>" <?php if ($qitem_data['oqqit_rate_7'] == $vValue) echo 'selected'; ?>>
                        <?php echo $vValue; ?>
                    </option>
                    <?php
                }
                ?>
                <option value="NewVessel" <?php if ($qitem_data['oqqit_rate_7'] == 'NewVessel') echo 'selected'; ?>
                        class="alert-warning">New Vessel - Requires Approval
                </option>
            </select>
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_7',
                    'fieldDataType' => 'select',
                    'required' => true,
                    'requiredAddedCustomCode' => "&& $('#3_oqqit_rate_6').val() == 'Ocean Vessel'",
                    'invalidText' => show_quotation_text("Επιλέξτε Vessel.", "Must select Vessel", 'Return')
                ]);
            ?>

        </div>
    </div>

    <div class="form-group row" id="ocean-vessel-age-approval-warning" style="display:none">
        <div class="col-4"></div>
        <div class="col-8 alert-warning" id="ocean-vessel-age-approval-warning-html">Vessel age requires approval</div>
    </div>

    <div class="form-group row" id="ocean-vessel-define-new-div" style="display: none">
        <label for="3_oqqit_rate_21" class="col-5 text-right">
            <?php show_quotation_text("Define New Vessel. <span class='alert-danger'>Requires Approval</span>"
                , "Define New Vessel. <span class='alert-warning'> &nbsp;Requires Approval &nbsp;</span>"); ?>
        </label>
        <div class="col-7">
            <input name="3_oqqit_rate_21" type="text" id="3_oqqit_rate_21"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_21"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_rate_21',
                    'fieldDataType' => 'text',
                    'required' => true,
                    'requiredAddedCustomCode' => "&& $('#3_oqqit_rate_7').val() == 'NewVessel'",
                    'invalidText' => show_quotation_text("Συμπληρώστε το νέο όνομα.", "Must Enter the new name", 'Return')
                ]);
            ?>

        </div>
    </div>
    <script>
        //load all vessels into an array
        let vesselList = [];
        <?php
            $resultVessels = $db->query($sqlVessels);
            while ($vessel = $db->fetch_assoc($resultVessels)){
                $value = $vessel['cde_value'] . " - " . $vessel['cde_value_2'] . " [" . $vessel['cde_option_value'] . "]";
                echo PHP_EOL.'vesselList["'.$value.'"] = "'.$vessel['cde_value_2'].'";';
            }
        ?>
        function newVesselNameOnChange() {

            if ($('#3_oqqit_rate_6').val() == 'Ocean Vessel') {

                if ($('#3_oqqit_rate_7').val() == 'NewVessel') {
                    $('#ocean-vessel-define-new-div').show();
                    //console.log('show');
                } else {
                    $('#ocean-vessel-define-new-div').hide();
                    //console.log('hide');
                }
                //console.log($('#3_oqqit_rate_7').val());
                //check for the vessel age
                let vessel = $('#3_oqqit_rate_7').val();
                let vesselYear = vesselList[vessel];
                let vesselAge = <?php echo date("Y");?> - ( vesselYear * 1);

                console.log('Vessel Age:' + vesselAge);
                if (vesselAge > 35){
                    $('#ocean-vessel-age-approval-warning').show();
                    $('#ocean-vessel-age-approval-warning-html').html('Vessel Age <b>will</b> incur additional charges. Approval is needed.');
                }
                else if (vesselAge > 30) {
                    $('#ocean-vessel-age-approval-warning').show();
                    $('#ocean-vessel-age-approval-warning-html').html('Vessel Age <b>may</b> incur additional charges. Approval is needed.');
                }
                else {
                    $('#ocean-vessel-age-approval-warning').hide();
                }

            }
            else {
                $('#ocean-vessel-define-new-div').hide();
                $('#ocean-vessel-age-approval-warning').hide();
            }
        }

        newVesselNameOnChange();
    </script>

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
                <option value="FCL" <?php if ($qitem_data['oqqit_rate_9'] == 'FCL') echo 'selected'; ?>>
                    FCL - Full Container
                </option>
                <option value="LCL" <?php if ($qitem_data['oqqit_rate_9'] == 'LCL') echo 'selected'; ?>>
                    LCL - Groupage Container
                </option>
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
            if ($db->user_data['usr_user_rights'] <= 2) {
                $dateMinDate = 60;
            } else {
                if ($db->user_data['usr_users_ID'] == 58) {
                    $dateMinDate = 30;
                } else if ($db->user_data['usr_users_ID'] == 42) {
                    $dateMinDate = 30;
                } else {
                    $dateMinDate = 7;
                }
            }
            $formValidator->addField(
                [
                    'fieldName' => '3_oqqit_date_1',
                    'fieldDataType' => 'date',
                    'enableDatePicker' => true,
                    'datePickerValue' => $db->convert_date_format($qitem_data["oqqit_date_1"], 'yyyy-mm-dd', 'dd/mm/yyyy'),
                    'dateMinDate' => date('d/m/Y', mktime(0, 0, 0, date('m'), (date('d') - $dateMinDate), date('Y'))),
                    'required' => true,
                    'invalidText' => show_quotation_text("Καταχωρήστε Shipment Date.", "Must supply Shipment Date", 'Return')
                ]);
            ?>
        </div>
    </div>

    <script>

        //
        $( document ).ready(function() {
            calculateTotalInsuredValue();
        });

    </script>

    <?php
}

function mc_cargo_details_4()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter, $quotationUnderwriter;
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
        <label for="4_oqqit_rate_10" class="col-4">
            <?php show_quotation_text("BOL/AWB", "BOL/AWB"); ?>
        </label>
        <div class="col-8">
            <input name="4_oqqit_rate_10" type="text" id="4_oqqit_rate_10"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_10"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_10',
                    'fieldDataType' => 'text',
                    'required' => false
                ]);
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="4_oqqit_rate_11" class="col-4">
            <?php show_quotation_text("Invoice", "Invoice"); ?>
        </label>
        <div class="col-8">
            <input name="4_oqqit_rate_11" type="text" id="4_oqqit_rate_11"
                   class="form-control"
                   value="<?php echo $qitem_data["oqqit_rate_11"]; ?>">
            <?php
            $formValidator->addField(
                [
                    'fieldName' => '4_oqqit_rate_11',
                    'fieldDataType' => 'text',
                    'required' => false
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
            <?php
            if ($db->user_data['usr_user_rights'] == 0 || $db->user_data['usr_users_groups_ID'] == 2) {
                ?>
                <div class="row">
                    <div class="col-9">
                        <select id="4_oqqit_rate_6" name="4_oqqit_rate_6" class="form-control">
                            <option value="DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR150 each & every loss or 1% of Total Sum Insured, whichever is greater."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR150 each & every loss or 1% of Total Sum Insured, whichever is greater.') echo "selected"; ?>
                            >DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR150
                                each & every loss or 1% of Total Sum Insured, whichever is greater.
                            </option>

                            <option value="DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR 250 each & every loss or 1% of Total Sum Insured, whichever is greater."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR 250 each & every loss or 1% of Total Sum Insured, whichever is greater.') echo "selected"; ?>
                            >DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR
                                250 each & every loss or 1% of Total Sum Insured, whichever is greater.
                            </option>

                            <option value="DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR500 each & every loss or 1% of Total Sum Insured, whichever is greater."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR500 each & every loss or 1% of Total Sum Insured, whichever is greater.') echo "selected"; ?>
                            >DEDUCTIBLE: For consignments with Sum Insured under EUR2.000 Nil All other shipments EUR500
                                each & every loss or 1% of Total Sum Insured, whichever is greater.
                            </option>

                            <option value="DEDUCTIBLE: €1.000 each & every loss or 3% of Total Sum Insured, whichever is greater."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: €1.000 each & every loss or 3% of Total Sum Insured, whichever is greater.') echo "selected"; ?>
                            >DEDUCTIBLE: €1.000 each & every loss or 3% of Total Sum Insured, whichever is greater.
                            </option>

                            <option value="DEDUCTIBLE: €250 each & every loss."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: €250 each & every loss.') echo "selected"; ?>
                            >DEDUCTIBLE: €250 each & every loss.
                            </option>

                            <option value="DEDUCTIBLE: €300 each & every loss."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: €300 each & every loss.') echo "selected"; ?>
                            >DEDUCTIBLE: €300 each & every loss.
                            </option>

                            <option value="DEDUCTIBLE: €500 each & every loss."
                                <?php if ($qitem_data['oqqit_rate_6'] == 'DEDUCTIBLE: €500 each & every loss.') echo "selected"; ?>
                            >DEDUCTIBLE: €500 each & every loss.
                            </option>
                        </select>
                    </div>
                    <div class="col-1">
                        Lock
                    </div>
                    <div class="col-2">
                        <select id="4_oqqit_rate_9" name="4_oqqit_rate_9" class="form-control">
                            <option value="0" <?php if ($qitem_data['oqqit_rate_9'] != '1') echo "selected"; ?>>No
                            </option>
                            <option value="1" <?php if ($qitem_data['oqqit_rate_9'] == '1') echo "selected"; ?>>Yes
                            </option>
                        </select>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <?php
                if ($qitem_data['oqqit_rate_9'] == '1') {
                    echo $qitem_data['oqqit_rate_6'];
                    ?>
                    <input type="hidden" id="4_oqqit_rate_6" name="4_oqqit_rate_6"
                           value="<?php echo $qitem_data['oqqit_rate_6']; ?>">
                    <?php
                } else {
                    ?>
                    <textarea name="4_oqqit_rate_6" id="4_oqqit_rate_6"
                              class="form-control"><?php echo $qitem_data['oqqit_rate_6']; ?></textarea>
                    <?php
                    $formValidator->addField(
                        [
                            'fieldName' => '4_oqqit_rate_6',
                            'fieldDataType' => 'text',
                            'required' => false
                        ]);
                }//do not show if locked
            }
            ?>
        </div>
    </div>
<?php }//show if user rights <= 2
    ?>

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
        <input type="hidden" id="4_oqqit_rate_8" name="4_oqqit_rate_8"
               value="<?php echo $qitem_data['oqqit_rate_8']; ?>">
        <?php
    }//if user rights > 2 then show this
    ?>

    <script>
        function updateRate() {
            let commodity = $('#3_oqqit_rate_4').val();
            let clause = $('input[name=3_oqqit_rate_13]:checked', '#myForm').val();
            let rate = 0;
            if (commodity == 'General Cargo & Merchandise') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_general_cargo_rate"];?>';
            } else if (commodity == 'New/Used Vehicles') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_vehicles_rate"];?>';
            } else if (commodity == 'Machinery') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_machinery_rate"];?>';
            } else if (commodity == 'Temp. Controlled Cargo other than meat') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_temp_no_meat_rate"];?>';
            } else if (commodity == 'Temp. Controlled Cargo Meat') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_temp_meat_rate"];?>';
            } else if (commodity == 'Special Cover Mobile Phones, Electronic Equipment') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_special_cover_rate"];?>';
            } else if (commodity == 'Personal Effects professionally packed') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_pro_packed_rate"];?>';
            } else if (commodity == 'CPMB - Cyprus Potato Marketing Board') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_owner_packed_rate"];?>';
            } else if (commodity == 'Other') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_other_rate"];?>';
            } else if (commodity == 'Tobacco') {
                rate = '<?php echo $quotationUnderwriter["oqun_excess_tobacco_rate"];?>';
            }

            if (clause == 'Clause C') {
                rate = '<?php echo $quotationUnderwriter["oqun_icc_c_rate"];?>';
            }
            $('#4_oqqit_rate_8').val(rate);
        }

        //add event to commodity and conditions of insurance on change
        //$("#3_oqqit_rate_4").change(function () {
        //    updateRate();
        //});
        //$("input[name=3_oqqit_rate_13]", "#myForm").change(function () {
        //    updateRate();
        //});
    </script>


    <?php
}

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    global $quotationUnderwriter;

    //find the underwriters minimum premium
    switch ($values[3][4]['rate']) {
        case 'General Cargo & Merchandise':
            $minPremium = $quotationUnderwriter['oqun_mc_general_min_premium'];
            break;
        case 'New/Used Vehicles':
            $minPremium = $quotationUnderwriter['oqun_mc_vehicles_min_premium'];
            break;
        case 'Machinery':
            $minPremium = $quotationUnderwriter['oqun_mc_machinery_min_premium'];
            break;
        case 'Temp. Controlled Cargo other than meat':
            $minPremium = $quotationUnderwriter['oqun_mc_temp_no_meat_min_premium'];
            break;
        case 'Temp. Controlled Cargo Meat':
            $minPremium = $quotationUnderwriter['oqun_mc_temp_meat_min_premium'];
            break;
        case 'Special Cover Mobile Phones, Electronic Equipment':
            $minPremium = $quotationUnderwriter['oqun_mc_special_cover_min_premium'];
            break;
        case 'Personal Effects professionally packed':
            $minPremium = $quotationUnderwriter['oqun_mc_pro_packed_min_premium'];
            break;
        case 'CPMB - Cyprus Potato Marketing Board':
            $minPremium = $quotationUnderwriter['oqun_mc_owner_packed_min_premium'];
            break;
        case 'Other':
            $minPremium = $quotationUnderwriter['oqun_mc_other_min_premium'];
            break;
        case 'Tobacco':
            $minPremium = $quotationUnderwriter['oqun_mc_tobacco_min_premium'];
            break;
        default:
            $minPremium = 0;
    }
    $premiumRate = $values[4][8]['rate'];
    //rate $values[4][8]['rate']
    //print_r($array);exit();
    //echo "Min Premium:".$minPremium;
    //echo "<br>Rate:".$values[4][8]['rate'];
    //exit();

    $array[4][8] = round(($values[3][20]['rate'] / 100) * ($premiumRate), 2);
    if ($array[4][8] < $minPremium) {
        $array[3][4] = $minPremium - $array[4][8];
    } else {
        $array[3][4] = 0;
    }
    $totalPremium = $array[3][4] + $array[4][8];
    //echo "Total Premium:".$totalPremium;
    $rounding = 0;
    //round to the next euro
    if ($quotationUnderwriter['oqun_mc_premium_rounding'] == 'next') {
        $rounding = ceil($totalPremium);
        $rounding = round($rounding - $totalPremium, 2);
    } //round to the previous euro
    else if ($quotationUnderwriter['oqun_mc_premium_rounding'] == 'previous') {
        $rounding = floor($totalPremium);
        $rounding = round($rounding - $totalPremium, 2);
    } //normal rounding
    else if ($quotationUnderwriter['oqun_mc_premium_rounding'] == 'normal') {
        $rounding = round($totalPremium, 0);
        $rounding = round($rounding - $totalPremium, 2);
    }
    $array[3][4] += $rounding;
    //echo "<br>Rounding:".$rounding;
    //exit();

    //echo $array[3][4]."<br>";
    //echo $array[4][8]."<br>";
    //echo $minPremium;print_r($values);exit();
    //echo $values[3][20]['rate']."<br>";
    //echo $array[4][8]."<br>";
    //echo $minPremium."<br>";
    //echo $premiumRate;exit();

    return $array;
}

function get_custom_fees_amount($data)
{

    global $quotationUnderwriter;

    $data['stamps'] = $quotationUnderwriter['oqun_min_stamps'];
    $data['fees'] = $quotationUnderwriter['oqun_min_fees'];
    //print_r($data);exit();
    return $data;
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
    global $db, $underwriter, $quotationUnderwriter, $quote;

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
        //$result['error'] = true;
        //$result['errorDescription'] .= 'Commodity Other Needs Approval.<br>';
    }

    //total insured value validation/referral
    $totalInsuredAmount = $item3['oqqit_rate_20'] * 1;
    $commodity = $item3['oqqit_rate_4'];
    $maxInsAmount = 0;

    $quotationUnderwriter = $quote->getQuotationUnderwriterData();

    if ($commodity == 'General Cargo & Merchandise') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_general_max_ins_amount'];
    } else if ($commodity == 'New/Used Vehicles') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_vehicles_max_ins_amount'];
    } else if ($commodity == 'Machinery') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_machinery_max_ins_amount'];
    } else if ($commodity == 'Temp. Controlled Cargo other than meat') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_temp_no_meat_max_ins_amount'];
    } else if ($commodity == 'Temp. Controlled Cargo Meat') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_temp_meat_max_ins_amount'];
    } else if ($commodity == 'Special Cover Mobile Phones, Electronic Equipment') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_special_cover_max_ins_amount'];
    } else if ($commodity == 'Personal Effects professionally packed') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_pro_packed_max_ins_amount'];
    } else if ($commodity == 'CPMB - Cyprus Potato Marketing Board') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_owner_packed_max_ins_amount'];
    } else if ($commodity == 'Tobacco') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_tobacco_max_ins_amount'];
    } else if ($commodity == 'Other') {
        $maxInsAmount = $quotationUnderwriter['oqun_mc_other_max_ins_amount'];
    }

    if ($db->originalUserData['usr_user_rights'] == 0) {
        //echo $totalInsuredAmount;
        //echo "<br>".$commodity;
        //echo "<br>".$maxInsAmount;
        //exit();
    }

    $logAction = '
    Check for validation.
    Total Insured Amount: ' . $totalInsuredAmount . '
    MaxInsAmount: ' . $maxInsAmount . '
    Commodity: ' . $commodity . '
    Original User: ' . $db->originalUserData['usr_users_ID'] . '
    Actual User: ' . $db->user_data['usr_users_ID'] . '
    ';
    $qunderData = print_r($quotationUnderwriter, true);

    $db->update_log_file('MarineApproval', $data['oqq_quotations_ID'], $logAction, 'QuotationUnderwriter Data\n' . $qunderData, '', '');

    if ($quotationUnderwriter['oqun_quotations_underwriter_ID'] == '') {
        //echo "An error has occurred. Call the system administrator.";
        //exit();
    }

    //temp delete
    if ($maxInsAmount < 1) {
        //$maxInsAmount = 500000;
    }
    if ($totalInsuredAmount > $maxInsAmount) {
        $result['error'] = true;
        $result['errorDescription'] .= 'Total Insured Value Needs Approval';
    }

    //check for validation for CIF
    $cifValue = $item3['oqqit_rate_19'];
    if ($cifValue == '20') {
        $result['error'] = true;
        $result['errorDescription'] .= 'CIF Increase 20% Needs approval';
    }

    //check if new vessel that requires validation
    if ($item3['oqqit_rate_7'] == 'NewVessel' && $item3['oqqit_rate_6'] == 'Ocean Vessel') {
        $result['error'] = true;
        $result['errorDescription'] .= 'New Vessel Needs to be created requires Approval! ' . $item3['oqqit_rate_21'];
    }

    if ($item3['oqqit_rate_6'] == 'Ocean Vessel') {
        //vessel Age check
        $sql = 'SELECT * FROM codes WHERE cde_type = "VesselNames"
            AND CONCAT(cde_value, " - ", cde_value_2, " [", cde_option_value, "]") = "' . $item3['oqqit_rate_7'] . '"';
        $vesselData = $db->query_fetch($sql);
        $vesselAge = date("Y") - $vesselData['cde_value_2'];
        //echo $vesselAge;
        if ($vesselAge > 30) {
            $result['error'] = true;
            $result['errorDescription'] .= 'Ocean Vessel Age is more than 30 [' . $vesselAge . '] needs approval';
        }
    }

    return $result;
}

function customIssueNumber($data)
{
    global $db;
    if ($data['oqq_users_ID'] == 42 || $data['oqq_users_ID'] == 58) {
        $prefix = 'KMCE2';
        $leadingZeros = 5;
        $lastNumber = $db->get_setting('kemter_mc_number_last_used');
        $newNumber = $db->buildNumber($prefix, $leadingZeros, $lastNumber + 1);
        $db->update_setting('kemter_mc_number_last_used', $lastNumber + 1);
    } else {
        $newNumber = $db->buildNumber($data['oqqt_quotation_number_prefix'],
            $data['oqqt_quotation_number_leading_zeros'],
            $data['oqqt_quotation_number_last_used'] + 1);
        //update db
        $newData['quotation_number_last_used'] = $data['oqqt_quotation_number_last_used'] + 1;
        $db->db_tool_update_row('oqt_quotations_types',
            $newData,
            'oqqt_quotations_types_ID = ' . $data['oqqt_quotations_types_ID'],
            $data['oqqt_quotations_types_ID'],
            '',
            'execute',
            'oqqt_');
    }

    return $newNumber;
}

function modify_post_values($post)
{

    $post['starting_date'] = $post['3_oqqit_date_1'];
    return $post;

}

?>
