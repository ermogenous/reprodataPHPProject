<?
include("../include/main.php");
$db = new Main();


$db->show_header();
?>
<script>
var user_level = <? echo $db->user_data["usr_user_rights"];?>;
function check_report() {
	
	if (user_level != 0) {
		
		alert('Report under construction.');
		return false;	
		
	}
return true;	
}

</script>
<table width="1016" border="0" cellspacing="0" cellpadding="0" class="menu_left_links">
  <tr>
    <td colspan="2"><strong><u>Reports with * are not to be used. Are under constuction</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PRODUCTION REPORTS </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_new.php">Production</a></td>
    <td>Customizable Period Production Report <a href="production_reports/period_production_new_v3.php">V3</a></td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_as_at_date_new.php">Production As At Date</a></td>
    <td>Customizable Period Production Report As At Date</td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_as_at_date_newV2.php">Production As At DateV2</a></td>
    <td>Customizable Period Production Report As At Date based on the line of business VIEW</td>
  </tr>
  <tr>
    <td width="218"><a href="production_reports/period_production_v2.php">Period Production </a></td>
    <td width="798">Production Totals for a specified period range. Only for Synthesis System. </td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_cymenu.php">Period Production For CYMENU </a></td>
    <td>Production Totals for a specified period range. Only for Cymenu </td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_advanced.php">Period Production Advanced </a></td>
    <td>Gets production from old and new system. Can get many years at once. Work In Progress </td>
  </tr>
  <tr>
    <td><a href="production_reports/unearned_premium_per_account_code.php">Unearned Per Account Code</a></td>
    <td>Groups the unearned premium per account code (REP: in loadings) + shows the Quota Unearned </td>
  </tr>
  <tr>
    <td><a href="production_reports/productions_by_section.php" onclick="return check_report();">*Production/Claims By Section </a></td>
    <td>Production and claims per agent for a specified period range. Can show up to 3 separated years </td>
  </tr>
  
  <tr>
    <td><a href="production_reports/production_by_loadings.php" onclick="return check_report();">*Loadings/Perils Production </a></td>
    <td>Filter the premium for a specific financial period by loadings And/Or Perils. </td>
  </tr>
  <tr>
    <td><a href="production_reports/diatirisimotita.php">Diatirisimotita With 2 Years </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="production_reports/motor_per_loading_cover.php" onclick="return check_report();">*Motor Per Loading Cover </a></td>
    <td>Calculates the premium for a specific financial period based on the LOADING cover.NOT THE POLICY COVER </td>
  </tr>
  <tr>
    <td><a href="production_reports/policies_as_at_date.php" onclick="return check_report();">*Policies Index AS AT DATE </a></td>
    <td>Shows policies that are covered on a specific day (as at date) PER ITEM</td>
  </tr>
  <tr>
    <td><a href="production_reports/policies_as_at_date_per_situation.php">Policies Index AS AT DATE SIT</a></td>
    <td>Shows policies that are covered on a specific day (as at date) PER SITUATION</td>
  </tr>
  <tr>
    <td><a href="production_reports/premium_per_specified_loadings.php">Premium Per Specified Loadings </a></td>
    <td>Shows the written premium by selecting specific loadings. At the bottom a total per T/P, F&amp;T and Comp. loadings </td>
  </tr>
  <tr>
    <td><a href="production_reports/policies_as_at_date_cresta_zones.php">Policies As At Date Cresta Zones </a></td>
    <td>Shows the totals insured amounts, premiums per each cresta zone. </td>
  </tr>
  <tr>
    <td><a href="production_reports/new_renewal_production.php" onclick="return check_report();">*New/Renewals Production </a></td>
    <td>Shows the total production grouped as new/renewals. Adds each endorsement/cancellation phase accordingly </td>
  </tr>
  <tr>
    <td><a href="production_reports/premium_per_policy_occupation.php">Premiums Per Policy Occupation </a></td>
    <td>Groups the premiums by the Policy Occupation, Shows Insured Amounts, Premium, Number Of Risks </td>
  </tr>
  <tr>
    <td><a href="production_reports/premium_per_item_per_policy_insured_amount.php">Premium Per Item</a></td>
    <td>Groups the premiums per policy items. Also extra group per policy insured amount. </td>
  </tr>
  <tr>
    <td><a href="production_reports/premium_per_commission.php" onclick="return check_report();">*Premium Per Commission </a></td>
    <td>Groups per agent, insurance type and shows premium on each commission </td>
  </tr>
  
  <tr>
    <td><a href="production_reports/unearned_premium_per_ac_code.php" onclick="return check_report();">*Unearned Premium Per A/C Code </a></td>
    <td>Groups the unearned premium per account code (commissions in sub form) + shows the Quota Unearned </td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_for_pa_medical.php" onclick="return check_report();">*Production for PA &amp; Medical</a></td>
    <td>Shows the production per Group,Atlantas etc for products PA &amp; Medical</td>
  </tr>
  <tr>
    <td><a href="production_reports/period_production_per_policy.php" onclick="return check_report();">*Period Production Per policy</a></td>
    <td>Production Current Year vs Previous Year / Policies Analysis / Policies Convertion</td>
  </tr>
  <tr>
    <td><a href="production_reports/per_driver.php">Production Per Drivers</a></td>
    <td>Shows number of drivers and procution per age</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>CLAIMS</p>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="claims/claims_report.php">Claims</a></td>
    <td>General Claims Report</td>
  </tr>
  <tr>
    <td><a href="claims/od_pd_bi.php">OD PD BI Totals </a></td>
    <td>Shows the claims based on OD, PD, BI of the claim. Also shows claims per POLICY COVER </td>
  </tr>
  
  <tr>
    <td><a href="claims/claims_ratio_report.php">Claims Ratio Report OLD</a></td>
    <td>Shows claims ratio per section. Both Cymenu and Synthesis</td>
  </tr>
  <tr>
    <td><a href="claims/claims_ratio_report_v2.php">Claims Ratio Report V2</a></td>
    <td>Shows claims ratio per section. Only Synthesis</td>
  </tr>
  <tr>
    <td><a href="claims/claims_per_section.php" onclick="return check_report();">*Claims Per Section </a></td>
    <td>Filters the claims per section such as Drivers Age </td>
  </tr>
  <tr>
    <td><a href="claims/claims_per_nationality.php">Claims Per Nationality </a></td>
    <td>Filters the claims per clients nationality and or driver </td>
  </tr>
  <tr>
    <td><a href="claims/claims_per_peril.php">Claims Per Peril Code </a></td>
    <td>Filters the claims per peril code and reserve/payment </td>
  </tr>
  <tr>
    <td><a href="claims/claims_as_at_date_ia_bands.php" onclick="return check_report();">*Claims Per Insured Amount Bands </a></td>
    <td>Shows the claims as at date and creates bands based on the policy insured amount </td>
  </tr>
  <tr>
    <td><a href="claims/claims_per_payment_code.php">Claims Per Payment Code </a></td>
    <td>Show the total payments per payment code </td>
  </tr>
  <tr>
    <td><a href="claims/claims_list_full_details.php">Claims Full Details </a></td>
    <td>Produces a list of claims with full details such as vehicles/drivers/policy details  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>OTHER</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="other/direct_clients_addresses.php" onclick="return check_report();">*Direct Clients Addresses </a></td>
    <td>All the direct clients (clients under the direct larnaca agent) addresses </td>
  </tr>
  <tr>
    <td><a href="other/portfolio_analysis_bands.php" onclick="return check_report();">*Portfolio Analysis Bands Cymenu </a></td>
    <td>Portfolio analysis bands for reinsurers from CYMENU </td>
  </tr>
  <tr>
    <td><a href="other/portfolio_analysis_bands_synthesis.php" onclick="return check_report();">*Portfolio Analysis Bands Synthesis </a></td>
    <td>Portfolio analysis bands for reinsurers from Synthesis </td>
  </tr>
  <tr>
    <td><a href="other/loadings.php">Loadings List </a></td>
    <td>Shows all the loadings. Filter with insurance type </td>
  </tr>
  <tr>
    <td><a href="other/cancellation_reasons.php" onclick="return check_report();">*Cancellation Reasons </a></td>
    <td>Shows the reason of cancellation of the policies. </td>
  </tr>
  <tr>
    <td><a href="other/actions_per_agent.php">Actions Per Agent </a></td>
    <td>Filters the actions per agent or other filters </td>
  </tr>
  <tr>
    <td><a href="other/renewals_statistics.php">Renewals Statistics </a></td>
    <td>Shows for a specific period how many renewals occurred and what was the result of these renewals. </td>
  </tr>
  <tr>
    <td><a href="other/policies_car_count_and_premium.php" onclick="return check_report();">*Policies Car Count &amp; Premium </a></td>
    <td>Shows as at the policies active in a specific day but shows premium,mif and other from all the policy phases. </td>
  </tr>
  <tr>
    <td><a href="other/policies_per_nationality.php" onclick="return check_report();">*Policies Per Clients Nationality </a></td>
    <td>Filters policies per clients occupation. Also shows premiums, fees, stamps </td>
  </tr>
  <tr>
    <td><a href="other/el_prod_claims.php" onclick="return check_report();">*EL Production/Claims </a></td>
    <td>EL production from all the insurance types. Can be grouped by occupation/agents</td>
  </tr>
  <tr>
    <td><a href="other/documents_printed.php" onclick="return check_report();">*Documents Printed</a></td>
    <td>Shows printed documents from policies/claims </td>
  </tr>
  <tr>
    <td><a href="other/clients_production_over_amount.php">Clients Production</a></td>
    <td>Clients production grouped with ID and Account. Finds over specified production amount.</td>
  </tr>
  <tr>
    <td><a href="other/agents_reports.php">Agents Reports</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>CLIENTS REPORTS </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="clients/insured_amounts.php" onclick="return check_report();">*Insured Amounts </a></td>
    <td>Filter by a specified insured amount range the clients </td>
  </tr>
  <tr>
    <td><a href="clients/clients_list.php">Clients Group List</a></td>
    <td>Groups Clients per account code OR cosnolidation</td>
  </tr>
  <tr>
    <td><a href="clients/clients_list_v2.php">Clients List</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PROFITABILITY REPORTS </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="profitability_reports/profitability_per_policy_occupation.php" onclick="return check_report();">*Per Policy Occupation </a></td>
    <td>Shows profitability based on the POLICY OCCUPATION </td>
  </tr>
</table>
<?
$db->show_footer();
?>