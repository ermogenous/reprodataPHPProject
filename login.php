<?php
include("include/main.php");

$db = new Main(0);

//unset ($_SESSION);

if ($db->get_setting("under_construction") == 1) {
	echo "<div align=\"center\">Website is under construction. <br> Please try again in a few moments.</div>";
	exit();
}

if ($db->admin_default_layout == 'synthesis'){
    header("Location:" . $main["site_url"] . "/synthesis/syn_login.php");
    exit();
}









if ($_GET["action"] == "logout") {

	$_SESSION[$main["environment"]."_admin_username"] = "";
	$_SESSION[$main["environment"]."_admin_password"] = "";
	unset($_SESSION[$main["environment"]."_admin_username"],$_SESSION[$main["environment"]."_admin_password"]);
	$_GET["error"] = "You are logged out.";
	$_SESSION["prev_url"] = "";
	header("Location: login.php?action=".$_GET["error"]);
	exit();
}

if ($_SESSION[$main["environment"]."_admin_username"] != "" && $_SESSION[$main["environment"]."_admin_password"] != "") {
	header("Location: home.php");
	exit();
}

if ($_POST["action"] == "login") {
//echo $_SESSION["failed_login_attempt"]." - ".$_SESSION["failed_login_attempt_last_time"]." - ".mktime()."(".(mktime() - $_SESSION["failed_login_attempt_last_time"]).")";
	if ($db->check_persistent_logins() == 0) {

		$sql = "SELECT * FROM `users` WHERE 1=1 AND `usr_password` = '".addslashes($_POST["password"])."' AND `usr_username` = '".addslashes($_POST["username"])."'";
		$result = $db->query($sql);
		if ($db->num_rows($result) > 0) {
			$row = $db->fetch_assoc($result);
			//check if active
            if ($row['usr_active'] == 1) {

                $_SESSION[$main["environment"] . "_admin_username"] = $_POST["username"];
                $_SESSION[$main["environment"] . "_admin_password"] = $_POST["password"];


                if ($_GET["goto"] == 1) {
                    header("Location: " . $_GET["gotourl"]);
                    exit();
                }
                if ($_SESSION["prev_url"] != "") {
                    $loc = $_SESSION["prev_url"];
                } else {
                    $loc = "home.php?";
                }

                header("Location: " . $loc);
                exit();
            }
            else {
                //user inactive/suspended
                $_GET['error'] = 'You account is suspended. Please contact the administrator.';
            }
		}//if correct
		else {
			$_SESSION["failed_login_attempt"]++;
			$_SESSION["failed_login_attempt_last_time"] = time();
			$_GET["error"] = "Invalid username and/or password. Try again.";
		}

	}
	else {
		header("Location:login.php");
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
if ($db->check_persistent_logins() == 0) {
?>

    <div class="container">
        <div class="col-lg-4 col-xs-12">
            <form action="" method="post">
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
}
else {
    $timeRemaining = 300 - (time() - $_SESSION["failed_login_attempt_last_time"]);
?>
<div align="center">More than 5 tries not allowed. Try again later in <?php echo $timeRemaining;?> seconds</div>
<?php }
$db->show_footer();
?>
