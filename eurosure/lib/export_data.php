<?php

function export_data_prepare_data($sql,$database,$part) {
global $$database;

$result = $$database->query($sql);
$i=0;

while ($data = $$database->fetch_assoc($result,1)) {
	
	foreach ($data as $name => $value) {
		
		if ($name != "odbc_affected_rows") {
		
			//check if the field is not to be removed.
			if (substr($name,0,7) != 'remove_') {
				$array[$i][$name] = $value;
				if ($i ==0) {
					$fields[] = $name;
				}
			}//if not remove the field
		}

	}//foreach loop
$i++;
}//while loop

if ($part == 'fields') 
	return $fields;
else if ($part == 'data')
	return $array;

}

function export_data_prepare_data_from_array($array,$part) {

foreach ($array as $num => $data) {

	foreach ($data as $name => $value) {
		
			//check if the field is not to be removed.
			if (substr($name,0,7) != 'remove_') {
				$array[$i][$name] = $value;
				if ($i ==0) {
					$fields[] = $name;
				}
		}

	}//foreach loop
$i++;
}//while loop

if ($part == 'fields') 
	return $fields;
else if ($part == 'data')
	return $array;

}

//sql , $database like db or sybase , separator like # or @ etc , colon like ' or " for the text
//out -> download or return
function export_data_delimited($sql,$database,$separator,$colon,$out,$new_line = '
',$data_type = 'SQL',$filename = 'output_file') {

if ($data_type == 'SQL') {
	$rows = export_data_prepare_data($sql,$database,'data');
	$fields_names = export_data_prepare_data($sql,$database,'fields');
}
else {
	$rows = $sql;
	$fields_names = $database;
}

	$j=0;
	foreach($fields_names as $name) {
		$output .= $name;
		if ($j != count($fields_names)-1)
			$output .= $separator;
		$j++;
	}//foreach

	$output .= $new_line;

	for ($i=0; $i< count($rows);$i++) {
			$p = 0;
			foreach($fields_names as $name) {
				$string = str_replace(" "," ",$rows[$i][$name]);
				$string = str_replace("
				","_",$string);
				$string = str_replace("\n","_",$string);
				if ($colon == 'double')
					$colon_out = '\"';
				else if ($colon == 'single')
					$colon_out = '\'';
				else if ($colon == 'none')
					$colon_out = '';
					
				$output .= $colon_out.$string.$colon_out;
				if ($p != count($fields_names)-1)
					$output .= $separator;
					$p++;
			}//foreach row
		$output .= $new_line;
	}//for loop
	
	if ($out == 'download')
		export_download_variable($output,$filename.'.txt');
	else 
		return $output;
	//export_text_file($output);
}//function export_delimited



function export_text_file($data) {
//header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=\"file.txt\"");
$handle = fopen("OutputFile.xml",'w');
fwrite($handle,$data);
fclose($handle);
//echo "<a href=\"OutputFile.txt\">Click here to download</a>";
echo $data;

}

function export_download_variable($data,$filename){
global $db;
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\""); 
header("Content-Transfer-Encoding: binary");
echo $data;
$db->main_exit();
exit();
}

function export_data_html_table($sql,$database,$table_param = 'border="1"',$show_totals = 1) {
	global $db;

$rows = export_data_prepare_data($sql,$database,'data');
$fields_names = export_data_prepare_data($sql,$database,'fields');

if (!is_array($fields_names)) {
$output = "<br><div align=\"center\"><div style=\"background-color:#FF9595; width:350px;\">--NO DATA FOUND--</div></div><br><br>";	
}
else {

	$output = "<table ".$table_param.">\n";
	$output .= "	<tr>\n";
	foreach ($fields_names as $name) {
	
		if (substr($name,0,6) == '_DATE_') {
			$output .= "		<td><strong>".substr($name,6)."</strong></td>\n";
		}
		else {
			$output .= "		<td><strong>".$name."</strong></td>\n";
		}
	
	}

$output .= "	</tr>\n";

	for ($i=0; $i< count($rows);$i++) {
			$p = 0;
			$output .= "	<tr>\n";
			foreach($fields_names as $name) {
				if ($rows[$i][$name] == "") {
					$out_string = '&nbsp;';
				}
				else {
					if (substr($name,0,6) == '_DATE_') {
						$out_string = $db->convert_date_format($rows[$i][$name],'yyyy-mm-dd','dd/mm/yyyy');
					}
					else {
						$out_string = $rows[$i][$name];
					}
				}
					
				$output .= "		<td>".$out_string."</td>\n";
				$p++;
				if (is_numeric($out_string)) {
					$totals[$name] += $out_string;
				}
			}//foreach
			$output .= "	</tr>\n";
	}//for

$totals["total_records"] = count($rows);

$output .= "</table>";
if ($show_totals == 1) {
	$output .= "<pre>".print_r($totals,1)."</pre>";
}

}
return $output;
}
?>