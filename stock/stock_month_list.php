<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 8:17 PM
 */

include("../include/main.php");
include("../include/tables.php");
include('stock.class.php');

$db = new Main(1, 'UTF-8');
$db->admin_title = "Stock Month List";


if ($_GET['pid'] > 0) {
    $stock = new Stock($_GET['pid']);
} else {

    $db->alertError('Must supply product');
    $db->show_header();
    $db->show_footer();
    exit();

}

$db->show_empty_header();

echo $stock->closePeriod();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="table-responsive">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-right text-success">Current Stock - <?php echo $stock->currentStock; ?></div>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">Month</th>
                        <th scope="col" class="text-center">Total +/-&nbsp;&nbsp;</th>
                        <th scope="col" class="text-center">
                            Balance
                            <a href="stock_transaction.php?pid=<?php echo $_GET['pid']; ?>">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>January</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>February</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>March</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>April</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>May</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>June</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>July</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>August</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>September</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>October</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>November</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th>December</th>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
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
