<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 15/2/2020
 * Time: 2:37 μ.μ.
 */

function getQuotationHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    //section 1 ========================================================================================================================================SECTION 1
    $sect1 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 14");
    //section 2 ========================================================================================================================================SECTION 2
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 15");

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
        $startDateParts = explode('-', $quotationData['oqq_starting_date']);
        $startDateNum = ($startDateParts[0] * 10000) + ($startDateParts[1] * 100) + ($startDateParts[2] * 1);
        $stamp = '<img src="images/full_stamp_signature_2020.png" width="140">';

    }
    $excess = explode('#', $sect2['oqqit_rate_6']);
    $limit = '';
    $option = '';
    if ($sect2['oqqit_rate_5'] == 1) {
        $limit = '€1.500.000 per vehicle';
        $option = 'Option 1 / Επιλογή 1η - See below page 2 / Δες ποιό κάτω σελίδα 2';
    } else if ($sect2['oqqit_rate_5'] == 2) {
        $limit = '€100.000 per vehicle';
        $option = 'Option 2 / Επιλογή 2η - See below page 2 / Δες ποιό κάτω σελίδα 2';
    } else if ($sect2['oqqit_rate_5'] == 3) {
        $limit = '€1.500.000 per vehicle';
        $option = 'Option 3 / Επιλογή 3η - See below page 2 / Δες ποιό κάτω σελίδα 2';
    } else if ($sect2['oqqit_rate_5'] == 4) {
        $limit = '€100.000 per vehicle';
        $option = 'Option 3 / Επιλογή 4η - See below page 2 / Δες ποιό κάτω σελίδα 2';
    }

    //claims
    $claimsAB = explode('@@', $sect2['oqqit_rate_1']);
    $claimsA = explode('##', $claimsAB[0]);
    $claimsB = explode('##', $claimsAB[1]);
    $claimsCD = explode('@@', $sect2['oqqit_rate_2']);
    $claimsC = explode('##', $claimsCD[0]);
    $claimsD = explode('##', $claimsCD[1]);
    $claimsList = '';
    if ($claimsA[0] != '') {
        $claimsList = "Year:" . $claimsA[0] . " Policy:" . $claimsA[2] . " Paid: €" . $claimsA[3] . " Reserved: €" . $claimsA[4] . "<br>";
    }
    if ($claimsB[0] != '') {
        $claimsList .= "Year:" . $claimsB[0] . " Policy:" . $claimsB[2] . " Paid: €" . $claimsB[3] . " Reserved: €" . $claimsB[4] . "<br>";
    }
    if ($claimsC[0] != '') {
        $claimsList .= "Year:" . $claimsC[0] . " Policy:" . $claimsC[2] . " Paid: €" . $claimsC[3] . " Reserved: €" . $claimsC[4] . "<br>";
    }
    if ($claimsD[0] != '') {
        $claimsList .= "Year:" . $claimsD[0] . " Policy:" . $claimsD[2] . " Paid: €" . $claimsD[3] . " Reserved: €" . $claimsD[4] . "<br>";
    }

    //vehicles
    $vehiclesAB = explode('@@',$sect1['oqqit_rate_13']);
    $vehicleA = explode('##',$vehiclesAB[0]);
    $vehicleB = explode('##',$vehiclesAB[1]);
    $vehiclesCD = explode('@@',$sect1['oqqit_rate_14']);
    $vehicleC = explode('##',$vehiclesCD[0]);
    $vehicleD = explode('##',$vehiclesCD[1]);
    $vehiclesList = '';
    if ($vehicleA[0] != ''){
        $vehiclesList = $vehicleA[0];
    }
    if ($vehicleB[0] != ''){
        $vehiclesList .= ', '.$vehicleB[0];
    }
    if ($vehicleC[0] != ''){
        $vehiclesList .= ', '.$vehicleC[0];
    }
    if ($vehicleD[0] != ''){
        $vehiclesList .= ', '.$vehicleD[0];
    }

    $html = '
    <style>
