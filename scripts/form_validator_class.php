<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/3/2019
 * Time: 10:59 ΠΜ
 *
 * Updates:
 * 2/10/2019 - generateErrorDescriptionDiv() a div that will show all the errors found in the form. can be used anywhere in the page
 */


class customFormValidator
{

    private $inputFieldsList = array();
    private $fieldCode = '';
    private $needIsDateFunction = false;
    private $needCompare2DatesFunction = false;
    private $needYearsFrom2DatesFunction = false;
    private $needEmailValidationFunction = false;
    private $needIntegerOnlyValidationFunction = false;
    private $customCode = [];

    private $disableForm = false;
    private $disableFormExceptions = [];
    private $formName = 'myForm';

    private $showErrorList = 0;
    private $showErrorInDiv = false;


    function __construct()
    {

    }

    public function showErrorList()
    {
        $this->showErrorList = 1;
    }

    public function includeCompare2DatesFunction()
    {
        $this->needCompare2DatesFunction = true;
    }

    public function includeYearsFrom2DatesFunction()
    {
        $this->needYearsFrom2DatesFunction = true;
    }

    /**
     * This will generate a div that will hold all the errors found in the form
     * You will need to define a title for each field so it will capture and shown in the div.
     * You can control the language in the title
     * Execute this function exactly where you want the div to be shown
     */
    public function generateErrorDescriptionDiv($classDescription = 'alert alert-warning')
    {
        $this->showErrorInDiv = true;
        echo '
        <div class="row">
            <div class="col-12 ' . $classDescription . '" id="formValidatorErrorDescriptionDiv" style="display: none;">Error Here</div>
        </div>
        ';
    }

    /**
     * Adds new field in the class
     *
     * @param array $fieldData
     */
    //always call this function right after the input field.
    function addField(array $fieldData)
    {
        //fieldName:string
        //fieldDataType: text/number/integer/date/age/radio/select/email
        //required: true/false
        //enableDatePicker: true/false ->when true it will echo the script required for the datepicker. jqueryUi must already exists.
        //datePickerValue: the value date to be inserted on creation
        //invalidText: the text to show when invalid.
        //invalidTextAutoGenerate: true/false gets automatically the value in the label field and generates the error. invalidText must be empty for this to work
        //requiredAddedCustomCode: added custom code in the if statement for the required section
        //dateMinDate : dd/mm/yyyy compares the 2 dates and if lower than min date then error
        //dateMaxDate : dd/mm/yyyy compares the 2 dates and if higher than max date then error
        //validateEmail: Validates if the email has the right format
        //minNumber: decimal -> number cannot be lower than this (inclusive)
        //maxNumber: decimal -> number cannot be higher than this (inclusive)
        //allowedNumberList: list of numbers in array that is allowed to be used [20,40,23,18,101etc] if list is empty [] then ignore
        //allowedNumberListCSCode: added custom code for the allowedNumberList

        if ($fieldData['fieldName'] == '') {
            echo "<div class='alert alert-danger'>Must provide fieldName in newField</div>";
            exit();
        }
        //init options
        if (!isset($fieldData['dateMinDate'])){
            $fieldData['dateMinDate'] = '';
        }
        if (!isset($fieldData['dateMaxDate'])){
            $fieldData['dateMaxDate'] = '';
        }
        if (!isset($fieldData['requiredAddedCustomCode'])){
            $fieldData['requiredAddedCustomCode'] = '';
        }


        $this->inputFieldsList[] = $fieldData;

        $this->echoDatePickerScriptCode($fieldData);

        $this->echoInvalidText($fieldData);

    }

    public function addCustomCode($code)
    {
        $this->customCode[] = $code;
    }

    //$exceptions[] = exceptions. Example -> $exceptions[] = 'buttons'
    public function disableForm($exceptions = [])
    {
        $this->disableForm = true;
        $this->disableFormExceptions = $exceptions;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
    }

    public function printAllFields()
    {
        print_r($this->inputFieldsList);
    }

    public function echoFormParameters()
    {
        echo 'class="needs-custom-validation" novalidate';
    }

