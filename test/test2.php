<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 13/1/2020
 * Time: 3:06 μ.μ.
 */

include("../include/main.php");

$db = new Main(1, 'UTF-8');
$db->show_header();
?>


    <div class="custom-control custom-radio">
        <input type="radio" id="customRadio1" name="something" class="custom-control-input">
        <label class="custom-control-label" for="something">Toggle this custom radio</label>
    </div>

    <div class="custom-control custom-radio">
        <input type="radio" id="customRadio2" name="something" class="custom-control-input">
        <label class="custom-control-label" for="something">Or toggle this other custom radio</label>
    </div>


<?php
$db->show_footer();
?>