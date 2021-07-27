<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 17/7/2021
 * Time: 10:07 μ.μ.
 */

include("../include/main.php");
include('../scripts/form_validator_class.php');
include('../scripts/form_builder_class.php');

$db = new Main(1);
$db->admin_title = "Settings Imitate User";

//only allow admins or users that usr_allow_imitate = 1
if ($db->originalUserData['usr_user_rights'] == 0 || $db->originalUserData['usr_allow_imitate'] == 1){
    //allow
}
else {
    header("Location:".$main['site_url']."/home.php");
    exit();
}

if ($_POST['action'] == 'submit') {
    if ($db->imitationMode === true){
        $user = $db->originalUserData['usr_users_ID'];
    }
    else {
        $user = $db->user_data['usr_users_ID'];
    }
    $db->db_tool_update_row('users',$_POST,'usr_users_ID = '.$user,$user,'fld_','execute','usr_');
    header("Location: imitate_user.php");
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

<div class="container">
    <form name="myForm" id="myForm" method="post" action="" onsubmit=""
        <?php $formValidator->echoFormParameters(); ?>>

        <div class="row">
            <div class="col alert alert-primary text-center font-weight-bold">
                Imitate User
            </div>
        </div>

        <div class="form-group row">
            <div class="col col-sm-12 col-md-3">
                User to imitate
            </div>
            <div class="col col-sm-12 col-md-6">
                <?php
                if ($db->imitationMode === true){
                    $mySelf = $db->originalUserData['usr_users_ID'];
                    $imitateID = $db->originalUserData['usr_imitate_user'];
                }
                else {
                    $mySelf = $db->user_data['usr_users_ID'];
                    $imitateID = $db->user_data['usr_imitate_user'];
                }
                $sql = 'SELECT 
                            usr_users_ID as value,
                            usr_name as name
                            FROM users 
                            WHERE usr_users_ID <> '.$mySelf.' 
                            AND usr_user_rights > '.$db->originalUserData['usr_user_rights'].' 
                            ORDER BY usr_name';
                $usersResult = $db->query($sql);
                $formB = new FormBuilder();
                $formB->setFieldName('fld_imitate_user')
                    ->setFieldType('select')
                    ->setInputValue($imitateID)
                    ->setInputSelectQuery($usersResult)
                    ->setInputSelectAddTopOption('Disable','0')
                    ->buildInput();
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="col text-center">
                <input type="hidden" id="action" name="action" value="submit">
                <input type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary">
            </div>
        </div>

    </form>
</div>

<?php
$db->show_footer();
?>
