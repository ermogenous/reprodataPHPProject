<script language="JavaScript" type="text/javascript">

//this function is executed on submit.
function custom_js_functions_return() {
var result;
result = '';


//FORM FIXES.

//update the contents field insured_amount_2 if contents section is oppened.
//document.getElementById('5_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_5').value;
//document.getElementById('6_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_6').value;

//return the result
return result;
}


function js_function_on_load() {
	

}
var insuredAge;
function showInsuredAge(){
    let fromDate = $('#starting_date').val();
    let toDate = $('#1_oqqit_date_1').val();

    if (isDate(fromDate) && isDate(toDate)) {
        insuredAge = getYearsFromDates(fromDate,toDate);
        $('#insured_age').html(insuredAge);
        checkInsuredAge();
    }
}

function checkInsuredAge(){
    var ageLimit = '<?php echo $underwriterData['oqun_mf_age_restriction'];?>';
    if (insuredAge > ageLimit){
        var error = 'Age limit is: ' + ageLimit;
        $('#insuredAgeError').html(error);
        FormErrorFound = true;
    }
    else {
        var error = '';
        $('#insuredAgeError').html(error);
    }


}

$( document ).ready(function() {
    showInsuredAge();
});
</script>