.tableTdBorder td{
    border:1px solid #000000;
    padding:10px;
    border-spacing: 0px;
    font-size: 12px;
    font-family: Tahoma;
}
.elementPageBreak{
    page-break-before: always;
}
.mainFonts{
    font-size: 14px;
}
</style>
    <div style="font-family: Tahoma; ' . $draftImage . '">
        <table width="900" style="font-size: 14px;">
            <tr>
                <td colspan="2" align="right">
                    <img src="' . $db->admin_layout_url . '/images/tysers_logo.jpg" height="95">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="font-size: 16px;">
                    <b>
                    EVIDENCE OF COVER <br>
                    FREIGHT SERVICES LIABILITY INSURANCE FACILITY
                    </b>
                    <br>
                    <hr style="color: black;">
                </td>
            </tr>
        </table>
            <table width="900" style="font-size: 14px;" class="tableTdBorder">
            <tr>
                <td width="40%">
                    Unique Market Reference / Αποκλειστική Αναφορά Αγοράς:
                </td>
                <td width="60%">
                    B0572MA204464
                </td>
            </tr>
            
            <tr>
                <td>
                    Attaching to Delegated Authority No.: / Επισυνάπτεται στη Εξουσιοδότηση Νο.:
                </td>
                <td>
                
                </td>
            </tr>
            
            <tr>
                <td>
                    Insured Name / Όνομα Ασφαλιζομένου:
                </td>
                <td>
                    ' . $quotationData['oqq_insureds_name'] . '
                </td>
            </tr>
            
            <tr>
                <td>
                    Address / Διεύθυνση: 
                </td>
                <td>
                    ' . $quotationData['oqq_insureds_address'] . ', '.$quotationData['oqq_insureds_city'].', '.$quotationData['oqq_insureds_postal_code'].', '.$sect1['oqqit_rate_1'].'
                </td>
            </tr>
            
            <tr>
                <td>
                    Period of Insurance / Περίοδος Ασφάλισης 
                </td>
                <td>
                    ' . $db->convertDateToEU($quotationData['oqq_starting_date'], 1, 0) . ' To 
                    ' . $db->convertDateToEU($quotationData['oqq_expiry_date'], 1, 0) . '
                </td>
            </tr>
            
            <tr>
                <td>
                    Limit of Liability / Όριο Ευθύνης: 
                </td>
                <td>
                    ' . $limit . '<br>
                    A maximum of 8,33 SDR (special drawing rights) per kilo gross weight of the affected part of the shipment.<br> 
                    Μέγιστο 8,33 SDR (special drawing rights) ανά κιλό του μικτού βάρους του ζημιωθέντος εμπορεύματος.
                </td>
            </tr>
            
            <tr>
                <td>
                    Deductible / Απαλλαγή: 
                </td>
                <td>
                    €' . $excess[1] . '
                </td>
            </tr>
            
            <tr>
                <td>
                    Conditions / Όροι: 
                </td>
                <td>
                    As within and as per terms and conditions wording attaching to and forming part of this insurance.<br>
                    Όπως στα πλαίσια και σύμφωνα με τους όρους και τις προϋποθέσεις που διατυπώνονται και αποτελούν μέρος αυτής της ασφάλισης.
                </td>
            </tr>
            
            <tr>
                <td>
                    Gross Freight Receipts / Ακάθαρτες Εισπράξεις Μεταφορών:
                </td>
                <td>
                    €'.$sect1['oqqit_rate_12'].'
                </td>
            </tr>
            
            <tr>
                <td>
                    Insured Services / Ασφαλιστικές Υπηρεσίες: 
                </td>
                <td>
                    '.$option.'
                </td>
            </tr>
            
            <tr>
                <td>
                    Insured Vehicle Reg No. / Αρ. Εγγραφής Ασφαλιζόμενων Οχημάτων:
                </td>
                <td>
                    ' . $vehiclesList . '
                </td>
            </tr>
            
            <tr>
                <td>
                    CLAIMS:
                </td>
                <td>
                    ' . $claimsList . '
                </td>
            </tr>
            
            <tr>
                <td>
                    Premium / Ασφάλιστρα:
                </td>
                <td>
                
                </td>
            </tr>
            
            <tr>
                <td>
                    Stamps / Χαρτόσημα:
                </td>
                <td>
                    €2.00
                </td>
            </tr>
            
            <tr>
                <td>
                    Notification of Claims / Γνωστοποίηση Απαιτήσεων: 
                </td>
                <td>
                
                </td>
            </tr>
            
            <tr>
                <td>
                    Information Provided To Insurers <br> Πληροφορίες Που Παρέχονται στους Ασφαλιστές:
                </td>
                <td>
                    The information provided by the Insured to the Insurer by way of the online application website shall be 
                    deemed to form part of this insurance.<br>
	                The Insured must disclose any and all information which might influence the Insurer in deciding whether 
	                or not to accept this insurance risk, what the terms of the insurance should be, or what premium to charge. 
	                Failure to do so may render this insurance voidable from Inception and enable the Insurer to repudiate liability.
	                <br><br>
                    Οι πληροφορίες που παρέχει ο Ασφαλισμένος στον Ασφαλιστή μέσω της διαδικτυακής εφαρμογής θεωρούνται ότι 
                    αποτελούν μέρος αυτής της ασφάλισης.<br>
                    Ο Ασφαλιζόμενος πρέπει να παρέχει οποιεσδήποτε πληροφορίες που θα μπορούσαν να επηρεάσουν τον Ασφαλιστή 
                    για να αποφασίσει εάν θα αποδεχθεί ή όχι αυτόν τον κίνδυνο, τους όρους αυτής της ασφάλισης ή τι ασφάλιστρο 
                    θα χρεώσει. Εάν δεν το κάνετε αυτό, η ασφάλιση αυτή μπορεί να ακυρωθεί από την Έναρξη και να επιτρέψει 
                    στον Ασφαλιστή να αρνηθεί ευθύνη.


                </td>
            </tr>

        </table>
        
