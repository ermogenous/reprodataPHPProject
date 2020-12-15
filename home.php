<?php
include("include/main.php");
if ($main['environment'] == 'synthesis'){

    include('synthesis/synthesis_class.php');
    $syn = new Synthesis();
    $db = new Main(0);

}
else {
    $db = new Main(1);
}

//check if in the layout folder home.php file exists.
if (is_file($main["local_url"]."/layout/".$db->admin_default_layout."/home.php")){
    include_once($main["local_url"]."/layout/".$db->admin_default_layout."/home.php");
    exit();
}




$db->show_header();
?>

<div class="container-fluid" style="">

    <div class="row">

        <div class="col-3"></div>
        <div class="col-2 text-center">
            <a href="products/products.php">
                <i class="fas fa-box-open fa-10x" title="Products"></i>
            </a>
        </div>
        <div class="col-2 text-center">
            <a href="agreements/agreements.php">
                <i class="far fa-handshake fa-10x" title="Agreements"></i>
            </a>
        </div>
        <div class="col-2 text-center">
            <a href="customers/customers.php">
                <i class="fas fa-users fa-10x" title="Customers"></i>
            </a>
        </div>
        <div class="col-3"></div>

    </div>
    <div class="row" style="height: 30px"></div>
    <div class="row">

        <div class="col-3"></div>

        <div class="col-2 text-center">
            <a href="stock/stock_transaction.php">
                <i class="fas fa-bars fa-10x" title="Stock"></i>
            </a>
        </div>
        <div class="col-2 text-center">
            <i class="fas fa-phone-volume fa-10x" title=""></i>
        </div>
        <div class="col-2 text-center">

        </div>
        <div class="col-3"></div>

    </div>


</div>

<br/>
<noscript>
    For full functionality of this site it is necessary to enable JavaScript.
    Here are the <a href="http://www.enable-javascript.com/" target="_blank">
        instructions how to enable JavaScript in your web browser</a>.
</noscript>
<?php
$db->show_footer();
?>
