<?php
function getQuotationHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('
            SELECT *, (SELECT cde_value FROM codes WHERE cde_code_ID = oqq_nationality_ID) as clo_nationality 
            FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    $quotationUnderwriter = $db->query_fetch(
        'SELECT * FROM 
                  oqt_quotations_underwriters 
                  WHERE oqun_user_ID = ' . $quotationData['oqq_users_ID']
    );
//section 1 ========================================================================================================================================SECTION 1
    $sect1 = $db->query_fetch('
        SELECT *,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_1)as clo_destination
        FROM oqt_quotations_items WHERE oqqit_quotations_ID = ' . $quotationID . ' AND oqqit_items_ID = 5');
    $sect2 = $db->query_fetch("
        SELECT *,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_4)as clo_member_1_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_9)as clo_member_2_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_14)as clo_member_3_nationality
        FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 6");
    $sect3 = $db->query_fetch("
        SELECT *,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_4)as clo_member_4_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_9)as clo_member_5_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_14)as clo_member_6_nationality
        FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 7");
    $sect4 = $db->query_fetch("
        SELECT *,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_4)as clo_member_7_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_9)as clo_member_8_nationality,
        (SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_14)as clo_member_9_nationality
        FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 8");

    //underwriter open cover number
    $underwriterOpenCoverNumber = '';

    //certificate number
    if ($quotationData['oqq_status'] != 'Active') {
        $certificateNumber = 'DRAFT';
        $draft = 'DRAFT';
        $draftImage = 'background-image:url(' . $main['site_url'] . '/dynamic_quotations/images/draft.gif);';
        $signature = '';
        $stamp = '';
    } else {
        $certificateNumber = $quotationData['oqq_number'];
        $draft = '';
        $draftImage = '';
        $signature = '<img src="images/santamas_signature_200.png" width="200">';
        $effDateSplit = explode("-",$sect1['oqqit_date_1']);
        $effDateNum = ($effDateSplit[0] * 10000) + ($effDateSplit[1] * 100) + ($effDateSplit[2] * 1);
        if ($effDateNum >= 20200101){
            $stamp = '<img src="images/full_stamp_signature_2020.png" width="140">';
        }
        else {
            $stamp = '<img src="images/full_stamp_signature.png" width="140">';
        }

        if ($quotationUnderwriter['oqun_tr_open_cover_number'] != '' && strlen($quotationUnderwriter['oqun_tr_open_cover_number']) >= 5) {
            $underwriterOpenCoverNumber = "Open Cover Number: " . $quotationUnderwriter['oqun_tr_open_cover_number'];
        }
    }


    //geographical area names
    $geoArea = '';
    if ($sect1['oqqit_rate_2'] == 'WorldExcl') {
        $geoArea = 'Worldwide (excluding U.S.A & Canada / Παγκόσμια (εκτός Η.Π.Α & Καναδά)';
    } else if ($sect1['oqqit_rate_2'] == 'WorldWide') {
        $geoArea = 'Worldwide / Παγκόσμια';
    }

    $html = '
<style>
.tableTdBorder td{
    border:1px solid #000000;
    padding:5px;
    font-size: 12px;
    font-family: Tahoma;
}
.normalFonts{
    font-size: 12px;
    font-family: Tahoma;
}
.tableNoTdBorder td{
    border:0px solid #FFFFFF;
    padding:0px;
    font-size: 12px;
    font-family: Tahoma;
}
.elementPageBreak{
    page-break-before: always;
}

