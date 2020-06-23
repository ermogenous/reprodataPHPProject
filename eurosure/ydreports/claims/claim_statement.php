<?
ini_set("memory_limit","128M");
ini_set('max_execution_time', 1000);

include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
include("../../tools/export_data.php");
include("../../tools/various_tools.php");
$sybase = new Sybase();