<!-- SECOND PAGE -->        
        <div class="elementPageBreak">
        
        <table width="900" style="font-size: 14px;">
            <tr>
                <td colspan="2" align="right">
                    <img src="' . $db->admin_layout_url . '/images/tysers_logo.jpg" height="95">
                </td>
            </tr>
            <tr>
                <td>
                    <b>Option 1 / Επιλογή 1η</b><br>
                    <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€1.500.000</b> per vehicle or other means of transport and storage.<br>
                    <b>DOMESTIC TRANSPORT Cabotage:</b> Maximum liability of <b>€600.000</b> per vehicle or other means of transport and storage.<br>
                    <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€1.500.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    <b>ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage:</b> Ανώτατο όριο ευθύνης <b>€600.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    <br>
                    <b>Option 2 / Επιλογή 2η</b><br>
                    <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€100.000</b> per vehicle or other means of transport and storage.<br>
                    <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€100.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    <br>
                    <b>Option 3 / Επιλογή 3η</b><br>
                    <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€1.500.000</b> per vehicle or other means of transport and storage.<br>
                    <b>DOMESTIC TRANSPORT Cabotage:</b> Maximum liability of <b>€600.000</b> per vehicle or other means of transport and storage.<br>
                    <b>INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR)</b><br>
                    Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is triggered for third party claims, for which it is are proven that there is no insurance.<br>
                    The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons into the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
                    The maximum liability is <b>€50.000</b> per loss.<br>
                    ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR): Ανώτατο όριο ευθύνης <b>€1.500.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage: Ανώτατο όριο ευθύνης <b>€600.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):<br>
                    Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo Clauses (C). Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν ασφάλιση εμπορευμάτων.<br>
                    Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημιές εμπορευμάτων που προκύπτουν από εισβολή μη εξουσιοδοτημένων προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν φέρει ευθύνη ο ασφαλισμένος.<br>
                    Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι <b>€50.000</b> ανά ζημιά-γεγονός.<br>
                    <br>
                    <b>Option 4 / Επιλογή 4η</b><br>
                    <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€100.000</b> per vehicle or other means of transport and storage.<br>
                    <b>INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR)</b><br>
                    Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is triggered for third party claims, for which it is are proven that there is no insurance.<br>
                    The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons into the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
                    The maximum liability is <b>€50.000</b> per loss.<br>
                    <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€100.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο αποθήκευσης.<br>
                    <b>ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):</b><br>
                    Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo Clauses (C). Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν ασφάλιση εμπορευμάτων.<br>
                    Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημιές εμπορευμάτων που προκύπτουν από εισβολή μη εξουσιοδοτημένων προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν φέρει ευθύνη ο ασφαλισμένος.<br>
                    Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι <b>€50.000</b> ανά ζημιά-γεγονός.<br>

                </td>
            </tr>
            <tr>
                <td style="height: 300px;"></td>
            </tr>
        </table>
        
        
        
        <table width="900" style="font-size: 14px;">
            <tr>
                <td colspan="2" align="right">
                    <img src="' . $db->admin_layout_url . '/images/tysers_logo.jpg" height="95">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="font-size: 16px;">
                    <b>
                    EVIDENCE OF COVER <br>
                    FREIGHT SERVICES LIABILITY INSURANCE FACILITY
                    </b>
                    <br>
                    <hr style="color: black;">
                </td>
            </tr>
        </table>
        
        <table width="900" style="font-size: 14px;">
            <tr>
                <td width="30%"><b>Security / Ασφαλιστές:</b></td>
                <td width="70%">
                    Signed on this date / Ημερομηνία υπογραφής - 
                    <br><br><br>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="justify">
                    <b>COMPLAINTS PROCEDURE</b> <br>
                    If you would like a copy of our complaint handling procedures or if you wish to make a complaint in 
                    respect of the services provided by us, you should first contact our Compliance Officer by email at 
                    ukcomplaints@integrogroup.com or in writing at 71 Fenchurch Street, London EC3M 4BS or by telephone 
                    at +44 (0)20 3915 0000. 
                    <br><br>
                    If you cannot thereafter settle your complaint with us directly, you may be entitled to refer it to 
                    the Financial Ombudsman Service (‘FOS’) whose contact details can be found on the FOS website at 
                    www.financialombudsman.org.uk. 
                    <br><br>
                    If you cannot settle your complaint with us and have no entitlement to refer it to the FOS, you can 
                    escalate the matter to Director of Legal & Compliance, Simon Palmer. 
                    <br><br>
                    If you are a consumer and your complaint relates to insurance purchased from us via electronic means 
                    (e.g. on‐line or via email or mobile ‘phone) then you are also able to use the EC On‐line Dispute 
                    Resolution (ODR) platform at http://ec.europa.eu/consumers/odr/ who will notify FOS on your behalf.

                </td>
            </tr>
            
            <tr>
                <td colspan="2" align="justify">
                    <b>ΔΙΑΔΙΚΑΣΙΑ ΠΑΡΑΠΟΝΩΝ</b> <br>
                    Εάν επιθυμείτε αντίγραφο των διαδικασιών διεκπεραίωσης των παράπονων μας ή εάν επιθυμείτε να υποβάλετε 
                    καταγγελία σχετικά με τις υπηρεσίες που παρέχονται από εμάς, θα πρέπει πρώτα να επικοινωνήσετε με τον 
                    Υπεύθυνο Συμμόρφωσης μέσω ηλεκτρονικού ταχυδρομείου στο ukcomplaints@integrogroup.com ή εγγράφως στη 
                    διεύθυνση 71 Fenchurch Street , Λονδίνο EC3M 4BS ή τηλεφωνικά στο +44 (0) 20 3915 0000.
                    <br><br>
                    Εάν στη συνέχεια δεν μπορείτε να διευθετήσετε άμεσα το παράπονο σας μαζί μας, ίσως έχετε το δικαίωμα να 
                    την παραπέμψετε στον Ενιαίο Φορέα Εξώδικης Επίλυσης Διαφορών Χρηματοοικονομικής Φύσης (Financial Ombudsman 
                    Service FOS), τα στοιχεία επικοινωνίας του οποίου βρίσκονται στην Ιστοσελίδα της FOS στη διεύθυνση: 
                    www.financialombudsman.org.uk.
                    <br><br>
                    Εάν δεν μπορείτε να διευθετήσετε το παράπονο σας μαζί μας και δεν έχετε κανένα δικαίωμα να το παραπέμψετε 
                    στο FOS, μπορείτε να κλιμακώσετε το θέμα απευθύνοντας το στον Διευθυντή Νομικών & Συμμόρφωσης, Simon Palmer.
                    <br><br>
                    Εάν είστε καταναλωτής και η καταγγελία σας σχετίζεται με ασφαλιστήριο που αγοράσατε από εμάς μέσω 
                    ηλεκτρονικών μέσων (π.χ. ηλεκτρονικά ή μέσω ηλεκτρονικού ταχυδρομείου ή κινητού τηλεφώνου), τότε μπορείτε 
                    επίσης να χρησιμοποιήσετε την πλατφόρμα επίλυσης διαφορών (ΗΕΔ) της Ευρωπαϊκής Ένωσης στο ec.europa.eu/consumers/odr/ 
                    που θα ειδοποιήσει τον Ενιαίο Φορέα Εξώδικης Επίλυσης Διαφορών Χρηματοοικονομικής Φύσης FOS για λογαριασμό σας.


                </td>
            </tr>
        </table>
        
