<?php


if ($quote->quotationData()['oqq_effective_date'] == '' ) {
    $effectiveDate = date('Y-m-d');
}
else {
    $effectiveDate = $quote->quotationData()['oqq_effective_date'];
}
$startDateParts = explode('-',explode(' ',$effectiveDate)[0]);
$startDateNum = ($startDateParts[0] * 10000) + ($startDateParts[1] * 100) + ($startDateParts[2] * 1);
if ($startDateNum < 20210723){
    include("mff_quotation_print_2020.php");
}
else {
    include("mff_quotation_print_2021.php");
}

?>
