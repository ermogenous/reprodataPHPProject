<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/2/2019
 * Time: 11:05 ΠΜ
 */

include("../include/main.php");
$db = new Main();
$db->admin_title = "Agents Modify";


if ($_POST["action"] == "insert") {
    $db->check_restriction_area('insert');
    $db->working_section = 'Agents Insert';

    $db->start_transaction();

    $_POST['fld_enable_commission_release'] = $db->get_check_value($_POST['fld_enable_commission_release']);

    $db->db_tool_insert_row('agents', $_POST, 'fld_', 0, 'agnt_');

    if ($db->dbSettings['accounts']['value'] == 'basic'){
        include('../basic_accounts/basic_accounts_class.php');
        $bacc = new BasicAccounts();
        $bacc->createAccountForAllAgents();
        $bacc->createReleaseAccountForAllAgents();
    }

    $db->commit_transaction();

    header("Location: agents.php");
    exit();

} else if ($_POST["action"] == "update") {
    $db->check_restriction_area('update');
    $db->working_section = 'Agents Modify';

    $db->start_transaction();

    $_POST['fld_enable_commission_release'] = $db->get_check_value($_POST['fld_enable_commission_release']);

    $db->db_tool_update_row('agents', $_POST, "`agnt_agent_ID` = " . $_POST["lid"],
        $_POST["lid"], 'fld_', 'execute', 'agnt_');

    if ($db->dbSettings['accounts']['value'] == 'basic'){
        include('../basic_accounts/basic_accounts_class.php');
        $bacc = new BasicAccounts();
        $bacc->createAccountForAllAgents();
        $bacc->createReleaseAccountForAllAgents();
        $bacc->updateAccountDetailsFromAgent($_POST['lid']);
        $bacc->updateReleaseAccountDetailsFromAgent($_POST['lid']);
    }

    $db->commit_transaction();
    header("Location: agents.php");
    exit();


}


if ($_GET["lid"] != "") {
    $db->working_section = 'Agents Get data';
    $sql = "SELECT * FROM `agents` WHERE `agnt_agent_ID` = " . $_GET["lid"];
    $data = $db->query_fetch($sql);
} else {
    $data['agnt_status'] = 'Active';
}


$db->show_header();
?>
    <div class="container">
        <form name="myForm" id="myForm" method="post" action="" onsubmit="">
            <div class="alert alert-dark text-center">
                <b><?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?>
                    &nbsp;Agent</b>
            </div>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                       role="tab"
                       aria-controls="pills-general" aria-selected="true">General</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pills-commission-types-tab" data-toggle="pill"
                       href="#pills-commission-types"
                       role="tab"
                       aria-controls="pills-commission-types" aria-selected="true">Commission Types</a>
                </li>

            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                     aria-labelledby="pills-general-tab">
                    <!-- GENERAL -->

                    <div class="form-group row">
                        <label for="fld_name" class="col-sm-1 col-form-label">Name</label>
                        <div class="col-sm-3">
                            <input name="fld_name" type="text" id="fld_name"
                                   class="form-control"
                                   value="<?php echo $data["agnt_name"]; ?>"
                                   required>
                        </div>

                        <label for="fld_status" class="col-sm-1 col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select name="fld_status" id="fld_status"
                                    class="form-control"
                                    required>
                                <option value="Active" <?php if ($data['agnt_status'] == 'Active') echo 'selected'; ?>>
                                    Active
                                </option>
                                <option value="InActive" <?php if ($data['agnt_status'] == 'InActive') echo 'selected'; ?>>
                                    In-active
                                </option>
                            </select>
                        </div>

                        <label for="fld_type" class="col-sm-1 col-form-label">Type</label>
                        <div class="col-sm-3">
                            <select name="fld_type" id="fld_type"
                                    class="form-control"
                                    required>
                                <option value=""></option>
                                <option value="Office" <?php if ($data['agnt_type'] == 'Office') echo 'selected'; ?>>
                                    Office
                                </option>
                                <option value="Agent" <?php if ($data['agnt_type'] == 'Agent') echo 'selected'; ?>>
                                    Agent
                                </option>
                                <option value="SubAgent" <?php if ($data['agnt_type'] == 'SubAgent') echo 'selected'; ?>>
                                    SubAgent
                                </option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group row">


                        <label for="fld_user_ID" class="col-sm-1 col-form-label">User</label>
                        <div class="col-sm-3">
                            <select name="fld_user_ID" id="fld_user_ID"
                                    class="form-control"
                                    required>
                                <option value=""></option>
                                <?php
                                $userResult = $db->query("SELECT * FROM users WHERE usr_active = 1 ORDER BY usr_name ASC");
                                while ($user = $db->fetch_assoc($userResult)) {

                                    ?>
                                    <option value="<?php echo $user['usr_users_ID']; ?>"
                                        <?php if ($user['usr_users_ID'] == $data['agnt_user_ID']) echo 'selected'; ?>>
                                        <?php echo $user['usr_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <label for="fld_enable_commission_release" class="col-sm-3 col-form-label">Enable Commission Release A/C</label>
                        <div class="col-sm-1 input-group input-group-text">
                            <input type="checkbox" id="fld_enable_commission_release" name="fld_enable_commission_release"
                                   class="form-control"
                                   value="1" <?php if ($data['agnt_enable_commission_release'] == 1) echo 'checked';?>>
                        </div>

                        <label for="fld_code" class="col-sm-2 col-form-label">Agent Code</label>
                        <div class="col-sm-2">
                            <input name="fld_code" type="text" id="fld_code"
                                   class="form-control"
                                   value="<?php echo $data["agnt_code"]; ?>"
                                   required>
                        </div>
                    </div>


                </div>

                <div class="tab-pane fade show" id="pills-commission-types" role="tabpanel"
                     aria-labelledby="pills-commission-types-tab">
                    <!-- GENERAL -->
                    <iframe src="commission_types.php?aid=<?php echo $_GET["lid"]; ?>"
                            frameborder="0"
                            scrolling="0" width="100%" height="400"></iframe>
                </div>

            </div>


            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label"></label>
                <div class="col-sm-8">
                    <input name="action" type="hidden" id="action"
                           value="<?php if ($_GET["lid"] == "") echo "insert"; else echo "update"; ?>">
                    <input name="lid" type="hidden" id="lid" value="<?php echo $_GET["lid"]; ?>">
                    <input type="button" value="Back" class="btn btn-secondary"
                           onclick="window.location.assign('agents.php')">
                    <input type="submit" name="Submit" id="Submit"
                           value="<?php if ($_GET["lid"] == "") echo "Insert"; else echo "Update"; ?> Agent"
                           class="btn btn-secondary" onclick="submitForm()">
                </div>
            </div>

        </form>
    </div>
    <script>
        function submitForm() {
            frm = document.getElementById('myForm');
            if (frm.checkValidity() === false) {

            }
            else {
                document.getElementById('Submit').disabled = true
            }
        }
    </script>
<?php
$db->show_footer();
?>