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
        <div class="col-2"></div>
        <div class="col-3 text-right">
            <button class="btn btn-primary" onclick="window.location.assign('quotations_types.php')">
                View Quotations Types
            </button>
        </div>
        <div class="col-3 text-left">
            <button class="btn btn-primary" onclick="window.location.assign('items.php')">
                View Quotations Items
            </button>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-primary" onclick="window.location.assign('underwriters.php')">
                Underwriters
            </button>
        </div>
    </div>
</div>
<?php
$db->show_footer();
?>