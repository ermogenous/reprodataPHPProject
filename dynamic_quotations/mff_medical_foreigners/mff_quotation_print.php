<?php
function getQuotationHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

//section 1 ========================================================================================================================================SECTION 1
    $sect1 = $db->query_fetch("SELECT *
                                        ,(SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_5)as clo_insured_country
                                        ,(SELECT cde_value FROM codes WHERE cde_code_ID = oqqit_rate_3)as clo_insured_occupation
                                        FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 1");
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 2");

    //find the package
    $pack1Html = '<input type="checkbox">';
    $pack2Html = '<input type="checkbox">';
    $pack3Html = '<input type="checkbox">';
    if ($sect2['oqqit_insured_amount_1'] == '1'){
        $pack1Html = '<input type="checkbox" checked="checked">';
    }else if ($sect2['oqqit_insured_amount_1'] == '2'){
        $pack2Html = '<input type="checkbox" checked="checked">';
    }
    else if ($sect2['oqqit_insured_amount_1'] == '3'){
        $pack3Html = '<input type="checkbox" checked="checked">';
    }

    //el
    $elPackage = '<input type="checkbox">';
    $socialSecurity = '';
    if ($sect2['oqqit_insured_amount_2'] == 1){
        $elPackage = '<input type="checkbox" checked="checked">';
        $socialSecurity = $sect2['oqqit_rate_3']."/".$sect2['oqqit_rate_4']."/".$sect2['oqqit_rate_5'];
    }

    $startDateParts = explode('-',explode(' ',$quotationData['oqq_starting_date'])[0]);
    $startDateNum = ($startDateParts[0] * 10000) + ($startDateParts[1] * 100) + ($startDateParts[2] * 1);

    //certificate number
    if ($quotationData['oqq_status'] != 'Active'){
        $certificateNumber = 'DRAFT';
        $draft = 'DRAFT';
        $draftImage = 'background-image:url(' . $main['site_url'] . '/dynamic_quotations/images/draft.gif);';
        $signature = '';
        $stamp = '';
    }
    else {
        $certificateNumber = $quotationData['oqq_number'];
        $draft = '';
        $draftImage = '';
        $signature = '<img src="images/santamas_signature_200.png" width="200">';

        if ($startDateNum < 20200101){
            $stamp = '<img src="images/full_stamp_signature.png" width="140">';
        }
        else if ($startDateNum >= 20200101 && $startDateNum < 20210701){
            $stamp = '<img src="images/full_stamp_signature_2020.png" width="140">';
        }
        else {
            $stamp = '<img src="images/full_stamp_signature_2021.png" width="140">';
        }



    }

    //if starting date is after 30/6/2021
    if ($startDateNum < 20210701) {
        $lloydsLogo = '<img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png">';
        $lloydsText = 'Authorised Coverholder at Lloyd`s';
    }
    else {
        $lloydsLogo = '';
        $lloydsText = '';
    }

    $html = '
<style>
.tableTdBorder td{
    border:1px solid #000000;
    padding:5px;
    font-size: 12px;
    font-family: Tahoma;
}

</style>
<div style="font-family: Tahoma; '.$draftImage.'">
    <table width="900" style="font-size: 14px;">
        <tr>
            <td width="33%"><img src="' . $db->admin_layout_url . '/images/Kemter-Logo-WhiteBG-300x60.png"></td>        
            <td width="34%" align="center">Certificate Number<br>Αριθμός Πιστοποιητικού<br><b>'.$certificateNumber.'</b></td>
            <td width="33%" align="right">'.$lloydsLogo.'</td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>PROPOSAL & EVIDENCE OF INSURANCE / ΠΡΟΤΑΣΗ & ΑΠΟΔΕΙΞΗ ΑΣΦΑΛΙΣΗΣ</b></td>
        </tr>
    </table>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="270">
                <b>POLICYHOLDER / ΣΥΜΒΑΛΛΟΜΕΝΟΣ</b>	
            </td>
            <td colspan="4">
                ' . $quotationData['oqq_insureds_name'] . '
            </td>
        </tr>
        <tr>
            <td>Identity Card or Company Reg. Number<br>Ταυτότητα ή Αριθμός Εγγραφής Εταιρείας</td>
            <td colspan="4">' . $quotationData['oqq_insureds_id'] . '</td>
        </tr>
        <tr>
            <td rowspan="2">Address / Διεύθυνση</td>        
            <td colspan="4"> ' . $quotationData['oqq_insureds_address'] . '</td>        
        </tr>
        <tr>
            <td width="100">City / Πόλη</td>
            <td width="170">' . $quotationData['oqq_insureds_city'] . '</td>
            <td width="130">Post Code / Κώδικας</td>
            <td>' . $quotationData['oqq_insureds_postal_code'] . '</td>
        </tr>
        <tr>
            <td>Home Telephone Number / Τηλέφωνο Οικίας</td>        
            <td colspan="2">' . $quotationData['oqq_insureds_tel'] . '</td>        
            <td>Mobile Number  Αριθμός Κινητού</td>        
            <td>' . $quotationData['oqq_insureds_mobile'] . '</td>        
        </tr>
     </table>
     <div style="height: 5px;"></div>
     <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="270"><b>INSURED / ΑΣΦΑΛΙΖΟΜΕΝΟΣ</b></td>
            <td colspan="3">' . $sect1['oqqit_rate_1'] . '</td>        
        </tr>
        <tr>
            <td>Place of Usual Business<br>Τόπος Συνήθους Εργασίας</td>        
            <td width="270">' . $sect1['oqqit_rate_2'] . '</td>        
            <td width="130">Occupation / Επάγγελμα</td>        
            <td width="">' . $sect1['clo_insured_occupation'] . '</td>
        </tr>
        <tr>
            <td>Passport Number / Αριθμός Διαβατηρίου</td>        
            <td>' . $sect1['oqqit_rate_4'] . '</td>
            <td>Country / Χώρα</td>        
            <td>' . $sect1['clo_insured_country'] . '</td>
        </tr>
        <tr>
            <td>Date of Birth / Ημερομηνία Γέννησης</td>        
            <td>'.$db->convert_date_format($sect1['oqqit_date_1'], 'yyyy-mm-dd', 'dd/mm/yyyy').'</td>
            <td>Gender / Γένος</td>        
            <td>' . getGenre($sect1['oqqit_rate_6']) . '</td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="30%">Period of Insurance / Περίοδος Ασφάλισης</td>
            <td width="100">From / Από</td>
            <td width="170">'.$db->convert_date_format($quotationData['oqq_starting_date'], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0).'</td>
            <td width="130">Το / Μέχρι</td>
            <td>'.$db->convert_date_format($quotationData['oqq_expiry_date'], 'yyyy-mm-dd', 'dd/mm/yyyy',1,0).'</td>
        </tr>
    </table>
    
    <div style="height: 5px;"></div>
    
    <table class="tableTdBorder" width="900" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20" style="border-right: 0px solid;"></td>
            <td width="580" align="center" style="border-left: 0px solid;"><b>SCHEDULE OF BENEFITS / ΠΙΝΑΚΑΣ ΠΑΡΟΧΩΝ</b></td>
            <td width="100" align="center"><b>PLAN A<br>ΣΧΕΔΙΟ Α</b></td>
            <td width="100" align="center"><b>PLAN B<br>ΣΧΕΔΙΟ Β</b></td>
            <td width="100" align="center"><b>PLAN C<br>ΣΧΕΔΙΟ Γ</b></td>
        </tr>
        <tr>
            <td style="border-right: 0px solid;" valign="top"><b>1.</b></td>
            <td style="border-left: 0px solid;">
                <b>
                MAXIMUM LIMIT PER ACCIDENT OR ILLNESS IN RESPECT OF IN-HOSPITAL TREATMENT<br>
                ΑΝΩΤΑΤΟ ΠΟΣΟ ΚΑΤΑ ΑΣΘΕΝΕΙΑ Ή ΑΤΥΧΗΜΑ ΕΝΤΟΣ ΝΟΣΟΚΟΜΕΙΟΥ
                </b>
                <br>
                &bull; &nbsp;&nbsp; Per in-hospital treatment/ Για Ενδονοσοκομειακή Περίθαλψη<br> 
                &bull; &nbsp;&nbsp; Per period of insurance and per person / Κατά περίοδο ασφάλισης και κατά άτομο<br>
                
                <b>1a. Hospitalization</b> (Room & Board) per day 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ΗΜΕΡΗΣΙΑ ΝΟΣΗΛΕΙΑ</b> (Δωμάτιο & Τροφή) για κάθε μέρα<br>
                <b>1b. Hospitalization</b> (Room & Board) per day Intensive Care 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ΗΜΕΡΗΣΙΑ ΝΟΣΗΛΕΙΑ</b> (Δωμάτιο & Τροφή) για κάθε μέρα σε μονάδα Εντατικής Παρακολούθησης
            </td>
            <td align="center" valign="top">Euro/€<br><br>8.600<br>13.700<br><br>70<br>175</td>
            <td align="center" valign="top">Euro/€<br><br>8.600<br>13.700<br><br>70<br>175</td>
            <td align="center" valign="top">Euro/€<br><br>12.000<br>18.000<br><br>100<br>300</td>
        </tr>
        <tr>
            <td style="border-right: 0px solid;" valign="top"><b>2.</b></td>
            <td style="border-left: 0px solid;">
            <b>MAXIMUM LIMIT PER ACCIDENT OR ILLNESS PER OUT-HOSPITAL TREATMENT<br>
            ΑΝΩΤΑΤΟ ΠΟΣΟ ΚΑΤΑ ΑΣΘΕΝΕΙΑ Ή ΑΤΥΧΗΜΑ ΕΚΤΟΣ ΝΟΣΟΚΟΜΕΙΟΥ</b><br>
            &bull; &nbsp;&nbsp; Per Out-hospital treatment / Για Εξωνοσοκομειακή Περίθαλψη<br>
            &bull; &nbsp;&nbsp; Per period of insurance and per person / Κατά περίοδο ασφάλισης και κατά άτομο<br>

            <b>2a.    MAXIMUM AMOUNT PER DOCTOR’S VISIT / ΑΝΩΤΑΤΟ ΠΟΣΟ ΚΑΤΑ ΙΑΤΡΙΚΗ ΕΠΙΣΚΕΨΗ</b>
            </td>
            <td align="center" valign="top"><br>685<br>1.750<br><br>20</td>
            <td align="center" valign="top"><br>---<br>---<br><br>---</td>
            <td align="center" valign="top"><br>1.000<br>2.500<br><br>50</td>
        </tr>
        <tr>
            <td style="border-right: 0px solid;" valign="top"><b>3.</b></td>
            <td style="border-left: 0px solid;">
            <b>MATERNITY COVER (Normal or Caesarean Section)<br>ΩΦΕΛΗΜΑ ΤΟΚΕΤΟΥ (Φυσιολογικός ή με καισαρική τομή)</b><br>
            Maximum limit up to / Ανώτατο όριο μέχρι:<br>
            The benefit is payable only if delivery takes place at least 10 months from the commencement of cover or inclusion of the Insured Person in the Policy. Το ωφέλημα είναι πληρωτέο νοουμένου ότι ο τοκετός γίνεται τουλάχιστον 10 μήνες μετά την έναρξη του Ασφαλιστηρίου ή την ένταξη του Ασφαλισμένου Προσώπου στο Ασφαλιστήριο
            </td>
            <td align="center" valign="top"><br><br>515</td>
            <td align="center" valign="top"><br><br>515</td>
            <td align="center" valign="top"><br><br>800</td>
        </tr>
        <tr>
            <td style="border-right: 0px solid;"><b>4.</b></td>
            <td style="border-left: 0px solid;">
            <b>TRANSPORTATION OF CORPSE / ΜΕΤΑΦΟΡΑΣ ΣΩΡΟΥ</b>
            </td>
            <td align="center" valign="top">3.450</td>
            <td align="center" valign="top">3.450</td>
            <td align="center" valign="top">5.000</td>
        </tr>
        <tr>
            <td style="border-right: 0px solid;"></td>
            <td style="border-left: 0px solid;" align="right"><b>Plan Selection / Επιλογή Σχεδίου</b></td>
            <td align="center">'.$pack1Html.'</td>
            <td align="center">'.$pack2Html.'</td>
            <td align="center">'.$pack3Html.'</td>
        </tr>
    </table>
    <div style="height: 7px;"></div>
    <div style="font-size: 10px; width: 900px; text-align: justify;">
        This <b>Schedule of Benefits</b> forms an integral part of <b>Medical Insurance Policy KMIPW 11 2017</b> This Policy will be renewed for an 
        additional period with the same terms and conditions that exist at the time of renewal subject to the premium being prepaid. 
        / <b>Ο Πίνακας Παροχών</b> αποτελεί αναπόσπαστο μέρος του <b>Ασφαλιστηρίου Ιατροφαρμακευτικής Περίθαλψης KMIPW 11 2017</b> Το Ασφαλιστήριο 
        θα ανανεωθεί αυτόματα για ακόμη μια ασφαλιστική περίοδο με τους όρους και τις προϋποθέσεις που θα ισχύουν κατά την ημερομηνία 
        ανανέωσης του και νοουμένου ότι το ασφάλιστρο ανανέωσης θα προπληρωθεί.<br>
        <div style="height: 7px;"></div>
        Co-insurance / Συνασφάλιση : Up to 65 years of age / Μέχρι 65 ετών &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10% on all Claims / 10% σε όλες τις απαιτήσεις<br>
        <div style="height: 7px;"></div>
    </div>
    <div style="font-size: 10px; width: 900px; text-align: left">
        Employers Liability Coverage / Κάλυψη Ευθύνη Εργοδότη: '.$elPackage.'
        &nbsp;&nbsp;
        Employer’s Registration Number / Αριθμό Μητρώου Εργοδότη: '.$socialSecurity.'
        <br>
        <br>
        <br>
        <br>
        Policyholder Signature / Υπογραφή Συμβαλλόμενου ____________________________________________ 
        Date / Ημερομηνία: ________________________
    </div>
 
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
                '.$signature.$draft.'
                <br>
                <br>
                Γιάννος Σανταμάς<br>
                Director / Διευθυντής<br>
                Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd<br>
                '.$lloydsText.' '.$draft.'
                </td>
                <td align="center">
                    '.$stamp.$draft.'<br><br>
                    Issue Date / Ημερομηνία Έκδοσης: <br>'.$db->convert_date_format($quotationData['oqq_effective_date'],'yyyy-mm-dd', 'dd/mm/yyyy',1,1).'
                </td>
            </tr>
        </table>
    </div>
    <div style="font-size: 10px;" align="center">
        P.O.Box 53538, 3033 Limassol Tel.:+357 25755952 Fax: +357 25755953 E-mail: kemter@kemterinsurance.com
    </div>
        
 </div>
    ';

    return $html;
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
