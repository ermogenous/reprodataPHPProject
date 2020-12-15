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
    private $fieldStyle = '';
    private $labelClasses; //the value of the input.
    private $inputExtraClasses;
    private $inputValue;//true/false if true adds an extra empty option at the top
    private $inputCheckBoxValue;
    private $radioInline = false;
    private $radioTotalOutputs = 1; //this will be used to automatically generate the ID`s of the radios. no need to define here anything
    private $radioValue;
    private $radioLabelDescription;
    private $inputSelectQuery;
    private $inputSelectArrayOptions;
    private $inputSelectAddEmptyOption;
    private $fieldOnChange;
    private $fieldOnKeyUp;
    private $disableField = false;

    //Label
    private $labelTitle = '';

    //AutoComplete JS CODE
    private $acjsSource;
    private $acjsDelay;
    private $acjsMinLength;


    //DEFAULT SETTINGS
    public $defaultLabelClass = 'col-form-label';
    public $defaultInputClass = 'form-control';

    //layout settings
    private $fieldDivClass = '';

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

    /**
     * @return $this
     */
    function initSettings(){
        $this->disableField = false;
        $this->fieldInputType = '';
        $this->inputSelectQuery = '';
        $this->inputSelectAddEmptyOption = false;
        $this->labelTitle = '';
        $this->fieldOnChange = '';
        $this->fieldOnKeyUp = '';
        $this->fieldDescription = '';
        $this->radioLabelDescription = '';
        return $this;
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
            $this->buildInputCheckbox();
        } else if ($this->fieldType == 'radio') {
            $this->buildInputRadio();
        } else if ($this->fieldType == 'textarea') {
            $this->buildInputTextArea();

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

        if ($this->fieldInputType == 'date'){
            echo '<input name="' . $this->fieldName . '" type="text" id="' . $this->fieldName . '" style="'.$this->fieldStyle.'"
              value="' . $this->inputValue . '" '. ' onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'"
              class="' . $this->defaultInputClass . ' ' . $this->inputExtraClasses . '" '.$disabled.'/>';
            echo '<script>
        $(function () {
            $("#'.$this->fieldName.'").datepicker();
            $("#'.$this->fieldName.'").datepicker("option", "dateFormat", "dd/mm/yy");
            $("#'.$this->fieldName.'").val("'.$this->inputValue.'");

        });
        </script>';
        }//need to include dateTime js addon
        else if ($this->fieldInputType == 'dateTime') {
            echo '<input name="' . $this->fieldName . '" type="text" id="' . $this->fieldName . '" style="'.$this->fieldStyle.'"
              value="' . $this->inputValue . '" '. ' onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'"
              class="' . $this->defaultInputClass . ' ' . $this->inputExtraClasses . '" '.$disabled.'/>';
            echo '<script>
        $(function () {
            $("#'.$this->fieldName.'").datetimepicker({
                dateFormat: "dd/mm/yy",
                timeFormat: "HH:mm",
                showSecond:false,
                showMillisec:false,
                showMicrosec:false,
                showTimezone:false
            });
            //$("#'.$this->fieldName.'").datepicker("setDate","'.$this->inputValue.'");
            $("#'.$this->fieldName.'").val("'.$this->inputValue.'");

        });
        </script>';
        }
        else {
            echo '<input name="' . $this->fieldName . '" type="' . $this->fieldInputType . '" id="' . $this->fieldName . '" style="'.$this->fieldStyle.'"
              value="' . $this->inputValue . '" '. ' onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'"
              class="' . $this->defaultInputClass . ' ' . $this->inputExtraClasses . '" '.$disabled.'/>';
        }

    }

    private function buildInputTextArea()
    {
        $disabled = '';
        if ($this->disableField == true){
            $disabled = 'disabled';
        }

        echo '<textarea name="' . $this->fieldName . '" id="' . $this->fieldName . '" style="'.$this->fieldStyle.'"
        onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'" class="' . $this->defaultInputClass . ' ' . $this->inputExtraClasses . '" '.$disabled.'>'
        . $this->inputValue . '</textarea>';

    }

    private function buildInputSelect()
    {
        global $db;
        echo '<select id="' . $this->fieldName . '" name="' . $this->fieldName . '" class="' . $this->defaultInputClass .' style="'.$this->fieldStyle.'"'
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

    private function buildInputCheckbox(){
        $disabled = '';
        if ($this->disableField == true){
            $disabled = 'disabled';
        }

        $checked = '';
        if ($this->inputValue == $this->inputCheckBoxValue){
            $checked = 'checked';
        }

        echo '
        <div class="form-check">
            <input type="checkbox" name="' . $this->fieldName . '" id="' . $this->fieldName . '" style="'.$this->fieldStyle.'"
            onkeyup="'.$this->fieldOnKeyUp.'" onchange="'.$this->fieldOnChange.'" '.$checked.'
            class="form-check-input ' . $this->inputExtraClasses . '" value="'.$this->inputCheckBoxValue.'" '.$disabled.'>
        </div>
        ';
    }

    private function buildInputRadio(){
        $disabled = '';
        if ($this->disableField == true){
            $disabled = 'disabled';
        }

        $checked = '';
        if ($this->inputValue == $this->radioValue){
            $checked = 'checked';
        }

        $inline = '';
        if ($this->radioInline == true){
            $inline = ' custom-control-inline';
        }

        echo '
        <div class="custom-control custom-radio'.$inline.'">
            <input type="radio" id="'.$this->fieldName."-".$this->radioTotalOutputs.'" name="'.$this->fieldName.'" class="custom-control-input" 
            value="'.$this->radioValue.'" onchange="'.$this->fieldOnChange.'" onkeyup="'.$this->fieldOnKeyUp.'" '.$checked.'><div class="invalid-feedback" id="'.$this->fieldName.'"-invalid-text"></div>
            <label class="custom-control-label" for="'.$this->fieldName."-".$this->radioTotalOutputs.'">'.$this->radioLabelDescription.'</label>
        </div>';
        $this->radioTotalOutputs++;
    }

    public function buildLabel()
    {
        $questionMark = '';
        if ($this->labelTitle != ''){
            $questionMark = ' <i class="fas fa-question"></i>';
        }
        echo '<label for="' . $this->fieldName . '" class="' . $this->labelClasses . ' ' . $this->defaultLabelClass
            . '" title="'.$this->labelTitle.'">'
            . $this->fieldDescription
            . $questionMark .
            '</label>';
        return $this;
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

        function startPageLoader(){
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
        }
        startPageLoader();

        $(document).ready(function () {
            $("#pageLoadingDialog").dialog("close");
        });
    </script>
        
        ';
    }

    //setters

    /**
     * @param $fieldName The id/name of the field
     * @return $this
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    /**
     * @param $fieldDescription
     * @return $this
     */
    public function setFieldDescription($fieldDescription)
    {
        $this->fieldDescription = $fieldDescription;
        return $this;
    }

    /**
     * @param $fieldType input/select/checkbox/radio/textarea
     * @return $this
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    /**
     * @param $fieldInputType: text/number/date/dateTime
     * @return $this
     */
    public function setFieldInputType($fieldInputType)
    {
        $this->fieldInputType = $fieldInputType;
        return $this;
    }

    /**
     * @param $labelClasses
     * @return $this
     */
    public function setLabelClasses($labelClasses)
    {
        $this->labelClasses = $labelClasses;
        return $this;
    }

    /**
     * @param $inputValue
     * @return $this
     */
    public function setInputValue($inputValue = '')
    {
        $this->inputValue = $inputValue;
        return $this;
    }

    /**
     * @param $checkBoxValue
     * @return $this
     */
    public function setInputCheckBoxValue($checkBoxValue){
        $this->inputCheckBoxValue = $checkBoxValue;
        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setRadioInline($value = true){
        $this->radioInline = $value;
        return $this;
    }

    public function setRadioLabelDescription($description){
        $this->radioLabelDescription = $description;
        return $this;
    }

    public function setRadioValue($value){
        $this->radioValue = $value;
        return $this;
    }

    /**
     * @param $inputSelectQuery
     * @return $this
     */
    public function setInputSelectQuery($inputSelectQuery)
    {
        $this->inputSelectQuery = $inputSelectQuery;
        return $this;
    }

    /**
     * @param $optArray
     * @return $this
     */
    public function setInputSelectArrayOptions($optArray){
        $this->inputSelectArrayOptions = $optArray;
        return $this;
    }

    /**
     * @param $inputSelectAddEmptyOption true/false
     * @return $this
     */
    public function setInputSelectAddEmptyOption($inputSelectAddEmptyOption)
    {
        $this->inputSelectAddEmptyOption = $inputSelectAddEmptyOption;
        return $this;
    }

    /**
     * @param $inputExtraClasses
     * @return $this
     */
    public function setInputExtraClasses($inputExtraClasses)
    {
        $this->inputExtraClasses = $inputExtraClasses;
        return $this;
    }

    /**
     * @param $fieldOnChage
     * @return $this
     */
    public function setFieldOnChange($fieldOnChage){
        $this->fieldOnChange = $fieldOnChage;
        return $this;
    }

    /**
     * @param $fieldOnKeyUp
     * @return $this
     */
    public function setFieldOnKeyUp($fieldOnKeyUp){
        $this->fieldOnKeyUp = $fieldOnKeyUp;
        return $this;
    }

    /**
     * @return $this
     */
    public function setDisableField(){
        $this->disableField = true;
        return $this;
    }

    /**
     * @param $style
     * @return $this
     */
    public function setFieldStyle($style){
        $this->fieldStyle = $style;
        return $this;
    }

    public function setFieldDivClass($fieldDivClass){
        $this->fieldDivClass = $fieldDivClass;
        return $this;
    }
    public function getFieldDivClass(){
        return $this->fieldDivClass;
    }

    /**
     * @return string
     */
    public function getLabelTitle()
    {
        return $this->labelTitle;
    }

    /**
     * @param string $labelTitle
     * @return $this
     */
    public function setLabelTitle($labelTitle)
    {
        $this->labelTitle = $labelTitle;
        return $this;
    }


}