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

$periodTotals = $stock->getTotalsOfAllPeriods();
?>


<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">Month</th>
                        <th scope="col" class="text-center">Total +/-</th>
                        <th>Month</th>
                        <th>Total +/-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th class="<?php greenCurrentMonth(1);?>">January</th>
                        <td class="text-center <?php greenCurrentMonth(1);?>"><?php echo $periodTotals[1]; ?></td>
                        <th class="<?php greenCurrentMonth(2);?>">February</th>
                        <td class="text-center <?php greenCurrentMonth(2);?>"><?php echo $periodTotals[2];?></td>
                    </tr>
                    <tr>
                        <th class="<?php greenCurrentMonth(3);?>">March</th>
                        <td class="text-center <?php greenCurrentMonth(3);?>"><?php echo $periodTotals[3];?></td>
                        <th class="<?php greenCurrentMonth(4);?>">April</th>
                        <td class="text-center <?php greenCurrentMonth(4);?>"><?php echo $periodTotals[4];?></td>
                    </tr>
                    <tr>
                        <th class="<?php greenCurrentMonth(5);?>">May</th>
                        <td class="text-center <?php greenCurrentMonth(5);?>"><?php echo $periodTotals[5];?></td>
                        <th class="<?php greenCurrentMonth(6);?>">June</th>
                        <td class="text-center <?php greenCurrentMonth(6);?>"><?php echo $periodTotals[6];?></td>
                    </tr>
                    <tr>
                        <th class="<?php greenCurrentMonth(7);?>">July</th>
                        <td class="text-center <?php greenCurrentMonth(7);?>"><?php echo $periodTotals[7];?></td>
                        <th class="<?php greenCurrentMonth(8);?>">August</th>
                        <td class="text-center <?php greenCurrentMonth(8);?>"><?php echo $periodTotals[8];?></td>
                    </tr>
                    <tr>
                        <th class="<?php greenCurrentMonth(9);?>">September</th>
                        <td class="text-center <?php greenCurrentMonth(9);?>"><?php echo $periodTotals[9];?></td>
                        <th class="<?php greenCurrentMonth(10);?>">October</th>
                        <td class="text-center <?php greenCurrentMonth(10);?>"><?php echo $periodTotals[10];?></td>
                    </tr>
                    <tr>
                        <th class="<?php greenCurrentMonth(11);?>">November</th>
                        <td class="text-center <?php greenCurrentMonth(11);?>"><?php echo $periodTotals[11];?></td>
                        <th class="<?php greenCurrentMonth(12);?>">December</th>
                        <td class="text-center <?php greenCurrentMonth(12);?>"><?php echo $periodTotals[12];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-10 text-center text-success">
                        Current Stock <?php echo $stock->currentStock; ?>
                    </div>
                    <div class="col-2 text-right">
                        <a href="stock_transaction.php?pid=<?php echo $_GET['pid']; ?>">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<script>

</script>
<?php
$db->show_empty_footer();

function greenCurrentMonth($month){
    global $stock;
    if ($stock->currentMonth == $month) {
        echo "text-success";
    }
}
?>
