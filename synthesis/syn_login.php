<?php
include("../include/main.php");
include("synthesis_class.php");

$db = new Main(0);


if ($db->get_setting("under_construction") == 1) {
    echo "<div align=\"center\">Website is under construction. <br> Please try again in a few moments.</div>";
    exit();
}
if ($_GET["action"] == "logout") {

    unset($_SESSION[$main['environment']."_logged_in"]);
    unset($_SESSION[$main['environment']."_usernm"]);
    unset($_SESSION[$main['environment']."_userpswd"]);
    unset($_SESSION[$main['environment']."_description"]);
    unset($_SESSION[$main['environment']."_menu"]);
    unset($_SESSION[$main['environment']."_status"]);
    $_GET["error"] = "You are logged out.";
    $_SESSION["prev_url"] = "";
    header("Location: syn_login.php?action=".$_GET["error"]);
    exit();
}

//if the user is already logged in
if ($_SESSION[$main["environment"]."_logged_in"] == true) {
    header("Location: ../home.php");
    exit();
}

if ($_POST["action"] == "login") {

    unset($_SESSION[$main['environment']."_logged_in"]);
    unset($_SESSION[$main['environment']."_usernm"]);
    unset($_SESSION[$main['environment']."_userpswd"]);

    $syn = new Synthesis(false);
    $syn->loginWebUser($_POST['username'],$_POST['password']);
    if ($syn->error == true){
        $db->generateAlertError($syn->errorDescription);
    }
    if ($syn->error == false){
        header("Location: ../home.php");
        exit();
    }

}//login user
$db->show_header();

if ($_GET['error'] != '') {
    ?>
    <div class="container">
        <div class="row col-12 alert alert-danger">
            <?php echo $_GET["error"]; ?>
        </div>
    </div>
    <?php
}
    ?>

    <div class="container">
        <div class="col-lg-4 col-xs-12">
            <form action="syn_login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="UsernameHelp" placeholder="Enter Username">
                    <small id="UsernameHelp" class="form-text text-muted">Please provide your Username</small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <input name="action" type="hidden" id="action" value="login" />
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>




<?php
$db->show_footer();
?>
