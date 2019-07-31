<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 29/7/2019
 * Time: 10:23 ΠΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
$db = new Main();

if ($_GET['lid'] == ''){
    header("Location: underwriters.php");
    exit();
}

//get underwriter
$sql = "
    SELECT * FROM
    ina_underwriters
    JOIN users ON usr_users_ID = inaund_user_ID
    WHERE
    inaund_underwriter_ID = ".$_GET['lid'];
$data = $db->query_fetch($sql);


$table = new draw_table('ina_underwriter_companies','');
$table->extra_from_section = ' JOIN ina_insurance_companies ON inaunc_insurance_company_ID = inainc_insurance_company_ID';
$table->extra_from_section .= ' JOIN ina_underwriters ON inaunc_underwriter_ID = inaund_underwriter_ID';
$table->extra_from_section .= ' JOIN users ON usr_users_ID = inaund_user_ID';
$table->extras = 'inaunc_underwriter_ID = '.$_GET['lid'];
$table->extras .= ' AND inaunc_status = "Active"';
$table->generate_data();

$db->show_header();
?>
    <div class="container">

        <div class="row alert alert-primary">
            <div class="col-12 text-center">Insurance Companies & Commissions for <?php echo $data['usr_name'];?></div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="alert alert-success">
                    <td align="center"><?php $table->display_order_links('ID', 'inaunc_underwriter_company_ID'); ?></td>
                    <td align="left"><?php $table->display_order_links('Company', 'inainc_name'); ?></td>
                    <td align="left"><?php $table->display_order_links('Status', 'inaunc_status'); ?></td>
                    <td align="center"><?php $table->display_order_links('Motor', 'inaunc_commission_motor'); ?></td>
                    <td align="center"><?php $table->display_order_links('Fire', 'inaunc_commission_fire'); ?></td>
                    <td align="center"> </td>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $table->fetch_data()) {
                    ?>
                    <tr onclick="editLine(<?php echo $row["inaunc_underwriter_company_ID"]; ?>);">
                        <th scope="row"><?php echo $row["inaunc_underwriter_company_ID"]; ?></th>
                        <td align="left"><?php echo $row["inainc_name"]; ?></td>
                        <td align="left"><?php echo $row["inaunc_status"]; ?></td>
                        <td align="center"><?php echo $row["inaunc_commission_motor"]; ?></td>
                        <td align="center"><?php echo $row["inaunc_commission_fire"]; ?></td>
                        <td width="59" align="center"><a
                                href="underwriter_company_modify.php?lid=<?php echo $row["inaunc_underwriter_company_ID"]; ?>">Modify</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3" align="left"><a href="underwriters.php">Back</a></td>
                    <td colspan="3" align="center">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('underwriter_company_modify.php?lid=' + id);
            }
        }
    </script>
<?php
$db->show_footer();
?>