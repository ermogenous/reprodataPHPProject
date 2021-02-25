<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 21/1/2021
 * Time: 3:15 μ.μ.
 */


include("../../../include/main.php");
include('../../../scripts/form_validator_class.php');
include('../../../scripts/form_builder_class.php');
include('../../lib/odbccon.php');
include('../../../tools/MEBuildExcel.php');

$db = new Main(1);
$db->admin_title = "Eurosure - Reports - Clients - Client Profile";


