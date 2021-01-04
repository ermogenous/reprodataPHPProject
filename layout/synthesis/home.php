<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:19 ΜΜ
 */

//header("Location:synthesis/accounts/accounts.php");
//exit();

include_once("include/main.php");
include_once("../../synthesis/synthesis_class.php");
$db = new Main(0);

$syn = new Synthesis();

$db->show_header();
?>
    <br>
    <div class="container">
        <div class="row">
            <?php
            if (strpos($_SESSION['synthesis_menu'], 'AC,') !== false) {
                ?>
                <div class="col-4 text-center">
                    <a href="<?php echo $main['site_url']; ?>/synthesis/accounts/accounts.php">
                        <i class="fas fa-file-invoice-dollar fa-5x"></i>
                        <br>View Accounts
                    </a>
                </div>
                <?php
            }
            ?>

            <?php
            if (strpos($_SESSION['synthesis_menu'], 'ST,') !== false) {
                ?>
                <div class="col-4">
                    <a href="<?php echo $main['site_url']; ?>/synthesis/inventory/inventory.php">
                        <i class="fas fa-warehouse fa-5x"></i>
                        <br>View Inventory
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="col-4"></div>
        </div>
    </div>
<?php
$db->show_footer();
