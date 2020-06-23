<?
include("../../include/main.php");
$db = new Main(1,'windows-1253');
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();


if ($_POST["action"] == "show") {

//product filtering
$product = "";
if ($_POST["product"] != "") {
	
	$product = "AND inity_insurance_type LIKE '".$_POST["product"]."'";

}
//remove product filtering
$remove_product = "";
if ($_POST["remove_product"] != "") {
	
	$remove_product = "AND inity_insurance_type NOT LIKE '".$_POST["remove_product"]."'";

}

$group_agent = "";
$group_agent_select = "clo_nationality";
if ($_POST["group_agent"] == 1) {
	$group_agent_select = "inag_agent_code ,inag_long_description ,clo_cypriot_or_non";
	$group_agent = " ,inag_agent_code ,inag_long_description";
}

$sql_pol = "
SELECT 
".$_POST["year_from"]." as st_from_year
,".$_POST["year_to"]." as st_to_year
,".$_POST["period_from"]." as st_from_period
,".$_POST["period_to"]." as st_to_period
,(-1 * sum (inped_premium_debit_credit * inped_x_premium)) As clo_x_premium
,(-1 * sum (inped_premium_debit_credit * inped_fees)) As clo_fees
,(-1 * sum (inped_premium_debit_credit * inped_stamps)) As clo_stamps
,(-1 * sum (inped_premium_debit_credit * inped_mif)) As clo_mif
,(-1 * sum (inped_premium_debit_credit * inped_premium)) As clo_period_premium
,incd_long_description as clo_nationality
,inpol_policy_number
,SUM(IF inpol_process_status IN ('N','R') THEN 1 ELSE 0 ENDIF)as clo_total_new_renewal
,inag_agent_code
,inag_long_description
,CASE
WHEN clo_nationality = 'Cypriot' THEN 'Cypriot'
WHEN clo_nationality IS NULL THEN NULL
ELSE 'Non Cypriot'
END as clo_cypriot_or_non
into #temp
FROM 
ininsurancetypes
JOIN inpolicies ON inpolicies.inpol_insurance_type_serial = ininsurancetypes.inity_insurance_type_serial
JOIN ingeneralagents ON ingeneralagents.inga_agent_serial = inpolicies.inpol_general_agent_serial
JOIN inagents ON inpolicies.inpol_agent_serial = inagents.inag_agent_serial
JOIN inpolicyendorsement ON inpolicies.inpol_policy_serial = inpolicyendorsement.inped_financial_policy_abs
JOIN inclients ON incl_client_serial = inpol_client_serial
LEFT OUTER JOIN inpcodes as nationality ON nationality.incd_pcode_serial = incl_nationality

WHERE 1=1
AND inpolicyendorsement.inped_status = '1' 
AND (inped_year*100+inped_period)>=(st_from_year*100+st_from_period)
AND (inped_year*100+inped_period)<=(st_to_year*100+st_to_period)
AND inpol_status IN ('A','N')
".$product."
".$remove_product."

GROUP BY inpol_policy_number
,clo_nationality
,inag_agent_code
,inag_long_description

SELECT 
".$group_agent_select." as clo_nationality
,COUNT() as clo_total_per_nationality
,SUM(clo_period_premium) as clo_period_premium
,SUM(clo_fees)as clo_fees
,SUM(clo_stamps)as clo_stamps
,SUM(clo_x_premium) as clo_x_premium
FROM #temp
WHERE 
#temp.clo_x_premium + #temp.clo_period_premium > 0
AND #temp.clo_total_new_renewal > 0
GROUP BY clo_nationality ".$group_agent."
ORDER BY ".$_POST["order_from"]." ".$_POST["order_type"]."
";

$result = $sybase->query($sql_pol);

//1. Removes all the records that have premium < 0 because those are cancellations that appeared in the period.
//2. Also removes records with premium 0 because are policies and cancellations that equal to 0 which means full cancellation
//3. Calculates how many phases in the period found that are New or Renewal. If found 0 means that only endorsements are found in the period and thus remove them.


//echo $sql;

}//if action == show

