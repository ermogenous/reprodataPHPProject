<script language="JavaScript" type="text/javascript">

//this function is executed on submit.
function custom_js_functions_return() {
var result;
result = '';
	//check insureds name not to be empty
	if (document.getElementById('insureds_name').value == "") {
		result += '<?php show_quotation_text("Αδειο Πεδίο Ονομα Ασφαλισμένου.","Empty Field Insureds Name.");?>\n' ;
	}

	if ($('#2_oqqit_insured_amount_2').val() == 1 && $('#2_oqqit_insured_amount_3').val() == ''){
	    result += '<?php show_quotation_text("Αδειο Πεδίο Αριθμό Μητρώου Εργοδότη.", "Empty Field Social Security Insurance Number .");?>\\n';
    }

//FORM FIXES.

//update the contents field insured_amount_2 if contents section is oppened.
//document.getElementById('5_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_5').value;
//document.getElementById('6_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_6').value;

//return the result
return result;
}


function js_function_on_load() {
	
	//updates the hidden field that updates the db at insured_amount_15 from the plusminus button if presses or not.

}

function check_plusminus_update_hidden_fields(section) {

	if (document.getElementById(section + '_oqqit_insured_amount_15').value !=  document.getElementById('plusminus_hidden_' + section).value && document.getElementById(section + '_oqqit_insured_amount_15').value != '') {
		switchPlusMinusButton('plusminus' + section,'<?php echo $db->admin_layout_url;?>images/buttons/grey_plus.gif','<?php echo $db->admin_layout_url;?>images/buttons/grey_minus.gif','plusminus_hidden_' + section);
		openCloseDivWindow('section1_div' + section);
	}

}
</script>