<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 31/7/2019
 * Time: 4:35 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Log File View";

if ($db->user_data['usr_user_rights'] > 0){
    header("Location: ../home.php");
    exit();
}


if ($_GET['lid'] != ''){
    $data = $db->query_fetch('SELECT * 
      FROM 
      log_file 
      JOIN users ON usr_users_ID = lgf_user_ID
      WHERE lgf_log_file_ID = '.$_GET['lid']);
}
else {
    header("Location: ../home.php");
    exit();
}

$db->show_header();
?>

<div class="container">
    <div class="row">
        <div class="col-12 alert alert-primary text-center">
            Log File Record <?php echo $data['usr_users_ID']." - ".$db->convert_date_format($data['lgf_date_time'],'yyyy-mm-dd','dd/mm/yyyy',1,1);?>
        </div>
    </div>

    <div class="row">
        <div class="col-2"><strong>User:</strong></div>
        <div class="col-4"><?php echo $data['lgf_user_ID']." - ".$data['usr_name'];?></div>
        <div class="col-2"><strong>IP</strong></div>
        <div class="col-4"><?php echo $data['lgf_ip'];?></div>
    </div>

    <div class="row">
        <div class="col-2"><strong>Date/Time:</strong></div>
        <div class="col-4"><?php echo $db->convert_date_format($data['lgf_date_time'],'yyyy-mm-dd','dd/mm/yyyy',1,1);?></div>
        <div class="col-2"><strong>Table Name</strong></div>
        <div class="col-4"><?php echo $data['lgf_table_name'];?></div>
    </div>

    <div class="row">
        <div class="col-2"><strong>Row Serial:</strong></div>
        <div class="col-4"><?php echo $data['lgf_row_serial'];?></div>
        <div class="col-2"><strong>Action</strong></div>
        <div class="col-4"><?php echo $data['lgf_action'];?></div>
    </div>

    <div class="row" style="height: 25px;"></div>

    <div class="row">
        <div class="col-2"><strong>New Values:</strong></div>
        <div class="col-10"><?php echo $db->prepare_text_as_html($data['lgf_new_values']);?></div>
    </div>

    <div class="row" style="height: 25px;"></div>

    <div class="row">
        <div class="col-2"><strong>Old Values</strong></div>
        <div class="col-10"><?php echo $db->prepare_text_as_html($data['lgf_old_values']);?></div>
    </div>

    <div class="row" style="height: 25px;"></div>

    <div class="row">
        <div class="col-2"><strong>Description</strong></div>
        <div class="col-10"><?php echo $db->prepare_text_as_html($data['lgf_description']);?></div>
    </div>
</div>


<?php
$db->show_footer();
?>