<?php

//print_r($quote->quotationData());

/*if ($quote->quotationData()['oqq_status'] == 'Outstanding'){
    $effectiveDate = $quote->quotationData()['oqq_starting_date'];
}
else {
    $effectiveDate = $quote->quotationData()['oqq_effective_date'];
}
*/
if ($quote->quotationData()['oqq_effective_date'] == '' ) {
    $effectiveDate = date('Y-m-d');
}
else {
    $effectiveDate = $quote->quotationData()['oqq_effective_date'];
}
$startDateParts = explode('-',explode(' ',$effectiveDate)[0]);
$startDateNum = ($startDateParts[0] * 10000) + ($startDateParts[1] * 100) + ($startDateParts[2] * 1);
if ($startDateNum < 20210723){
    include("fpa_quotation_print_2020.php");
}
else {
    include("fpa_quotation_print_2021.php");
}

?>
