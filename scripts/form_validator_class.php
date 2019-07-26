<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 21/3/2019
 * Time: 10:59 ΠΜ
 */


class customFormValidator
{

    private $inputFieldsList = array();
    private $fieldCode = '';
    private $needIsDateFunction = false;
    private $needCompare2DatesFunction = false;
    private $needEmailValidationFunction = false;
    private $needIntegerOnlyValidationFunction = false;
    private $customCode = [];

    private $disableForm = false;
    private $disableFormExceptions = [];
    private $formName = 'myForm';

    private $showErrorList = 0;


    function __construct()
    {
    }

    public function showErrorList()
    {
        $this->showErrorList = 1;
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
        if ($fieldData['fieldName'] == '') {
            echo "<div class='alert alert-danger'>Must provide fieldName in newField</div>";
            exit();
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
                echo '<div class="invalid-feedback">' . $fieldData['invalidText'] . '</div>';
            }
        } else {

            if ($fieldData['invalidTextAutoGenerate'] == true) {
                if ($fieldData['fieldDataType'] == 'select') {
                    $prefix = $db->showLangText('Must Select ','Επιλέξατε ');
                } else if ($fieldData['fieldDataType'] == 'email') {
                    $prefix = $db->showLangText('Must Enter Valid ','Πρέπει να εισάγετε έγκυρο ');
                } else {
                    $prefix = $db->showLangText('Must Enter ','Πρέπει να εισάγετε ');
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


        $return = "FieldsErrors['" . $fieldData['fieldName'] . "'] = [];";
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
            if ($('#" . $fieldData['fieldName'] . "').val() == '' " . $requiredAddedCustomCode . "){
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                FormErrorFound = true;
                ErrorList.push('" . $fieldData['fieldName'] . " -> Other Empty ');
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
            if (isDate($('#" . $fieldData['fieldName'] . "').val())){
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
 var showErrorList = '" . $this->showErrorList . "';
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

                    " . $fieldsValidationsText . "
                    " . $customCode . "

                    if (FormErrorFound) {
                        
                        if (showErrorList == '1'){
                            console.log('Error validation');
                            console.log(ErrorList);
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
     * ]
     * @return Promise JSCODE
     */

    public static function getPromiseJSCode($settings)
    {

        if ($settings['spinnerIcon'] != '') {
            $spinnerShow = '$(' . $settings['spinnerIcon'].').show();';
            $spinnerHide = '$(' . $settings['spinnerIcon'].').hide();';
        }
        if ($settings['correctIcon'] != '') {
            $correctShow = '$('.$settings['correctIcon'].').show();';
            $correctHide = '$('.$settings['correctIcon'].').hide();';
        }
        if ($settings['errorIcon'] != '') {
            $errorShow = '$(' . $settings['errorIcon'].').show();';
            $errorHide = '$(' . $settings['errorIcon'].').hide();';
        }
        if ($settings['errorText'] == '') {
            $errorText = '$('.$settings['errorField'].').html("Error finding the account");';
        } else {
            $errorText = '$('.$settings['errorField'].').html("' . $settings['errorText'] . '");';
        }

        $return = '
            function ' . $settings['functionName'] . ' {
            ' . $spinnerShow . '
            ' . $correctHide . '
            ' . $errorHide . '
            let inputCode = $('.$settings['sourceField'].').val();
        
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


}
