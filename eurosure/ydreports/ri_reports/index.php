<?
include("../../include/main.php");
$db = new Main();


$db->show_header();
?>
<table width="721" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr>
    <td colspan="2" align="center" class="row_table_head">Reports for ReInsurance </td>
  </tr>
  <tr class="links_style">
    <td width="240"><a href="portfolio_analysis_bands_marine_hull.php">Risk Profile For Yachts </a></td>
    <td width="481">Yachts and Pleasure Craft Bands </td>
  </tr>
  <tr class="links_style">
    <td><a href="portfolio_analysis_bands_pl.php">Risk Profile For Public Liability </a></td>
    <td>Public liability risk profile bands </td>
  </tr>
  <tr class="links_style">
    <td><a href="portfolio_analysis_bands_medmal.php">Risk Profile For Medmal</a></td>
    <td>Medmal risk profile bands</td>
  </tr>
  <tr class="links_style">
    <td><a href="period_production_per_occupation_pl.php">Period Production  PI </a></td>
    <td>Specifically for PI that shows also turnover and occupation </td>
  </tr>
  <tr class="links_style">
    <td><a href="policies_as_at_date_breakdown.php">Estimated Policies Breakdown </a></td>
    <td>Shows the number of policies As At for Motor, PA, EL and PL </td>
  </tr>
  <tr class="links_style">
    <td><a href="period_production_per_marina_hull_2101.php">Marine Hull Per Marine </a></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="links_style">
    <td><a href="period_production_bands_pa.php">PA Bands  </a></td>
    <td>Period Production bands </td>
  </tr>
  <tr class="links_style">
    <td><a href="portfolio_analysis_bands.php">As At Date Bands</a></td>
    <td>Works for PL/PA </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="721" border="0" align="center" cellpadding="0" cellspacing="0" class="row_table_border">
  <tr>
    <td colspan="2" align="center" class="row_table_head">Thanos Reports</td>
  </tr>
  <tr class="links_style">
    <td width="240"><a href="claims_transaction_per_operation_date.php">Claims Per Payment/Reserve List</a></td>
    <td width="481">List of claims transactions for a specific operation date</td>
  </tr>
  <tr class="links_style">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?
$db->show_footer();
?>
