<?php
//shows the tables for each section (item)
//the name of the field is OQIT_ITEMS_ID"_"FIELD_NAME
function tr_travel_information()
{
    global $db, $items_data, $qitem_data, $formValidator, $underwriter;
    ?>


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
                        <?php echo $db->showLangText('Worldwide (Excluding U.S.A & Canada)','Παγκόσμια (εκτός Η.Π.Α & Καναδά)');?>
                    </option>
                <option value="WorldWide" <?php if ($qitem_data['oqqit_rate_2'] == 'WorldWide') echo 'selected'; ?>>
                    <?php echo $db->showLangText('Worldwide','Παγκόσμια');?>
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
                    <?php echo $db->showLangText('No','Οχι');?>
                </option>
                <option value="Yes" <?php if ($qitem_data['oqqit_rate_3'] == 'Yes') echo 'selected'; ?>>
                    <?php echo $db->showLangText('Yes','Ναί');?>
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


    <div class="form-group row">
        <label for="5_oqqit_rate_4" class="col-sm-4 col-form-label">
            <?php show_quotation_text("Πακέτο", "Package"); ?>
        </label>
        <div class="col-sm-8">


            <select name="5_oqqit_rate_4" id="5_oqqit_rate_4"
                    class="form-control">
                <?php if (strpos($underwriter['oqun_tr_package_selection'],'#basic#') !== false) { ?>
                <option value="Basic" <?php if ($qitem_data['oqqit_rate_4'] == 'Basic') echo 'selected'; ?>>
                    Basic
                </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'],'#standard#') !== false) { ?>
                    <option value="Standard" <?php if ($qitem_data['oqqit_rate_4'] == 'Standard') echo 'selected'; ?>>
                        Standard
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'],'#luxury#') !== false) { ?>
                    <option value="Luxury" <?php if ($qitem_data['oqqit_rate_4'] == 'Luxury') echo 'selected'; ?>>
                        Luxury
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'],'#schengen#') !== false) { ?>
                    <option value="Schengen" <?php if ($qitem_data['oqqit_rate_4'] == 'Schengen') echo 'selected'; ?>>
                        Schengen
                    </option>
                <?php } ?>

                <?php if (strpos($underwriter['oqun_tr_package_selection'],'#limited#') !== false) { ?>
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

    <div class="row form-group alert alert-success" id="member_1_line">
        <div class="col-sm-12 text-center" onclick="showHideMembers(1);" style="cursor: pointer;">
            <strong>Member 1</strong>
            <i class="far fa-plus-square" id="member_1_plus" style="display: none"></i>
            <i class="far fa-minus-square" id="member_1_minus" style="display: none"></i>
            <input type="hidden" id="5_oqqit_rate_5" name="5_oqqit_rate_5" value="<?php echo $qitem_data['oqqit_rate_5'];?>">
        </div>
    </div>
    <div id="member_1_contents" style="display: none;">
        <div class="row form-group">

            <label for="5_oqqit_rate_6" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Όνομα", "Name"); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_rate_6" type="text" id="5_oqqit_rate_6"
                       class="form-control"
                       value="<?php echo $qitem_data["oqqit_rate_6"]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_6',
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_5").val() == "1"'
                    ]);
                ?>
            </div>

        </div>

        <div class="row form-group">

            <label for="5_oqqit_rate_7" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Αριθμός Διαβατηρίου η Ταυτότητα", "Passport No. or I.D."); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_rate_7" type="text" id="5_oqqit_rate_7"
                       class="form-control"
                       value="<?php echo $qitem_data["oqqit_rate_7"]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_7',
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_5").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="5_oqqit_rate_8" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Ιθαγένεια", "Nationality"); ?>
            </label>
            <div class="col-sm-8">
                <select class="form-control" id="5_oqqit_rate_8" name="5_oqqit_rate_8">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                    $result = $db->query($sql);
                    while ($count = $db->fetch_assoc($result)){
                        ?>
                        <option value="<?php echo $count['cde_code_ID'];?>"
                            <?php if ($qitem_data['oqqit_rate_8'] == $count['cde_code_ID']) echo "selected"; ?>
                        ><?php echo $count['cde_value'];?></option>
                    <?php } ?>
                </select>
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_8',
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_5").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="5_oqqit_date_1" class="col-sm-4 col-form-label">
                <?php show_quotation_text(" Ημ. Γέννησης", "Date of Birth"); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_date_1" type="text" id="5_oqqit_date_1"
                       class="form-control">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_date_1',
                        'fieldDataType' => 'date',
                        'enableDatePicker' => true,
                        'datePickerValue' => $db->convertDateToEU($qitem_data["oqqit_date_1"]),
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_5").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

    </div>


    <div class="row form-group alert alert-success" id="member_2_line">
        <div class="col-sm-12 text-center" onclick="showHideMembers(2);" style="cursor: pointer;">
            <strong>Member 2</strong>
            <i class="far fa-plus-square" id="member_2_plus" style="display: none"></i>
            <i class="far fa-minus-square" id="member_2_minus" style="display: none"></i>
            <input type="hidden" id="5_oqqit_rate_10" name="5_oqqit_rate_10" value="<?php echo $qitem_data['oqqit_rate_10'];?>">
        </div>
    </div>
    <div id="member_2_contents" style="display: none;">
        <div class="row form-group">

            <label for="5_oqqit_rate_11" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Όνομα", "Name"); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_rate_11" type="text" id="5_oqqit_rate_11"
                       class="form-control"
                       value="<?php echo $qitem_data["oqqit_rate_11"]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_11',
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_10").val() == "1"'
                    ]);
                ?>
            </div>

        </div>

        <div class="row form-group">

            <label for="5_oqqit_rate_12" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Αριθμός Διαβατηρίου η Ταυτότητα", "Passport No. or I.D."); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_rate_12" type="text" id="5_oqqit_rate_12"
                       class="form-control"
                       value="<?php echo $qitem_data["oqqit_rate_12"]; ?>">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_12',
                        'fieldDataType' => 'text',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_10").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="5_oqqit_rate_13" class="col-sm-4 col-form-label">
                <?php show_quotation_text("Ιθαγένεια", "Nationality"); ?>
            </label>
            <div class="col-sm-8">
                <select class="form-control" id="5_oqqit_rate_13" name="5_oqqit_rate_13">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT * FROM codes WHERE cde_type = 'Countries' ORDER BY cde_value ASC";
                    $result = $db->query($sql);
                    while ($count = $db->fetch_assoc($result)){
                        ?>
                        <option value="<?php echo $count['cde_code_ID'];?>"
                            <?php if ($qitem_data['oqqit_rate_13'] == $count['cde_code_ID']) echo "selected"; ?>
                        ><?php echo $count['cde_value'];?></option>
                    <?php } ?>
                </select>
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_rate_13',
                        'fieldDataType' => 'select',
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_10").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

        <div class="row form-group">

            <label for="5_oqqit_date_2" class="col-sm-4 col-form-label">
                <?php show_quotation_text(" Ημ. Γέννησης", "Date of Birth"); ?>
            </label>
            <div class="col-sm-8">
                <input name="5_oqqit_date_2" type="text" id="5_oqqit_date_2"
                       class="form-control">
                <?php
                $formValidator->addField(
                    [
                        'fieldName' => '5_oqqit_date_2',
                        'fieldDataType' => 'date',
                        'enableDatePicker' => true,
                        'datePickerValue' => $db->convertDateToEU($qitem_data["oqqit_date_2"]),
                        'required' => true,
                        'invalidTextAutoGenerate' => true,
                        'requiredAddedCustomCode' => '&& $("#5_oqqit_rate_10").val() == "1"'
                    ]);
                ?>
            </div>
        </div>

    </div>




    <?php
}//section 2

function insured_amount_custom_rates($array, $values, $quotation_id)
{
    return $array;
}

?>