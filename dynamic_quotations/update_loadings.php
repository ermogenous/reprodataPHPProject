<?php
include("../include/main.php");
$db = new Main(1,'windows-1253');
//include("../include/tables.php");
include("../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();
if ($_POST["action"] == "update") {

	$sql = "SELECT * FROM inloadings";
	$result = $sybase->query($sql);
	while ($loading = $sybase->fetch_assoc($result)) {
	
		//check in mysql
		$sql = "SELECT * FROM inq_loadings WHERE inqldg_loading_serial = ".$loading["inldg_loading_serial"];
		$res = $db->query($sql);
		if ($db->num_rows($res) > 0 ) {
			//get data
			$data = $db->fetch_assoc($res);
			
			$i=0;
			foreach ($loading as $name => $value) {
				//first check if is correct rows
				if ($name == 'inldg_declaration_discount_appl'){
					$name = 'inldg_declaration_discount_applied';
				}

				if (substr($name,0,6) == 'inldg_' && $name != 'inldg_loading_serial') {
					
					//if data are the same
					if (substr($loading["inldg_last_update"],0,19) == $data["inqldg_last_update"]) {
						//do nothing
					}
					else {
						$i++;
						$update_output .= ", inqldg_".(substr($name,6))." = \"".str_replace("'","",$value)."\"";
					}
					
			
				}//if correct rows
			
			}//foreach column	

			//if changes found
			if ($i != 0) {
				$output .= "UPDATE inq_loadings SET ".substr($update_output,1)." WHERE inqldg_loading_serial = ".$loading["inldg_loading_serial"]."";
				$update_output = '';
				//$db->query($output);
			}
						
		}//if row is found
		else {
		
			foreach ($loading as $name => $value) {
				//first check if is correct rows
				if (substr($name,0,6) == 'inldg_') {
					
					if ($name == 'inldg_declaration_discount_appl'){
						$name = 'inldg_declaration_discount_applied';
					}
					
					$insert_output .= ", inqldg_".(substr($name,6))." = \"".str_replace("'","",$value)."\"";
			
			
			
				}//if correct rows
			
			}//foreach column	

			$output .= "INSERT INTO inq_loadings SET ".substr($insert_output,1)."";	
			$insert_output = '';
			//$db->query($output);
		
		}//else if now row is found
	
	
	
	}



	echo $output;


}//if action = update


?>
<form action="" method="post">
  <input name="action" type="hidden" id="action" value="update" />
  <input type="submit" name="Submit" value="Submit" />
</form>
<?php


$db->show_footer();
?>