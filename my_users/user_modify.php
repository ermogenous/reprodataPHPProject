<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 15-May-19
 * Time: 10:56 AM
 */


include("../include/main.php");
$db = new Main();
$db->admin_title = "My Users Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');

    $db->working_section = 'Check max users on user insert';
    $totalUsers = $db->query_fetch('SELECT COUNT(*)as clo_total_users FROM users WHERE usr_active = 1');
    if ($totalUsers['clo_total_users'] >= $db->decrypt($db->get_setting('user_max_user_accounts'))){
        $db->generateAlertError('Reached max capacity of users. Contact Administrator');
        foreach ($_POST as $name => $value){
            if (substr($name,0,4) == 'fld_'){
                $data['usr_'.substr($name,4)] = $_POST['fld_'.substr($name,4)];
            }
        }

    }
    else {
        $db->working_section = 'My Users Insert';
        $db->db_tool_insert_row('users', $_POST, 'fld_',0, 'usr_');
        header("Location: users.php");
        exit();
    }




} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');

    $db->working_section = 'Check max users on user insert';
    $totalUsers = $db->query_fetch('SELECT COUNT(*)as clo_total_users FROM users WHERE usr_active = 1');
    if ($totalUsers['clo_total_users'] > $db->decrypt($db->get_setting('user_max_user_accounts'))){
        $db->generateAlertError('Reached max capacity of users['.$totalUsers['clo_total_users'].' of '.$db->decrypt($db->get_setting('user_max_user_accounts')).']  Contact Administrator');
    }
    else {
        $db->working_section = 'My Users Modify';
        $db->db_tool_update_row('users', $_POST, "`usr_users_ID` = " . $_POST["lid"],
            $_POST["lid"], 'fld_', 'execute', 'usr_');
        header("Location: users.php");
        exit();
    }

}


if ($_GET["lid"] != "") {
    $db->working_section = 'My Users Get data';
    $sql = "SELECT * FROM `users` WHERE `usr_users_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);

    //check if the user is allowed to modify this user.
    if ($db->user_data['usr_user_rights'] > $data['usr_user_rights']){
        header("Location: users.php");
        exit();
    }


}
else {
    $data['usr_active'] = 1;
}

include('../scripts/form_validator_class.php');
$formValidator = new customFormValidator();

//echo $db->encrypt('21');

$db->show_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <form name="myForm" id="myForm" method="post" action=""
                <?php $formValidator->echoFormParameters(); ?>>
                <div class="alert alert-dark text-center">
                    <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                        &nbsp;User</b>
                </div>

                <div class="form-group row">
                    <label for="fld_active" class="col-sm-4 col-form-label">Active</label>
                    <div class="col-sm-8">
                        <select name="fld_active" id="fld_active"
                                class="form-control">
                            <option value="1" <?php if ($data['usr_active'] == 1) echo 'selected';?>>Active</option>
                            <option value="0" <?php if ($data['usr_active'] == 0) echo 'selected';?>>In-active</option>
                        </select>
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_active",
                            "fieldDataType" => "select",
                            "required" => true,
                            "invalidText" => "Choose an option",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input name="fld_name" type="text" id="fld_name"
                               class="form-control"
                               value="<?php echo $data["usr_name"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_name",
                            "fieldDataType" => "text",
                            "required" => true,
                            "invalidText" => "Enter Name",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_username" class="col-sm-4 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input name="fld_username" type="text" id="fld_username"
                               class="form-control"
                               value="<?php echo $data["usr_username"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_username",
                            "fieldDataType" => "text",
                            "required" => true,
                            "invalidText" => "Enter Username",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_password" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input name="fld_password" type="text" id="fld_password"
                               class="form-control"
                               value="<?php echo $data["usr_password"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_password",
                            "fieldDataType" => "text",
                            "required" => true,
                            "invalidText" => "Enter Password",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password2" class="col-sm-4 col-form-label">Re-Enter Password</label>
                    <div class="col-sm-8">
                        <input name="password2" type="text" id="password2"
                               class="form-control"
                               value="<?php echo $data["usr_password"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "password2",
                            "fieldDataType" => "text",
                            "required" => true,
                            "invalidText" => "Re-Enter Password same as above",
                        ]);
                        $formValidator->addCustomCode("
                            if ($('#fld_password').val() == $('#password2').val()){
                                $('#password2').addClass('is-valid');
                                $('#password2').removeClass('is-invalid');
                                $('#password2-invalid-text').hide();
                            }
                            else {
                                $('#password2').addClass('is-invalid');
                                $('#password2').removeClass('is-valid');
                                $('#password2-invalid-text').show();
                                FormErrorFound = true;
                            }
                        ");
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input name="fld_email" type="text" id="fld_email"
                               class="form-control"
                               value="<?php echo $data["usr_email"]; ?>">
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_email",
                            "fieldDataType" => "email",
                            "validateEmail" => true,
                            "required" => false,
                            "invalidText" => "Enter Email",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_user_rights" class="col-sm-4 col-form-label">User Rights</label>
                    <div class="col-sm-8">
                        <select name="fld_user_rights" id="fld_user_rights" class="form-control">
                            <option value="">Select User Rights</option>
                            <option value="2" <?php if ($data["usr_user_rights"] == 2) echo "selected=\"selected\""; ?>>
                                Advanced Users
                            </option>
                            <option value="3" <?php if ($data["usr_user_rights"] == 3) echo "selected=\"selected\""; ?>>
                                Normal Users/Internal
                            </option>
                            <option value="4" <?php if ($data["usr_user_rights"] == 4) echo "selected=\"selected\""; ?>>
                                Agents
                            </option>
                        </select>
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_user_rights",
                            "fieldDataType" => "select",
                            "required" => true,
                            "invalidText" => "Select User Rights",
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fld_users_groups_ID" class="col-sm-4 col-form-label">Group</label>
                    <div class="col-sm-8">
                        <select name="fld_users_groups_ID" id="fld_users_groups_ID" class="form-control">
                            <option value=""></option>
                            <?php
                            $res = $db->query("SELECT * FROM `users_groups`");
                            while ($ug = $db->fetch_assoc($res)) {
                                ?>
                                <option value="<?php echo $ug["usg_users_groups_ID"]; ?>" <?php if ($data["usr_users_groups_ID"] == $ug["usg_users_groups_ID"]) echo "selected=\"selected\""; ?>><?php echo $ug["usg_group_name"]; ?></option>
                            <?php } ?>
                        </select>
                        <?php
                        $formValidator->addField([
                            "fieldName" => "fld_users_groups_ID",
                            "fieldDataType" => "select",
                            "required" => true,
                            "invalidText" => "Select Group",
                        ]);
                        ?>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <input name="action" type="hidden" id="action"
                               value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                        <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                        <input type="button" value="Back" class="btn btn-secondary"
                               onclick="window.location.assign('users.php')">
                        <input type="submit" name="Submit" id="Submit"
                               value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> User"
                               class="btn btn-secondary">
                    </div>
                </div>

            </form>
        </div>
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
    </div>
</div>

<?php
$formValidator->output();
$db->show_footer();
?>