    public function echoDateFieldFormatTag()
    {
        echo 'placeholder="dd/mm/yyyy"';
    }

//this must be executed right after of the input field. Inside of the same <div> tag
    private function echoInvalidText($fieldData)
    {
        global $db;
        if ($fieldData['invalidText'] != '') {
            if ($fieldData['fieldDataType'] == 'radio') {
                echo '<div class="invalid-feedback" id="' . $fieldData['fieldName'] . '-invalid-text">' . $fieldData['invalidText'] . '</div>';
            } else {
                //echo '<div class="invalid-feedback">' . $fieldData['invalidText'] . '</div>';
                echo '<div class="invalid-feedback" id="' . $fieldData['fieldName'] . '-invalid-text">' . $fieldData['invalidText'] . '</div>';
            }
        } else {

            if ($fieldData['invalidTextAutoGenerate'] == true) {
                if ($fieldData['fieldDataType'] == 'select') {
                    $prefix = $db->showLangText('Must Select ', 'Επιλέξατε ');
                } else if ($fieldData['fieldDataType'] == 'email') {
                    $prefix = $db->showLangText('Must Enter Valid ', 'Πρέπει να εισάγετε έγκυρο ');
                } else {
                    $prefix = $db->showLangText('Must Enter ', 'Πρέπει να εισάγετε ');
                }

                echo '<div class="invalid-feedback" id="' . $fieldData['fieldName'] . '-invalid-text"></div>';
                echo '<script>
                    $("#' . $fieldData['fieldName'] . '-invalid-text").html(
                        "' . $prefix . '" + $("label[for=\'' . $fieldData['fieldName'] . '\']").html()
                    );
                    </script>';
            }
        }
    }

    private function getFieldsValidationsText()
    {

        $returnText = '';

        foreach ($this->inputFieldsList as $fieldData) {
            //reset its code
            $this->fieldCode = '';
            $returnText .= $this->getRequiredCode($fieldData);

        }

        return $returnText;

    }

    private function echoDatePickerScriptCode($fieldData)
    {
        global $db;


        if ($fieldData['fieldDataType'] == 'date' && $fieldData['enableDatePicker'] == true) {
            //check if jquery_ui is enabled
            if ($db->enabled_jquery_ui != 'yes') {
                echo '<div class="alert alert-danger">For date picker to work needs Jquery UI</div>';
            }


            echo '
        <script>
        $(function () {
            $("#' . $fieldData['fieldName'] . '").datepicker();
            $("#' . $fieldData['fieldName'] . '").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#' . $fieldData['fieldName'] . '").val("' . $fieldData['datePickerValue'] . '");

        });
        </script>';
        }

    }