?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>Premium Per Nationality </strong></td>
    </tr>
    <tr>
      <td>Year</td>
      <td>From <input name="year_from" type="text" id="year_from" value="<? echo $_POST["year_from"];?>"> To <input name="year_to" type="text" id="year_to" value="<? echo $_POST["year_to"];?>"></td>
    </tr>
    <tr>
      <td width="122">Period</td>
      <td width="527"><select name="period_from" id="period_from">
        <option value="1" <? if ($_POST["period_from"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["period_from"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["period_from"] == "3") echo "selected=\"selected\"";?>>March</option>
        <option value="4" <? if ($_POST["period_from"] == "4") echo "selected=\"selected\"";?>>April</option>
        <option value="5" <? if ($_POST["period_from"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["period_from"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["period_from"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["period_from"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="9" <? if ($_POST["period_from"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["period_from"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["period_from"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["period_from"] == "12") echo "selected=\"selected\"";?>>December</option>
      </select>
      /  
      <select name="period_to" id="period_to">
        <option value="1" <? if ($_POST["period_to"] == "1") echo "selected=\"selected\"";?>>January</option>
        <option value="2" <? if ($_POST["period_to"] == "2") echo "selected=\"selected\"";?>>February</option>
        <option value="3" <? if ($_POST["period_to"] == "3") echo "selected=\"selected\"";?>>March</option>
        <option value="4" <? if ($_POST["period_to"] == "4") echo "selected=\"selected\"";?>>April</option>
        <option value="5" <? if ($_POST["period_to"] == "5") echo "selected=\"selected\"";?>>May</option>
        <option value="6" <? if ($_POST["period_to"] == "6") echo "selected=\"selected\"";?>>June</option>
        <option value="7" <? if ($_POST["period_to"] == "7") echo "selected=\"selected\"";?>>July</option>
        <option value="8" <? if ($_POST["period_to"] == "8") echo "selected=\"selected\"";?>>August</option>
        <option value="9" <? if ($_POST["period_to"] == "9") echo "selected=\"selected\"";?>>September</option>
        <option value="10" <? if ($_POST["period_to"] == "10") echo "selected=\"selected\"";?>>October</option>
        <option value="11" <? if ($_POST["period_to"] == "11") echo "selected=\"selected\"";?>>November</option>
        <option value="12" <? if ($_POST["period_to"] == "12") echo "selected=\"selected\"";?>>December</option>
        </select> 
      Operation Dates (date of the reserves) </td>
    </tr>
    
    <tr>
      <td>Product</td>
      <td><input name="product" type="text" id="product" value="<? echo $_POST["product"];?>" /> 
      ex 19% or 1711 or 17% </td>
    </tr>
    <tr>
      <td>Exclude Product </td>
      <td><input name="remove_product" type="text" id="remove_product" value="<? echo $_POST["remove_product"];?>" />
      Product here will be removed. ex 19TC </td>
    </tr>
    <tr>
      <td>Order By </td>
      <td><select name="order_from" id="order_from">
        <option value="clo_nationality" <? if ($_POST["order_from"] == "clo_nationality") echo "selected=\"selected\"";?>>Nationality</option>
        <option value="clo_total_per_nationality" <? if ($_POST["order_from"] == "clo_total_per_nationality") echo "selected=\"selected\"";?>>Total Policies</option>
        <option value="clo_period_premium" <? if ($_POST["order_from"] == "clo_period_premium") echo "selected=\"selected\"";?>>Premium</option>
        <option value="clo_fees" <? if ($_POST["order_from"] == "clo_fees") echo "selected=\"selected\"";?>>Fees</option>
        <option value="clo_stamps" <? if ($_POST["order_from"] == "clo_stamps") echo "selected=\"selected\"";?>>Stamps</option>
        <option value="inag_agent_code" <? if ($_POST["order_from"] == "inag_agent_code") echo "selected=\"selected\"";?>>Agent Code</option>

      </select>
        <select name="order_type" id="order_type">
          <option value="ASC" <? if ($_POST["order_type"] == "ASC") echo "selected=\"selected\"";?>>Ascending</option>
          <option value="DESC" <? if ($_POST["order_type"] == "DESC") echo "selected=\"selected\"";?>>Descending</option>
        </select>      </td>
    </tr>
    <tr>
      <td>Group By Agents </td>
      <td><input name="group_agent" type="checkbox" id="group_agent" value="1" <? if ($_POST["group_agent"] == 1) echo "checked=\"checked\"";?> /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NOTES: <br>
        1.
      Preferable to exclude 19TC because they do not have nationality on their client accounts. <br>
      2. Policies that do not have Nationality are 100% Companies. </td>
    </tr>
    <tr>
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {
	$extra_field = 0;
	if ($_POST["group_agent"] == 1) {
		$extra_field = 1;
	}
	
?>
<br><br>
<div id="print_view_section_html">
<table width="<? if ($_POST["group_agent"] == 1) echo 750; else echo 650;?>" border="1" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000" class="main_text">
  <tr>
    <td colspan="<? echo 5 + $extra_field;?>" align="center"><strong>Policies Per Clients Nationality For Period <? echo $_POST["period_from"]."/".$_POST["year_from"]." TO ".$_POST["period_to"]."/".$_POST["year_to"];?><br />For Products [ <? echo $_POST["product"];?> ], Excluded Products [ <? echo $_POST["remove_product"];?> ]</strong></td>
    </tr>
  <tr>


<?
$i=0;
while ($row = $sybase->fetch_assoc($result)) {


	if ($i == 0 || ($i%66 == 0)) {
	$nationality_width = 200;
	if ($_POST["group_agent"] == 1) {
	$nationality_width = 100;
	?>
		<td width="370"><strong>Agent</strong></td>
	<? } ?>
		<td width="<? echo $nationality_width;?>"><strong>Nationality</strong></td>
		<td width="70" align="center"><strong>Total Policies </strong></td>
		<td width="70" align="center"><strong>Fees</strong></td>
		<td width="70" align="center"><strong>Stamps</strong></td>
		<td width="70" align="center"><strong>Premium</strong></td>
	  </tr>
<? }//header if ?>
  <tr>
	<?
	$i++;
	if ($_POST["group_agent"] == 1) {
	?>
    <td><? echo substr($row["inag_agent_code"]." - ".$row["inag_long_description"],0,41);?></td>
	<? } ?>
    <td><? echo $row["clo_nationality"];?></td>
    <td align="center"><? echo $row["clo_total_per_nationality"];?></td>
    <td align="center"><? echo sprintf("%01.2f",$row["clo_fees"]);?></td>
    <td align="center"><? echo sprintf("%01.2f",$row["clo_stamps"]);?></td>
    <td align="center"><? echo sprintf("%01.2f",$row["clo_period_premium"]);?></td>
  </tr>
<? 
//count the totals
$total_policies += $row["clo_total_per_nationality"];
$total_fees += $row["clo_fees"];
$total_stamps += $row["clo_stamps"];
$total_premium += $row["clo_period_premium"];

if ($row["clo_nationality"] <> 'Cypriot' && $row["clo_nationality"] <> '') {
	
	$non_total_policies += $row["clo_total_per_nationality"];
	$non_total_fees += $row["clo_fees"];
	$non_total_stamps += $row["clo_stamps"];
	$non_total_premium += $row["clo_period_premium"];
	

}

}
?>
  <tr>
    <td><strong>TOTALS:</strong></td>
	<?
	if ($_POST["group_agent"] == 1) {
	?>
    <td>&nbsp;</td>
	<? } ?>
    <td align="center"><strong><? echo $total_policies;?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$total_fees);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$total_stamps);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$total_premium);?></strong></td>
  </tr>
  <tr>
    <td colspan="<? echo 5 + $extra_field;?>"><hr /></td>
    </tr>
  <tr>
    <td><strong>Non Cypriots/Non Companies</strong></td>
	<?
	if ($_POST["group_agent"] == 1) {
	?>
    <td>&nbsp;</td>
	<? } ?>
    <td align="center"><strong><? echo $non_total_policies;?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$non_total_fees);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$non_total_stamps);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$non_total_premium);?></strong></td>
  </tr>
</table>
</div>

<? } ?>

<?
$db->show_footer();
?>