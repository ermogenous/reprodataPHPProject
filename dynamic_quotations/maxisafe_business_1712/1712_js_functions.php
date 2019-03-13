<script language="JavaScript" type="text/javascript">

//this function is executed on submit.
function custom_js_functions_return() {
var result;
result = '';
	//check insureds name not to be empty
	if (document.getElementById('insureds_name').value == "") {
		result += '<? show_quotation_text("Αδειο Πεδίο Ονομα Ασφαλισμένου.","Empty Field Insureds Name.");?>\n' ;
	}



//FORM FIXES.

//update the contents field insured_amount_2 if contents section is oppened.
document.getElementById('5_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_5').value;
document.getElementById('6_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_6').value;
document.getElementById('7_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_7').value;
document.getElementById('8_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_8').value;
document.getElementById('9_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_9').value;
document.getElementById('10_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_10').value;
document.getElementById('11_oqqit_insured_amount_15').value = document.getElementById('plusminus_hidden_11').value;
		
//return the result
return result;
}


function js_function_on_load() {
	
	//updates the hidden field that updates the db at insured_amount_15 from the plusminus button if presses or not.
	//section 5
	check_plusminus_update_hidden_fields(5);	
	//section 6
	check_plusminus_update_hidden_fields(6);
	//section 7
	check_plusminus_update_hidden_fields(7);
	//section 8
	check_plusminus_update_hidden_fields(8);
	//section 9
	check_plusminus_update_hidden_fields(9);
	//section 10
	check_plusminus_update_hidden_fields(10);
	//section 11
	check_plusminus_update_hidden_fields(11);

}

function check_plusminus_update_hidden_fields(section) {

	if (document.getElementById(section + '_oqqit_insured_amount_15').value !=  document.getElementById('plusminus_hidden_' + section).value && document.getElementById(section + '_oqqit_insured_amount_15').value != '') {
		switchPlusMinusButton('plusminus' + section,'<? echo $db->admin_layout_url;?>images/buttons/grey_plus.gif','<? echo $db->admin_layout_url;?>images/buttons/grey_minus.gif','plusminus_hidden_' + section); 
		openCloseDivWindow('section1_div' + section);
	}

}
</script>