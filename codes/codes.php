<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 6/8/2018
 * Time: 12:02 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Codes";

$db->show_header();

if ($_GET['search_code'] == 'search'){
    $table = new draw_table('codes', 'cde_code_ID', 'ASC');
    $table->extras = "cde_type = '".$_GET['type']."'";
    $codeSelection = $_GET['type'];
    $table->generate_data();
}
else {

    $table = new draw_table('codes', 'cde_code_ID', 'ASC');
    $table->extras = "cde_type = 'code'";
    $codeSelection = 'code';
    $table->generate_data();
}
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <form name="codes" method="get" action="" onsubmit="">
                <div class="form-group row">
                    <div class="col-9">
                        <select name="type" id="type"
                                class="form-control">
                            <option value="code" <?php if ($data['cde_type'] == 'code') echo 'selected'; ?>>Code
                            </option>

                            <?php
                            $sql = "SELECT * FROM codes WHERE cde_type = 'code' ORDER BY cde_value_label";
                            $result = $db->query($sql);
                            while ($codes = $db->fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $codes['cde_value']; ?>"
                                    <?php if ($_GET['type'] == $codes['cde_value']) echo 'selected'; ?>
                                ><?php echo $codes['cde_value_label']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="hidden" name="search_code" id="serach_code" value="search">
                        <input type="submit" name="Submit" value="Submit" class="btn btn-secondary">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'cde_code_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'cde_value_label'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Value', 'cde_value'); ?></th>
                        <th scope="col">
                            <a href="codes_modify.php?codeSelection=<?php echo $codeSelection;?>">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($row = $table->fetch_data()) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row["cde_code_ID"]; ?></th>
                        <td><?php echo $row["cde_value_label"]; ?></td>
                        <td><?php echo $row["cde_value"]; ?></td>
                        <td>
                            <a href="codes_modify.php?lid=<?php echo $row["cde_code_ID"]; ?>&codeSelection=<?php echo $codeSelection;?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                            <a href="codes_delete.php?lid=<?php echo $row["cde_code_ID"]; ?>&codeSelection=<?php echo $codeSelection;?>"
                               onclick="return confirm('Are you sure you want to delete this code?');"><i
                                        class="fas fa-minus-circle"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>

<?php
$db->show_footer();
?>
