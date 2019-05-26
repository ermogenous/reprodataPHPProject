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
    private $customCode = [];

    private $disableForm = false;
    private $formName = 'myForm';


    function __construct()
    {
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
        //fieldDataType: text/number/date/age/radio/select/email
        //required: true/false
        //enableDatePicker: true/false ->when true it will echo the script required for the datepicker. jqueryUi must already exists.
        //datePickerValue: the value date to be inserted on creation
        //invalidText: the text to show when invalid.
        //requiredAddedCustomCode: added custom code in the if statement for the required section
        //dateMinDate : compares the 2 dates and if lower than min date then error
        //dateMaxDate : compares the 2 dates and if higher than max date then error
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

    public function disableForm()
    {
        $this->disableForm = true;
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
        if ($fieldData['invalidText'] != '') {
            if ($fieldData['fieldDataType'] == 'radio') {
                echo '<div class="invalid-feedback" id="' . $fieldData['fieldName'] . '-invalid-text">' . $fieldData['invalidText'] . '</div>';
            } else {
                echo '<div class="invalid-feedback">' . $fieldData['invalidText'] . '</div>';
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
            if ($db->enabled_jquery_ui != 'yes'){
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
                //alert('radio error');
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
            if ($.isNumeric($('#" . $fieldData['fieldName'] . "').val()) == true ){
                $('#" . $fieldData['fieldName'] . "').addClass('is-valid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-invalid');
            }
            else {
                $('#" . $fieldData['fieldName'] . "').addClass('is-invalid');
                $('#" . $fieldData['fieldName'] . "').removeClass('is-valid');
                FormErrorFound = true;
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

                    " . $fieldsValidationsText . "
                    " . $customCode . "

                    if (FormErrorFound) {
                        //alert('Error validation');
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
        if ($this->disableForm == true) {
            echo '
            $("#' . $this->formName . ' :input").prop("disabled", true);
            ';
            echo '';
        }
        echo "</script>";

    }


}
