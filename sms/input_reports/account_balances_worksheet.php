<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 6/11/2021
 * Time: 8:40 μ.μ.
 */

ini_set('max_execution_time', 3600);
ini_set('memory_limit', '4096M');

include("../../include/main.php");
include('../../scripts/form_validator_class.php');
include('../../scripts/form_builder_class.php');
include('../../eurosure/lib/odbccon.php');

$db = new Main(1);
//This report inputs the overdue balances into the sms gateway
$db->admin_title = "Eurosure - SMS - Input Reports - Account Balances Overdue";

if ($_POST['update'] == 'Update Records'){
    foreach ($_POST as $name => $value){
        //find the row
        if (substr($name,4) == 'row'){

        }
    }
}


if ($_POST['asat'] != ''){
    $_GET['asat'] = $_POST['asat'];
}
if ($_POST['year'] != ''){
    $_GET['year'] = $_POST['year'];
}
if ($_POST['period'] != ''){
    $_GET['period'] = $_POST['period'];
}

//check if worksheet exists
if ($_GET['asat'] == '' || $_GET['year'] == '' || $_GET['period'] == '') {
    //exit from here
    header("Location: account_balances_worksheets.php");
    exit();
}

$formValidator = new customFormValidator();
$formValidator->setFormName('myForm');
$formValidator->showErrorList();

$db->enable_jquery_ui();
$db->enable_rxjs_lite();
$db->show_header();
FormBuilder::buildPageLoader();

?>
<form name="myForm" id="myForm" method="post" action="" onsubmit=""
    <?php $formValidator->echoFormParameters(); ?>>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-md-block"></div>
            <div class="col-12 col-md-10">
                <div class="row">
                    <div class="col alert alert-primary text-center font-weight-bold">
                        Worksheet
                        AsAt: <?php echo $_GET['asat'] . " Year:" . $_GET['year'] . " Period:" . $_GET['period']; ?>
                    </div>
                </div>


                <div class="row">

                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Agent Code</th>
                            <th scope="col">Account Code</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Max Due Days</th>
                            <th scope="col">Total O/S Amount</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM es_worksheets 
                        WHERE 
                        esws_type = 'SMS_Account_Balances'
                        AND esws_as_at_date = '" . $db->convertDateToUS($_GET['asat']) . "'
                        AND esws_year = '" . $_GET['year'] . "'
                        AND esws_period = '" . $_GET['period'] . "'
                        ORDER BY esws_text_02 ASC, esws_text_04 ASC";
                        $result = $db->query($sql);
                        $i = 0;
                        while ($row = $db->fetch_assoc($result)) {
                            $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $row['esws_status']; ?></td>
                                <td><?php echo $row['esws_text_01']; ?></td>
                                <td><?php echo $row['esws_text_03']; ?></td>
                                <td><?php echo $row['esws_text_04']; ?></td>
                                <td><?php echo $row['esws_int_02']; ?></td>
                                <td><?php echo $row['esws_double_02']; ?></td>
                                <td>
                                    <span class="form-group">
                                        <input type="hidden" name="row_<?php echo $i; ?>"
                                               id="row_<?php echo $i; ?>"
                                               value="<?php echo $row['esws_worksheet_ID']; ?>">
                                        <?php
                                        $checked = '';
                                        if ($_POST['chk_'.$i] == ''){
                                            $checked = 'checked';
                                        }
                                        else {
                                            if ($_POST['chk_'.$i] == 1) {
                                                $checked = 'checked';
                                            }
                                        }
                                        ?>
                                        <input class="form-control" type="checkbox" id="chk_<?php echo $i; ?>"
                                               name="chk_<?php echo $i; ?>" value="1" <?php echo $checked;?>>
                                    </span>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-5 d-none d-sm-block col-form-label"></label>
                    <div class="col-sm-7">
                        <input name="action" type="hidden" id="action" value="lock">

                        <input name="asat" type="hidden" id="asat" value="<?php echo $_GET['asat'];?>">
                        <input name="year" type="hidden" id="year" value="<?php echo $_GET['year'];?>">
                        <input name="period" type="hidden" id="period" value="<?php echo $_GET['period'];?>">

                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('account_balances_worksheets.php')">
                        <input type="submit" name="update" id="update"
                               value="Update Records"
                               class="btn btn-primary">
                    </div>
                </div>
            </div>
            <div class="col-1 d-none d-md-block"></div>
        </div>


    </div>
</form>
<?php

$formValidator->output();
$db->show_footer();
?>
