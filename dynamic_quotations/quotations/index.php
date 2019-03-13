<?php
include("../../include/main.php");
$db = new Main();

$db->show_header();

?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center" style="height: 40px;">
            <b>Quotations Administration</b>
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-3 text-right">
            <button class="btn btn-primary" onclick="window.location.assign('quotations_types.php')">
                View Quotations Types
            </button>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" onclick="window.location.assign('items.php')">
                View Quotations Items
            </button>
        </div>
        <div class="col-3"></div>
    </div>
</div>
<?php
$db->show_footer();
?>