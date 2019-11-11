<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/10/2019
 * Time: 8:55 ΜΜ
 */

class FormBuilder
{

    public $fieldName;
    private $fieldDescription; //Type of the text input: text/number/email
    private $fieldType;//text of all label classes needed
    private $fieldInputType;// Type of input input/select/checkbox/radio/textarea
    private $labelClasses; //the value of the input.
    private $inputExtraClasses;
    private $inputValue;//true/false if true adds an extra empty option at the top
    private $inputSelectQuery;
    private $inputSelectArrayOptions;
    private $inputSelectAddEmptyOption;
    private $fieldOnChange;
    private $fieldOnKeyUp;
    private $disableField = false;

    //AutoComplete JS CODE
    private $acjsSource;
    private $acjsDelay;
    private $acjsMinLength;


    //DEFAULT SETTINGS
    public $defaultLabelClass = 'col-form-label';
    public $defaultInputClass = 'form-control';

    /**
     * FormBuilder constructor.
     * @param $settings
     * fieldName
     * fieldDescription
     * fieldType
     */
    function __construct($settings = [])
    {
        $this->fieldName = $settings['fieldName'];
        $this->fieldDescription = $settings['fieldDescription'];
        $this->fieldType = $settings['fieldType'];
        $this->fieldInputType = $settings['fieldInputType'];
        $this->labelClasses = $settings['labelClasses'];
        $this->inputValue = $settings['inputValue'];
        $this->inputSelectQuery = $settings['inputSelectQuery'];
        $this->inputSelectAddEmptyOption = $settings['inputSelectArrayOptions'];
        $this->inputSelectAddEmptyOption = $settings['inputSelectAddEmptyOption'];
        $this->inputExtraClasses = $settings['inputExtraClasses'];
        $this->fieldOnKeyUp = $settings['fieldOnKeyUp'];
        $this->fieldOnChange = $settings['fieldOnChange'];
    }

    public function buildInput()
    {
        global $db;
        //build the input
        if ($this->fieldType == 'input') {
            $this->buildInputInput();
        } else if ($this->fieldType == 'select') {
            $this->buildInputSelect();
        } else if ($this->fieldType == 'checkbox') {

        } else if ($this->fieldType == 'radio') {

        } else if ($this->fieldType == 'textarea') {

        } else {
            echo "FormBuilder:buildInput parameter fieldType is not specified correctly.";
        }
    }

    private function buildInputInput()
    {
        $disabled = '';
        if ($this->disableField == true){
            $disabled = 'disabled';
        }

        echo '<input name="' . $this->fieldName . '" type="' . $this->fieldInputType . '" id="' . $this->fieldName . '"
              value="' . $this->inputValue . '" '. ' onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'"
              class="' . $this->defaultInputClass . ' ' . $this->inputExtraClasses . '" '.$disabled.'/>';
    }

    private function buildInputSelect()
    {
        global $db;
        echo '<select id="' . $this->fieldName . '" name="' . $this->fieldName . '" class="' . $this->defaultInputClass
            . ' onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'"  ' . $this->inputExtraClasses . '">' . PHP_EOL;

        if ($this->inputSelectAddEmptyOption == true) {
            echo '<option value=""></option>' . PHP_EOL;
        }
        if ($this->inputSelectQuery != '') {
            while ($row = $db->fetch_assoc($this->inputSelectQuery)) {

                echo '<option value="' . $row['value'] . '"';
                if ($row['value'] == $this->inputValue) {
                    echo ' selected';
                }
                echo '>' . $row['name'] . '</option>' . PHP_EOL;

            }
        }
        else if (is_array($this->inputSelectArrayOptions)){
            foreach($this->inputSelectArrayOptions as $name => $value){
                echo '<option value="' . $name . '"';
                if ($name == $this->inputValue) {
                    echo ' selected';
                }
                echo '>' . $value . '</option>' . PHP_EOL;
            }
        }

        echo '</select>' . PHP_EOL;
    }

    public function buildLabel()
    {
        echo '<label for="' . $this->fieldName . '" class="' . $this->labelClasses . ' ' . $this->defaultLabelClass . '">' . $this->fieldDescription . '</label>';
    }

