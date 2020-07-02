<?php


class meFormBuilder
{

    //input field options
    private $fieldName;
    private $fieldDescription;
    private $fieldType; // its type like input/checkbox/select/radio/textarea
    private $fieldInputType; // text/date/dateTime/Number
    private $inputValue; //the value of the input
    private $fieldDisable = false;
    private $fieldStyle;
    private $fieldOnKeyUp;
    private $fieldOnChange;
    private $inputClasses = 'form-control';


    //input label options
    private $labelClasses = 'col-form-label';
    private $labelTitle;

    /**
     * FormBuilder constructor.
     * @param $settings
     * fieldName
     * fieldDescription
     * fieldType
     */
    function __construct($settings = [])
    {

    }

    /**
     * @return $this
     */
    function initSettings()
    {

    }

    function buildLabel()
    {

        echo '<label for="' . $this->fieldName . '" class="' . $this->labelClasses
            . '" title="' . $this->labelTitle . '">'
            . $this->fieldDescription .
            '</label>';
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
        if ($this->fieldDisable == true) {
            $disabled = 'disabled';
        }
        echo '<input name="' . $this->fieldName . '" type="text" id="' . $this->fieldName . '" style="' . $this->fieldStyle . '"
              value="' . $this->inputValue . '" ' . ' onkeyup="' . $this->fieldOnKeyUp . '" onchange="' . $this->fieldOnChange . '"
              class="' . $this->inputClasses . '" ' . $disabled . '/>';

    }

    /**
     * @param mixed $fieldName
     * @return $this
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    /**
     * @param mixed $fieldDescription
     * @return $this
     */
    public function setFieldDescription($fieldDescription)
    {
        $this->fieldDescription = $fieldDescription;
        return $this;
    }

    /**
     * @param mixed $fieldType
     * @return $this
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    /**
     * @param mixed $fieldInputType
     * @return $this
     */
    public function setFieldInputType($fieldInputType)
    {
        $this->fieldInputType = $fieldInputType;
        return $this;
    }

    /**
     * @param mixed $inputValue
     * @return $this
     */
    public function setInputValue($inputValue)
    {
        $this->inputValue = $inputValue;
        return $this;
    }

    /**
     * @param bool $fieldDisable
     * @return $this
     */
    public function setFieldDisable()
    {
        $this->fieldDisable = true;
        return $this;
    }

    /**
     * @param string $labelClasses
     * @return $this
     */
    public function setLabelClasses($labelClasses)
    {
        $this->labelClasses = $labelClasses;
        return $this;
    }

    /**
     * @param mixed $labelTitle
     * @return $this
     */
    public function setLabelTitle($labelTitle)
    {
        $this->labelTitle = $labelTitle;
        return $this;
    }

    /**
     * @param mixed $fieldStyle
     * @return $this
     */
    public function setFieldStyle($fieldStyle)
    {
        $this->fieldStyle = $fieldStyle;
        return $this;
    }

    /**
     * @param mixed $fieldOnKeyUp
     * @return $this
     */
    public function setFieldOnKeyUp($fieldOnKeyUp)
    {
        $this->fieldOnKeyUp = $fieldOnKeyUp;
        return $this;
    }

    /**
     * @param mixed $fieldOnChange
     * @return $this
     */
    public function setFieldOnChange($fieldOnChange)
    {
        $this->fieldOnChange = $fieldOnChange;
        return $this;
    }

    /**
     * @param string $inputClasses
     * @return $this
     */
    public function setInputClasses($inputClasses)
    {
        $this->inputClasses = $inputClasses;
        return $this;
    }


}