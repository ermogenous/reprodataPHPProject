<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 30/8/2018
 * Time: 11:39 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Agreements";
//$db->enable_rxjs_lite();
$db->enable_jquery_ui();

$db->show_header();

$table = new draw_table('agreements', 'agr_agreement_ID', 'ASC');
$table->extra_from_section = "JOIN customers ON cst_customer_ID = agr_customer_ID";

if ($_POST['search'] == 'search') {
    $db->working_section = 'Agreements Search';
    $table->extras = "cst_customer_ID = ".$_POST['search_field-id'];
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
                    <tr>
                        <th scope="col"><?php $table->display_order_links('#', 'agr_agreement_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Number', 'agr_agreement_number'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Starting Date', 'agr_starting_date'); ?></th>
                        <th scope="col">
                            <a href="customers_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["agr_agreement_ID"]; ?>);">
                            <th scope="row"><?php echo $row["agr_agreement_ID"]; ?></th>
                            <td><?php echo $row["agr_agreement_number"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td><?php echo $row["agr_starting_date"]; ?></td>
                            <td>
                                <a href="customers_modify.php?lid=<?php echo $row["agr_agreement_ID"]; ?>"><i
                                            class="fas fa-edit"></i></a>&nbsp
                                <a href="customers_delete.php?lid=<?php echo $row["agr_agreement_ID"]; ?>"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this agreement?');"><i
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
            window.location.assign('agreements_modify.php?lid=' + id);
        }
    }
</script>

<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "agreements_api.php?section=agreements_search";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>
