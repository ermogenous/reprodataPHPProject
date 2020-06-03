<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 02/06/2020
 * Time: 10:56
 */

include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "";

$db->show_header();
?>

    <div class="container">
        <div class="row">
            <div class="col-12 alert alert-primary text-center">
                <b>Soeasy agent import check process</b>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="list-group">
                    <a href="import_file.php">
                        <li class="list-group-item">
                            Import File
                        </li>
                    </a>

                    <a href="validate_records.php">
                        <li class="list-group-item">
                            Validate Records
                        </li>
                    </a>

                    <a href="export_file.php">
                        <li class="list-group-item">
                            Export File
                        </li>
                    </a>

                    <a href="lapse_policies.php">
                        <li class="list-group-item">
                            Lapse Process
                        </li>
                    </a>

                    <a href="validate_lapse.php">
                        <li class="list-group-item">
                            Validate Lapsed Policies Process
                        </li>
                    </a>

                </ul>
            </div>
        </div>
    </div>

<?php
$db->show_footer();
?>