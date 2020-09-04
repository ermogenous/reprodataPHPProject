<?php
include("../include/main.php");
include("lib/odbccon.php");

$db = new Main(1);

$syn = new ODBCCON('EUROTEST');


$sql = "

INSERT INTO inpcodes (incd_record_type,incd_record_code) VALUES ('11','22');
SELECT @@IDENTITY as cloLastID;

";
$syn->beginTransaction();
$result = $syn->query($sql);
$data = $syn->fetch_assoc($result);
$syn->commit();
print_r($data);