    private function getRequiredCode($fieldData)
    {
        global $db;

        //check if variables or strings
        if (substr($fieldData['dateMinDate'], 0, 3) != "$('" && $fieldData['dateMinDate'] != '') {
            $fieldData['dateMinDate'] = "'" . $fieldData['dateMinDate'] . "'";
        }
        if (substr($fieldData['dateMaxDate'], 0, 3) != "$('" && $fieldData['dateMaxDate'] != '') {
            $fieldData['dateMaxDate'] = "'" . $fieldData['dateMaxDate'] . "'";
        }


        $return = "FieldsErrors['" . $fieldData['fieldName'] . "'] = [];
        ";
        if ($fieldData['required'] == true) {

            //requiredAddedCustomCode
            $requiredAddedCustomCode = '';
            if ($fieldData['requiredAddedCustomCode'] != '') {
                $requiredAddedCustomCode = $fieldData['requiredAddedCustomCode'];
            }


            //for RADIO
            if ($fieldData['fieldDataType'] == 'radio') {
                $return .= "
            if (typeof $('input[name=" . $fieldData['fieldName'] . "]:checked').val() == 'undefined' " . $requiredAddedCustomCode . "){
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                $('#" . $fieldData['fieldName'] . "-invalid-text').show();
                FormErrorFound = true;
                ErrorList.push('" . $fieldData['fieldName'] . " -> Radio Empty');
                ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Empty ');
            }
            else {
                $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "-invalid-text').hide();
            }
            ";
            } //For other
            else {
                $return .= "
            if ( ($('#" . $fieldData['fieldName'] . "').val() == '' && $('#" . $fieldData['fieldName'] . "').prop('disabled') !== true)" . $requiredAddedCustomCode . "){
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                FormErrorFound = true;
                ErrorList.push('" . $fieldData['fieldName'] . " -> Others Empty ');
                ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Empty ');
                
            }
            else {
                $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
            }
            ";
            }

        }
        //DATE added check if valid date
        if ($fieldData['required'] == true && $fieldData['fieldDataType'] == 'date') {
            $this->needIsDateFunction = true;
            $return .= "
            if (isDate($('#" . $fieldData['fieldName'] . "').val()) || $('#" . $fieldData['fieldName'] . "').val() == ''){
                //if is-invalid already exists then another check hit. do not make as valid.
                if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                    $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                }
            }
            else {
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                FormErrorFound = true;
                ErrorList.push('" . $fieldData['fieldName'] . " -> If Valid Date ');
                ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Invalid Date ');
            }
            ";
        }
        //DATE MINIMUM DATE
        if ($fieldData['fieldDataType'] == 'date' && $fieldData['dateMinDate'] != '') {
            $this->needCompare2DatesFunction = true;
            $return .= "
                if ($('#" . $fieldData['fieldName'] . "').val() != '' && compare2Dates($('#" . $fieldData['fieldName'] . "').val()," . $fieldData['dateMinDate'] . ") == 2 ){
                    $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                    FormErrorFound = true;
                    FieldsErrors['" . $fieldData['fieldName'] . "']['dateMin'] = false;
                    ErrorList.push('" . $fieldData['fieldName'] . " -> Minimum Date ');
                    ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Date Lower than expected ');
                }
                else {
                    //if is-invalid already exists then another check hit. do not make as valid.
                    if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                        FieldsErrors['" . $fieldData['fieldName'] . "']['dateMin'] = true;
                    }
                    
                }
            ";
        }
        //DATE MAXIMUM DATE
        if ($fieldData['fieldDataType'] == 'date' && $fieldData['dateMaxDate'] != '') {
            $this->needCompare2DatesFunction = true;
            $return .= "
                if ( $('#" . $fieldData['fieldName'] . "').val() != '' && compare2Dates($('#" . $fieldData['fieldName'] . "').val(), " . $fieldData['dateMaxDate'] . ") == 1 ){
                    $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                    FormErrorFound = true;
                    ErrorList.push('" . $fieldData['fieldName'] . " -> Maximum Date ');
                    ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Date higher than expected ');
                }
                else {
                    //if is-invalid already exists then another check hit. do not make as valid.
                    if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                    }
                }
            ";
        }

        //NUMBER added check if valid number
        if ($fieldData['fieldDataType'] == 'number') {

            $return .= "
            if ($.isNumeric($('#" . $fieldData['fieldName'] . "').val()) == true || $('#" . $fieldData['fieldName'] . "').val() == ''){
                //if is-invalid already exists then another check hit. do not make as valid.
                if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                    $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                }
            }
            else {
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                FormErrorFound = true;
                ErrorList.push('" . $fieldData['fieldName'] . " -> If is numeric');
                ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Not numeric ');
            }
            ";

            //NUMBER MINIMUM
            if (is_numeric($fieldData['minNumber'])) {
                $return .= "
                    if ($('#" . $fieldData['fieldName'] . "').val() < " . $fieldData['minNumber'] . "){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                        FormErrorFound = true;
                        ErrorList.push('" . $fieldData['fieldName'] . " -> Min Number ');
                        ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Number lower than expected ');
                        
                    }
                    else {
                        //if is-invalid already exists then another check hit. do not make as valid.
                        if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                            $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                            $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                        }
                    }
                ";
            }

            //NUMBER MAXIMUM
            if (is_numeric($fieldData['maxNumber'])) {
                $return .= "
                    if ($('#" . $fieldData['fieldName'] . "').val() > " . $fieldData['maxNumber'] . " && FieldsErrors['" . $fieldData['fieldName'] . "']['minNumber'] != false){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                        FormErrorFound = true;
                        ErrorList.push('" . $fieldData['fieldName'] . " -> Max Number ');
                        ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Number higher than expected ');
                    }
                    else {
                        //if is-invalid already exists then another check hit. do not make as valid.
                        if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                            $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                            $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                        }
                    }
                ";
            }

            if (!empty($fieldData['allowedNumberList'])) {
                //make the array list
                foreach ($fieldData['allowedNumberList'] as $value) {
                    $jsif .= " $('#" . $fieldData['fieldName'] . "').val() != '" . $value . "' &&";
                }
                $jsif = $db->remove_last_char($jsif);
                $jsif = $db->remove_last_char($jsif);

                $return .= "
                if (" . $jsif . " " . $fieldData['allowedNumberListCSCode'] . "){
                    $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                    FormErrorFound = true;
                    ErrorList.push('" . $fieldData['fieldName'] . " -> Number not in list ');
                    ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Number not allowed ');
                }
                else {
                    //if is-invalid already exists then another check hit. do not make as valid.
                    if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                    }
                }
                
                ";
            }
        }

        if ($fieldData['fieldDataType'] == 'integer' && $fieldData['required'] == true) {
            $this->needIntegerOnlyValidationFunction = true;
            $return .= "
                    if ( validateOnlyInteger($('#" . $fieldData['fieldName'] . "').val()) == false ){
                        $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                        $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                        FormErrorFound = true;
                        ErrorList.push('" . $fieldData['fieldName'] . " -> Invalid Integer ');
                        ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Number not integer ');
                    }
                    else {
                        //if is-invalid already exists then another check hit. do not make as valid.
                        if ($('#" . $fieldData['fieldName'] . "').hasClass('is-invalid') != true){
                            $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                            $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                        }
                    }
                ";
        }

        //Email Validation
        if ($fieldData['fieldDataType'] == 'email' && $fieldData['validateEmail'] == true) {
            $this->needEmailValidationFunction = true;
            $return .= "
                if (validateEmail($('#" . $fieldData['fieldName'] . "').val())) {
                    $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
                }
                else {
                    $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                    $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                    FormErrorFound = true;
                    ErrorList.push('" . $fieldData['fieldName'] . " -> Invalid Email ');
                    ErrorListFull.push($('#" . $fieldData['fieldName'] . "').attr('title') + ' - Invalid Email ');
                }
            ";
        }

        return $return;
    }

    private function getCustomCode()
    {
        $customCode = '';
        foreach ($this->customCode as $code) {
            $customCode .= $code . "\n";
        }

        return $customCode;
    }

    public function output()
    {
        $fieldsValidationsText = $this->getFieldsValidationsText();
        $customCode = $this->getCustomCode();

        echo "
 <script>
 var FormErrorFound = false;
 var FieldsErrors = [];
 var ErrorList = [];
 var ErrorListFull = [];
 var showErrorList = '" . $this->showErrorList . "';
 var showErrorListInDiv = '" . $this->showErrorInDiv . "';
     (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-custom-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    //alert('Checking Form');
                    //console.log('Checking Form');
                    
                    
                    FormErrorFound = false;
                    //clear errorList
                    ErrorList = [];
                    ErrorListFull = [];

                    " . $fieldsValidationsText . "
                    " . $customCode . "

                    if (FormErrorFound) {
                        
                        if (showErrorList == '1'){
                            console.log('Error validation');
                            console.log(ErrorList);
                            //console.log(ErrorListFull);
                        }
                        
                        if (showErrorListInDiv == '1'){
                            let errorFullListHtml = '';
                            let errorFullListHtmlNum = 0;
                            $.each(ErrorListFull,function (index,value){
                                errorFullListHtmlNum++;
                                
                                if (errorFullListHtmlNum > 1){
                                    errorFullListHtml = errorFullListHtml + '<br>';
                                }
                                
                                errorFullListHtml = errorFullListHtml + value;
                            });
                            
                            
                            if (errorFullListHtmlNum > 0){
                                $('#formValidatorErrorDescriptionDiv').show();
                                $('#formValidatorErrorDescriptionDiv').html(errorFullListHtml);
                            }
                            else {
                                $('#formValidatorErrorDescriptionDiv').hide();
                            }
                        }
                        
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    else {
                        //alert('Form Validated');
                        form.classList.add('was-validated');
                    }
                }, false);
            });
        }, false);
    })();
        ";

        if ($this->needIsDateFunction == true) {
            echo "
            function isDate(txtDate) {
            var currVal = txtDate;
            if (currVal == '')
                return false;
            //Declare Regex
            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
            var dtArray = currVal.match(rxDatePattern); // is format OK?

            if (dtArray == null)
                return false;

            //Checks for dd/mm/yyyy format.
            dtDay = dtArray[1];
            dtMonth = dtArray[3];
            dtYear = dtArray[5];

            if (dtMonth < 1 || dtMonth > 12)
                return false;
            else if (dtDay < 1 || dtDay > 31)
                return false;
            else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
                return false;
            else if (dtMonth == 2) {
                var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
                if (dtDay > 29 || (dtDay == 29 && !isleap))
                    return false;
            }
            return true;
        }
        ";
        }
        if ($this->needCompare2DatesFunction == true) {
            echo "
        function compare2Dates(date1,date2){

            let date1Split = date1.split('/');
            let date2Split = date2.split('/');
            let date1Num = ((date1Split[2] * 10000) + date1Split[1] * 100) + (date1Split[0] * 1);
            let date2Num = ((date2Split[2] * 10000) + date2Split[1] * 100) + (date2Split[0] * 1);

            //if 1 is bigger than 2 then 1
            if (date1Num > date2Num){
                return 1;
            }
            //if 2 is bigger than 1 then 2
            if (date1Num < date2Num){
                return 2;
            }
            //else are equal then 0
            else {
                return 0;
            }
        }

            ";
        }

        if ($this->needYearsFrom2DatesFunction == true) {
            echo "
            
    function getYearsFromDates(dFrom, dTo, whatToReturn = 'Years'){
    
    var fromSplit = dFrom.split('/');
    var toSplit = dTo.split('/');

    var dateTo = new Date(
        toSplit[2],
        toSplit[1],
        toSplit[0]
    );

    var yearNow = dateTo.getFullYear();
    var monthNow = dateTo.getMonth();
    var dateNow = dateTo.getDate();
    //date must be mm/dd/yyyy
    var dob = new Date(
        fromSplit[2],
        fromSplit[1]-1,
        fromSplit[0]
    );

    var totalTimeDiff = dateTo.getTime() - dob.getTime();
    var totalDays = Math.floor(totalTimeDiff / (1000 * 3600 * 24));

    var yearDob = dob.getFullYear();
    var monthDob = dob.getMonth();
    var dateDob = dob.getDate();
    var age = {};
    var ageString = '';
    var yearString = '';
    var monthString = '';
    var dayString = '';


    yearAge = yearNow - yearDob;

    if (monthNow >= monthDob)
        var monthAge = monthNow - monthDob;
    else {
        yearAge--;
        var monthAge = 12 + monthNow -monthDob;
    }

    if (dateNow >= dateDob)
        var dateAge = dateNow - dateDob;
    else {
        monthAge--;
        var dateAge = 31 + dateNow - dateDob;

        if (monthAge < 0) {
            monthAge = 11;
            yearAge--;
        }
    }

    age = {
        years: yearAge,
        months: monthAge,
        days: dateAge
    };

    if ( age.years > 1 ) yearString = \" years\";
    else yearString = \" year\";
    if ( age.months> 1 ) monthString = \" months\";
    else monthString = \" month\";
    if ( age.days > 1 ) dayString = \" days\";
    else dayString = \" day\";


    if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.years + yearString + \", \" + age.months + monthString + \", and \" + age.days + dayString + \" old.\";
    else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
        ageString = \"Only \" + age.days + dayString + \" old!\";
    else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
        ageString = age.years + yearString + \" old. Happy Birthday!!\";
    else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.years + yearString + \" and \" + age.months + monthString + \" old.\";
    else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.months + monthString + \" and \" + age.days + dayString + \" old.\";
    else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
        ageString = age.years + yearString + \" and \" + age.days + dayString + \" old.\";
    else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.months + monthString + \" old.\";
    else ageString = \"Oops! Could not calculate age!\";

    if (whatToReturn == 'Years'){
        return age.years;
    }
    else if (whatToReturn == 'AgeString'){
        return ageString;
    }
    else if (whatToReturn == 'totalDays'){
        return totalDays;
    }
    else {
        return age.years;
    }
}
            
            ";
        }

        if ($this->needEmailValidationFunction == true) {
            echo '
            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test( $email );
            }
            ';
        }
        if ($this->needIntegerOnlyValidationFunction == true) {
            echo '
            function validateOnlyInteger($text) {
                if ($text.match(/^\d*$/)){
                    return true
                }
                return false;
            }
            ';
        }
        if ($this->disableForm == true) {
            echo '
            $("#' . $this->formName . ' :input").prop("disabled", true);
            ';

            //find the exceptions
            foreach ($this->disableFormExceptions as $value) {
                if ($value == 'buttons') {
                    echo '
                    $("#' . $this->formName . ' :button").prop("disabled", false);
                    ';
                }
            }


        }
        echo "</script>";

    }

    //STATIC FUNCTION
    public static function getAutoCompleteJSCode($fieldName, $parameters)
    {

        if ($parameters['delay'] == '') {
            $parameters['delay'] = 500;
        }
        if ($parameters['minLength'] == '') {
            $parameters['minLength'] = 2;
        }

        $return = '
        <script>
        $("#' . $fieldName . '").autocomplete({
            source: "' . $parameters['source'] . '",
            delay: ' . $parameters['delay'] . ',
            minLength: ' . $parameters['minLength'] . ',
            messages: {
            noResults: "",
            results: function () {
                ' . $parameters['resultsCode'] . '
            }
            },
            search: function (event, ui) {
                ' . $parameters['searchCode'] . '
            },
            focus: function (event, ui) {
                ' . $parameters['focusCode'] . '
                return false;
            },
            select: function (event, ui) {
                ' . $parameters['selectCode'] . '
            return false;
        }
        });
        </script>';
        return $return;
    }

    /**
 * @param $settings [
 * source -> the full source of the api ->automatically the input code is added as 'value'
 * functionName -> the name of the function for the output. Make sure it does not exists in the same page dont forget the ()
 * sourceField -> the id of the field that has the source
 * spinnerIcon -> id of the spinner icon -> if set shows/hides a spinner when necessary
 * errorIcon -> id of the error icon -> if set shows/hides an error icon when necessary
 * correctIcon -> id of the correct icon -> if set shows/hides a correct icon when necessary
 * errorField -> a field (div,span etc) to show the errorText
 * errorText -> not required. default exists -> the errorText to show in the errorField
 * errorJSCode -> extra js code to show in the error part of the promise
 * successJSCode -> extra js code to show in the success part of the promise
 * ifDataJSCode-> extra js code if data is found
 * ifNoDataJSCode-> extra js code if data is NOT found
 * errorJSCode -> js code if error occurs
 * ifDataJSCode -> js code on success and if data is retrieved
 * ifNoDataJSCode-> js code on success and if no data is retrieved
 * successJSCode -> js code on success
 *
 * ]
 * @return Promise JSCODE
 */

    public static function getPromiseJSCode($settings)
    {

        if ($settings['spinnerIcon'] != '') {
            $spinnerShow = '$(' . $settings['spinnerIcon'] . ').show();';
            $spinnerHide = '$(' . $settings['spinnerIcon'] . ').hide();';
        }
        if ($settings['correctIcon'] != '') {
            $correctShow = '$(' . $settings['correctIcon'] . ').show();';
            $correctHide = '$(' . $settings['correctIcon'] . ').hide();';
        }
        if ($settings['errorIcon'] != '') {
            $errorShow = '$(' . $settings['errorIcon'] . ').show();';
            $errorHide = '$(' . $settings['errorIcon'] . ').hide();';
        }
        if ($settings['errorText'] == '') {
            $errorText = '$(' . $settings['errorField'] . ').html("Error finding the account");';
            $correctShow .= '$(' . $settings['errorField'] . ').html("");';
        } else {
            $errorText = '$(' . $settings['errorField'] . ').html("' . $settings['errorText'] . '");';
            $correctShow .= '$(' . $settings['errorField'] . ').html("");';
        }

        $return = '
            function ' . $settings['functionName'] . ' {
            ' . $spinnerShow . '
            ' . $correctHide . '
            ' . $errorHide . '
            let inputCode = $(' . $settings['sourceField'] . ').val();
        
            Rx.Observable.fromPromise($.get("' . $settings['source'] . '&value=" + inputCode))
            .subscribe((response) => {
                    data = response;
                },
                () => {
                    ' . $errorShow . '
                    ' . $spinnerHide . '
                    ' . $errorText . '
                    ' . $settings['errorJSCode'] . '
                }
                ,
                () => {
                    ' . $spinnerHide . '
                    if (data != null) {
                        ' . $correctShow . '
                        ' . $settings['ifDataJSCode'] . '
                    }
                    else {
                        ' . $errorShow . '
                        ' . $errorText . '
                        ' . $settings['ifNoDataJSCode'] . '
                    }
                    ' . $settings['successJSCode'] . '

                }
                );
            }
        ';
        return $return;

    }

    /**
     * @param $settings [
     * source -> the full source of the api ->automatically the input code is added as 'value'
     * functionName -> the name of the function for the output. Make sure it does not exists in the same page dont forget the ()
     * sourceField -> the id of the field that has the source
     * spinnerIcon -> id of the spinner icon -> if set shows/hides a spinner when necessary
     * errorIcon -> id of the error icon -> if set shows/hides an error icon when necessary
     * correctIcon -> id of the correct icon -> if set shows/hides a correct icon when necessary
     * errorField -> a field (div,span etc) to show the errorText
     * errorText -> not required. default exists -> the errorText to show in the errorField
     * errorJSCode -> extra js code to show in the error part of the promise
     * successJSCode -> extra js code to show in the success part of the promise
     * ifDataJSCode-> extra js code if data is found
     * ifNoDataJSCode-> extra js code if data is NOT found
     * errorJSCode -> js code if error occurs
     * ifDataJSCode -> js code on success and if data is retrieved
     * ifNoDataJSCode-> js code on success and if no data is retrieved
     * successJSCode -> js code on success
     * prefixJSCode -> js code right after the declaration of the function
     *
     * ]
     * @return Promise JSCODE
     */

    public static function getPromiseJSCodeV2($settings)
    {

        if ($settings['spinnerIcon'] != '') {
            $spinnerShow = '$(' . $settings['spinnerIcon'] . ').show();';
            $spinnerHide = '$(' . $settings['spinnerIcon'] . ').hide();';
        }
        if ($settings['correctIcon'] != '') {
            $correctShow = '$(' . $settings['correctIcon'] . ').show();';
            $correctHide = '$(' . $settings['correctIcon'] . ').hide();';
        }
        if ($settings['errorIcon'] != '') {
            $errorShow = '$(' . $settings['errorIcon'] . ').show();';
            $errorHide = '$(' . $settings['errorIcon'] . ').hide();';
        }
        if ($settings['errorText'] == '') {
            //$errorText = '$(' . $settings['errorField'] . ').html("Error finding the account");';
            //$correctShow .= '$(' . $settings['errorField'] . ').html("");';
        } else {
            $errorText = '$(' . $settings['errorField'] . ').html("' . $settings['errorText'] . '");';
            $correctShow .= '$(' . $settings['errorField'] . ').html("");';
        }

        $return = '
            function ' . $settings['functionName'] . ' {
            ' .$settings['prefixJSCode']. '
            ' . $spinnerShow . '
            ' . $correctHide . '
            ' . $errorHide . '
            let inputCode = $(' . $settings['sourceField'] . ').val();
        
            Rx.Observable.fromPromise($.get(' . $settings['source'] . '))
            .subscribe((response) => {
                    data = response;
                },
                () => {
                    ' . $errorShow . '
                    ' . $spinnerHide . '
                    ' . $errorText . '
                    ' . $settings['errorJSCode'] . '
                }
                ,
                () => {
                    ' . $spinnerHide . '
                    if (data != null) {
                        ' . $correctShow . '
                        ' . $settings['ifDataJSCode'] . '
                    }
                    else {
                        ' . $errorShow . '
                        ' . $errorText . '
                        ' . $settings['ifNoDataJSCode'] . '
                    }
                    ' . $settings['successJSCode'] . '

                }
                );
            }
        ';
        return $return;

    }

}
