<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 18/05/2020
 * Time: 11:00
 */

include("../../include/main.php");
include("../synthesis_class.php");

$db = new Main(1);
$db->admin_title = "Synthesis Accounts Transaction List";

$syn = new Synthesis();
$transactionList = $syn->getAccountTransactionList($_GET['lid']);
if ($syn->error == true){
    $db->generateAlertError($syn->errorDescription);
}

$db->show_header();

if ($syn->error == false) {
    ?>

    <div class="container">
        <div class="col-12 alert alert-primary text-center">
            <b>Account <?php echo $_GET['lid'];?> Transaction List</b>
        </div>

        <div class="row">
            <?php
            echo $db->prepare_text_as_html(print_r($transactionList,true));
            ?>
        </div>
    </div>


    <?php
}//if no error in getting transaction list
$db->show_footer();
?>