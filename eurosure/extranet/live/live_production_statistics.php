<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 14/5/2021
 * Time: 12:10 μ.μ.
 */

include("../../../include/main.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Extranet Live Statistics";

//$db->show_header();
$db->show_empty_header();

$lang = 'ENG';
$year = date('Y');
$period = date('m');
//echo $year . "/" . $period;

$current = $db->query_fetch(
    'SELECT
            rpgwp_agent_code,
            rpgwp_agent_description,
            SUM(rpgwp_gwp_current)as clo_gwp_current,
            SUM(rpgwp_gwp_previous)as clo_gwp_previous,
            SUM(rpgwp_gwp_motor_current)as clo_gwp_motor_current,
            SUM(rpgwp_gwp_motor_previous)as clo_gwp_motor_previous,
            SUM(rpgwp_gwp_liability_current)as clo_gwp_liability_current,
            SUM(rpgwp_gwp_liability_previous)as clo_gwp_liability_previous,
            SUM(rpgwp_gwp_property_current)as clo_gwp_property_current,
            SUM(rpgwp_gwp_property_previous)as clo_gwp_property_previous,
            SUM(rpgwp_gwp_engineering_current)as clo_gwp_engineering_current,
            SUM(rpgwp_gwp_engineering_previous)as clo_gwp_engineering_previous,
            SUM(rpgwp_gwp_misc_current)as clo_gwp_misc_current,
            SUM(rpgwp_gwp_misc_previous)as clo_gwp_misc_previous,
            SUM(rpgwp_gwp_marine_current)as clo_gwp_marine_current,
            SUM(rpgwp_gwp_marine_previous)as clo_gwp_marine_previous

            FROM report_gross_written_premium 
            WHERE rpgwp_agent_code = "' . $db->user_data['usr_agent_code'] . '"
            AND rpgwp_year = ' . $year . '
            AND rpgwp_period BETWEEN 1 AND ' . $period . '
            GROUP BY 
            rpgwp_agent_code,
            rpgwp_agent_description');

?>

<div class="container">
    <br>
    <div class="row alert alert-primary text-center font-weight-bold">
        <div class="col">
            <?php echo $db->user_data['usr_name'] . " - " . $db->user_data['usr_agent_code']; ?>
        </div>
    </div>
    <div class="row alert alert-secondary text-center font-weight-bold">
        <div class="col">
            Live Statistics
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="list-group">
                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-chart-line"></i>Last update at:
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Overall Production (Net Premium)"
                        ?>
                    </p>
                </span>
                <hr>
                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-car"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_motor_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Motor Production"
                        ?>
                    </p>
                </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-user-shield"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_liability_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Liability Production"
                        ?>
                    </p>
                </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-home"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_property_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Property Production"
                        ?>
                    </p>
                </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-wrench"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_engineering_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Engineering Production"
                        ?>
                    </p>
                </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-mortar-pestle"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_misc_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Miscellaneous Production"
                        ?>
                    </p>
                </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-anchor"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_marine_current']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . $year . " Marine Production"
                        ?>
                    </p>
                </span>

            </div>
        </div>
        <div class="col-md-6">
            <div class="list-group">
            <span class="list-group-item">
                <h3 class="pull-right">
                    <i class="fas fa-chart-line"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    <?php
                    echo $db->fix_int_to_double($current['clo_gwp_previous']);
                    echo getDifferenceProd($current['clo_gwp_current'], $current['clo_gwp_previous']);
                    ?>
                </h4>
                <p class="list-group-item-text">
                    <?php
                    echo getMonthName($period, $lang) . " " . ($year - 1) . " Overall Production (Net Premium)"
                    ?>
                </p>
            </span>
                <hr>
                <span class="list-group-item">
                <h3 class="pull-right">
                    <i class="fas fa-car"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    <?php
                    echo $db->fix_int_to_double($current['clo_gwp_motor_previous']);
                    echo getDifferenceProd($current['clo_gwp_motor_current'], $current['clo_gwp_motor_previous']);
                    ?>
                </h4>
                <p class="list-group-item-text">
                    <?php
                    echo getMonthName($period, $lang) . " " . ($year - 1) . " Motor Production"
                    ?>
                </p>
            </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-user-shield"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_liability_previous']);
                        echo getDifferenceProd($current['clo_gwp_liability_current'], $current['clo_gwp_liability_previous']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . ($year - 1) . " Liability Production"
                        ?>
                    </p>
            </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-home"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_property_previous']);
                        echo getDifferenceProd($current['clo_gwp_property_current'], $current['clo_gwp_property_previous']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . ($year - 1) . " Property Production"
                        ?>
                    </p>
            </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-wrench"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_engineering_previous']);
                        echo getDifferenceProd($current['clo_gwp_engineering_current'], $current['clo_gwp_engineering_previous']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . ($year - 1) . " Engineering Production"
                        ?>
                    </p>
            </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-mortar-pestle"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_misc_previous']);
                        echo getDifferenceProd($current['clo_gwp_misc_current'], $current['clo_gwp_misc_previous']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . ($year - 1) . " Miscellaneous Production"
                        ?>
                    </p>
            </span>

                <span class="list-group-item">
                    <h3 class="pull-right">
                        <i class="fas fa-anchor"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">€
                        <?php
                        echo $db->fix_int_to_double($current['clo_gwp_marine_previous']);
                        echo getDifferenceProd($current['clo_gwp_marine_current'], $current['clo_gwp_marine_previous']);
                        ?>
                    </h4>
                    <p class="list-group-item-text">
                        <?php
                        echo getMonthName($period, $lang) . " " . ($year - 1) . " Marine Production"
                        ?>
                    </p>
            </span>
            </div>
        </div>
    </div>
</div>

<?php
//$db->show_footer();
$db->show_empty_footer();

function getDifferenceProd($current, $previous)
{
    global $db;
    $diff = $current - $previous;

    if ($previous > $current) {
        return ' &nbsp;&nbsp;<i class="fas fa-sort-amount-down"></i>
                <span class="alert-danger">&nbsp;' . $db->fix_int_to_double($diff) . "</span>";
    } else if ($previous == $current) {
        return ' &nbsp;&nbsp;<i class="fas fa-equals"></i>
                <span class="alert-secondary">&nbsp;' . $db->fix_int_to_double($diff) . "</span>";
    } else {
        return ' &nbsp;&nbsp;<i class="fas fa-sort-amount-up"></i>
                <span class="alert-success">&nbsp;' . $db->fix_int_to_double($diff) . "</span>";
    }

}

function getMonthName($month, $lang)
{
    if ($lang != 'ENG' || $lang != 'GR') {
        $lang = 'ENG';
    }
    if ($lang == 'ENG') {
        switch ($month) {
            case 1:
                return 'January';
            case 2:
                return 'February';
            case 3:
                return 'March';
            case 4:
                return 'April';
            case 5:
                return 'May';
            case 6:
                return 'June';
            case 7:
                return 'July';
            case 8:
                return 'August';
            case 9:
                return 'September';
            case 10:
                return 'October';
            case 11:
                return 'November';
            case 12:
                return 'December';
        }//case
    }//eng
    else if ($lang == 'GR') {
        switch ($month) {
            case 1:
                return 'Γεννάρης';
            case 2:
                return 'Φεβρουάριος';
            case 3:
                return 'Μάρτης';
            case 4:
                return 'Απριλιος';
            case 5:
                return 'Μάιος';
            case 6:
                return 'Ιούνιος';
            case 7:
                return 'Ιούλιος';
            case 8:
                return 'Αύγουστος';
            case 9:
                return 'Σεπτέμβριος';
            case 10:
                return 'Οκτόμβριος';
            case 11:
                return 'Νοέμβριος';
            case 12:
                return 'Δεκέμβριος';
        }//case
    }
}

?>
