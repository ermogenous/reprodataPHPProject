<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 05/05/2020
 * Time: 11:06
 */

include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Report - Actuary";

$db->show_header();
?>
    <div class="container">

        <div class="list-group">
            <a href="policy_transactions.php" class="list-group-item list-group-item-action">
                Policy Transactions
            </a>
        </div>

    </div>
<?php
$db->show_footer();
?>