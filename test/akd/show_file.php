<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 3/1/2020
 * Time: 1:00 μ.μ.
 */

include('../../include/main.php');
include("../../scripts/form_builder_class.php");
include("../../scripts/form_validator_class.php");
include('create_sql/functions.php');
$db = new Main(1);

$fileCreateList['acc_account.csv'] = 'acc_account_insert.php';
$fileCreateList['cor_entity.csv'] = 'core_entity_insert.php';
$fileCreateList['insa_policy.csv'] = 'insa_policy_insert.php';

if ($_POST['action'] == 'show' && $_POST['createSql'] == 'CreateSql'){
    $fileLocation = $fileCreateList[$_POST['fld_file']];
    header("Location: create_sql/".$fileLocation);
    exit();
}

$db->enable_jquery_ui();
$db->show_header();
FormBuilder::buildPageLoader();
$formB = new FormBuilder();
$formB->setLabelClasses('col-sm-3');
?>

<form name="myForm" id="myForm" method="post" action="" onsubmit="">

    <div class="container">
        <div class="row">
            <?php
            $formB->setFieldName('fld_file')
                ->setFieldDescription('Select File')
                ->setFieldType('select')
                ->setInputValue($_POST['fld_file'])
                ->buildLabel();
            ?>
            <div class="col-3">
                <?php
                $files = scandir($main['local_url'] . '/test/akd');
                foreach ($files as $file) {
                    $fileSplit = explode('.', $file);
                    $extension = $fileSplit[1];
                    if ($file != '.' && $file != '..' && $extension == 'csv') {
                        $allFiles[$file] = $file;
                    }
                }
                $formB->setInputSelectArrayOptions($allFiles)
                    ->setInputSelectAddEmptyOption(true)
                    ->buildInput();
                ?>
            </div>
            <div class="col-3">
                <input type="hidden" value="show" id="action" name="action">
                <input type="submit" value="Show" class="btn btn-primary">
                <input type="submit" id="createSql" name="createSql" value="CreateSql" class="btn btn-secondary">
            </div>
        </div>
    </div>
</form>
<?php
if ($_POST['action'] == 'show'){
    $codes = getCodesArray();
    $entities = getEntitiesArray();
    //print_r($entities);
    //print_r($codes);
    ?>
    <table border="1" width="100%">

    <?php

    $handle = fopen($_POST['fld_file'], "r");
    if ($handle) {
        $num = 0;
        while (($line = fgets($handle)) !== false) {

            $num++;
            $dataSplit = explode(";",$line);
                if ($num == 1) {
                    echo "<tr>";

                    $j = 0;
                    $numToStop = 0;
                    foreach ($dataSplit as $header) {
                        $j++;
                        $header = substr($header, 1, strlen($header) - 2);
                        if ((strpos($header,'create_func') !== false
                             || $header == 'acc_lock_flag'
                        )&& $numToStop == 0) {
                            $numToStop = $j;
                        }

                        if ($j < $numToStop || $numToStop == 0) {
                            echo "<td>" . $header . "(".($j-1).")</td>" . PHP_EOL;
                        }
                    }
                    echo "</tr>";
                }
                if ($num > 1){
                    $j = 0;
                    echo "<tr>";
                    foreach ($dataSplit as $contents) {
                        $contents = substr($contents, 1, strlen($contents) - 2);
                        $codeData = '';
                        if ($codes[$contents]['value'] != ''){
                            $codeData = '[C]'.$codes[$contents]['value'];
                        }

                        //check if entity
                        $entityData = '';
                        if ($entities[$contents] != ''){
                            $entityData = "[E]".$entities[$contents];
                        }

                        $j++;

                        if ($j < $numToStop || $numToStop == 0) {
                            echo "<td>" . $contents . $codeData . $entityData . "</td>" . PHP_EOL;
                        }
                    }
                    //if ($j > 2)break;
                    echo "</tr>";
                }
        }

        fclose($handle);
    } else {
        echo 'Error opening the file';
    }
    ?>
    </table>
    <?php
}
?>
<?php
$db->show_footer();
?>