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
</head>
<body>
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
        else if ($sect1['oqqit_rate_4'] == 'Tobacco'){
            $excess = $underwriterData['oqun_excess_tobacco'];
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

        $conditionsOfInsurance = getConditionsOfInsurance($sect1['oqqit_rate_4'],$sect1['oqqit_rate_13'],$quotationID);

        //ocean vessel name and steamer
        if ($sect1['oqqit_rate_6'] == 'Ocean Vessel') {
            $oceanVessel = "<strong>Vessel Name:</strong> " . $sect1['oqqit_rate_7'];
        }
        else {
            $oceanVessel = '';
        }

        if ($sect2['oqqit_rate_10'] != ''){
            $bolInvoice = '<br><b>BOL/AWB:</b> '.$sect2['oqqit_rate_10']."<br>";
        }
        if ($sect2['oqqit_rate_11'] != ''){
            $bolInvoice .= '<b>Invoice:</b> '.$sect2['oqqit_rate_11'];
        }


        //for currency money format
        setlocale(LC_MONETARY, 'it_IT');

        if ($quotationData['oqq_status'] == 'Active'){
            $signature = '<img src="' . $main['site_url'] . '/dynamic_quotations/images/stamp_signature.png" width="150px"><br>Authorised Signatory Kemter Insurance Agencies, Sub-Agencies & Consultants Ltd.';
        }
        else {
            $signature = 'Signature Pending';
        }

        if ($i > 1){
            //$pageBreak = '<hr style="page-break-after: always; color: white;">';
            //Duplicate/Non negotiable copy
            $pageBreak = '<pagebreak>';
        }
        else {
            //ORIGINAL
            $pageBreak = '';
        }

        //if declared value currency and freight value currency are the same then show that currency else show eur
        if ($sect1['oqqit_rate_2'] == $sect1['oqqit_rate_16']){
            $insuredValue = ($sect1['oqqit_rate_3'] + $sect1['oqqit_rate_17']) * (($sect1['oqqit_rate_19'] / 100) + 1);
            $insuredValue = round($insuredValue,2);
            $insuredValueCurrency = $sect1['oqqit_rate_2'];

            //echo $sect1['oqqit_rate_19'];
            //exit();
        }
        else {
            $insuredValue = $sect1['oqqit_rate_20'];
            $insuredValueCurrency = 'EUR';
        }

        $html .= '
'.$pageBreak.'
<div style="font-family: Tahoma;">

    <table width="900" style="font-size: 12px; '.$draftImage.'">
        <tr>
            <td colspan="3">
                
                <table width="900">
                    <tr>
                        <td width="35%" style="font-size: 9px;">
                            <span style="font-size: 16px;">
                                <b>'.$copy.'</b>
                            </span><br><br>
                            THIS CERTIFICATE REQUIRES ENDORSEMENT<br> IN THE EVENT OF ASSIGNMENT                            
                        </td>
                        <td width="30%" align="center">
                            <img src="' . $db->admin_layout_url . 'images/Kemter-Icon.png" height="110px">
                        </td>
                        <td width="35%" align="right">
                            <img src="' . $db->admin_layout_url . 'images/lloyds_logo.jpg" width="150px">
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
                <b>This is to Certify</b> that <b>Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd</b> are 
                authorised by Underwriters at <b>Lloyd’s Insurance Company S.A.</b> to sign and issue this Certificate 
                on their <b>behalf (Under Unique Market Reference Number: B1808L210003)</b> and that the said 
                Underwriters have undertaken to Issue Policy/Policies of Insurance to cover up to EUR5.000.000 (or 
                equivalent in other currencies), in all by any one approved steamer(s) and/or motor vessel(s) and/or 
                air and/or road and/or rail and/or as may be agreed in which will be embodied to the Insurance declared 
                hereunder to have been effected.  
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table width="100%" border="0">
                    <tr>
                        <td width="25%"><b>Conveyance</b></td>
                        <td width="25%"><b>Issue Date</b></td>
                        <td width="25%"><b>Insured Value/Currency</b></td>
                        <td width="25%" rowspan="5" align="center" style="font-size: 10px">
                            '.$signature.'
                        </td>
                    </tr>
                    <tr>
                        <td>' . $sect1['oqqit_rate_6'] . '</td>
                        <td>'.$db->convert_date_format($quotationData['oqq_effective_date'],'yyyy-mm-dd','dd/mm/yyyy',1,1).'</td>
                        <td>' .number_format($insuredValue,2,',','.').' '.$insuredValueCurrency.'</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td><b>From</b></td>
                        <td><b>To</b></td>
                        <td><b>Via</b></td>
                    </tr>

                    <tr>
                        <td>' . $sect1['clo_country_from'] . $approvalFromCountry.' - '.$sect1['oqqit_rate_14'].'</td>
                        <td>' . $sect1['clo_country_to'] . $approvalToCountry . ' - '.$sect1['oqqit_rate_15'].'</td>
                        <td>' . $sect1['oqqit_rate_11'] . $approvalViaCountry . '</td>
                    </tr>
                    <tr>
                        <td height="10">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
            <td colspan="3" height="150px" valign="top">
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
                            '.$bolInvoice.'
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="left">
                <strong>Shipment Date: on or about </strong> '.$db->convert_date_format($sect1['oqqit_date_1'],'yyyy-mm-dd','dd/mm/yyyy').'
            </td>
        </tr>
        </table>
        <hr style="color: #000000; height: 1px;">
        <div style="font-size: 9px">
            <p align="center">
                <b>Conditions of Insurance '.$approvalCommodity.'</b>
            </p>
            ' . $conditionsOfInsurance[0] . '<br>
            '.$sect2['oqqit_rate_6'].'
            <p align="center"><b>Conditions Continued on the back hereof</b></p>
            <b>Underwriters Agree Losses, if any, shall be payable to the order of 
            '.$quotationData['oqq_insureds_name'].'
            on surrender of this Certificate</b>
            <br>
            <p align="center"><b>IMPORTANT INSTRUCTIONS IN THE EVENT OF CLAIM</b></p>
            <p align="justify" style="font-size: 10px">
                In the event of physical evidence of loss or damage which may result in a claim under this insurance 
                immediate notice must be given <strong>Within Cyprus</strong> to Kemter Insurance Agencies Sub-Agencies 
                and Consultants Ltd or Claims outside of Cyprus the nearest Lloyd’s Agent at the port or place where 
                the loss or damage is discovered in order that they may examine the goods and issue a survey report 
                if required. All documentation to be submitted to:
            </p>
            <table width="900" style="font-size: 10px">
                <tr>
                    <td width="10%"></td>
                    <td width="50%">
                        Kemter Insurance Agencies Sub-Agencies and Consultants Ltd,<br>
                        Akinita Ieras Mitropolis,<br>
                        Block B’, Office 112,<br>
                        3040 Limassol, Cyprus
                    </td>
                    <td width="40%">
                        Tel. : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+357 25 755 952 <br>
                        Fax. : &nbsp;&nbsp;&nbsp;&nbsp;+357 25 755 953 <br>
                        E-mail: &nbsp;&nbsp;<u>claims@kemterinsurance.com</u>
                    </td>
                </tr>
                <tr><td height="25"></td></tr>
                <tr>
                    <td colspan="2">Certificate No. '.$certificateNumber.' '.$underwriterOpenCoverNumber.'</td>
                    <td align="right">Page 1 of 2</td>
                </tr>
            </table>
            
            <pagebreak></pagebreak>
            <p align="center"><strong>This is page 2 of 2 total pages of Certificate No. '.$certificateNumber.' '.$underwriterOpenCoverNumber.'</strong></p>
            '.$conditionsOfInsurance[1].'
            
            </b>
        </div>
           
<table width="900" class="tableTdBorder" cellpadding="0" cellspacing="0" style="'.$draftImage.'">
    <tr>
        <td width="400" align="center" valign="top">
        <table width="100%" border="0" class="tableTdNoBorder" style="font-size: 10px;">
            <tr>
                <td align="center" style="font-size:10px;" colspan="2">
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
        <td width="40"></td>
        <td width="460" valign="top">
        <table width="100%" border="0" class="tableTdNoBorder" style="font-size:11px;" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" colspan="2">
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
    }


    $html .= "</body>";
    return $html;
}

