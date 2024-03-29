<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 10/2/2020
 * Time: 10:11 π.μ.
 */

function getMarineQuotation($quotationID){
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    //underwriter data
    $underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = '.$quotationData['oqq_users_ID']);


    //get items data
    $sect1 = $db->query_fetch("
      SELECT 
        *,
        (SELECT cde_value FROM codes WHERE oqqit_rate_10 = cde_code_ID)as clo_country_from,
        (SELECT cde_value FROM codes WHERE oqqit_rate_11 = cde_code_ID)as clo_country_via,
        (SELECT cde_value FROM codes WHERE oqqit_rate_12 = cde_code_ID)as clo_country_to,
        
        (SELECT cde_option_value FROM codes WHERE oqqit_rate_10 = cde_code_ID)as clo_country_from_type,
        (SELECT cde_option_value FROM codes WHERE oqqit_rate_11 = cde_code_ID)as clo_country_via_type,
        (SELECT cde_option_value FROM codes WHERE oqqit_rate_12 = cde_code_ID)as clo_country_to_type
        
        FROM 
        oqt_quotations_items 
        WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 3");
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 4");

    $html = '
<head>
<style>
.tableTdBorder td{
    border:1px solid #000000;
    padding:15px;
    font-size: 14px;
    font-family: Tahoma;
}
.tableTdNoBorder td{
    border:0px solid #FFFFFF;
    padding:5px;
    font-size: 11px;
    font-family: Tahoma;
}

.smallText{
    font-size: 10px;
    font-family: Tahoma;
}

body{
    margin-top: 0px; 
    margin-bottom: 0px; 
    margin-left: 0px; 
    margin-right: 0px;
    padding: 0;
 }
</style>
';

    for ($i=1; $i<=3; $i++) {
        $copy = '';
        if ($i==1){
            $copy = 'ORIGINAL';
        }
        else if ($i == 2){
            $copy = 'DUPLICATE';
        }
        else if ($i == 3){
            $copy = 'Non Negotiable Copy';
        }

        //certificate number
        if ($quotationData['oqq_status'] != 'Active'){
            $certificateNumber = 'DRAFT';
            $draft = 'DRAFT';
            $draftImage = 'background-image:url(' . $main['site_url'] . '/dynamic_quotations/images/draft.gif);';
        }
        else {
            $certificateNumber = $quotationData['oqq_number'];
            $draft = '';
            $draftImage = '';
        }

        //find approvals to show in pdf
        $approvalFromCountry = '';
        $approvalViaCountry = '';
        $approvalToCountry = '';
        $approvalCommodity= '';
        if ($quotationData['oqq_status'] == 'Pending'){
            $approvalHtml = ' [<span style="color: red; background: lightgrey;">Approval</span>]';

            //origin/from country
            if ($sect1['clo_country_from_type'] == 'Approval'){
                $approvalFromCountry = $approvalHtml;
            }
            //via country
            if ($sect1['clo_country_via_type'] == 'Approval'){
                $approvalViaCountry = $approvalHtml;
            }
            //to country
            if ($sect1['clo_country_to_type'] == 'Approval'){
                $approvalToCountry = $approvalHtml;
            }

            //commodity
            if ($sect1['oqqit_rate_4'] == 'Other'){
                $approvalCommodity = $approvalHtml;
            }

        }

        //underwriter open cover number
        $underwriterOpenCoverNumber = '';
        if ($underwriterData['oqun_open_cover_number'] != '' && strlen($underwriterData['oqun_open_cover_number']) >= 5){
            $underwriterOpenCoverNumber = "Open Cover Number: ".$underwriterData['oqun_open_cover_number'];
        }

        //find excess
        $excess = '';
        if ($sect1['oqqit_rate_4'] == 'General Cargo & Merchandise'){
            $excess = $underwriterData['oqun_excess_general_cargo'];
        }
        else if ($sect1['oqqit_rate_4'] == 'New/Used Vehicles'){
            $excess = $underwriterData['oqun_excess_vehicles'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Machinery'){
            $excess = $underwriterData['oqun_excess_machinery'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Temp. Controlled Cargo other than meat'){
            $excess = $underwriterData['oqun_excess_temp_no_meat'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Temp. Controlled Cargo Meat'){
            $excess = $underwriterData['oqun_excess_temp_meat'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Special Cover Mobile Phones, Electronic Equipment'){
            $excess = $underwriterData['oqun_excess_special_cover'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Personal Effects professionally packed'){
            $excess = $underwriterData['oqun_excess_pro_packed'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Personal Effects owner packed'){
            $excess = $underwriterData['oqun_excess_owner_packed'];
        }
        else if ($sect1['oqqit_rate_4'] == 'CPMB - Cyprus Potato Marketing Board'){
            $excess = $underwriterData['oqun_excess_owner_packed'];
        }
        else if ($sect1['oqqit_rate_4'] == 'Other'){
            $excess = $underwriterData['oqun_excess_other'];
        }


        //if the field 4_oqqit_rate_6 is empty then fill it with the underwriters commission.
        if ($sect2['oqqit_rate_6'] == ''){
            //update the db field with the excess from above

            $newData['rate_6'] = $excess;
            $db->db_tool_update_row('oqt_quotations_items',
                $newData,
                'oqqit_quotations_items_ID = '.$sect2['oqqit_quotations_items_ID'],
                $sect2['oqqit_quotations_items_ID'],
                '',
                'execute',
                'oqqit_');
            //update the sect2 data
            $sect2['oqqit_rate_6'] = $excess;
        }

        $conditionsOfInsurance = getConditionsOfInsurance($sect1['oqqit_rate_4'],$sect1['oqqit_rate_13']);

        //ocean vessel name and steamer
        if ($sect1['oqqit_rate_6'] == 'Ocean Vessel') {
            $oceanVessel = "<strong>Vessel Name:</strong> " . $sect1['oqqit_rate_7'];
        }
        else {
            $oceanVessel = '';
        }
        //for currency money format
        setlocale(LC_MONETARY, 'it_IT');


        if ($quotationData['oqq_quotations_ID'] <= 4020){
            $marketReferenceNum = 'B0750RARSP1900822';
        }
        else {
            $marketReferenceNum = 'B0750RARSP2000822';
        }

        $html .= '
</head>
<body>
<div style="font-family: Tahoma;">

    <table width="900" style="font-size: 12px; '.$draftImage.'">
        <tr>
            <td colspan="3">
                
                <table width="900">
                    <tr>
                        <td width="90%" style="font-size: 9px;">
                            <span style="font-size: 16px;">
                                <b>'.$copy.'</b>
                            </span><br><br>
                            CROMAR UNDERWRITING AGENCY S.A. - TME Coverholder<br>
                            Αττική: Αγ. Κωνσταντίνου 17 & Αγ. Αναργύρων 42, 151 24 Μαρούσι, Τηλ: 210 80 28 946, Fax: 210 80 29 055<br>
                            Θεσσαλονίκη: Πολυτεχνείου 24, 546 25 Θεσσαλονίκη, Τηλ: 2310 502 506-7, Fax: 2310 526 028<br>
                            Α.Φ.Μ. 801116254, ΔΟΥ: ΦΑΕ ΑΘΗΝΩΝ<br>
                            <br>
                            Attica: 17, Ag. Konstantinou & Ag. Anargiron str., 151 24 Marousi, Tel: +30 210 80 28 946, Fax: +30 210 80 29 055<br>
                            Thessaloniki: 24, Politechniou str., 546 25 Thessaloniki, Tel: +30 2310 502 506-7, Fax: +30 2310 526 028<br>
                            Tax No. 801116254, Tax Authority: FAE ATHINON<br>
                            e-mail: info@cromar.gr http://www.cromar.gr<br>
                            
                        </td>
                        <td align="right">
                            <img src="' . $db->admin_layout_url . '/images/tokio-marine-kiln_logo_2.jpg" width="150px">
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="center">&nbsp;<br></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>
                <span style="font-size: 20px;">CERTIFICATE OF INSURANCE<br>'.$certificateNumber.' '.$underwriterOpenCoverNumber.'</span>
            </b></td>
        </tr>
        <tr>
            <td colspan="3" align="justify">
                <b>This is to Certify</b> that Cromar Insurance Brokers Ltd are authorised by Underwriters at Tokio Marine 
                Europe Ltd to sign and issue this Certificate on their behalf (Under Unique Market Reference Number: 
                '.$marketReferenceNum.' and that the said Underwriters have undertaken to Issue Policy/Policies of Insurance 
                to cover up to EUR1.000.000 (or equivalent in other currencies), in all by any one approved steamer(s) 
                and/or motor vessel(s) and/or air and/or road and/or rail and/or as may be agreed in which will be embodied 
                to the Insurance declared hereunder to have been effected. 
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="10%">Conveyance:</td>
                        <td width="28%">' . $sect1['oqqit_rate_6'] . '</td>
                        <td width="6%">From:</td>
                        <td width="28%">' . $sect1['clo_country_from'] . $approvalFromCountry.' - '.$sect1['oqqit_rate_14'].'</td>
                        <td width="18%"></td>
                        <td width=""></td>
                    </tr>
                    <tr>
                       <td>Via</td>
                       <td>' . $sect1['oqqit_rate_11'] . $approvalViaCountry . '</td>
                       <td>To</td>
                       <td>' . $sect1['clo_country_to'] . $approvalToCountry . ' - '.$sect1['oqqit_rate_15'].'</td>
                       <td>Insured Value/Currency</td>
                       <td>' .number_format($sect1['oqqit_rate_3'],0,',','.')." ".$sect1['oqqit_rate_2'] . '</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%">
                    
                </table>
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="center"><hr style="color: #000000; height: 1px;"></td>
        </tr>
        
        <tr>
            <td colspan="3" height="220px" valign="top">
                <table width="100%">
                    <tr>
                        <td width="50%" valign="top">
                            <b>Marks and Numbers</b><br><br>
                            ' . nl2br($sect2['oqqit_rate_2']) . '<br><br><br>
                            <strong>Supplier</strong><br>
                            ' . nl2br($sect2['oqqit_rate_5']) . '<br><br>
                            ' .nl2br($sect2['oqqit_rate_3']).'
                        </td>
                        <td width="50%" valign="top">
                            <b>Goods Insured</b><br><br>
                            ' . nl2br($sect2['oqqit_rate_1']) . '<br>
                            '.$oceanVessel.'
                            '.($sect2['oqqit_rate_7'] != ''?('<br><b>Your Ref:</b>'.$sect2['oqqit_rate_7']):'').'
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="left">
                <strong>Shipment Date: on or about </strong> '.$db->convert_date_format($sect1['oqqit_date_1'],'yyyy-mm-dd','dd/mm/yyyy').'
                <hr style="color: #000000; height: 1px;">
            </td>
        </tr>
        <tr>
            <td colspan="3" height="230px" valign="top">
                <b>Conditions of Insurance '.$approvalCommodity.'</b><br><br>
                ' . $conditionsOfInsurance[0] . '<br>'.$sect2['oqqit_rate_6'].'
            </td>
            
        </tr>
        
        <tr>
            <td colspan="3" align="center">
                <b>Conditions Continued on the back hereof</b><br><br>
            </td>
        </tr>
        
        <tr>
            <td colspan="3">
                <b>Underwriters Agree Losses, if any, shall be payable to the order of 
                '.$quotationData['oqq_insureds_name'].'
                on surrender of this Certificate
                </b><br><br><br><br>
                
            </td>
        </tr>

        <tr>
            <td width="200"><b>
                    Place of Issue: Athens 
                    <br>
                    Date: '.$db->convert_date_format($quotationData['oqq_effective_date'],'yyyy-mm-dd','dd/mm/yyyy',1,1).'
                </b>
            </td>
            <td align="right">
                <img src="' . $db->admin_layout_url . '/images/tokiomarinesignature.jpg" width="250px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td align="right" style="font-size: 12px;">
                <img src="' . $db->admin_layout_url . '/images/cromar-signature-agency.jpg" width="200px">
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <b>IMPORTANT INSTRUCTIONS IN THE EVENT OF CLAIM</b>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="justify">
                In the event of physical evidence of loss or damage which may result in a claim under this insurance immediate notice must be given 
                <b>Within Cyprus</b> to Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd or Claims outside of Cyprus the nearest Lloyd’s Agent 
                at the port or place where the loss or damage is discovered in order that they may examine the goods and issue a survey report if 
                required. All documentation to be submitted to:
                <br><br>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="15%"></td>
                        <td width="60%">
                            Claims Department, Cromar Insurance Broker Ltd,<br>
                            17 Agiou Konstantinou Street,<br>
                            Marousi, 15124, Greece<br>
                        </td>
                        <td>
                            Tel. : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+30 210 8028946 <br>
                            Fax. : &nbsp;&nbsp;&nbsp;&nbsp;+30 210 8029055 <br>
                            E-mail: &nbsp;&nbsp;<u>claims@cromar.gr</u>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    
    <hr style="page-break-after: always; color: white;">
    
    <table width="900" style="font-size: 11px; '.$draftImage.'">
        <tr>
            <td colspan="3" align="center">
                <b>TERMINATION OF TRANSIT CLAUSE (TERRORISM)</b>
            </td>
        </tr>
        
        <tr>
            <td colspan="3">
                <b>This clause shall be paramount and shall override anything contained in this insurance inconsistent therewith.</b>
            </td>
        </tr>
        
        <tr>
            <td valign="top" width="20">1.</td>
            <td colspan="2" align="justify">
            Notwithstanding any provision to the contrary contained in this Policy or the Clauses referred to therein, it is 
            agreed that in so far as the Policy covers loss of or damage to the subject-matter insured caused by any terrorist 
            or any person acting from a political motive, such cover is conditional upon the subject matter either
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td width="20" valign="top">1.1</td>
            <td width="860" align="justify">
                As per the transit clauses contained within the Policy.<br>or
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">1.2</td>
            <td align="justify">
                on delivery to the Consignee`s or other final warehouse or place of storage  at the destination named herein,
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">1.3</td>
            <td align="justify">
                on delivery to any other warehouse or place of storage, whether prior to or at the destination named herein, 
                which the Assured elect to use either for storage other than tin the ordinary course of transit or for 
                allocation or distribution, <br> or 
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">1.4</td>
            <td align="justify">
                in respect of marine transits, on the expiry of 60 days after completion of discharge overside of the 
                goods hereby insured from the oversea vessel at the final port of discharge, 
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">1.5</td>
            <td align="justify">
                in respect of air transits, on the expiry of 30 days after unloading the subject-matter insured from 
                the aircraft at the final place of discharge, whichever shall first occur.  
            </td>
        </tr>
        
        <tr>
            <td valign="top">2.</td>
            <td valign="top"></td>
            <td align="justify">
                If this Policy or the Clauses referred to therein specifically provide cover for inland or other further 
                transits following on from storage, or termination as provided for above, cover will re-attach, and 
                continues during the ordinary course of that transit terminating again in accordance with the clause 1.  
            </td>
        </tr>
        
        <tr>
            <td valign="top">3.</td>
            <td></td>
            <td align="justify">
                This clause is subject to English law and practice.
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="center">
                <b>CARGO ISM ENDORSEMENT</b>
            </td>
        </tr>
        
        <tr>
            <td colspan="3">
                Applicable to shipments on board Ro-Ro passenger ferries.<br>
                Applicable with effect from 1 July 1998 to shipments on board:
            </td>
        </tr>
        
        <tr>
            <td>1.</td>
            <td colspan="2">
                Passenger vessels transporting more than 12 passengers and
            </td>
        </tr>
        
        <tr>
            <td valign="top">2.</td>
            <td colspan="2" align="justify">
                oil tankers, chemical tankers, gas carriers, bulk carriers and cargo high speed craft of 500 gt or more.<br>
                Applicable with effect from 1 July 2002 to shipments on board all other cargo ships and mobile offshore
                drilling units of 500 gt or more
            </td>
        </tr>
        
        <tr>
            <td valign="top">3.</td>
            <td colspan="2" align="justify">
                In no case shall this Insurance cover loss, damage or expense where the subject matter insured is carried 
                by a vessel that is not ISM Code certified or whose owners or operators do not hold an ISM Code Document 
                of Compliance when, at the time of loading of the subject matter insured on board the vessel, the Assured
                were aware, or in the ordinary course of business should have been aware: 
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">(a)</td>
            <td>
                Either that such vessel was not certified in accordance with the ISM Code.
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td valign="top">(b)</td>
            <td>
                Or that a current Document of Compliance was not held by her owners or operators as required under the
                SOLAS Convention 1974 as amended.
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="justify">
                This exclusion shall not apply where this insurance has been assigned to the party claiming hereunder
                who has bought or agreed to buy the subject matter insured in good faith under a binding contract.
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="center"><br>
                <b>CARGO ISM FORWARDING CHARGES CLAUSE</b>
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="justify">
                This insurance is extended to reimburse the Assured, up to the limit of the sum insured for the voyage,
                for any extra charges properly and reasonably incurred in unloading, storing and forwarding the 
                subject-matter to the destination to which it is insured hereunder following release of cargo from a vessel
                arrested or detained at or diverted to any other port or place (other than the intended port of destination)
                where the voyage is terminated due either:
            </td>
        </tr>
        
        <tr>
            <td valign="top">a)</td>
            <td colspan="2" align="justify">
                to such vessel not being certified in accordance with the ISM Code; <br>
                or
            </td>
        </tr>
        
        <tr>
            <td valign="top">b)</td>
            <td colspan="2" align="justify">
                to a current Document of Compliance not being held by her owners or operators;<br>
                as required under the SOLAS Convention 1974 as amended.
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="justify">
                This clause, which does not apply to General Average or Salvage or Salvage Charges, is subject to all other 
                terms conditions and exclusions contained in the policy.
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="center">
                <b>SANCTION LIMITATION AND EXCLUSION CLAUSE JC2010/014 (11/08/10)</b>
            </td>
        </tr>
        
        <tr>
            <td colspan="3" align="justify">
                No (re)insurer shall be deemed to provide cover and no (re)insurer shall be liable to pay any claim or 
                provide any benefit hereunder to the extent that the provision of such cover, payment of cuch claim or
                provision of such benefit would expose that (re)insurer to any sanction, prohibition or restriction under 
                United Nations resolutions or the trade or economic sanctions, laws or regulations of the European Union,
                United Kingdom or United States of America.
            </td>
        </tr>
        
    </table>
    
    <br>
    
    <div style="width:900px" style="font-size: 10px; text-align:center">
    <b>IMPORTANT INSTRUCTIONS IN THE EVENT OF A CLAIM</b>
    </div> 
    
<table width="900" class="tableTdBorder" cellpadding="0" cellspacing="0" style="'.$draftImage.'">
    <tr>
        <td width="410" align="center" valign="top">
        <table width="100%" border="0" class="tableTdNoBorder">
            <tr>
                <td align="center" style="font-size:12px;" colspan="2">
                    <b>DOCUMENTATION OF CLAIMS</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    To enable claims to be dealt with promptly, the Assured or their Agent are advised to submit all available 
                    supporting documents without delay, including when applicable:
                </td>
            </tr>
            <tr>
                <td width="15" align="left">1.</td>
                <td align="left">Original policy or certificate of insurance</td>
            </tr>
            <tr>
                <td width="15" align="left">2.</td>
                <td align="left">Original or copy of shipping invoices, together with shipping specifications and/or weight notes.</td>
            </tr>
            <tr>
                <td width="15" align="left">3.</td>
                <td align="left">Copy of Commercial invoice and Packing List.</td>
            </tr>
            <tr>
                <td width="15" align="left">4.</td>
                <td align="left">Original Bill Of Lading and/or other contract of carriage.</td>
            </tr>
            <tr>
                <td width="15" align="left">5.</td>
                <td align="left">Survey report or other documentary evidence to show the extent of the loss or damage.</td>
            </tr>
            <tr>
                <td width="15" align="left">6.</td>
                <td align="left">Lading account and weight notes at final destination.</td>
            </tr>
            <tr>
                <td width="15" align="left">7.</td>
                <td align="left">Copy of custom documents.</td>
            </tr>
            <tr>
                <td width="15" align="left">8.</td>
                <td align="left">Correspondence exchanged with the Carriers and other parties regarding their liability
                for the loss or damage.</td>
            </tr>
        </table>



        <div style="width:100%" style="text-align:justify; font-size:11px;">
            <br>
        </div>
        
        </td>
        <td width="80"></td>
        <td width="410" valign="top">
        <table width="100%" border="0" class="tableTdNoBorder">
            <tr>
                <td align="center" style="font-size:12px;" colspan="2">
                    <b>IMPORTANT<br>LIABILITY OF CARRIERS, BAILERS OR OTHER THIRD PARTIES</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    It is the duty of the Assured and their Agents, in all cases, to take such measures as may be reasonable 
                    for the purpose of averting or minimizing a loss and to ensure that all rights against Carriers, Bailees or other third
                    parties are properly preserved and exercised. In particular, the Assured or their Agents are required:-
                </td>
            </tr>
            <tr>
                <td width="15" align="left">1.</td>
                <td align="left">To claim immediately on the Carriers, Port Authorities or other Bailees for any missing packages.
                </td>
            </tr>
            <tr>
                <td width="15" align="left">2.</td>
                <td align="left">In no circumstances, except under written protest, to give clean receipts where goods are in doubtful condition,
                </td>
            </tr>
            <tr>
                <td width="15" align="left" valign="top">3.</td>
                <td align="left">When delivery is made by Container, to ensure that the Container and its seals are examined
                immediately by their responsible official. If the container is delivered damaged or with shipping documents, 
                to clause the delivery receipt accordingly and retain all defective or irregular seals for subsequent identification.
                </td>
            </tr>
            <tr>
                <td width="15" align="left" valign="top">4.</td>
                <td align="left">To apply immediately for survey by Carriers` or other Bailees` Representatives if any 
                loss or damage be apparent and claim on the Carriers or other Bailees for any actual loss or damage found at 
                such survey.
                </td>
            </tr>
            <tr>
                <td width="15" align="left" valign="top">5.</td>
                <td align="left">To give notice in waiting to the Carriers or other Bailees within 3 days of delivery 
                if the loss or damage was not apparent at the time of taking delivery.</td>
            </tr>
            <tr>
                <td width="15" align="left" colspan="2"><b>Note:</b> The Consignees or their Agents are recommended to make
                themselves familiar with the Regulations of the Port Authorities at the port of discharge.</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<br>
<div style="text-align:center; font-size:9px;">
    <b>
        Note:  The Institute Clauses Incorporated herein are deemed to be those current ath the time of commencement of the risk.
    </b>
</div>
    
</div>
';
        if ($conditionsOfInsurance[1] != ''){
            $html .= '
            <hr style="page-break-after: always; color: white;">
            <div style="font-size: 10px;">
            Page 3:<br>
            </div>
            <div style="font-size: 10px;" align="center">
                <b>Conditions Of Insurance:</b><br>
            </div>
            <br>
            <div style="font-size: 10px;">
                '.$conditionsOfInsurance[1].'
            </div>
            ';

        }
    }


    $html .= "</body>";
    return $html;
}

function getConditionsOfInsurance($commodity,$clause){
    if ($commodity == 'General Cargo & Merchandise'){
        if ($clause == 'Clause A') {
            $return[0] = '<strong>General Cargo - Shipments by Sea, Air or Land</strong>
            <br>Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 as applicable.
            <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
            <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009 as applicable. 
            <br>Institute Classification Clause CL354 dated 1.1.01.
            <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
            <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
            <br>Termination of Transit Clause (Terrorism).
            <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
            <br>Including transhipment, barge and lightering risks whether customary or otherwise.
            <br>Subject also to Additional Conditions as attached.
            ';
        }
        else {
            $return[0] = "
        <strong>ICC C</strong>
        <br>Institute Cargo Clauses “C” CL384 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons
        <br>Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as
        applicable.
        <br>Excluding Electrical and Mechanical derangement unless caused by a peril insured against.
        <br>Termination of Transit Clause Terrorism 2009 JC2009/056
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject also to Additional Conditions as attached.";
        }


    }

    if ($commodity == 'New/Used Vehicles'){
        $return[0] = '
        <strong>Automobiles, Motorcycles & Caravans – New Used, Second Hand</strong>
        <br>Institute Cargo Clauses “A” CL382 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br><b>Subject also to Additional Conditions as on page 3.</b>';

        $return[1] = ' 
        <br>Subject to a Certificate of Condition defined as: A document stating the condition of the vehicle at the time the vehicle enters the custody of the freight forwarder or steamship company noting all defects agreed by both the freight forwarder and the owner of the vehicle and signed at the same time.
        <br>Subject also to Automobile & Motorcycle Additional Conditions as follows:
        <br>
        <br>Additional Exclusions:
        <br>- Excluding the risks of scratching, denting, chipping, bruising, marring, staining.
        <br>- Excluding loss of or damage due to mechanical, electrical or electronic derangement unless there is evidence of external damage to the vehicle.
        <br>- Excluding loss or damage arising out of climatic or atmospheric conditions or extremes of temperature or freezing of coolant.
        <br>- Excluding rusting, oxidisation & discolouration unless caused by an insured peril.
        <br>- Excluding loss or damage to accessories or portable equipment unless declared prior to shipment.
        <br>- Excluding theft or pilferage of Audio / Visual and/or GPS equipment unless stolen with the vehicle.
        <br>- Excluding loss or damage whilst under own power, except whilst being loaded or unloaded from the carrying conveyance or container.
        <br>- Excluding loss or damage arising from climatic or atmospheric conditions or extremes of temperature or freezing of coolant, and/or frost damage.
        <br>- Excluding damages, injury or liabilities to any third party whatsoever.
        <br>- Excluding any claim recoverable under a policy of Motor Insurance.
        <br>- Excluding the risks of confiscation & seizure.
        <div style="height: 600px;"></div>
    ';
    }

    if ($commodity == 'Machinery'){
        $return[0] = '
        <strong>Machinery etc. - Shipments by Sea, Air or Land</strong>
        <br>Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 as applicable.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009 as applicable. 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Excluding Electrical and Mechanical derangement unless caused by a peril insured against.
        <br>Excluding rusting, oxidisation & discolouration unless caused by an insured peril.
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject also to Additional Conditions as attached.
        ';
    }

    if ($commodity == 'Temp. Controlled Cargo other than meat'){
        $return[0] = '
        <strong>Shipments by Sea or Land of Refrigerated or Temperature Controlled Cargoes, other than Meat</strong>
        <br>Institute Frozen / Chilled Food Clauses (A) – 24 Hour Breakdown Cl. 423 01.03.2017
        <br>Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 
        <br>Institute War Clauses (Cargo) CL385 1.1.09.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject also to Additional Conditions as attached.
        ';
    }

    if ($commodity == 'Temp. Controlled Cargo Meat'){
        $return[0] = '
        <strong>Shipments by Sea or Land of Refrigerated or Temperature Controlled Cargoes of Meat</strong>
        <br>Institute Frozen / Chilled Meat Clauses (A) – 24 Hour Breakdown Cl. 426 01.03.2017
        <br>Duration Clause 8.1.2 to apply. w/h to w/h or Duration Clause 8.1.3 to apply. fob
        <br>Strikes Clause (Frozen Chilled Meat) CL. 428 01.03.2017 
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject also to Additional Conditions as attached.
        ';
    }

    if ($commodity == 'Special Cover Mobile Phones, Electronic Equipment'){
        $return[0] = '
        <strong>Special Cargo, Electronic Equipment, Mobile Phones, Tablets</strong> 
        <br>Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 1.1.09.
        <br>Institute War Clauses (Air cargo) (excluding sendings by Post) CL388 1.1.09.
        <br>Institute Strikes Clauses (Air cargo) CL389 1.1.09.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Excluding loss of or damage due to mechanical, electrical or electronic derangement 
        <br>Excluding mysterious disappearance.
        <br>Warranted pallets are shrink wrapped and the contents obscured from view.
        ';
    }

    if ($commodity == 'Personal Effects professionally packed'){
        $return[0] = '
        <strong>Household Goods & Personal Effects – Professional packed  (Refer)</strong>
        <br>Institute Cargo Clauses “A” CL382 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism).
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br><b>Subject also to Additional Conditions as on page 3.</b>';

        $return[1] = '
        <br>Subject also to Household Goods & Personal Effects Additional Conditions as follows:
        <br>(a) Average Clause
        <br>This Policy is subject to the condition of average, that is to say, if the property covered by this Insurance shall at the time of loss be of greater value than the sum insured hereby the Assured shall only be entitled to recover hereunder such proportion of the said loss as the sum insured by this Policy bears to the total value of the said property.
        <br>
        <br>(b) Pairs and Sets Clause
        <br>Where any insured item consists of articles in a pair or set this Policy is not to pay more than the value of any particular part or parts which may be lost without reference to any special value which such article or articles may have as part of such pair or set, nor more than a proportionate part of such pair or set.
        <br>        
        <br>(c) Depreciation
        <br>Underwriters’ liability is restricted to the reasonable cost of repair and no claim is to attach hereto for depreciation consequent thereon.
        <br>
        <br>(d) Mechanical and Electrical Derangement
        <br>Excluding loss of or damage due to mechanical, electrical or electronic derangement unless there is evidence of external damage to the insured item or its packing.
        <br>
        <br>(e) Moth, Vermin, Wear & Tear
        <br>Excluding loss or damage due to moth, vermin, wear, tear and gradual deterioration.
        <br>
        <br>(f) Climatic Conditions Clause
        <br>Excluding loss or damage by climatic or atmospheric conditions or extremes of temperature.
        <br>
        <br>(g) Professional Packing
        <br>Excluding losses arising as a result of goods not having been professionally packed.
        <br>
        <br>(h) Excluded Goods
        <br>Excluding loss of or damage to furs valued over €200, or any cash, notes, stamps, deeds, tickets, travellers’ cheques, jewellery, watches, or similar valuable articles other than as declared and agreed herein.
        <br>
        <br>(i) Itemised Inventory
        <br>Subject to valued, itemised inventory to be lodged with Freight Forwarder prior to shipment.
        <div style="height: 400px;"></div>
        ';
    }

    if ($commodity == 'CPMB - Cyprus Potato Marketing Board'){
        $return[0] = '
        Institute Cargo Clauses (C) CL384.1.1.09. or Institute Frozen / Chilled Food Clauses (C) Cl. 431 01.03.2017 as applicable.
        <br>Institute Strike Clauses (Cargo) CL386.1.1.09 or Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 as applicable.
        <br>Institute War Clauses (Cargo) CL385 1.1.09. 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>
        <br>
        <br>
        <br>
        <br>
        
';

    }

    if ($commodity == 'Other'){
        $return[0] = '
        <br>Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by
        <br>Post) CL387 dated 01.01.2009 Institute Frozen / Chilled Food Clauses (A) - amended to 8 consecutive hours
        <br>Breakdown Cl. 423 01.03.2017 as applicable.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo)
        <br>CL389 dated 01.01.2009 and/or Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 as applicable.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding
        <br>sendings by Post) CL388 dated 01.01.2009 as applicable.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion
        CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC 2009/056 1.1.09 JC 2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        
        
        
        ';
    }

    return $return;

}