</style>
<div style="font-family: Tahoma; ' . $draftImage . '">
    <table width="900" style="font-size: 14px;">
        <tr>
            <td width="33%"><img src="' . $db->admin_layout_url . '/images/Kemter-Logo-WhiteBG-300x60.png"></td>        
            <td width="34%" align="center">Certificate Number<br>Αριθμός Πιστοποιητικού<br><b>' . $certificateNumber . '<br> ' . $underwriterOpenCoverNumber . '</b></td>
            <td width="33%" align="right"><img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png"></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>PROPOSAL & EVIDENCE OF TRAVEL INSURANCE / ΠΡΟΤΑΣΗ & ΑΠΟΔΕΙΞΗ ΑΣΦΑΛΙΣΗΣ ΤΑΞΙΔΙΟΥ</b></td>
        </tr>
    </table>
    
    <table class="tableTdBorder" width="900" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
            Name of First Applicant<br>
            Όνομα Πρώτου Αιτούντος
            </td>
            <td align="center">
                Passport No or ID<br>
                Αριθμός Διαβατηρίου ή Ταυτότητα
            </td>
            <td align="center">
                Nationality<br>
                Ιθαγένεια
            </td>
            <td align="center">
                Date of Birth<br>
                Ημ. Γεννήσεως
            </td>
        </tr>
        <tr>
            <td align="center">
                ' . $quotationData['oqq_insureds_name'] . '
            </td>
            <td align="center">
                ' . $quotationData['oqq_insureds_id'] . '
            </td>
            <td align="center">
                ' . $quotationData['clo_nationality'] . '
            </td>
            <td align="center">
                ' . $db->convertDateToEU($quotationData['oqq_birthdate']) . '
            </td>
        </tr>
    </table>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%" colspan="2">
                Address / Διεύθυνση: &nbsp;
                ' . $quotationData['oqq_insureds_address'] . ', ' . $quotationData['oqq_insureds_city'] . ',' . $quotationData['oqq_insureds_postal_code'] . '
            </td>
        </tr>
        <tr>
            <td>
                Telephone / Τηλέφωνο: &nbsp;
                ' . $quotationData['oqq_insureds_tel'] . '
            </td>
            <td>
                Destination / Προορισμός: &nbsp;
                ' . $sect1['clo_destination'] . '
            </td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                Names of other Applicants<br>
                Ονόματα Άλλων Αιτητών
            </td>
            <td align="center">
                Passport No or I.D.<br>
                Αιθμός Διαβατηρίου ή Ταυτότητα
            </td>
            <td align="center">
                Nationality<br>
                Ιθαγένεια
            </td>
            <td align="center">
                Date of Birth<br>
                Ημ. Γεννήσεως
            </td>
        </tr>
        <tr>
            <td align="center">' . ($sect2['oqqit_rate_1'] == '1' ? $sect2['oqqit_rate_2'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_1'] == '1' ? $sect2['oqqit_rate_3'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_1'] == '1' ? $sect2['clo_member_1_nationality'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_1'] == '1' ? $db->convertDateToEU($sect2['oqqit_date_1']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect2['oqqit_rate_6'] == '1' ? $sect2['oqqit_rate_7'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_6'] == '1' ? $sect2['oqqit_rate_8'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_6'] == '1' ? $sect2['clo_member_2_nationality'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_6'] == '1' ? $db->convertDateToEU($sect2['oqqit_date_2']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect2['oqqit_rate_11'] == '1' ? $sect2['oqqit_rate_12'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_11'] == '1' ? $sect2['oqqit_rate_13'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_11'] == '1' ? $sect2['clo_member_3_nationality'] : "") . '</td>
            <td align="center">' . ($sect2['oqqit_rate_11'] == '1' ? $db->convertDateToEU($sect2['oqqit_date_3']) : "") . '</td>
        </tr>
        
        <tr>
            <td align="center">' . ($sect3['oqqit_rate_1'] == '1' ? $sect3['oqqit_rate_2'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_1'] == '1' ? $sect3['oqqit_rate_3'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_1'] == '1' ? $sect3['clo_member_4_nationality'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_1'] == '1' ? $db->convertDateToEU($sect3['oqqit_date_1']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect3['oqqit_rate_6'] == '1' ? $sect3['oqqit_rate_7'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_6'] == '1' ? $sect3['oqqit_rate_8'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_6'] == '1' ? $sect3['clo_member_5_nationality'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_6'] == '1' ? $db->convertDateToEU($sect3['oqqit_date_2']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect3['oqqit_rate_11'] == '1' ? $sect3['oqqit_rate_12'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_11'] == '1' ? $sect3['oqqit_rate_13'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_11'] == '1' ? $sect3['clo_member_6_nationality'] : "") . '</td>
            <td align="center">' . ($sect3['oqqit_rate_11'] == '1' ? $db->convertDateToEU($sect3['oqqit_date_3']) : "") . '</td>
        </tr>
        
        <tr>
            <td align="center">' . ($sect4['oqqit_rate_1'] == '1' ? $sect4['oqqit_rate_2'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_1'] == '1' ? $sect4['oqqit_rate_3'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_1'] == '1' ? $sect4['clo_member_7_nationality'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_1'] == '1' ? $db->convertDateToEU($sect4['oqqit_date_1']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect4['oqqit_rate_6'] == '1' ? $sect4['oqqit_rate_7'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_6'] == '1' ? $sect4['oqqit_rate_8'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_6'] == '1' ? $sect4['clo_member_8_nationality'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_6'] == '1' ? $db->convertDateToEU($sect4['oqqit_date_2']) : "") . '</td>
        </tr>
        <tr>
            <td align="center">' . ($sect4['oqqit_rate_11'] == '1' ? $sect4['oqqit_rate_12'] : "&nbsp;") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_11'] == '1' ? $sect4['oqqit_rate_13'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_11'] == '1' ? $sect4['clo_member_9_nationality'] : "") . '</td>
            <td align="center">' . ($sect4['oqqit_rate_11'] == '1' ? $db->convertDateToEU($sect4['oqqit_date_3']) : "") . '</td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                Geographical Area / Γεωγραφική Περιοχή: &nbsp;
                ' . $geoArea . '
            </td>
            <td>
                Package / Πακέτο: &nbsp;
                ' . ($sect1['oqqit_rate_4'] == 'Limited' ? "Russian Visa" : $sect1['oqqit_rate_4']). '
            </td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="normalFonts" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <strong>
                Period of Insurance:
                </strong>  
            </td>
            <td>
                Shall commence at the time of leaving The Republic of Cyprus and shall terminate on return thereto on completion 
                of the journey or holiday.
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>
                Περίοδος Ασφάλισης:&nbsp;&nbsp;
                </strong> 
            </td>
            <td>
                Θα αρχίζει κατά την αναχώρηση από τη Κυπριακή Δημοκρατία και θα τερματίζεται κατά την επιστροφή
                σε αυτή με την συμπλήρωση του ταξιδού ή διακοπών.
            </td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="normalFonts" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="350">
                <strong>
                Period of Insurance / Περίοδος Ασφάλισης<br>
                Maximum Period 90 days/ Μέγιστη Περίοδος 90 Μέρες &nbsp;&nbsp;
                </strong>
                '. ($sect1['oqqit_rate_8'] == '' ? "" : '<br>'.$sect1['oqqit_rate_8']) .'
            </td>
            <td width="250" valign="top">
                ' . $sect1['oqqit_rate_5'] . ' Days / Μέρες
            </td>
            <td width="300" valign="top">
                From / Από: ' . $db->convertDateToEU($sect1['oqqit_date_1']) . '
                ' . ($sect1['oqqit_rate_3'] == 'Yes' ? '<br><strong>Winter Sports Coverage:</strong> Included' : '') . '
            </td>
            
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="normalFonts" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="300">
                <strong>
                Notification of Claims and Circumstances to<br>
                Κοινοποίηση Απαιτήσεων και Γεγονότα στους
                </strong>
            </td>
            <td valign="top" width="400">
                Kemter Insurance Agencies Sub-Agencies and Consultants Ltd
            </td>
            <td valign="top" width="200">
                claims@kemterinsurance.com
            </td>
        </tr>
    </table>
    
    ' . ($quotationUnderwriter['oqun_tr_show_prem'] == '1' ? '
    <table class="normalFonts" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td>
            <strong>Total Amount Payable:</strong>
             €' . ($quotationData['oqq_premium'] + $quotationData['oqq_stamps'] + $quotationData['oqq_fees']) . ' 
            </td>
        </tr>
    </table>
    ' : '') . '
    
    <div style="height: 10px;"></div>
    
    <table class="normalFonts" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                In the event of a serious <strong>illness</strong> or <strong>injury</strong> during <strong>Your Trip </strong>
                which will require hospitalisation, in the first instance <strong>You</strong> must notify <strong>Our</strong>
                Medical Assistance Company.<br>
                Σε περίπτωση σοβαρής <strong>Ασθένειας</strong> ή <strong>Τραυματισμού</strong> κατά τη διάρκεια του <strong>Ταξιδιού σας</strong>
                που θα απαιτήσει νοσηλεία σε νοσοκομείο, πρέπει πρώτα να ενημερώσετε την Εταιρεία Ιατρικής Βοήθειας.<br>
                <br>
                Tel. / Τηλ.: +44 20 3640 6820
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Fax. / Φαξ.: +44 20 8481 7721
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                E-mail / Ηλεκτρονική Διεύθυνση: internationlhealthcare@healix.com
                <br>
                <br>
                By signing this application,  you are confirming that you are in good health and not traveling for
                Medical Reasons, furthermore, please disclose any other facts that may influence the acceptance
                of the risk. On acceptance of the Application and payment, a Schedule will be issued and together
                With the Proposal shall be the basis of this contract.
                <br>
                Με την υπογραφή σας σε αυτή τη αίτηση επιβεβαιώνετε ότι είστε σε καλή υγεία και δεν 
                ταξιδεύετε για ιατρικούς λόγους, επίσης παρακαλώ αναφέρετε οποιαδήποτε άλλα γεγονότα
                που τυχόν επηρεάζουν την αποδοχή του κινδύνου. Με την αποδοχή της αίτησης και την
                καταβολή του ασφαλίστρου, θα εκδοθεί ο Πίνακας του Ασφαλιστηρίου που μαζί με την Αίτηση 
                θα αποτελούν αναπόσπαστο μέρος του Ασφαλιστηρίου συμβολαίου
                <br>
                <br>
                <strong>Data Protection Act</strong>
                Any information provided us regarding You or any Person
                Insured will be processed by us in compliance with the provisions of the Processing of Personal Data
                (Protection of the Individual) Regulation (EU) 2016/679, as amended each time, for the purpose of 
                providing insurance and handling claims or complaints, if any. This may necessitate providing such information
                to third parties.
                <br>
                <strong>Προστασία Δεδομένων</strong>
                <br>
                Οι όποιες πληροφορίες για Σας ή οποιοδήποτε ασφαλισμένο πρόσωπο δίνονται σε Μας, 
                θα τυγχάνουν επεξεργασίας από Εμάς, σε συμμόρφωση με τις πρόνοιες του Γενικού Κανονισμού Προστασίας 
                Δεδομένων (ΕΕ) 2016/679 ως εκάστοτε τροποποιείται, για σκοπούς παροχής ασφάλισης και χειρισμού των 
                απαιτήσεων ή παραπόνων, αν υπάρξουν. Για αυτό, ενδέχεται να χρειαστεί να δοθούν αυτές οι πληροφορίες 
                και σε τρίτους.

                
            </td>
        </tr>
    </table>
        
    
    
    <div style="height: 20px;"></div>
    
    <div style="font-size: 10px;">
        <table style="font-size: 10px;" width="100%">
            <tr>
                <td width="60%">
                    <b>Signed By / Υπογράφτηκε από:</b>
                </td>
                <td width="40%" align="center">
                    <b>Issued By / Εκδόθηκε από:</b>
                </td>
            </tr>
            <tr>
                <td>
                ' . $signature . $draft . '
                <br>
                <br>
                Γιάννος Σανταμάς<br>
                Director / Διευθυντής<br>
                Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd<br>
                Authorised Coverholder at Lloyd`s ' . $draft . '
                </td>
                <td align="center">
                    ' . $stamp . $draft . '<br><br>
                    Issue Date / Ημερομηνία Έκδοσης: <br>' . $db->convert_date_format($quotationData['oqq_effective_date'], 'yyyy-mm-dd', 'dd/mm/yyyy', 1, 1) . '
                </td>
            </tr>
        </table>
    </div>
    <div style="font-size: 10px;" align="center">
        P.O.Box 53538, 3033 Limassol Tel.:+357 25755952 Fax: +357 25755953 E-mail: kemter@kemterinsurance.com
    </div>
    
    
    <div class="elementPageBreak">
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="820" style="background-color: #BFE0BE">
                <strong>PLAN NAME</strong>
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td width="80" style="background-color: #BFE0BE" align="center">Basic</td>' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td width="80" style="background-color: #BFE0BE" align="center">Standard</td>' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td width="80" style="background-color: #BFE0BE" align="center">Luxury</td>' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td width="80" style="background-color: #BFE0BE" align="center">Special</td>' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td width="80" style="background-color: #BFE0BE" align="center">Schengen Visa</td>' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td width="80" style="background-color: #BFE0BE" align="center">Russian Visa</td>' : '') . '
        </tr>
        <tr>
            <td>
                Emergency medical & travel expenses<br>
                Deductible per claimant
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €100.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €200.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €250.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €100.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €50.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €50.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                Emergency medical evacuation & Repatriation of mortal remains
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €100.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €200.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €250.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €100.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €50.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €50.000
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                Funeral Expenses
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €10.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €10.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €10.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €10.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €5.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €5.000
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">Hospital Inconvenience Expenses</td>
                        <td width="410">
                            <strong>
                                Daily Limit:<br>
                                Maximum Limit:
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €25<br>
                <div style="color: red">€1.500</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €50<br>
                <div style="color: red">€2.500</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €100<br>
                <div style="color: red">€5.000</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €100<br>
                <div style="color: red">€5.000</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410" colspan="2">
                            <strong>
                                Personal Accident
                            </strong>
                            <br>
                            1 Accidental Death<br>
                            2. <strong>Loss of Limb</strong> (one limb) or <strong>Loss of Sight</strong> (one eye)<br>
                            3. <strong>Loss of Limb</strong> (two limbs) or <strong>Loss of Sight</strong> (both eyes)<br>
                            4. <strong>Permanent Total Disablement</strong><br>
                            In no case shall <strong>Our</strong> liability exceed the largest <strong>Benefit Amount</strong>
                            applicable under any one of the Benefits above.
                        </td>
                    </tr>
                    <tr>
                        <td width="410" valign="top">
                            <strong>For Insured Persons under the age of sixteen (16):</strong><br>
                            <strong>For Insured Persons over the age of sixty-five (65):</strong><br>
                        </td>
                        <td width="410">
                        Benefit 1 is limited to €5.000 and Benefits 2,3, and 4 are reduced by 50%.<br>
                        Benefit 1 is limited to €5.000 and Benefits 2 and 3 are reduced by 50%, Benefit 4
                        (<strong>Permanent Total Disablement</strong>) is deleted.
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center" valign="top">
                <br>
                €50.000<br>
                €50.000<br>
                €50.000<br>
                €50.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center" valign="top">
                <br>
                €100.000<br>
                €100.000<br>
                €100.000<br>
                €100.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center" valign="top">
                <br>
                €150.000<br>
                €150.000<br>
                €150.000<br>
                €150.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center" valign="top">
                <br>
                €100.000<br>
                €100.000<br>
                €100.000<br>
                €100.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center" valign="top">
                <br>
                €20.000<br>
                €20.000<br>
                €20.000<br>
                €20.000
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center" valign="top">
                <br>
                €20.000<br>
                €20.000<br>
                €20.000<br>
                €20.000
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Trip Cancellation
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €5.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €5.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €5.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €5.000<br>
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €500<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €500<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Trip Delay
                        </td>
                        <td width="410">
                            Hourly Limit:<br>
                            Maximum Limit:<br>
                            <strong>Excess for each and every claim</strong>                            
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €25<br>
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €50<br>
                €300<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €100<br>
                €600<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €100<br>
                €600<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €25<br>
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €25<br>
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Missed Departure
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €500<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €750<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €1.000<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €1.000<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Baggage Delay
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €500<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €750<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €750<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Loss/Damage of baggage & personal effects<br>
                            Single Article Limit
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €500<br>
                €350
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €1.000<br>
                €350
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €2.000<br>
                €350
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €2.000<br>
                €350
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €500<br>
                €350
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €500<br>
                €350<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Loss of Money
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €500<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €1.000<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €1.000<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €1.000<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Loss of travel documents
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €350<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €350<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €100<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Legal Expenses
                        </td>
                        <td width="410">
                                <br>
                                Aggregae Limit:<br>
                            <strong>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €25.000<br>
                €25.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €25.000<br>
                €25.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €25.000<br>
                €25.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €75.000<br>
                €75.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €25.000<br>
                €25.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €25.000<br>
                €25.000
                <div style="color: red">€100</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
            
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Hi-jack and Kidnap
                        </td>
                        <td width="410">
                                Daily Limit:<br>
                                Maximum Limit:<br>
                            <strong>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
                
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €200<br>
                €5.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €200<br>
                €5.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €200<br>
                €5.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                €200<br>
                €5.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                €200<br>
                €2.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                €200<br>
                €2.000
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                Emergency medical assistance
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Special' ? '<td align="center">
                Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Included
            </td>
            ' : '') . '
        </tr>
        
    </table>
    
    <div style="height: 20px;"></div>
    ' . ($sect1['oqqit_rate_4'] != 'Special' ? '
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <strong>Winter Sports Optional Coverage (included only if selected)</strong>
            </td>
            <td width="80"></td>
        </tr>
        
        <tr>
            <td>
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Avalanche
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €250<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €250<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €250<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Equipment Hire
                        </td>
                        <td width="410">
                                Daily Limit:<br>
                                Maximum Limit:<br>
                            <strong>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €25<br>
                €250
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €25<br>
                €250
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €25<br>
                €250
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Lift Pass
                        </td>
                        <td width="410">
                            <strong>
                                <br>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €200<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €200<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €200<br>
                <div style="color: red">€50</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
        <tr>
            <td>
                <table class="tableNoTdBorder" width="820" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" width="410">
                            Piste Closure
                        </td>
                        <td width="410">
                                Daily Limit:<br>
                                Maximum Limit:<br>
                            <strong>
                                Excess for each and every claim
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
            ' . ($sect1['oqqit_rate_4'] == 'Basic' ? '<td align="center">
                €25<br>
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Standard' ? '<td align="center">
                €25<br>
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Luxury' ? '<td align="center">
                €25<br>
                €250<br>
                <div style="color: red">Nil</div>
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Schengen' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
            ' . ($sect1['oqqit_rate_4'] == 'Limited' ? '<td align="center">
                Not Included
            </td>
            ' : '') . '
        </tr>
        
    </table>' : '') . '
    
    
 </div>';

    $data['issueDate'] = $quotationData['oqq_effective_date'];
    $data['effectiveDate'] = $sect1['oqqit_date_1'];
    $data['expiryDate'] = $quotationData['oqq_expiry_date'];
    $data['coverage'] = $sect1['oqqit_rate_2'];
    $data['package'] = $sect1['oqqit_rate_4'];
    $data['certificateNum'] = $certificateNumber;
    $data['openCoverNumber'] = $underwriterOpenCoverNumber;
    $data['draftImage'] = $draftImage;
    $data['name'] = $quotationData['oqq_insureds_name'];


    //when limited no confirmation letter
    if ($sect1['oqqit_rate_4'] != 'Limiteddddd') { //show in all

        $data['clo_destination'] = $sect1['clo_destination'];
        //generate confirmation for client
        $html .= getConfirmationLetter($data);

        //members - need one by one cause of the location of the data
        if ($sect2['oqqit_rate_1'] == '1'){
            $data['name'] = $sect2['oqqit_rate_2'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect2['oqqit_rate_6'] == '1'){
            $data['name'] = $sect2['oqqit_rate_7'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect2['oqqit_rate_11'] == '1'){
            $data['name'] = $sect2['oqqit_rate_12'];
            $html .= getConfirmationLetter($data);
        }

        if ($sect3['oqqit_rate_1'] == '1'){
            $data['name'] = $sect3['oqqit_rate_2'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect3['oqqit_rate_6'] == '1'){
            $data['name'] = $sect3['oqqit_rate_7'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect3['oqqit_rate_11'] == '1'){
            $data['name'] = $sect3['oqqit_rate_12'];
            $html .= getConfirmationLetter($data);
        }

        if ($sect4['oqqit_rate_1'] == '1'){
            $data['name'] = $sect4['oqqit_rate_2'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect4['oqqit_rate_6'] == '1'){
            $data['name'] = $sect4['oqqit_rate_7'];
            $html .= getConfirmationLetter($data);
        }
        if ($sect4['oqqit_rate_11'] == '1'){
            $data['name'] = $sect4['oqqit_rate_12'];
            $html .= getConfirmationLetter($data);
        }
    }


    return $html;
}

function getConfirmationLetter($data){
    global $db,$totalPageBreaks;

    $issueDate = explode('-',$data['issueDate']);
    $effDateSplit = explode("-",$data['effectiveDate']);
    $expiryDate = explode("-",$data['expiryDate']);

    //worldwide or excluding
    if ($data['coverage'] == 'WorldExcl'){
        $world = 'Worldwide excluding U.S.A / Canada';
        $worldLong = 'Medical coverage is provided while traveling worldwide (except within the insured person\'s Country of Residence, 
            the USA, and Canada) including '.$data['clo_destination'];
    }
    else {
        $world = 'Worldwide';
        $worldLong = 'Medical coverage is provided while traveling worldwide (except within the insured person\'s Country of Residence)';
    }

    if ($data['package'] == 'Basic'){
        $maxLimit = '100,000.00';
        $maxLimitExcess = '100';
    }
    else if ($data['package'] == 'Standard'){
        $maxLimit = '200,000.00';
        $maxLimitExcess = '100';
    }
    else if ($data['package'] == 'Luxury'){
        $maxLimit = '250,000.00';
        $maxLimitExcess = '100';
    }
    else if ($data['package'] == 'Special'){
        $maxLimit = '100,000.00';
        $maxLimitExcess = '100';
    }
    else if ($data['package'] == 'Schengen'){
        $maxLimit = '50,000.00';
        $maxLimitExcess = '100';
    }
    else if ($data['package'] == 'Limited'){
        $maxLimit = '50,000.00';
        $maxLimitExcess = '100';
    }

    $return .= '
    <div class="elementPageBreak"></div>
    <div style="font-family: Tahoma; ' . $data['draftImage'] . '">
        <table width="900">
            <tr>
                <td width="30%"><img src="' . $db->admin_layout_url . '/images/Kemter-Logo-WhiteBG-300x60.png"></td>
                <td width="70%" align="right"><img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png"></td>
            </tr>
            <tr>
                <td colspan="2"><br><br></td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="font-size:18px">
                    <strong>Confirmation of Coverage</strong><br><br><br><br>
                </td>
            </tr>
            <tr>
                <td colspan="2">'.date("F d, Y",mktime(0,0,0,$issueDate[1],$issueDate[2],$issueDate[0])).'<br><br><br><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    Confirmation of Coverage for:<br>
                    Certificate Number:
                </td>
                <td>
                    '.$data['name'].'<br>
                    '.$data['certificateNum'] . ' ' . $data['openCoverNumber'].'
                </td>
            </tr>
        </table>
        
        <p class="normalFonts">
            To Whom It May Concern:
        </p>
        
        <p class="normalFonts">
            Please be advised that '.$data['name'].' has purchased Travel Single-Trip '.$world.'
            certificate number '.$certificateNumber . ' ' . $underwriterOpenCoverNumber.' 
            effective '.date("d-F-Y",mktime(0,0,0,$effDateSplit[1],$effDateSplit[2],$effDateSplit[0])).' 
            to '.date("d-F-Y",mktime(0,0,0,$expiryDate[1],$expiryDate[2],$expiryDate[0])).' . 
        </p>
        
        <p class="normalFonts" align="justify">
            The policy is administered by Kemter Insurance Agencies Sub-Agencies and Consultants Ltd and underwritten 
            by Lloyd\'s Insurance Company S.A..
        </p>
        
        <p class="normalFonts" align="justify">
            '.$worldLong.', per policy provisions. Coverage includes the Schengen states per the 
            policy provisions. Emergency evacuation (also known as Repatriation) is provided up to a maximum benefit 
            of '.$maxLimit.'            
            EUR and Return of Mortal Remains benefits up to a maximum of 
            '.$maxLimit.' EUR are included when 
            coordinated by Kemter Insurance Agencies Sub-Agencies and Consultants Ltd. A copy of the Schedule of Cover 
            and Excesses, which provides an outline of the plan\'s coverage, limitations, and maximum benefits, as well 
            as a copy of the Certificate of Insurance of the Policy indicated above may be
            presented as required. This information will verify that Eligible Expenses, including Hospitalisation expenses, are 
            subject to a '.$maxLimitExcess.' EUR excess. The maximum limit of coverage for the lifetime of the coverage is '.$maxLimit.' EUR.
        </p>
        
        <p class="normalFonts" align="justify">
            If you have any questions or would like to speak to someone regarding the above cover, please feel free to 
            contact our office at the number listed below.
        </p>
        <br><br><br>
        
        <p class="normalFonts">
            Sincerely,
        </p>
        
        <p class="normalFonts">
            <strong>Kemter Insurance Agencies Sub-Agencies and Consultants Ltd</strong>
        </p>
        
        <div style="height: 260px;"></div>
        
        <p class="normalFonts" style="color: lightblue" align="center">
            Athinon 82 , Akinita I Mitropolis, Block B\', Office 112 & 113, 3040 Limassol<br>
            Tel.+357 25755952, Fax: +357 25755953<br>
            E-mail:kemter@kemterinsurance.com
        </p>
        
        
    </div>
        ';
    return $return;

}

function getGenre($genre)
{
    if ($genre == 'Male') {
        return 'Male/Άρρεν';
    } else {
        return 'Female/Θήλυ';
    }
}

?>