function getConditionsOfInsurance($commodity,$clause,$quotationID){
    if ($commodity == 'General Cargo & Merchandise'){
        if ($clause == 'Clause A') {
            $return[0] = '
            
            Institute Cargo Clauses “A” CL382 dated 01.01.2009 and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 as applicable.
            <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
            <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Air Cargo) CL389 dated 01.01.2009 as applicable.
            <br>Institute Classification Clause CL354 dated 1.1.01.
            <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical &amp; Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
            <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
            <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
            <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
            <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
            <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
            <br>Including transhipment, barge and lightering risks whether customary or otherwise.';
            $return[1] = '
            <strong>Excluded Risks and Interests:</strong>
            <ul>
                <li>New or Used Machinery etc.</li>
                <li>Motor Vehicles </li>
                <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
                <li>Tobacco and Manufactured Tobacco Substitutes </li>
                <li>Pharmaceutical Products </li>
                <li>Household and Personal Effects</li>
                <li>Consumer accounts</li>
                <li>Rejection risks</li>
                <li>Ocean tows</li>
                <li>Nuclear fuel including yellow cake</li>
                <li>Containers written as such</li>
                <li>War on land</li>
                <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
                <li>Nut risks where goods are stored at or near a processing plant</li>
                <li>Wineries</li>
                <li>Hay</li>
                <li>Cotton</li>
                <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
                <li>Nursery risks</li>
                <li>Commodity traders</li>
                <li>Retail locations</li>
                <li>Coal</li>
                <li>Storage outside the ordinary course of transit</li>
                <li>Primary and excess stock only</li>
                <li>Fine Arts and Species</li>
                <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
                <li>Stamps, credit and debit cards including telephone calling cards</li>
                <li>Jewellery, watches, precious stones and precious metals </li>
                <li>Aircrafts, ships, boats, any floating structures</li>
                <li>Tanks and other armoured fighting vehicles</li>
                <li>Arms and ammunitions, parts and accessories thereof</li>
                <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
                <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
                <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
                <li>Blood & Life Science Products</li>
                <li>Cash in transit</li>
                <li>Fishmeal</li>
                <li>Railway or Tramway Locomotives</li>
            </ul>
            <strong>Excluded Bulk Merchandise</strong>
            <ul>
                <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
                <li>Lac, Gums, Resins and Other Vegetable Saps and Extracts</li> 
                <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
                <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
                <li>Residues and Waste from the Food Industries</li>
                <li>Beverages, Spirits and Vinegar</li>
            </ul>
            ';
        }
        else {
            $return[0] = "
        <strong>ICC C</strong>
        <br>Institute Cargo Clauses “C” CL384 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        ";
        }
    }/* updated 23/07/2021*/

    if ($commodity == 'New/Used Vehicles'){
        $return[0] = '
        Institute Cargo Clauses “A” CL382 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject to a Certificate of Condition defined as: A document stating the condition of the vehicle at the time the vehicle enters the custody of the freight forwarder or steamship company noting all defects agreed by both the freight forwarder and the owner of the vehicle and signed at the same time.
        ';
        $return[1] = '
        <strong>Additional Exclusions:</strong>
        <ul>
        <li>Excluding the risks of scratching, denting, chipping, bruising, marring, staining.</li>
        <li>Excluding loss of or damage due to mechanical, electrical or electronic derangement unless there is evidence of external damage to the vehicle.</li>
        <li>Excluding loss or damage arising out of climatic or atmospheric conditions or extremes of temperature or freezing of coolant.</li>
        <li>Excluding rusting, oxidisation & discolouration unless caused by an insured peril.</li>
        <li>Excluding loss or damage to accessories or portable equipment unless declared prior to shipment.</li>
        <li>Excluding theft or pilferage of Audio / Visual and/or GPS equipment unless stolen with the vehicle.</li>
        <li>Excluding loss or damage whilst under own power, except whilst being loaded or unloaded from the carrying conveyance or container.</li>
        <li>Excluding loss or damage arising from climatic or atmospheric conditions or extremes of temperature or freezing of coolant, and/or frost damage.</li>
        <li>Excluding damages, injury or liabilities to any third party whatsoever.</li>
        <li>Excluding any claim recoverable under a policy of Motor Insurance.</li>
        <li>Excluding the risks of confiscation & seizure.</li>
        </ul>
        <br>
        <br>
        <strong>Excluded Risks and Interests:</strong>
        <br>
        <table width="900" style="font-size: 12px">
            <tr>
                <td>
                    <ul>
                        <li>General Cargo, Goods and/or Merchandise of every description</li> 
                        <li>New or Used Machinery</li>
                        <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
                        <li>Tobacco and Manufactured Tobacco Substitutes </li>
                        <li>Pharmaceutical Products </li>
                        <li>Household and Personal Effects</li>
                        <li>Consumer accounts</li>
                        <li>Rejection risks</li>
                        <li>Ocean tows</li>
                        <li>Nuclear fuel including yellow cake</li>
                        <li>Containers written as such</li>
                        <li>War on land</li>
                        <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
                        <li>Nut risks where goods are stored at or near a processing plant</li>
                        <li>Wineries</li>
                        <li>Hay</li>
                        <li>Cotton</li>
                        <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li>Nursery risks</li>
                        <li>Commodity traders</li>
                        <li>Retail locations</li>
                        <li>Coal</li>
                        <li>Storage outside the ordinary course of transit</li>
                        <li>Primary and excess stock only</li>
                        <li>Fine Arts and Species </li>
                        <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
                        <li>Stamps, credit and debit cards including telephone calling cards</li>
                        <li>Jewellery, watches, precious stones and precious metals </li>
                        <li>Aircrafts, ships, boats, any floating structures</li>
                        <li>Tanks and other armoured fighting vehicles</li>
                        <li>Arms and ammunitions, parts and accessories thereof</li>
                        <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
                        <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
                        <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
                        <li>Blood & Life Science Products</li>
                        <li>Cash in transit</li>
                        <li>Fishmeal</li>
                        <li>Railway or Tramway Locomotives</li>
                    </ul>
                </td>
            </tr>
        </table>
        
        <br>
        <strong>Excluded Bulk merchandise</strong>
        <br>
        <ul>
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac, Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        ';

    }/* updated 23/07/2021*/

    if ($commodity == 'Machinery'){
        $return[0] = '
        Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 as applicable.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009 as applicable. 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Excluding Electrical and Mechanical derangement unless caused by a peril insured against.
        <br>Excluding rusting, oxidisation & discolouration unless caused by an insured peril.
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        ';
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <br>
        <ul>
            <li>General Cargo, Goods and/or Merchandise of every description</li> 
            <li>Motor Vehicles </li>
            <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
            <li>Tobacco and Manufactured Tobacco Substitutes </li>
            <li>Pharmaceutical Products </li>
            <li>Household and Personal Effects</li>
            <li>Consumer accounts</li>
            <li>Rejection risks</li>
            <li>Ocean tows</li>
            <li>Nuclear fuel including yellow cake</li>
            <li>Containers written as such</li>
            <li>War on land</li>
            <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
            <li>Nut risks where goods are stored at or near a processing plant</li>
            <li>Wineries</li>
            <li>Hay</li>
            <li>Cotton</li>
            <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
            <li>Nursery risks</li>
            <li>Commodity traders</li>
            <li>Retail locations</li>
            <li>Coal</li>
            <li>Storage outside the ordinary course of transit</li>
            <li>Primary and excess stock only</li>
            <li>Fine Arts and Species</li>
            <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
            <li>Stamps, credit and debit cards including telephone calling cards</li>
            <li>Jewellery, watches, precious stones and precious metals </li>
            <li>Aircrafts, ships, boats, any floating structures</li>
            <li>Tanks and other armoured fighting vehicles</li>
            <li>Arms and ammunitions; parts and accessories thereof</li>
            <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
            <li>Fur skins and Artificial Fur; Manufactures Thereof</li>
            <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
            <li>Blood & Life Science Products</li>
            <li>Cash in transit</li>
            <li>Fishmeal</li>
            <li>Railway or Tramway Locomotives</li>
        </ul>
        <br>
        <strong>Excluded Bulk merchandise</strong>
        <br>
        <ul>
        <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
        <li>Lac; Gums, Resins and Other Vegetable Saps and Extracts</li> 
        <li>Products of the Milling Industry, Malt; Starches, Inulin, Wheat Gluten, Cereals</li> 
        <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
        <li>Residues and Waste from the Food Industries </li>
        <li>Beverages, Spirits and Vinegar </li>
        </ul>
        
        ';
    }/* updated 23/07/2021*/

    if ($commodity == 'Temp. Controlled Cargo other than meat'){
        $return[0] = '
        Institute Frozen / Chilled Food Clauses (A) – 24 Hour Breakdown Cl. 423 01.03.2017
        <br>Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 
        <br>Institute War Clauses (Cargo) CL385 1.1.09.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        ';
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <br>
        <ul>
        <li>General Cargo, Goods and/or Merchandise of every description</li> 
        <li>New or Used Machinery</li>
        <li>Motor Vehicles </li>
        <li>Frozen or Chilled Meat</li>
        <li>Tobacco and Manufactured Tobacco Substitutes</li> 
        <li>Pharmaceutical Products </li>
        <li>Household and Personal Effects</li>
        <li>Consumer accounts</li>
        <li>Rejection risks</li>
        <li>Ocean tows</li>
        <li>Nuclear fuel including yellow cake</li>
        <li>Containers written as such</li>
        <li>War on land</li>
        <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
        <li>Nut risks where goods are stored at or near a processing plant</li>
        <li>Wineries</li>
        <li>Hay</li>
        <li>Cotton</li>
        <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
        <li>Nursery risks</li>
        <li>Commodity traders</li>
        <li>Retail locations</li>
        <li>Coal</li>
        <li>Storage outside the ordinary course of transit</li>
        <li>Primary and excess stock only</li>
        <li>Fine Arts and Species</li>
        <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
        <li>Stamps, credit and debit cards including telephone calling cards</li>
        <li>Jewellery, watches, precious stones and precious metals </li>
        <li>Aircrafts, ships, boats, any floating structures</li>
        <li>Tanks and other armoured fighting vehicles</li>
        <li>Arms and ammunitions, parts and accessories thereof</li>
        <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
        <li>Fur skins and Artificial Fur; Manufactures Thereof</li>
        <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
        <li>Blood & Life Science Products</li>
        <li>Cash in transit</li>
        <li>Fishmeal</li>
        <li>Railway or Tramway Locomotives</li>
        </ul>
        <br>
        <br>
        <strong>Excluded Bulk merchandise</strong>
        <ul> 
        <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
        <li>Lac; Gums, Resins and Other Vegetable Saps and Extracts</li> 
        <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
        <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
        <li>Residues and Waste from the Food Industries </li>
        <li>Beverages, Spirits and Vinegar </li>
        </ul>
        ';
    }/* updated 23/07/2021*/

    if ($commodity == 'Temp. Controlled Cargo Meat'){
        $return[0] = '
        Institute Frozen / Chilled Meat Clauses (A) – 24 Hour Breakdown Cl. 426 01.03.2017
        <br>Duration Clause 8.1.2 to apply. w/h to w/h or Duration Clause 8.1.3 to apply. fob
        <br>Strikes Clause (Frozen Chilled Meat) CL. 428 01.03.2017 
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        ';
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <br>
        <ul>
            <li>General Cargo, Goods and/or Merchandise of every description</li> 
            <li>New or Used Machinery</li>
            <li>Motor Vehicles </li>
            <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
            <li>Tobacco and Manufactured Tobacco Substitutes </li>
            <li>Pharmaceutical Products </li>
            <li>Household and Personal Effects</li>
            <li>Consumer accounts</li>
            <li>Rejection risks</li>
            <li>Ocean tows</li>
            <li>Nuclear fuel including yellow cake</li>
            <li>Containers written as such</li>
            <li>War on land</li>
            <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
            <li>Nut risks where goods are stored at or near a processing plant</li>
            <li>Wineries</li>
            <li>Hay</li>
            <li>Cotton</li>
            <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
            <li>Nursery risks</li>
            <li>Commodity traders</li>
            <li>Retail locations</li>
            <li>Coal</li>
            <li>Storage outside the ordinary course of transit</li>
            <li>Primary and excess stock only</li>
            <li>Fine Arts and Species</li>
            <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
            <li>Stamps, credit and debit cards including telephone calling cards</li>
            <li>Jewellery, watches, precious stones and precious metals </li>
            <li>Aircrafts, ships, boats, any floating structures</li>
            <li>Tanks and other armoured fighting vehicles</li>
            <li>Arms and ammunitions, parts and accessories thereof</li>
            <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
            <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
            <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
            <li>Blood & Life Science Products</li>
            <li>Cash in transit</li>
            <li>Fishmeal</li>
            <li>Railway or Tramway Locomotives</li>
        </ul>
        <strong>Excluded Bulk merchandise</strong>
        <br>
        <ul>
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac; Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        <br><br>
        ';
    }/* updated 23/07/2021*/

    if ($commodity == 'Special Cover Mobile Phones, Electronic Equipment'){
        $return[0] = '
        Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009.
        <br>Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009. 
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Institute Replacement Clause CL372 dated 01.12.2008 or Second-hand Replacement Clause as attached as applicable.
        <br>Excluding loss or damage due to mechanical, electrical or electronic derangement.
        <br>Excluding mysterious disappearance.
        <br>Warranted pallets are shrink wrapped and contents obscured from view.
        ';
        $return[0] = adhocChanges($quotationID,$commodity,$return[0]);
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <ul>
        <li>General Cargo, Goods and/or Merchandise of every description 
        <li>New or Used Machinery</li>
        <li>Motor Vehicles up to 7 years old, container or ro/ro</li> 
        <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
        <li>Tobacco and Manufactured Tobacco Substitutes </li>
        <li>Pharmaceutical Products </li>
        <li>Household and Personal Effects</li>
        <li>Consumer accounts</li>
        <li>Rejection risks</li>
        <li>Ocean tows</li>
        <li>Nuclear fuel including yellow cake</li>
        <li>Containers written as such</li>
        <li>War on land</li>
        <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
        <li>Nut risks where goods are stored at or near a processing plant</li>
        <li>Wineries</li>
        <li>Hay</li>
        <li>Cotton</li>
        <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
        <li>Nursery risks</li>
        <li>Commodity traders</li>
        <li>Retail locations</li>
        <li>Coal</li>
        <li>Storage outside the ordinary course of transit</li>
        <li>Primary and excess stock only</li>
        <li>Fine Arts and Species </li>
        <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
        <li>Stamps, credit and debit cards including telephone calling cards</li>
        <li>Jewellery, watches, precious stones and precious metals </li>
        <li>Aircrafts, ships, boats, any floating structures</li>
        <li>Tanks and other armoured fighting vehicles</li>
        <li>Arms and ammunitions, parts and accessories thereof</li>
        <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
        <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
        <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
        <li>Blood & Life Science Products</li>
        <li>Cash in transit</li>
        <li>Fishmeal</li>
        <li>Railway or Tramway Locomotives</li>
        </ul>
        <br>
        <br>
        
        <strong>Excluded Bulk merchandise</strong> 
        <ul>
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac; Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt; Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        ';
    }/* updated 24/7/2021 */

    if ($commodity == 'Personal Effects professionally packed'){
        $return[0] = '
        Institute Cargo Clauses “A” CL382 dated 01.01.2009.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        
        ';
        $return[1] = '
        <br>a)	Average Clause. This Policy is subject to the condition of average, that is to say, if the property covered by this Insurance shall at the time of loss be of greater value than the sum insured hereby the Assured shall only be entitled to recover hereunder such proportion of the said loss as the sum insured by this Policy bears to the total value of the said property.
        <br>b)	Pairs and Sets Clause. Where any insured item consists of articles in a pair or set this Policy is not to pay more than the value of any particular part or parts which may be lost without reference to any special value which such article or articles may have as part of such pair or set, nor more than a proportionate part of such pair or set.
        <br>c)	Depreciation. Underwriters’ liability is restricted to the reasonable cost of repair and no claim is to attach hereto for depreciation consequent thereon.
        <br>d)	Mechanical and Electrical Derangement. Excluding loss of or damage due to mechanical, electrical or electronic derangement unless there is evidence of external damage to the insured item or its packing.
        <br>e)	Moth, Vermin, Wear & Tear. Excluding loss or damage due to moth, vermin, wear, tear and gradual deterioration.
        <br>f)	Climatic Conditions Clause. Excluding loss or damage by climatic or atmospheric conditions or extremes of temperature.
        <br>g)	Professional Packing. Excluding losses arising as a result of goods not having been professionally packed.
        <br>h)	Excluded Goods. Excluding loss of or damage to furs valued over €200, or any cash, notes, stamps, deeds, tickets, travellers’ cheques, jewellery, watches, or similar valuable articles other than as declared and agreed herein.
        <br>i)	Itemised Inventory. Subject to valued, itemised inventory to be lodged with Freight Forwarder prior to shipment.
        <br><br>
        <strong>Excluded Risks and Interests:</strong>
        <table width="900" style="font-size: 10px">
            <tr>
                <td width="450">
                    <ul>
                        <li>General Cargo, Goods and/or Merchandise of every description</li> 
                        <li>New or Used Machinery</li>
                        <li>Motor Vehicles up to 7 years old, container or ro/ro</li> 
                        <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
                        <li>Tobacco and Manufactured Tobacco Substitutes </li>
                        <li>Pharmaceutical Products </li>
                        <li>Household and Personal Effects</li>
                        <li>Consumer accounts</li>
                        <li>Rejection risks</li>
                        <li>Ocean tows</li>
                        <li>Nuclear fuel including yellow cake</li>
                        <li>Containers written as such</li>
                        <li>War on land</li>
                        <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
                        <li>Nut risks where goods are stored at or near a processing plant</li>
                        <li>Wineries</li>
                        <li>Hay</li>
                        <li>Cotton</li>
                        <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li>Nursery risks</li>
                        <li>Commodity traders</li>
                        <li>Retail locations</li>
                        <li>Coal</li>
                        <li>Storage outside the ordinary course of transit</li>
                        <li>Primary and excess stock only</li>
                        <li>Fine Arts and Species </li>
                        <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
                        <li>Stamps, credit and debit cards including telephone calling cards</li>
                        <li>Jewellery, watches, precious stones and precious metals </li>
                        <li>Aircrafts, ships, boats, any floating structures</li>
                        <li>Tanks and other armoured fighting vehicles</li>
                        <li>Arms and ammunitions, parts and accessories thereof</li>
                        <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
                        <li>Fur skins and Artificial Fur; Manufactures Thereof</li>
                        <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
                        <li>Blood & Life Science Products</li>
                        <li>Cash in transit</li>
                        <li>Fishmeal</li>
                        <li>Railway or Tramway Locomotives</li>
                    </ul>
                </td>
            </tr>
        </table>
        <br>
        <strong>Excluded Bulk merchandise</strong> 
        <ul>
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac, Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        <br><br><br>
        ';
    }/* Updated 24/07/2021 */

    if ($commodity == 'CPMB - Cyprus Potato Marketing Board'){
        $return[0] = '
        Institute Cargo Clauses (C) CL384.1.1.09. or Institute Frozen / Chilled Food Clauses (C) Cl. 431 01.03.2017 as applicable.
        <br>Institute Strike Clauses (Cargo) CL386.1.1.09 or Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 as applicable.
        <br>Institute War Clauses (Cargo) CL385 1.1.09. 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical and Electromagnetic Weapons Exclusion Clause CL370 dated 10/11/03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10/11/03.
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
';

    }

    if ($commodity == 'Tobacco'){
        $return[0] = '
        Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 as applicable.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009 as applicable. 
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        ';
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <ul>
            <li>General Cargo, Goods and/or Merchandise of every description</li> 
            <li>New or Used Machinery</li>
            <li>Motor Vehicles up to 7 years old, container or ro/ro</li> 
            <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
            <li>Pharmaceutical Products </li>
            <li>Household and Personal Effects</li>
            <li>Consumer accounts</li>
            <li>Rejection risks</li>
            <li>Ocean tows</li>
            <li>Nuclear fuel including yellow cake</li>
            <li>Containers written as such</li>
            <li>War on land</li>
            <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
            <li>Nut risks where goods are stored at or near a processing plant</li>
            <li>Wineries</li>
            <li>Hay</li>
            <li>Cotton</li>
            <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
            <li>Nursery risks</li>
            <li>Commodity traders</li>
            <li>Retail locations</li>
            <li>Coal</li>
            <li>Storage outside the ordinary course of transit</li>
            <li>Primary and excess stock only</li>
            <li>Fine Arts and Species </li>
            <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
            <li>Stamps, credit and debit cards including telephone calling cards</li>
            <li>Jewellery, watches, precious stones and precious metals </li>
            <li>Aircrafts, ships, boats, any floating structures</li>
            <li>Tanks and other armoured fighting vehicles</li>
            <li>Arms and ammunitions, parts and accessories thereof</li>
            <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
            <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
            <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
            <li>Blood & Life Science Products</li>
            <li>Cash in transit</li>
            <li>Fishmeal</li>
            <li>Railway or Tramway Locomotives</li>
        </ul>
        <br>
        <strong>Excluded Bulk merchandise</strong> 
        <ul>
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac, Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        ';
    }

    if ($commodity == 'Other'){
        $return[0] = '
        Institute Cargo Clauses “A” CL382 dated 01.01.2009. and/or Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009 Institute Frozen / Chilled Food Clauses (A) – amended to 8 consecutive hours Breakdown Cl. 423 01.03.2017 as applicable.
        <br>Institute Strikes Clauses (Cargo) CL386 dated 01.01.2009 and/ or Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009 and/or Strikes Clause (Frozen Chilled Food) CL. 424 01.03.2017 as applicable.
        <br>Institute War Clauses (Cargo) CL385 dated 01.01.2009 and/or Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009 as applicable.
        <br>Institute Classification Clause CL354 dated 1.1.01.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Including transhipment, barge and lightering risks whether customary or otherwise.
        <br>Subject also to Additional Conditions as attached.
        ';
        $return[1] = '
        <strong>Excluded Risks and Interests:</strong>
        <ul>
            <li>General Cargo, Goods and/or Merchandise of every description</li> 
            <li>New or Used Machinery</li>
            <li>Motor Vehicles up to 7 years old, container or ro/ro</li> 
            <li>Frozen or Chilled Foodstuff or Frozen or Chilled Meat</li>
            <li>Tobacco and Manufactured Tobacco Substitutes </li>
            <li>Household and Personal Effects</li>
            <li>Consumer accounts</li>
            <li>Rejection risks</li>
            <li>Ocean tows</li>
            <li>Nuclear fuel including yellow cake</li>
            <li>Containers written as such</li>
            <li>War on land</li>
            <li>Lumber / timber risks where goods are stored at or adjacent to a sawmill</li>
            <li>Nut risks where goods are stored at or near a processing plant</li>
            <li>Wineries</li>
            <li>Hay</li>
            <li>Cotton</li>
            <li>Soft commodities, being grains, wheat soya, coffee, cocoa, sugar, nuts, seeds, pulses, legumes and rice written as such</li>
            <li>Nursery risks</li>
            <li>Commodity traders</li>
            <li>Retail locations</li>
            <li>Coal</li>
            <li>Storage outside the ordinary course of transit</li>
            <li>Primary and excess stock only</li>
            <li>Fine Arts and Species </li>
            <li>Documents, monies of every description, securities, negotiable documents or instruments, bonds, bullion,</li>
            <li>Stamps, credit and debit cards including telephone calling cards</li>
            <li>Jewellery, watches, precious stones and precious metals </li>
            <li>Aircrafts, ships, boats, any floating structures</li>
            <li>Tanks and other armoured fighting vehicles</li>
            <li>Arms and ammunitions; parts and accessories thereof</li>
            <li>Explosives, Pyrotechnic Products, Matches, Pyrophoric Alloys</li>
            <li>Fur skins and Artificial Fur, Manufactures Thereof</li>
            <li>Raw Hides and Skins (Other Than Fur skins) and Leather</li>
            <li>Blood & Life Science Products</li>
            <li>Cash in transit</li>
            <li>Fishmeal</li>
            <li>Railway or Tramway Locomotives</li>
        </ul>
        <br>
        <br>
        <strong>Excluded Bulk merchandise</strong>
        <ul> 
            <li>Coffee, Tea, Mate and Spices / Cocoa Beans</li> 
            <li>Lac, Gums, Resins and Other Vegetable Saps and Extracts</li> 
            <li>Products of the Milling Industry, Malt, Starches, Inulin, Wheat Gluten, Cereals</li> 
            <li>Animal or Vegetable Fats and Oils and Their Cleavage Products Prepared Edible Fats, Animal or Vegetable Waxes / Cocoa butter, fat and oil / Sugars and Sugar Confectionery</li> 
            <li>Residues and Waste from the Food Industries </li>
            <li>Beverages, Spirits and Vinegar </li>
        </ul>
        ';
    }

    return $return;

}

