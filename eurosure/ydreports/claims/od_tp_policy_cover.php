<?
include("../../include/main.php");
$db = new Main();
include("../../include/sybasecon.php");
$sybase = new Sybase();

$db->show_header();


if ($_POST["action"] == "show") {

//claim open date
$claim_open = "";

if ($_POST["claim_open_from"] != 0){ 
	$claim_open = "AND incvsdt_open_date BETWEEN '".$_POST["year"]."/".$_POST["claim_open_from"]."' AND '".$_POST["year"]."/".$_POST["claim_open_to"]."'";
}

//product filtering
$product = "";
if ($_POST["product"] != "") {
	
	$product = "AND LEFT(incvsdt_claim_number,4) LIKE '".$_POST["product"]."'";

}
//remove product filtering
$remove_product = "";
if ($_POST["remove_product"] != "") {
	
	$remove_product = "AND LEFT(incvsdt_claim_number,4) NOT LIKE '".$_POST["remove_product"]."'";

}

$sql = "
SELECT incvsdt_claim_number,
            
            SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'OD' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_payments_od,
            SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'PD' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_payments_pd,
            SUM(IF incvsdt_line_type = 'E' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'BI' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."' THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_estimated_payments_bi,
            
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'OD' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_payments_od,
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'PD' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_payments_pd,
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'BI' AND incvsdt_operation_date <= '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_payments_bi,       
           
            clo_estimated_payments_od - clo_settled_payments_od as clo_os_estimations_payments_od,
            clo_estimated_payments_pd - clo_settled_payments_pd as clo_os_estimations_payments_pd,
            clo_estimated_payments_bi - clo_settled_payments_bi as clo_os_estimations_payments_bi,
            
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'OD' AND incvsdt_operation_date BETWEEN '".$_POST["year"]."/".$_POST["from"]."' AND '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_period_payments_od,
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'PD' AND incvsdt_operation_date BETWEEN '".$_POST["year"]."/".$_POST["from"]."' AND '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_period_payments_pd,
            SUM(IF incvsdt_line_type = 'S' AND incvsdt_line_sub_type = 'C6' AND incd_reserve_payment_type = 'BI' AND incvsdt_operation_date BETWEEN '".$_POST["year"]."/".$_POST["from"]."' AND '".$_POST["year"]."/".$_POST["to"]."'  THEN incvsdt_debit_credit * incvsdt_value ELSE 0 ENDIF) as clo_settled_period_payments_bi

FROM inclaims_asat_date JOIN inpcodes On incd_pcode_serial = incvsdt_reserve_serial

WHERE 1=1
".$claim_open."
".$product."
".$remove_product."
GROUP BY incvsdt_claim_number
ORDER BY incvsdt_claim_number ASC;
";
$result = $sybase->query($sql);
echo $sql;
$total_claims = 0;
while ($row = $sybase->fetch_assoc($result)) {
$total_claims++;
	$os_reserve_od += $row["clo_os_estimations_payments_od"];
	$os_reserve_pd += $row["clo_os_estimations_payments_pd"];
	$os_reserve_bi += $row["clo_os_estimations_payments_bi"];
	
	$period_pey_od += $row["clo_settled_period_payments_od"];
	$period_pey_pd += $row["clo_settled_period_payments_pd"];
	$period_pey_bi += $row["clo_settled_period_payments_bi"];
	
}//while loop
}//if action == show
?>

<form name="form1" method="POST" action="">
  <table width="651" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
    <tr>
      <td height="25" colspan="2" align="center"><strong>OD, PD, BI For a giver period </strong></td>
    </tr>
    <tr>
      <td>Year</td>
      <td><input name="year" type="text" id="year" value="<? echo $_POST["year"];?>"></td>
    </tr>
    <tr>
      <td width="122">Period</td>
      <td width="527"><select name="from" id="from">
        <option value="01/01" <? if ($_POST["from"] == "01/01") echo "selected=\"selected\"";?>>January</option>
        <option value="02/01" <? if ($_POST["from"] == "02/01") echo "selected=\"selected\"";?>>February</option>
        <option value="03/01" <? if ($_POST["from"] == "03/01") echo "selected=\"selected\"";?>>March</option>
        <option value="04/01" <? if ($_POST["from"] == "04/01") echo "selected=\"selected\"";?>>April</option>
        <option value="05/01" <? if ($_POST["from"] == "05/01") echo "selected=\"selected\"";?>>May</option>
        <option value="06/01" <? if ($_POST["from"] == "06/01") echo "selected=\"selected\"";?>>June</option>
        <option value="07/01" <? if ($_POST["from"] == "07/01") echo "selected=\"selected\"";?>>July</option>
        <option value="08/01" <? if ($_POST["from"] == "08/01") echo "selected=\"selected\"";?>>August</option>
        <option value="09/01" <? if ($_POST["from"] == "09/01") echo "selected=\"selected\"";?>>September</option>
        <option value="10/01" <? if ($_POST["from"] == "10/01") echo "selected=\"selected\"";?>>October</option>
        <option value="11/01" <? if ($_POST["from"] == "11/01") echo "selected=\"selected\"";?>>November</option>
        <option value="12/01" <? if ($_POST["from"] == "12/01") echo "selected=\"selected\"";?>>December</option>
      </select>
      /  
      <select name="to" id="to">
        <option value="01/31" <? if ($_POST["to"] == "01/31") echo "selected=\"selected\"";?>>January</option>
        <option value="02/28" <? if ($_POST["to"] == "02/28") echo "selected=\"selected\"";?>>February</option>
        <option value="03/31" <? if ($_POST["to"] == "03/31") echo "selected=\"selected\"";?>>March</option>
        <option value="04/30" <? if ($_POST["to"] == "04/30") echo "selected=\"selected\"";?>>April</option>
        <option value="05/31" <? if ($_POST["to"] == "05/31") echo "selected=\"selected\"";?>>May</option>
        <option value="06/30" <? if ($_POST["to"] == "06/30") echo "selected=\"selected\"";?>>June</option>
        <option value="07/31" <? if ($_POST["to"] == "07/31") echo "selected=\"selected\"";?>>July</option>
        <option value="08/31" <? if ($_POST["to"] == "08/31") echo "selected=\"selected\"";?>>August</option>
        <option value="09/30" <? if ($_POST["to"] == "09/30") echo "selected=\"selected\"";?>>September</option>
        <option value="10/31" <? if ($_POST["to"] == "10/31") echo "selected=\"selected\"";?>>October</option>
        <option value="11/30" <? if ($_POST["to"] == "11/30") echo "selected=\"selected\"";?>>November</option>
        <option value="12/31" <? if ($_POST["to"] == "12/31") echo "selected=\"selected\"";?>>December</option>
        </select> 
      Operation Dates (date of the reserves) </td>
    </tr>
    <tr>
      <td>Claim Open Date </td>
      <td><select name="claim_open_from" id="claim_open_from">
	    <option value="0">Select</option>
        <option value="01/01" <? if ($_POST["claim_open_from"] == "01/01") echo "selected=\"selected\"";?>>January</option>
        <option value="02/01" <? if ($_POST["claim_open_from"] == "02/01") echo "selected=\"selected\"";?>>February</option>
        <option value="03/01" <? if ($_POST["claim_open_from"] == "03/01") echo "selected=\"selected\"";?>>March</option>
        <option value="04/01" <? if ($_POST["claim_open_from"] == "04/01") echo "selected=\"selected\"";?>>April</option>
        <option value="05/01" <? if ($_POST["claim_open_from"] == "05/01") echo "selected=\"selected\"";?>>May</option>
        <option value="06/01" <? if ($_POST["claim_open_from"] == "06/01") echo "selected=\"selected\"";?>>June</option>
        <option value="07/01" <? if ($_POST["claim_open_from"] == "07/01") echo "selected=\"selected\"";?>>July</option>
        <option value="08/01" <? if ($_POST["claim_open_from"] == "08/01") echo "selected=\"selected\"";?>>August</option>
        <option value="09/01" <? if ($_POST["claim_open_from"] == "09/01") echo "selected=\"selected\"";?>>September</option>
        <option value="10/01" <? if ($_POST["claim_open_from"] == "10/01") echo "selected=\"selected\"";?>>October</option>
        <option value="11/01" <? if ($_POST["claim_open_from"] == "11/01") echo "selected=\"selected\"";?>>November</option>
        <option value="12/01" <? if ($_POST["claim_open_from"] == "12/01") echo "selected=\"selected\"";?>>December</option>
      </select>
        /
        <select name="claim_open_to" id="claim_open_to">
		  <option value="0">Select</option>
          <option value="01/31" <? if ($_POST["claim_open_to"] == "01/31") echo "selected=\"selected\"";?>>January</option>
          <option value="02/28" <? if ($_POST["claim_open_to"] == "02/28") echo "selected=\"selected\"";?>>February</option>
          <option value="03/31" <? if ($_POST["claim_open_to"] == "03/31") echo "selected=\"selected\"";?>>March</option>
          <option value="04/30" <? if ($_POST["claim_open_to"] == "04/30") echo "selected=\"selected\"";?>>April</option>
          <option value="05/31" <? if ($_POST["claim_open_to"] == "05/31") echo "selected=\"selected\"";?>>May</option>
          <option value="06/30" <? if ($_POST["claim_open_to"] == "06/30") echo "selected=\"selected\"";?>>June</option>
          <option value="07/31" <? if ($_POST["claim_open_to"] == "07/31") echo "selected=\"selected\"";?>>July</option>
          <option value="08/31" <? if ($_POST["claim_open_to"] == "08/31") echo "selected=\"selected\"";?>>August</option>
          <option value="09/30" <? if ($_POST["claim_open_to"] == "09/30") echo "selected=\"selected\"";?>>September</option>
          <option value="10/31" <? if ($_POST["claim_open_to"] == "10/31") echo "selected=\"selected\"";?>>October</option>
          <option value="11/30" <? if ($_POST["claim_open_to"] == "11/30") echo "selected=\"selected\"";?>>November</option>
          <option value="12/31" <? if ($_POST["claim_open_to"] == "12/31") echo "selected=\"selected\"";?>>December</option>
        </select> 
        Claim open date. (optional) </td>
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
      <td><input name="action" type="hidden" id="action" value="show"></td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
</form>

<?
if ($_POST["action"] == "show") {
?>
<br><br>
<table width="552" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000">
  <tr>
    <td width="150"><strong>Total Claims <? echo $total_claims;?></strong> </td>
    <td width="100" align="center"><strong>OD</strong></td>
    <td width="100" align="center"><strong>PD</strong></td>
    <td width="100" align="center"><strong>BI</strong></td>
    <td width="100" align="center"><strong>TOTALS</strong></td>
  </tr>
  <tr>
    <td><strong>Oustanding Reserve </strong></td>
    <td align="center"><? echo sprintf("%01.2f",$os_reserve_od);?></td>
    <td align="center"><? echo sprintf("%01.2f",$os_reserve_pd);?></td>
    <td align="center"><? echo sprintf("%01.2f",$os_reserve_bi);?></td>
    <td align="center"><strong><? $out_total = $os_reserve_od + $os_reserve_pd + $os_reserve_bi; echo sprintf("%01.2f",$out_total);?></strong></td>
  </tr>
  <tr>
    <td><strong>Period Payments </strong></td>
    <td align="center"><? echo sprintf("%01.2f",$period_pey_od);?></td>
    <td align="center"><? echo sprintf("%01.2f",$period_pey_pd);?></td>
    <td align="center"><? echo sprintf("%01.2f",$period_pey_bi);?></td>
    <td align="center"><strong><? $res_total = $period_pey_od + $period_pey_pd + $period_pey_bi; echo sprintf("%01.2f",$res_total);?></strong></td>
  </tr>
  <tr>
    <td><strong>Totals</strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$period_pey_od + $os_reserve_od);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$period_pey_pd + $os_reserve_pd);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$period_pey_bi + $os_reserve_bi);?></strong></td>
    <td align="center"><strong><? echo sprintf("%01.2f",$res_total + $out_total);?></strong></td>
  </tr>
<?
$total = $res_total + $out_total;
?>
  <tr>
    <td><strong>%</strong></td>
    <td align="center"><? echo sprintf("%01.2f",(($period_pey_od + $os_reserve_od) *100) / $total);?>%</td>
    <td align="center"><? echo sprintf("%01.2f",(($period_pey_pd + $os_reserve_pd) *100) / $total);?>%</td>
    <td align="center"><? echo sprintf("%01.2f",(($period_pey_bi + $os_reserve_bi) *100) / $total);?>%</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<? } ?>

<?
$db->show_footer();
?>