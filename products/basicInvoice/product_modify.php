<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 21/05/2020
 * Time: 15:38
 */

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');

$db = new Main();
$db->admin_title = "Products Modify";

if ($_POST['action'] == 'insert') {
    $db->check_restriction_area('insert');
    $db->working_section = 'Products Modify Inserting';

    $db->start_transaction();

    $db->db_tool_insert_row('products', $_POST, 'fld_', 0, 'prd_');

    $db->commit_transaction();
    header("Location: products.php");
    exit();

} else if ($_POST['action'] == 'update') {
    $db->check_restriction_area('update');
    $db->working_section = 'Products Modify Updating';

    $db->start_transaction();

    $db->db_tool_update_row('products', $_POST, 'prd_product_ID = ' . $_POST["lid"], $_POST['lid']
        , 'fld_', 'execute', 'prd_');
    $db->commit_transaction();
    header("Location: products.php");
    exit();
}

if ($_GET['lid'] != '') {
    $data = $db->query_fetch('SELECT * FROM products WHERE prd_product_ID = ' . $_GET['lid']);
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();


$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

?>

<div class="container">
    <div class="row">
        <div class="col-sm-1 d-none d-md-block"></div>
        <div class="col-sm-10 col-md-10">
            <form name="myForm" id="myForm" method="post" action="" onsubmit=""
                <?php $formValidator->echoFormParameters(); ?>>

                <div class="row">
                    <div class="col-12 alert alert-primary text-center"><b>Product</b></div>
                </div>


                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_active')
                        ->setFieldDescription('Status')
                        ->setLabelClasses('col-sm-4')
                        ->setFieldType('select')
                        ->setInputValue($data['prd_active'])
                        ->setInputSelectAddEmptyOption(true)
                        ->buildLabel();
                    ?>
                    <div class="col-8">
                        <?php
                        $formB->setInputSelectArrayOptions([
                            '1' => 'Active',
                            '0' => 'InActive'
                        ])
                            ->buildInput();
                        ?>
                    </div>

                </div>
                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_name')
                        ->setFieldDescription('Name')
                        ->setLabelClasses('col-sm-4')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['prd_name'])
                        ->buildLabel();
                    ?>
                    <div class="col-8">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_description')
                        ->setFieldDescription('Description')
                        ->setLabelClasses('col-sm-4')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['prd_description'])
                        ->buildLabel();
                    ?>
                    <div class="col-8">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'text',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row form-group">
                    <?php
                    $formB = new FormBuilder();
                    $formB->setFieldName('fld_price')
                        ->setFieldDescription('Selling Price')
                        ->setLabelClasses('col-sm-4')
                        ->setFieldType('input')
                        ->setFieldInputType('text')
                        ->setInputValue($data['prd_price'])
                        ->buildLabel();
                    ?>
                    <div class="col-8">
                        <?php
                        $formB->buildInput();
                        $formValidator->addField(
                            [
                                'fieldName' => $formB->fieldName,
                                'fieldDataType' => 'number',
                                'required' => true,
                                'invalidTextAutoGenerate' => true
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-4 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('products.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Product"
                               class="btn btn-primary">
                    </div>
                </div>


            </form>

        </div>
    </div>
</div>
<?php
$formValidator->output();
$db->show_footer();
?>
