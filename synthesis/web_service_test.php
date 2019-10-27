<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 18/10/2019
 * Time: 3:47 ΜΜ
 */

include('../include/main.php');
include('synthesis_class.php');

$db = new Main(0);

$syn = new Synthesis();




if ($syn->error == false){
    $db->generateAlertSuccess('Succesfully Connected to SyBase');
}
else {
    $db->generateAlertError($syn->errorDescription);
}

$db->show_header();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <button class="btn btn-success" onclick="getAccountList();">Get Account List</button>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-2">
            <strong>Account Code</strong>
        </div>
        <div class="col-3">
            <strong>A/C Name</strong>
        </div>
        <div class="col-3">
            <strong>Address Name</strong>
        </div>
        <div class="col-2"></div>
    </div>
    <?php
    if ($_GET['action'] == 'getAccountList') {
        $accountList = $syn->getAccountList();
        for($i=0; $i <= $accountList['totalRows']; $i++){
        ?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-2">
                <?php echo $accountList['rows'][$i]['ccac_acct_code'];?>
            </div>
            <div class="col-3">
                <?php echo $accountList['rows'][$i]['ccac_long_desc'];?>
            </div>
            <div class="col-3">
                <?php echo $accountList['rows'][$i]['ccad_long_desc'];?>
            </div>
            <div class="col-2"></div>
        </div>

        <?php
        }
    }
    ?>
</div>

<script>
    function getAccountList(){
        window.location.assign('web_service_test.php?action=getAccountList');
    }
</script>
<?php
$syn->logout();
$db->show_footer();
?>