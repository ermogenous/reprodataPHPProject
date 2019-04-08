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
    private $customCode = [];


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
        //fieldDataType: text/number/date/age/radio/select
        //required: true/false
        //enableDatePicker: true/false ->when true it will echo the script required for the datepicker. jqueryUi must already exists.
        //datePickerValue: the value date to be inserted on creation
        //invalidText: the text to show when invalid.
        //requiredAddedCustomCode: added custom code in the if statement for the required section
        if ($fieldData['fieldName'] == '') {
            echo "Must provide fieldName in newField ";
            exit();
        }

        $this->inputFieldsList[] = $fieldData;

        $this->echoDatePickerScriptCode($fieldData);


        $this->echoInvalidText($fieldData);

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

        if ($fieldData['fieldDataType'] == 'date' && $fieldData['enableDatePicker'] == true) {
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
        $return = '';
        if ($fieldData['required'] == true) {

            //requiredAddedCustomCode
            $requiredAddedCustomCode = '';
            if ($fieldData['requiredAddedCustomCode'] != '') {
                $requiredAddedCustomCode = $fieldData['requiredAddedCustomCode'];
            }


            //for RADIO
            if ($fieldData['fieldDataType'] == 'radio') {
                $return = "
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
            }
            //For other
            else {
                $return = "
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

        return $return;
    }
    public function addCustomCode($code){
        $this->customCode[] = $code;
    }

    private function getCustomCode()
    {
        $customCode = '';
        foreach($this->customCode as $code){
            $customCode .= $code."\n";
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
        echo "</script>";

    }



}
