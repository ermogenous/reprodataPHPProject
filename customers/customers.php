<?php
include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Customers";
//$db->enable_rxjs_lite();
$db->enable_jquery_ui();
$db->show_header();

$table = new draw_table('customers', 'cst_customer_ID', 'ASC');
$table->extras = $db->CustomersWhere();
if ($_POST['search'] == 'search') {
    if ($_POST['search_field-id'] > 0){
        $table->extras .= " AND cst_customer_ID = ".$_POST['search_field-id'];
    }
    else {
        $table->extras .= " AND (cst_identity_card LIKE '%".$_POST['search_field']."%'
        OR
        cst_name LIKE '%".$_POST['search_field']."%'
        OR
        cst_surname LIKE '%".$_POST['search_field']."%'
        OR
        cst_work_tel_1 LIKE '%".$_POST['search_field']."%'
        OR
        cst_work_tel_2 LIKE '%".$_POST['search_field']."%'
        OR
        cst_fax LIKE '%".$_POST['search_field']."%'
        OR
        cst_mobile_1 LIKE '%".$_POST['search_field']."%'
        OR
        cst_mobile_2 LIKE '%".$_POST['search_field']."%')";
    }
}

$table->generate_data();
//echo $table->sql;
?>


<div class="container">

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">

            <div class="row">

                <div class="col-12">
                    <form name="myForm" id="myForm" method="post" action="" onsubmit="">
                        <div class="form-group row">
                            <label for="search_field" class="col-sm-2 col-form-label"><?php echo $db->showLangText("Search", "Αναζήτηση"); ?></label>
                            <div class="col-sm-8 ui-widget">
                                <input name="search_field" type="text" id="search_field"
                                       class="form-control"
                                       value="<?php echo $_POST['search_field'];?>">
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
                        <th scope="col"><?php $table->display_order_links('#', 'cst_customer_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText("ID", "Ταυτότητα"), 'cst_identity_card'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText("Name", "Όνομα"), 'cst_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links($db->showLangText("SurName", "Επίθετο"), 'cst_surname'); ?></th>
                        <th scope="col">
                            <a href="customers_modify.php">
                                <i class="fas fa-plus-circle" title="<?php echo $db->showLangText("Customer Modify", "Δημιουργία Νέου Πελάτη "); ?>"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["cst_customer_ID"]; ?>);">
                            <th scope="row"><?php echo $row["cst_customer_ID"]; ?></th>
                            <td><?php echo $row["cst_identity_card"]; ?></td>
                            <td><?php echo $row["cst_name"]; ?></td>
                            <td><?php echo $row["cst_surname"]; ?></td>
                            <td>
                                <a href="customers_modify.php?lid=<?php echo $row["cst_customer_ID"]; ?>"><i
                                            class="fas fa-edit" title="<?php echo $db->showLangText("Customer Modify", "Τροποποίηση Πελάτη "); ?>"></i></a>&nbsp
                                <a href="customers_delete.php?lid=<?php echo $row["cst_customer_ID"]; ?>"
                                   onclick="ignoreEdit = true; return confirm('Are you sure you want to delete this customer?');"><i
                                            class="fas fa-minus-circle" title="<?php echo $db->showLangText("Customer Delete", "Σβήσιμο Πελάτη "); ?>"></i></a>
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
            window.location.assign('customers_modify.php?lid=' + id);
        }
    }
</script>

<?php
$table->autoCompleteFieldName = 'search_field';
$table->autoCompleteSourceAPI = "customers_api.php?section=customers";
$table->showAutoCompleteJsCode();
$db->show_footer();
?>
