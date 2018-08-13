<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 8:17 PM
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Stock Month List";

$db->show_empty_header();

$sql = 'SELECT * FROM stock WHERE stk_product_ID = '.$_GET["pid"];
$result = $db->query($sql);
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Month</th>
                        <th scope="col">Total +/-&nbsp;&nbsp;&nbsp;&nbsp;<a href="stock_transaction.php?pid=<?php echo $_GET['pid'];?>">
                                <i class="fas fa-plus-circle"></i>
                            </a></th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>January</th>
                        <td>0</td>
                    </tr>
                    <tr>
                        <th>February</th>
                        <td>0</td>
                    </tr>
                    <tr>
                        <th>March</th>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<script>

</script>
<?php
$db->show_empty_footer();
?>
