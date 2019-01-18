<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 24/8/2018
 * Time: 4:45 ΜΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main();
$db->admin_title = "Customers Products";

$db->show_empty_header();

$table = new draw_table('agreements', 'agr_agreement_ID', 'DESC');
$table->extra_from_section = "JOIN agreement_items ON agri_agreement_ID = agr_agreement_ID
                              JOIN products ON prd_product_ID = agri_product_ID";
$table->extras = 'agr_customer_ID = '.$_GET["cid"]. " AND agr_status = 'Active' AND agri_status = 'Active'";
$table->generate_data();
?>

<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'prd_product_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Machine', 'prd_model'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Agreement', 'agr_agreement_number'); ?></th>
                        <th scope="col">
                            <a href="customers_products_modify.php?lid=<?php echo $_GET['lid']; ?>">
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
                            <th scope="row"><?php echo $row["prd_product_ID"]; ?></th>
                            <td><?php echo $row["prd_model"]; ?></td>
                            <td><?php echo $row["agr_agreement_number"]; ?></td>
                            <td>
                                <a href="../agreements/agreements_modify.php?lid=<?php echo $row["agr_agreement_ID"]; ?>" target="_parent">
                                    <i class="fas fa-edit"></i></a>&nbsp
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
            parent.location.assign('../agreements/agreements_modify.php?lid=' + id );
        }
    }
</script>

<?php
$db->show_empty_footer();
?>