function adhocChanges($quotationID, $commodity,$text){
    if ($quotationID == 7858 && $commodity == 'Special Cover Mobile Phones, Electronic Equipment'){
        $text = '
        Institute Cargo Clauses (Air) (excluding sendings by Post) CL387 dated 01.01.2009.
        <br>Institute War Clauses (Air Cargo) (excluding sendings by Post) CL388 dated 01.01.2009.
        <br>Institute Strikes Clauses (Cargo) (Air Cargo) CL389 dated 01.01.2009.
        <br>Institute Radioactive Contamination, Chemical, Biological, Biochemical & Electromagnetic Weapons Exclusion Clause CL370 dated 10.11.03.
        <br>Institute Cyber Attack Exclusion Clause CL380 dated 10.11.03.
        <br>Termination of Transit Clause (Terrorism) JC2009/056 1.1.09
        <br>Marine Cyber Exclusion Clause LMA5402 11.11.19
        <br>Communicable Disease Exclusion Clause (Cargo) JC2020/011 17.04.20
        <br>Subject to Sanction Limitation and Exclusion Clause JC2010/014 11.08.10
        <br>Excluding mysterious disappearance.
        <br>Excluding loss or damage caused by corkfly, ullage, unexplained shortages, contamination and discolouration, extremes of temperature or pecuniary loss caused by fall in market value.
        <br>Excluding loss or damage caused directly or indirectly by water damage to labels.
        <br>Warranted that the whisky is shipped in purpose-built cases and shipped under the “white glove” service. Failure to comply with this warranty will invalidate this policy from inception.
        ';
    }

    return $text;
}
