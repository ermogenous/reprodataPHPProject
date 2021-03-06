<?php
include("../../include/main.php");
include("../../include/tables.php");

$db = new Main(1,'UTF-8');
$db->admin_title = "Accounts";

$db->show_header();

$table = new draw_table('ac_accounts','acacc_code','ASC');
$table->extra_select_section = ', type.actpe_name as clo_type, subtype.actpe_name as clo_sub_type';
$table->extra_from_section = ' LEFT OUTER JOIN ac_account_types as type ON acacc_account_type_ID = type.actpe_account_type_ID';
$table->extra_from_section .= ' LEFT OUTER JOIN ac_account_types as subtype ON acacc_account_sub_type_ID = subtype.actpe_account_type_ID';
$table->per_page = 100;
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
                        <th scope="col"><?php $table->display_order_links('Ctrl/A/c','acacc_control');?></th>
                        <th scope="col"><?php $table->display_order_links('Name','acacc_name');?></th>
                        <th scope="col"><?php $table->display_order_links('Type','clo_type');?></th>
                        <th scope="col"><?php $table->display_order_links('Sub Type','clo_sub_type');?></th>
                        <th scope="col"><?php $table->display_order_links('Active','acacc_active');?></th>
                        <th scope="col" width="85">
                            <a href="accounts_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        $class = '';
                        if ($row['acacc_control'] == 1){
                            $class .= 'alert alert-secondary';
                        }
                        if($row["acacc_active"] != 'Active'){
                            $class .= "alert alert-danger";
                        }

                        if ($row['acacc_account_sub_type_ID'] == -1){
                            $subType = 'Control Account';
                        }
                        else {
                            $subType = substr($row["clo_sub_type"],0,25);
                            if (strlen($row["clo_sub_type"]) > 25){
                                $subType .= '...';
                            }
                        }
                        ?>
                        <tr class="<?php echo $class; ?>" onclick="editLine(<?php echo $row["acacc_account_ID"]; ?>);">
                            <th scope="row"><?php echo $row["acacc_code"];?></td>
                            <td><?php echo $row["acacc_control"] == 1? 'Control' : 'Account';?></td>
                            <td><?php echo $row["acacc_name"];?></td>
                            <td><?php echo $row["clo_type"];?></td>
                            <td><?php echo $subType; ?></td>
                            <td><?php echo $row["acacc_active"];?></td>
                            <td>
                                <a href="accounts_modify.php?lid=<?php echo $row["acacc_account_ID"];?>"><i class="fas fa-edit"></i></a>&nbsp
                                <a href="accounts_delete.php?lid=<?php echo $row["acacc_account_ID"];?>"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this Account?');"><i class="fas fa-minus-circle"></i></a>
                            </td>
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

    var ignoreEdit = false;
    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign('accounts_modify.php?lid=' + id);
        }
    }
</script>
<?php
$db->show_footer();
?>