<!-- THIRD PAGE -->
            <table width="900" style="font-size: 13px;">
            <tr>
                <td height="500"></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <img src="' . $db->admin_layout_url . '/images/tysers_logo.jpg" height="95">
                </td>
            </tr>
            <tr>
                <td align="justify">
                    <b>IMPORTANT NOTICE</b><br><br>
                    <b>PROCEDURE IN THE EVENT OF LOSS OR DAMAGE FOR WHICH UNDERWRITERS MAY BE LIABLE</b><br><br>
                    In the event of loss or damage where Underwriters liability may be involved, it is essential that 
                    Underwriters be informed immediately in order that they may consider whether or not a survey is 
                    required to establish the extent of loss or damage.  You should, therefore, contact TYSERS who will 
                    instruct you in the steps to be taken and the documentation required.<br><br>
                    
                    <b>ΣΗΜΑΝΤΙΚΗ ΕΝΗΜΕΡΩΣΗ
                    <br><br>ΔΙΑΔΙΚΑΣΙΑ ΣΕ ΠΕΡΙΠΤΩΣΗ ΑΠΩΛΕΙΑΣ Ή ΖΗΜΙΑΣ ΓΙΑ ΤΙΣ ΟΠΟΙΕΣ ΥΠΑΡΧΟΥΝ ΥΠΟΧΡΕΩΣΕΙΣ
                    </b><br><br>
                    Σε περίπτωση απώλειας ή ζημιάς, στην οποία μπορεί να εμπλέκεται η ευθύνη του Ασφαλιστή, είναι απαραίτητο οι 
                    Ασφαλιστές να ενημερωθούνε άμεσα ώστε να μπορούν να διαπιστώσουν εάν απαιτείται ή όχι εκτίμηση για να εξακριβωθεί 
                    η έκταση της ζημαίς. Ως εκ τούτου, πρέπει να επικοινωνήσετε με τους TYSERS, οι οποίοι θα σας καθοδηγήσουν 
                    στα βήματα που πρέπει να γίνουν και στην τεκμηρίωση που απαιτείται.
                    <br><br>
                    
                    <b>DUTIES OF THE ASSURED</b><br>
                    It is the duty of the Assured and their Agents, in all cases, to take such measures as may be 
                    reasonable for the purpose of averting or minimising a loss and to ensure that all rights against 
                    Carriers, Bailees or other third parties are properly preserved and exercised.  In particular, 
                    the Assured or their Agents are required:<br>
                    1.	To claim immediately on the Carriers, Port Authorities or other Bailees for any missing packages.<br>
                    2.	In no circumstances, except under written protest, to give clean receipts where goods are in doubtful condition.<br>
                    3.	When delivery is made by Container, to ensure that the Container and its seals are examined 
                    immediately by their responsible official.<br>
                    If the Container is delivered damaged or with seals broken or missing or with seals other than as 
                    stated in the shipping documents, to clause the delivery receipt accordingly and retain all defective 
                    or irregular seals for subsequent identification.<br>
                    4.	To apply immediately for survey by Carriers’ or other Bailees’ Representatives if any loss or 
                    damage be apparent and claim on the Carriers or other Bailees for any actual loss or damage found at such survey.<br>
                    5.	To give notice in writing to the Carriers or other Bailees within 3 days of delivery if the 
                    loss or damage was not apparent at the time of taking delivery.<br><br>
                    
                    <b>ΚΑΘΗΚΟΝΤΑ ΤΟΥ ΑΣΦΑΛΙΣΜΕΝΟΥ</b><br><br>
                    
                    Είναι καθήκον του Ασφαλισμένου και των Πρακτόρων τους, σε κάθε περίπτωση, να λαμβάνουν λογικά μέτρα για 
                    την αποτροπή ή την ελαχιστοποίηση της ζημιάς και να διασφαλίζουν ότι όλα τα δικαιώματα έναντι των Μεταφορέων, 
                    οι Θεματοφύλακες ή άλλα τρίτα μέρη διατηρούνται και ασκούνται σωστά. Συγκεκριμένα, οι Ασφαλισμένοι ή οι 
                    Πράκτορές τους απαιτούνται:<br>
                    1.	Να ζητήσουν αμέσως από τους Φορείς, τις Λιμενικές Αρχές ή άλλους Θεματοφύλακες για τυχόν ελλείποντα πακέτα.<br>
                    2.	Σε καμία περίπτωση, εκτός από γραπτή διαμαρτυρία, να δώσουν καθαρή φορτωτική όταν τα εμπορεύματα 
                    βρίσκονται σε αμφίβολη κατάσταση.<br>
                    3.	Όταν η παράδοση πραγματοποιείται με εμπορευματοκιβώτιο, να βεβαιωθούν ότι το εμπορευματοκιβώτιο 
                    και οι σφραγίδες του ελέγχονται αμέσως από τον αρμόδιο υπάλληλο.
                    Εάν το εμπορευματοκιβώτιο έχει παραδοθεί με ζημιές ή με σπασμένες σφραγίδες ή στερείται σφραγίδας ή 
                    με σφραγίδες διαφορετικές από εκείνες που αναφέρονται στα έγγραφα αποστολής, να αναγράψετε τις διαφορές 
                    στην φορτωτική και να διατηρήσουν όλες τις ελαττωματικές ή ακανόνιστες σφραγίδες για επακόλουθη αναγνώριση.<br>
                    4.	Να υποβάλουν αμέσως αίτηση για εκτίμηση από τους Μεταφορείς ή άλλους εκπροσώπους των Θεματοφυλάκων 
                    εάν οποιαδήποτε απώλεια ή ζημιά είναι εμφανής και να ζητήσουν από τους μεταφορείς ή άλλους Θεματοφύλακες 
                    για τυχόν πραγματικές απώλειες ή ζημιές που διαπιστώθηκαν κατά την έρευνα αυτή.<br>
                    5.	Να ενημερώσουν γραπτώς τους Μεταφορείς ή άλλους Θεματοφύλακες εντός 3 ημερών από την παράδοση εάν η 
                    ζημιά δεν ήταν εμφανής κατά τη στιγμή της παραλαβής.<br><br>

                    
                    
                    <b>
                    NOTE:<br>
                    The Consignees or their Agents are recommended to make themselves familiar with the Regulations of 
                    the Port Authorities at the port of discharge.<br><br>
                    DOCUMENTATION OF CLAIMS
                    </b><br>
                    
                    To enable claims to be dealt with promptly, the Assured or their Agents are advised to submit all 
                    available supporting documents without delay, including when applicable:<br>
                    1.	Original policy or certificate of insurance.<br>
                    2.	Original or copy shipping invoices, together with shipping specification and/or weight notes.<br>
                    3.	Original Bill of Lading and/or other contract of carriage. (Full set in the event of total loss. <br>
                    4.	Survey report or other documentary evidence to show the extent of the loss or damage.<br>
                    5.	Landing account and weight notes at final destination.<br>
                    6.	Correspondence exchanged with the Carriers and other Parties regarding their liability for the loss or damage.
                    <br><br>
                    
                    <b>ΣΗΜΕΙΩΣΗ:</b><br>
                    Οι παραλήπτες ή οι Αντιπρόσωποί τους συνιστώνται να εξοικειωθούν με τους Κανονισμούς των Λιμενικών 
                    Αρχών στο λιμάνι εκφόρτωσης.<br><br>
                    
                    <b>ΤΕΚΜΗΡΙΩΣΗ ΑΠΑΙΤΗΣΕΩΝ</b>
                    <br>
                    Για να διευκολυνθεί η ταχεία διεκπεραίωση απαιτήσεων ο Ασφαλιζόμενος ή οι Πράκτορές του συμβουλεύονται 
                    να υποβάλουν χωρίς καθυστέρηση όλα τα διαθέσιμα δικαιολογητικά, συμπεριλαμβανομένου, κατά περίπτωση:<br>
                    1.		Πρωτότυπο συμβόλαιο ή πιστοποιητικό ασφάλισης.<br>
                    2.		Πρωτότυπα ή αντίγραφα τιμολογίων αποστολής, μαζί με τις προδιαγραφές αποστολής ή / και ζυγολόγια.<br>
                    3.		Πρωτότυπο φορτωτικής ή / και άλλη σύμβαση μεταφοράς. (Όλα τα έγγραφα σε περίπτωση ολικής απώλειας.)<br>
                    4.		Εκτίμηση ή άλλα αποδεικτικά στοιχεία που να δείχνουν την έκταση της ζημιάς.<br>
                    5.		Τελική έκθεση εκφόρτωσης και σημειώσεις βάρους στον τελικό προορισμό.<br>
                    6.		Ανταλλαγή αλληλογραφίας με τους Μεταφορείς και άλλα Μέρη σχετικά με την ευθύνη τους για την απώλεια ή τη ζημιά.<br>


                </td>
            </tr>
        </table>
    
    
        
    </div>
    ';
    return $html;
}