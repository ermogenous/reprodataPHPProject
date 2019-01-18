<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 14-Jan-19
 * Time: 5:10 PM
 */


include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Customers";
//$db->enable_rxjs_lite();
$db->enable_jquery_ui();


$db->show_header();

$table = new draw_table('customer_groups', 'csg_customer_group_ID', 'ASC');

if ($_POST['search'] == 'search') {
    if ($_POST['search_field-id'] > 0){
        $table->extras = "csg_customer_group_ID = ".$_POST['search_field-id'];
    }
    else {
        $table->extras = "
        CONCAT(csg_code, ' ', csg_description) LIKE '%".$_GET['search_field']."%'";
    }
}


$table->generate_data();
?>


    <div class="container">

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">

                <div class="row">

                    <div class="col-12">
                        <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                            <div class="form-group row">
                                <label for="search_field" class="col-sm-2 col-form-label">Search</label>
                                <div class="col-sm-8 ui-widget">
                                    <input name="search_field" type="text" id="search_field"
                                           class="form-control"
                                           value="">
                                    <input id="search_field-id" name="search_field-id" type="hidden">
                                    <input id="search" name="search" value="search" type="hidden">
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" name="Submit" id="Submit"
                                           value="Search"
                                           class="btn btn-secondary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="alert alert-success">
                            <th scope="col"><?php $table->display_order_links('ID', 'csg_customer_group_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Code', 'csg_code'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Description', 'csg_description'); ?></th>
                            <th scope="col">
                                <a href="customer_groups_modify.php">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr onclick="editLine(<?php echo $row["csg_customer_group_ID"]; ?>);">
                                <th scope="row"><?php echo $row["csg_customer_group_ID"]; ?></th>
                                <td><?php echo $row["csg_code"]; ?></td>
                                <td><?php echo $row["csg_description"]; ?></td>
                                <td>
                                    <a href="customer_groups_modify.php?lid=<?php echo $row["csg_customer_group_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                    <a href="customers_groups_delete.php?lid=<?php echo $row["csg_customer_group_ID"]; ?>"
                                       onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this customer group?');"><i
                                            class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    <script>
        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.location.assign('customer_groups_modify.php?lid=' + id);
            }
        }
    </script>

<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "customer_groups_api.php?section=customers_groups_search";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>