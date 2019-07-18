<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 16/7/2019
 * Time: 2:02 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts Categories";

$db->show_empty_header();

$table = new draw_table('ac_accounts','acacc_code','ASC');
$table->extras = 'acacc_control != 1 AND acacc_active = "Active"';

$table->generate_data();

?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-lg-block"></div>
            <div class="col-12 col-lg-10">
                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?php $table->display_order_links('Code','acacc_code');?></th>
                            <th scope="col"><?php $table->display_order_links('Type','acacc_control');?></th>
                            <th scope="col"><?php $table->display_order_links('Name','acacc_name');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            $class = '';

                            if($row["acacc_active"] != 'Active'){
                                $class .= "alert alert-danger";
                            }

                            ?>
                            <tr class="<?php echo $class; ?>" onclick="selectAccount(<?php echo $row['acacc_code'];?>);">
                                <th scope="row"><?php echo $row["acacc_code"];?></td>
                                <td><?php echo $row["acacc_control"] == 1? 'Control' : 'Account';?></td>
                                <td><?php echo $row["acacc_name"];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-1 d-none d-lg-block"></div>
        </div>
    </div>

<script>
    function selectAccount(accountCode){

        window.parent.loadAccount(accountCode);

    }
</script>

<?php
$db->show_empty_footer();
?>