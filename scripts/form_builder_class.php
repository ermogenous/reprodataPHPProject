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
    private $fieldDescription;
    private $fieldType; // Type of input input/select/checkbox/radio/textarea
    private $fieldInputType; //Type of the text input: text/number/email
    private $labelClasses;//text of all label classes needed
    private $inputExtraClasses;
    private $inputValue; //the value of the input.
    private $inputSelectQuery;
    private $inputSelectAddEmptyOption;//true/false if true adds an extra empty option at the top


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
    function __construct($settings)
    {

        $this->fieldName = $settings['fieldName'];
        $this->fieldDescription = $settings['fieldDescription'];
        $this->fieldType = $settings['fieldType'];
        $this->fieldInputType = $settings['fieldInputType'];
        $this->labelClasses = $settings['labelClasses'];
        $this->inputValue = $settings['inputValue'];
        $this->inputSelectQuery = $settings['inputSelectQuery'];
        $this->inputSelectAddEmptyOption = $settings['inputSelectAddEmptyOption'];
        $this->inputExtraClasses = $settings['inputExtraClasses'];

    }

    public function buildInput()
    {

        //build the input
        if ($this->fieldType == 'input') {
            $this->buildInputInput();
        } else if ($this->fieldType == 'select') {
            $this->buildInputSelect();
        } else if ($this->fieldType == 'checkbox') {

        } else if ($this->fieldType == 'radio') {

        } else if ($this->fieldType == 'textarea') {

        }
    }

    public function buildLabel()
    {
        echo '<label for="' . $this->fieldName . '" class="' . $this->labelClasses . ' '.$this->defaultLabelClass.'">' . $this->fieldDescription . '</label>';
    }

    private function buildInputInput()
    {
        echo '<input name="' . $this->fieldName . '" type="' . $this->fieldInputType . '" id="' . $this->fieldName . '"
              value="' . $this->inputValue . '"
              class="'.$this->defaultInputClass.' '.$this->inputExtraClasses.'"/>';
    }

    private function buildInputSelect(){
        global $db;
        echo '<select id="'.$this->fieldName.'" name="'.$this->fieldName.'" class="'.$this->defaultInputClass.' '.$this->inputExtraClasses.'">'.PHP_EOL;

        if ($this->inputSelectAddEmptyOption == true){
            echo '<option value=""></option>'.PHP_EOL;
        }
        while ($row = $db->fetch_assoc($this->inputSelectQuery)){

            echo '<option value="'.$row['value'].'"';
            if ($row['value'] == $this->inputValue){
                echo ' selected';
            }
            echo '>'.$row['name'].'</option>'.PHP_EOL;

        }

        echo '</select>'.PHP_EOL;
    }

    //STATIC FUNCTION
    public function buildAutoCompleteJSCode($parameters)
    {

        if ($parameters['delay'] == '') {
            $parameters['delay'] = 500;
        }
        if ($parameters['minLength'] == '') {
            $parameters['minLength'] = 2;
        }

        $return = '
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
                ' . $parameters['selectCode'] . '
            return false;
        }
        });
        </script>';
        echo $return;
    }

}