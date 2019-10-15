<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 9/10/2019
 * Time: 10:01 ΠΜ
 */

/**
 * @param $settings Array
 */
function generateSearchBox($settings)
{

    /**
     * Settings Options
     * report -> the name of the report using this function
     * submitButtonName -> The value of the submit button -> default Search
     * showAsAtDate -> true/false
     * showFromDate -> true/false
     * showToDate -> true/false
     */

    //setting the defaults
    $settings['submitButtonName'] == '' ? $settings['submitButtonName'] = 'Search' : '';

    include('../../../scripts/form_validator_class.php');
    $formValidator = new customFormValidator();
    $formValidator->setFormName('myForm');


    ?>

    <div class="container-fluid">
        <form name="myForm" id="myForm" method="post" action="" onsubmit=""
            <?php $formValidator->echoFormParameters(); ?>>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">

                    <?php
                    if ($settings['showAsAtDate'] == true) {
                        ?>
                        <div class="row">
                            <div class="col-sm-2">As At Date</div>
                            <div class="col-sm-2 form-group">
                                <input type="text" class="form-control" id="sbAsAtDate" name="sbAsAtDate">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'sbAsAtDate',
                                        'fieldDataType' => 'date',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true,
                                        'enableDatePicker' => true,
                                        'datePickerValue' => $_POST['sbAsAtDate']
                                    ]);
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <?php
                        if ($settings['showFromDate'] == true) {
                            ?>
                            <div class="col-sm-2">Date From</div>
                            <div class="col-sm-2 form-group">
                                <input type="text" class="form-control" id="sbDateFrom" name="sbDateFrom">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'sbDateFrom',
                                        'fieldDataType' => 'date',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true,
                                        'enableDatePicker' => true,
                                        'datePickerValue' => $_POST['sbDateFrom']
                                    ]);
                                ?>
                            </div>
                            <?php
                        }
                        if ($settings['showToDate']) {
                            ?>
                            <div class="col-sm-1">Date To</div>
                            <div class="col-sm-2 form-group">
                                <input type="text" class="form-control" id="sbDateTo" name="sbDateTo">
                                <?php
                                $formValidator->addField(
                                    [
                                        'fieldName' => 'sbDateTo',
                                        'fieldDataType' => 'date',
                                        'required' => false,
                                        'invalidTextAutoGenerate' => true,
                                        'enableDatePicker' => true,
                                        'datePickerValue' => $_POST['sbDateTo']
                                    ]);
                                ?>
                            </div>
                        <?php } ?>
                    </div>


                </div>
                <div class="col-sm-2"></div>
            </div>


            <div class="form-group row">
                <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                <div class="col-sm-8">
                    <input name="action" type="hidden" id="action"
                           value="sbSearch">
                    <input name="report" type="hidden" id="report" value="<?php echo $settings['report']; ?>">
                    <input type="submit" name="Submit" id="Submit"
                           value="<?php echo $settings['submitButtonName']; ?>"
                           class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <?php
    $formValidator->output();
}