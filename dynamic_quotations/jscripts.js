// JavaScript Document
function openCloseDivWindow(field) {
	
	//alert(document.getElementById(field).style.display);
	if (document.getElementById(field).style.display == 'block') {
		document.getElementById(field).style.display = 'none';	
	}
	else {
		document.getElementById(field).style.display = 'block';	
	}
	
}//openCloseDivWindow


function open_close_div_via_check(check,div) {

	if (document.getElementById(check).checked == true) {
		document.getElementById(div).style.display = 'block';
	}
	else {
		document.getElementById(div).style.display = 'none';
	}

}


function check_all_open_close_div_via_check(check_array,div_array) {
	
	for (i=0; i<check_array.length ; i++) {
	
		open_close_div_via_check(check_array[i],div_array[i]);
		
	}
	
}