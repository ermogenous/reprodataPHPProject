<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
$sybase = new Sybase();


if ($_POST["print"] != 1) {
	$db->show_header();
}
?>
<style type="text/css">
<!--
.table_headers {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: bolder;
	color: #000000;
	text-decoration: none;
}
.main_table_text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #000000;
	text-decoration: none;
}
-->
</style>
<script language="JavaScript" type="text/javascript">

function send_form() {

	if (document.getElementById('print').checked == true) {
		
		document.report.target = '_blank';		
		document.report.submit();
	}
	else {
		document.report.submit();
	}

}

</script>
<? 
if ($_POST["print"] != 1) {
?>
<form action="" method="post" target="" name="report">
<table width="375" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="152">Starting Month/Year</td>
    <td width="217"><input name="start_month" type="text" id="start_month" value="<? echo $_POST["start_month"];?>" size="12">
      /
      <input name="start_year" type="text" id="start_year" size="12" value="<? echo $_POST["start_year"];?>"></td>
  </tr>
  
  <tr>
    <td>Ending Month/Year</td>
    <td><input name="end_month" type="text" id="end_month" value="<? echo $_POST["end_month"];?>" size="12">
      /
      <input name="end_year" type="text" id="end_year" size="12" value="<? echo $_POST["end_year"];?>"></td>
  </tr>
  
  <tr>
    <td>Policy Numbers (LIKE) </td>
    <td><input name="policy_like" type="text" id="policy_like" value="<? echo $_POST["policy_like"];?>" /></td>
  </tr>
  <tr>
    <td>Section</td>
    <td><select name="section" id="section">
      <option value="policy" <? if ($_POST["section"] == "policy") echo "selected=\"selected\"";?>>By Policy</option>
      <option value="bands" <? if ($_POST["section"] == "bands") echo "selected=\"selected\"";?>>Bands</option>
    </select>    </td>
  </tr>
  <tr>
    <td>Print?</td>
    <td><input name="print" type="checkbox" id="print" value="1" /></td>
  </tr>
  <tr>
    <td><input name="action" type="hidden" id="action" value="show"></td>
    <td><input type="button" name="Button" value="Submit" onclick="send_form();"></td>
  </tr>
</table>

</form>
<?
}
if ($_POST["action"] == "show") {
$sql = "SELECT * FROM ap_asci_complete WHERE 
(
	year1 = ".$_POST["start_year"]." AND month1 >= ".$_POST["start_month"]."   
	AND month1 <= ".$_POST["end_month"]."
) AND `category` = 'NON' AND `policy` LIKE '".$_POST["policy_like"]."' 
AND policy <> '1171004524' AND policy <> '1174009407' AND katigoria_kindinou = 'B'
";
//AND katigoria_kindinou = 'B'
//E -> Commercial
//K -> Simple
//B -> Industrial
$title = 'Industrial 01/01/2009 - 30/09/2009';

$result = $db->query($sql);

while ($row = $db->fetch_assoc($result)) {

	if ($row["logistikos_klados"] == '1729' || $row["logistikos_klados"] == '1701' || $row["logistikos_klados"] == '1612' || $row["logistikos_klados"] == '1736') {
		$data[$row["policy"]]["insured_amount"] += $row["kefalaio"];
	}
	$data[$row["policy"]][$row["logistikos_klados"]]["premium"] += $row["premium"];
	$data[$row["policy"]]["total_premium"] += $row["premium"];
	$data2[$row["logistikos_klados"]]["total_premium"] += $row["premium"];
	//$data[$row["policy"]]["insured_amount"] += $row["kefalaio"];
	$log[$row["logistikos_klados"]] = 1;
	$policies[$row["policy"]] = 1;
	
//print_r($row["policy"])." -> ";
}

//foreach ($data2 as $name => $value) {
//	echo $name." -> ".$data2[$name]["total_premium"]."<br>";
//}


//print_r($log);
if ($_POST["section"] == "policy") {
?>

<table width="1140" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="60">Policy</td>
    <td width="60">EQ 1803</td>
    <td width="60">OP 1704</td>
    <td width="60">Iliki Zimia 1729</td>
    <td width="60">PL 2230</td>
    <td width="60">EQ (1802)</td>
    <td width="60">Fire(1701)</td>
    <td width="60">O.Pa(1703)</td>
    <td width="60">Theft(1804)</td>
    <td width="60">Thermosimf. (1733)</td>
    <td width="60">Nomiki E.(2208)</td>
    <td width="60">(1806)</td>
    <td width="60">(2209)</td>
    <td width="60">(1710)</td>
    <td width="60">(2226)</td>
    <td width="60">(1705)</td>
    <td width="60">(1612)</td>
    <td width="60">(1713)</td>
    <td width="60" align="right">TOTAL</td>
  </tr>
<?
}//if section policy

foreach($policies as $policy => $value) {
//bands for the next table.

$bands["total"]["insured_amount"] += $data[$policy]["insured_amount"];
$bands["total"]["total_premium"] += $data[$policy]["total_premium"];
$bands["total"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
$bands["total"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
$bands["total"]["total_policies"] += 1;


if ($data[$policy]["insured_amount"] <= 100000) {
	$bands["1"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["1"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["1"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["1"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"]; 
	$bands["1"]["total_policies"] += 1;

}
else if ($data[$policy]["insured_amount"] > 100000 && $data[$policy]["insured_amount"] <= 200000 ) {
	$bands["100000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["100000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["100000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["100000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];;
	$bands["100000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 200000 && $data[$policy]["insured_amount"] <=  300000) {
	$bands["200000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["200000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["200000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["200000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["200000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 300000 && $data[$policy]["insured_amount"] <=  400000) {
	$bands["300000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["300000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["300000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["300000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["300000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 400000 && $data[$policy]["insured_amount"] <=  500000) {
	$bands["400000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["400000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["400000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["400000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["400000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 500000 && $data[$policy]["insured_amount"] <=  750000) {
	$bands["500000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["500000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["500000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["500000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["500000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 750000 && $data[$policy]["insured_amount"] <=  1000000) {
	$bands["750000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["750000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["750000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["750000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["750000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 1000000 && $data[$policy]["insured_amount"] <=  1250000) {
	$bands["1000000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["1000000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["1000000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["1000000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["1000000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 1250000 && $data[$policy]["insured_amount"] <=  1500000) {
	$bands["1250000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["1250000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["1250000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["1250000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["1250000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 1500000 && $data[$policy]["insured_amount"] <=  2000000) {
	$bands["1500000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["1500000"]["total_premium"] += $data[$policy]["total_premium"];
	$bands["1500000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["1500000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["1500000"]["total_policies"] += 1;
}
else if ($data[$policy]["insured_amount"] > 2000000 ) {
	$bands["2000000"]["insured_amount"] += $data[$policy]["insured_amount"];
	$bands["2000000"]["total_premium"] += $data[$policy]["total_premium"];	
	$bands["2000000"]["eq_premium"] += $data[$policy][1802]["premium"] + $data[$policy][1803]["premium"];
	$bands["2000000"]["fire_premium"] += $data[$policy][1701]["premium"] + $data[$policy][1612]["premium"] + $data[$policy][1703]["premium"] + $data[$policy][1705]["premium"] + $data[$policy][1710]["premium"] + $data[$policy][1729]["premium"] + $data[$policy][2230]["premium"] + + $data[$policy][1804]["premium"];
	$bands["2000000"]["total_policies"] += 1;
	//$all = $all.$policy.", ";
}

if ($_POST["section"] == "policy") {
?>
  <tr>
    <td><? echo $policy;?></td>
    <td><? echo $data[$policy][1803]["premium"];?></td>
    <td><? echo $data[$policy][1704]["premium"];?></td>
    <td><? echo $data[$policy][1729]["premium"];?></td>
    <td><? echo $data[$policy][1729]["premium"];?></td>
    <td><? echo $data[$policy][1802]["premium"];?></td>
    <td><? echo $data[$policy][1701]["premium"];?></td>
    <td><? echo $data[$policy][1703]["premium"];?></td>
    <td><? echo $data[$policy][1804]["premium"];?></td>
    <td><? echo $data[$policy][1733]["premium"];?></td>
    <td><? echo $data[$policy][2208]["premium"];?></td>
    <td><? echo $data[$policy][1806]["premium"];?></td>
    <td><? echo $data[$policy][2209]["premium"];?></td>
    <td><? echo $data[$policy][1710]["premium"];?></td>
    <td><? echo $data[$policy][2226]["premium"];?></td>
    <td><? echo $data[$policy][1705]["premium"];?></td>
    <td><? echo $data[$policy][1612]["premium"];?></td>
    <td><? echo $data[$policy][1713]["premium"];?></td>
    <td align="right"><? echo $data[$policy]["total_premium"];?></td>
  </tr>
<? 
}//if section policy
}//for each
echo $all;
if ($_POST["section"] == "policy") {
?>
  <tr>
    <td><? echo $policy;?></td>
    <td><? echo $data[1803]["total_premium"];?></td>
    <td><? echo $data[1704]["total_premium"];?></td>
    <td><? echo $data[1729]["total_premium"];?></td>
    <td><? echo $data[1729]["total_premium"];?></td>
    <td><? echo $data[1802]["total_premium"];?></td>
    <td><? echo $data[1701]["total_premium"];?></td>
    <td><? echo $data[1703]["total_premium"];?></td>
    <td><? echo $data[1804]["total_premium"];?></td>
    <td><? echo $data[1733]["total_premium"];?></td>
    <td><? echo $data[2208]["total_premium"];?></td>
    <td><? echo $data[1806]["total_premium"];?></td>
    <td><? echo $data[2209]["total_premium"];?></td>
    <td><? echo $data[1710]["total_premium"];?></td>
    <td><? echo $data[2226]["total_premium"];?></td>
    <td><? echo $data[1705]["total_premium"];?></td>
    <td><? echo $data[1612]["total_premium"];?></td>
    <td><? echo $data[1713]["total_premium"];?></td>
    <td align="right"><? echo $data[$policy]["total_premium"];?></td>
  </tr>
</table>


<hr />

<?




}//if section policy
//print_r($bands);
if ($_POST["section"] == "bands") {
?>
<div align="center">
<? echo $title;?>
<table width="845" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="107" class="table_headers">Bands</td>
    <td width="90" align="right" class="table_headers">NO.OF.POLICIES</td>
    <td width="90" align="right" class="table_headers">Total Sum Insured</td>
    <td width="90" align="right" class="table_headers">EQ Premium </td>
    <td width="90" align="right" class="table_headers">Fire Premium </td>
    <td width="90" align="right" class="table_headers">Total Premium </td>
    <td width="90" align="right" class="table_headers">Average Rate Per Mille </td>
    <td width="90" align="right" class="table_headers">Average Sum Insured </td>
    <td width="90" align="right" class="table_headers">Average EQ Rate Per Mille </td>
  </tr>
<? 
$sections[1] = 1;
$sections[2] = 100000;
$sections[3] = 200000;
$sections[4] = 300000;
$sections[5] = 400000;
$sections[6] = 500000;
$sections[7] = 750000;
$sections[8] = 1000000;
$sections[9] = 1250000;
$sections[10] = 1500000;
$sections[11] = 2000000;
$sections[12] = "total";
$sections_names[1] = "0-100,000";
$sections_names[2] = "100,001-200,000";
$sections_names[3] = "200,001-300,000";
$sections_names[4] = "300,001-400,000";
$sections_names[5] = "400,001-500,000";
$sections_names[6] = "500,001-750,000";
$sections_names[7] = "750,001-1,000,000";
$sections_names[8] = "1,000,001-1,250,000";
$sections_names[9] = "1,250,001-1,500,000";
$sections_names[10] = "1,500,001-2,000,000";
$sections_names[11] = "Over 2,000,000";
$sections_names[12] = "Total";


foreach($sections as $number => $value) {
?>
  <tr>
    <td class="table_headers"><? echo $sections_names[$number];?></td>
    <td align="right" class="main_table_text"><? if ($bands[$value]["total_policies"] >0) echo $bands[$value]["total_policies"]; else echo 0;?></td>
    <td align="right" class="main_table_text"><? echo number_format($bands[$value]["insured_amount"]);?></td>
    <td align="right" class="main_table_text"><? echo number_format($bands[$value]["eq_premium"],2);?></td>
    <td align="right" class="main_table_text"><? echo number_format($bands[$value]["fire_premium"],2);?></td>
    <td align="right" class="main_table_text"><? echo number_format($bands[$value]["total_premium"],2);?></td>
    <td align="right" class="main_table_text"><? if ($bands[$value]["total_policies"] > 0) echo number_format(($bands[$value]["total_premium"]/$bands[$value]["insured_amount"])*1000,2); else echo 0; ?></td>
    <td align="right" class="main_table_text"><? if ($bands[$value]["total_policies"] > 0) echo number_format($bands[$value]["insured_amount"]/$bands[$value]["total_policies"],2); else echo 0; ?></td>
    <td align="right" class="main_table_text"><? if ($bands[$value]["total_policies"] > 0) echo number_format($bands[$value]["eq_premium"]/$bands[$value]["insured_amount"]*1000,2); else echo 0; ?></td>
  </tr>
<? } ?>
</table>
</div>

<?
}//if section bands

}//if show
if ($_POST["print"] != 1) {
	$db->show_footer();
}
else {
	$db->main_exit();
}
?>