    public function buildAutoCompleteJSCode($parameters)
    {
        /**
         * Parameters:
         * source: the url of the source
         * delay: miliseconds
         * minLength: the min amount of chars to start searching
         * resultsCode: js extra code to be executed on the return of the results
         * searchCode: js extra code to be executed on search
         * focusCode: js extra code to be executed on focus
         * selectCode: js extra code to be executed on select
         * autofillOnSelect: put here the field name to use ex:name
         * loadIDInHiddenField: the name of the hidden field. Leave empty to ignore
         */

        //only applies to input field
        if ($this->fieldType != 'input'){
            echo 'Auto Complete js code applies only to input fields.';
            exit();
        }

        if ($parameters['delay'] == '') {
            $parameters['delay'] = 500;
        }
        if ($parameters['minLength'] == '') {
            $parameters['minLength'] = 2;
        }

        $selectFunction = '';
        if ($parameters['autofillOnSelect'] != ''){
            $selectFunction = "$('#".$this->fieldName."').val(ui.item.".$parameters['autofillOnSelect'].");";
        }

        if ($parameters['loadIDInHiddenField'] != ''){
            $selectFunction .= "";
        }

        $script = '
        <script>
        $("#' . $this->fieldName . '").autocomplete({
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
                '.$selectFunction.'
                ' . $parameters['selectCode'] . '
            return false;
        }
        });
        </script>';
        echo $script;
    }

    public static function buildPageLoader(){
        global $main;
        echo '
        
        <div id="pageLoadingDialog" title="" style="display: none;">
        <img src="'.$main['site_url'].'/images/icon_spinner_transparent.gif">
    </div>
    <script>

        $("#pageLoadingDialog").dialog({
            autoOpen: true,
            show: "slide",
            modal: true,
            height: 180,
            width: 150,
            create: function () {
                $(".ui-dialog").find(".ui-dialog-titlebar").css({
                    "background-image": "none",
                    "background-color": "white",
                    "border": "none"
                });
            },
            closeOnEscape: false,
            open: function (event, ui) {
                $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
            }

        });

        $(document).ready(function () {
            $("#pageLoadingDialog").dialog("close");
        });
    </script>
        
        ';
    }

    //setters

    /**
     * @param $fieldName The id/name of the field
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    /**
     * @param $fieldDescription
     */
    public function setFieldDescription($fieldDescription)
    {
        $this->fieldDescription = $fieldDescription;
        return $this;
    }

    /**
     * @param $fieldType input/select/checkbox/radio/textarea
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    /**
     * @param $fieldInputType: text/number/date
     */
    public function setFieldInputType($fieldInputType)
    {
        $this->fieldInputType = $fieldInputType;
        return $this;
    }

    /**
     * @param $labelClasses
     */
    public function setLabelClasses($labelClasses)
    {
        $this->labelClasses = $labelClasses;
        return $this;
    }

    /**
     * @param $inputValue
     */
    public function setInputValue($inputValue)
    {
        $this->inputValue = $inputValue;
        return $this;
    }

    /**
     * @param $inputSelectQuery
     */
    public function setInputSelectQuery($inputSelectQuery)
    {
        $this->inputSelectQuery = $inputSelectQuery;
        return $this;
    }

    public function setInputSelectArrayOptions($optArray){
        $this->inputSelectArrayOptions = $optArray;
        return $this;
    }

    /**
     * @param $inputSelectAddEmptyOption
     */
    public function setInputSelectAddEmptyOption($inputSelectAddEmptyOption)
    {
        $this->inputSelectAddEmptyOption = $inputSelectAddEmptyOption;
        return $this;
    }

    /**
     * @param $inputExtraClasses
     */
    public function setInputExtraClasses($inputExtraClasses)
    {
        $this->inputExtraClasses = $inputExtraClasses;
        return $this;
    }

    /**
     * @param $fieldOnChage
     */
    public function setFieldOnChange($fieldOnChage){
        $this->fieldOnChange = $fieldOnChage;
        return $this;
    }

    /**
     * @param $fieldOnKeyUp
     */
    public function setFieldOnKeyUp($fieldOnKeyUp){
        $this->fieldOnKeyUp = $fieldOnKeyUp;
        return $this;
    }

    public function setDisableField(){
        $this->disableField = true;
    }

}