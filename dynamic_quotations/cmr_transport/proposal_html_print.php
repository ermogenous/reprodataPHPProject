<?php

function getProposalHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    //section 1 ========================================================================================================================================SECTION 1
    $sect1 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 14");
    //section 2 ========================================================================================================================================SECTION 2
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 15");

    $checkBoxImage = '&#10004; Selected';
    $packageExcess = explode('#', $sect2['oqqit_rate_6']);

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
    font-family: Arial;
}
</style>

<table width="900" class="mainFonts">
    <tr>
        <td align="center" colspan="2">
            <b>INSURANCE QUESTIONNAIRE – RISK ANALYSIS<br>
            ΕΡΩΤΗΜΑΤΟΛΟΓΙΟ - ΑΝΑΛΥΣΗ ΚΙΝΔΥΝΩΝ</b><br>
            INTERNATIONAL TRANSPORTS CMR / DOMESTIC TRANSPORT CABOTAGE / LEGAL PROTECTION<br>
            ΑΣΤΙΚΗ ΕΥΘΥΝΗ ΜΕΤΑΦΟΡΕΑ ΓΙΑ ΔΙΕΘΝΕΙΣ ΜΕΤΑΦΟΡΕΣ CMR / ΕΘΝΙΚΕΣ ΜΕΤΑΦΟΡΕΣ  CABOTAGE / ΝΟΜΙΚΗ ΠΡΟΣΤΑΣΙΑ<br>
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>1.	Applicant Details / Στοιχεία Αιτούντος</b></td>    
    </tr>
    <tr class="tableTdBorder">
        <td width="40%">Company name / Επωνυμία επιχείρησης (λατινικοί χαρακτήρες)</td>
        <td width="60%">' . $quotationData['oqq_insureds_name'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Trading name (if different) / Εμπορικό Όνομα (αν διαφορετικό)</td>
        <td>' . $sect1['oqqit_rate_2'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Year company established / Έτος ίδρυσης εταιρείας</td>
        <td>' . $sect1['oqqit_rate_3'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Responsible Person / Υπεύθυνος</td>
        <td>' . $sect1['oqqit_rate_4'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Country / Χώρα<br>
            City / Τόπος<br>
            Postal Code Τ.Κ.
        </td>
        <td>
        ' . $sect1['oqqit_rate_2'] . '<br>
        ' . $quotationData['oqq_insureds_city'] . '<br>
        ' . $quotationData['oqq_insureds_postal_code'] . '
        </td>
    </tr>
    <tr class="tableTdBorder">
        <td>Street / Οδός</td>
        <td>' . $quotationData['oqq_insureds_address'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Telephone / Τηλέφωνο<br>
            Fax / Φαξ<br>
            Mobile / Κινητό
        </td>
        <td>
        ' . $sect1['oqqit_rate_5'] . '<br>
        ' . $sect1['oqqit_rate_6'] . '<br>
        ' . $sect1['oqqit_rate_7'] . '
        </td>
    </tr>
    <tr class="tableTdBorder">
        <td>E-Mail address / Ηλεκτρονική Διεύθυνση</td>
        <td>' . $sect1['oqqit_rate_8'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Website Address / Διεύθυνση της Ιστοσελίδας </td>
        <td>' . $sect1['oqqit_rate_9'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Correspondence Address / Διεύθυνση Αλληλογραφίας</td>
        <td>' . $sect1['oqqit_rate_10'] . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>VAT / Tax No. / Α.Φ.Μ. / Δ.Ο.Υ.</td>
        <td>' . $sect1['oqqit_rate_11'] . '</td>
    </tr>
    <tr>
        <td colspan="2">
            <br>Policy Commencement / Έναρξη συμβολαίου: 
            ' . $db->convertDateToEU($quotationData['oqq_starting_date'], 1, 0) . '
            Expiry: ' . $db->convertDateToEU($quotationData['oqq_expiry_date'], 1, 0) . '
        </td>
    </tr>
</table>
<br>
<table width="900" class="mainFonts">
    <tr>
        <td colspan="2"><b>2.	Business Details / Στοιχεία Επιχείρησης</b></td>
    </tr>
    <tr>
        <td width="75%">Estimated turnover (12 months) / Εκτιμώμενος κύκλος εργασιών (12 μήνες)</td>
        <td width="25%">€' . $sect1['oqqit_rate_12'] . '</td>
    </tr>
    <tr>
        <td>Number of vehicles to be Insured / Αριθμός οχημάτων που θα ασφαλιστούνε</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="mainFonts">
                <tr class="tableTdBorder">
                    <td width="25%">Vehicle Registration Number / Αριθμός Κυκλοφορίας Οχήματος</td>
                    <td width="25%">Tractor Unit / Ελκυστήρας</td>
                    <td width="25%">Trailer / Τρέϊλερ</td>
                    <td width="25%">Vehicle Type (see below) Τύπος Οχήματος (βλ. κάτω)</td>
                </tr>
                ';
    $vehicles123 = explode("@@", $sect2['oqqit_rate_8']);
    $vehicles[1] = explode("##", $vehicles123[0]);
    $vehicles[2] = explode("##", $vehicles123[1]);
    $vehicles[3] = explode("##", $vehicles123[2]);
    $vehicles456 = explode("@@", $sect2['oqqit_rate_9']);
    $vehicles[4] = explode("##", $vehicles456[0]);
    $vehicles[5] = explode("##", $vehicles456[1]);
    $vehicles[6] = explode("##", $vehicles456[2]);
    $vehicles789 = explode("@@", $sect2['oqqit_rate_10']);
    $vehicles[7] = explode("##", $vehicles789[0]);
    $vehicles[8] = explode("##", $vehicles789[1]);
    $vehicles[9] = explode("##", $vehicles789[2]);
    $vehicles101112 = explode("@@", $sect2['oqqit_rate_11']);
    $vehicles[10] = explode("##", $vehicles101112[0]);
    $vehicles[11] = explode("##", $vehicles101112[1]);
    $vehicles[12] = explode("##", $vehicles101112[2]);
    $vehicles131415 = explode("@@", $sect2['oqqit_rate_12']);
    $vehicles[13] = explode("##", $vehicles131415[0]);
    $vehicles[14] = explode("##", $vehicles131415[1]);
    $vehicles[15] = explode("##", $vehicles131415[2]);
    $vehicles161718 = explode("@@", $sect2['oqqit_rate_13']);
    $vehicles[16] = explode("##", $vehicles161718[0]);
    $vehicles[17] = explode("##", $vehicles161718[1]);
    $vehicles[18] = explode("##", $vehicles161718[2]);
    $vehicles1920 = explode("@@", $sect2['oqqit_rate_14']);
    $vehicles[19] = explode("##", $vehicles1920[0]);
    $vehicles[20] = explode("##", $vehicles1920[1]);
    $totalVehicles = 0;
    foreach ($vehicles as $vehicle) {
        if ($vehicle[0] != '') {
            $totalVehicles++;
            $html .= '
            <tr class="tableTdBorder">
                <td>' . $vehicle[0] . '</td>
                <td>' . $vehicle[1] . '</td>
                <td>' . $vehicle[2] . '</td>
                <td>' . $vehicle[3] . '</td>
            </tr>
        ';
        }
    }
    //give height for the rows to sit properly
    $extraBreaks = '';
    if ($totalVehicles == 1) $extraBreaks = '<br><br><br><br><br>';
    if ($totalVehicles == 2) $extraBreaks = '<br><br><br><br><br>';
    if ($totalVehicles == 3) $extraBreaks = '<br><br><br><br><br>';
    if ($totalVehicles == 4) $extraBreaks = '<br><br><br>';
    if ($totalVehicles == 5) $extraBreaks = '';
    $html .= '
            <tr>
                <td colspan="4">' . $extraBreaks . '</td>
            </tr>
    ';
    $questionsAll = explode("@@", $sect2['oqqit_rate_7']);
    $questionsGeo = explode("##", $questionsAll[0]);
    $questionsOp = explode("##", $questionsAll[1]);
    $questionsKind = explode("##", $questionsAll[2]);

    if ($questionsGeo[0] == '') $questionsGeo[0] = '0';
    if ($questionsGeo[1] == '') $questionsGeo[1] = '0';
    if ($questionsGeo[2] == '') $questionsGeo[2] = '0';
    if ($questionsGeo[3] == '') $questionsGeo[3] = '0';

    if ($questionsOp[0] == 1) $questionsOp[0] = 'Yes'; else $questionsOp[0] = 'No';
    if ($questionsOp[1] == 1) $questionsOp[1] = 'Yes'; else $questionsOp[1] = 'No';
    if ($questionsOp[2] == 1) $questionsOp[2] = 'Yes'; else $questionsOp[2] = 'No';
    if ($questionsOp[3] == 1) $questionsOp[3] = 'Yes'; else $questionsOp[3] = 'No';

    if ($questionsKind[0] == '') $questionsKind[0] = '0';
    if ($questionsKind[1] == '') $questionsKind[1] = '0';
    if ($questionsKind[2] == '') $questionsKind[2] = '0';
    if ($questionsKind[3] == '') $questionsKind[3] = '0';
    if ($questionsKind[4] == '') $questionsKind[4] = '0';
    if ($questionsKind[5] == '') $questionsKind[5] = '0';
    if ($questionsKind[6] == '') $questionsKind[6] = '0';
    if ($questionsKind[7] == '') $questionsKind[7] = '0';
    if ($questionsKind[8] == '') $questionsKind[8] = '0';

    $kindTotal = $questionsKind[0] + $questionsKind[1] + $questionsKind[2] + $questionsKind[3] + $questionsKind[4] +
        $questionsKind[5] + $questionsKind[6] + $questionsKind[7] + $questionsKind[8];

    $html .= '
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><br><b>Geographical Scope of Operations / Γεωγραφική Σφαίρα Δραστηριοτήτων</b></td>
    </tr>
    <tr>
        <td>International Transports within Europe / Διεθνείς μεταφορές εντός Ευρώπης</td>
        <td align="center">' . $questionsGeo[0] . '%</td>
    </tr>
    <tr>
        <td>International Transports within Europe / from and to CIS Countries / Διεθνείς μεταφορές εντός Ευρώπης 
        από και προς χώρες πρώην Σοβιετικής Ένωσης</td>
        <td align="center" valign="top">' . $questionsGeo[1] . '%</td>
    </tr>
    <tr>
        <td>National Transport (exclusively within Greece) / Εθνικές Μεταφορές (αποκλειστικά εντός Ελλάδας)</td>
        <td align="center">' . $questionsGeo[2] . '%</td>
    </tr>
    <tr>
        <td>Near and Middle east Countries (ex. Israel) / Χώρες της Εγγύς και Μέσης Ανατολής (πχ. Ισραήλ)</td>
        <td align="center">' . $questionsGeo[3] . '%</td>
    </tr>
    <tr>
        <td colspan="2"><br><b>Description of Operations / Περιγραφή Δραστηριοτήτων</b></td>
    </tr>
    <tr>
        <td>Do you carry out Domestic haulage? / Διεξάγετε εvδομεταφορές καμποτάζ;</td>
        <td valign="top" align="center">' . $questionsOp[0] . '</td>
    </tr>
    <tr>
        <td>Do loaded trailer(s) travel or remain unaccompanied? / Τα τρέϊλερ ταξιδεύουν ή παραμένουν 
        ασυνόδευτα όταν είναι φορτωμένα με εμπόρευμα;</td>
        <td valign="top" align="center">' . $questionsOp[1] . '</td>
    </tr>
    <tr>
        <td>Do you Haul third Party trailers or Containers? Κάνετε τρακτορεύσεις τρέϊλερ ή κοντέινερ τρίτων;</td>
        <td valign="top" align="center">' . $questionsOp[2] . '</td>
    </tr>
    <tr>
        <td>Do you transport cargo as a Freight forwarder / Διεξάγετε μεταφορές ως Διαμεταφορέας (Παραγγελιοδόχος μεταφοράς)</td>
        <td valign="top" align="center">' . $questionsOp[3] . '</td>
    </tr>
</table>

<table width="900" class="mainFonts">
    <tr>
        <td colspan="2"><br><b>Kind of Good Transported / Μεταφερόμενα Εμπορεύματα </b></td>
    </tr>
    <tr>
        <td width="85%"></td>
        <td width="15%" align="center">%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>General Cargo / Γενικό Εμπόρευμα </td>
        <td align="center">' . $questionsKind[0] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Refrigerated and/or temperature-controlled cargo / Θερμοκρασιακά Ελεγχόμενα Φορτία</td>
        <td align="center">' . $questionsKind[1] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>High value cargo (Electronics, DVDs etc.) / Φορτία υψηλής αξίας (Ηλεκτρονικά, DVD, κλπ.)</td>
        <td align="center">' . $questionsKind[2] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tobacco products / Προϊόντα καπνού</td>
        <td align="center">' . $questionsKind[3] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Wines and Spirits / Κρασιά και οινοπνευματώδη ποτά</td>
        <td align="center">' . $questionsKind[4] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Hazardous cargo / Επικίνδυνο φορτία</td>
        <td align="center">' . $questionsKind[5] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Pharmaceuticals / Φαρμακευτικά Προϊόντα</td>
        <td align="center">' . $questionsKind[6] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Personal and Household effects / Προσωπικά και Οικιακής Χρήσης αντικείμενα</td>
        <td align="center">' . $questionsKind[7] . '%</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Other / Άλλα </td>
        <td align="center">' . $questionsKind[8] . '%</td>
    </tr>
    <tr>
        <td width="85%"></td>
        <td width="15%" align="center">Total ' . $kindTotal . '%</td>
    </tr>
</table>
<table width="900" class="mainFonts">
    <tr>
        <td colspan="2"><b>Conventional basis of Liability / Συμβατικές βάσεις ευθύνης</b></td>
    </tr>
    <tr>
        <td width="60%">Special agreement with Companies (Please specifies) <br> Ειδικές συμφωνίες με εταιρίες (παρακαλούμε προσδιορίστε) </td>
        <td width="40%" valign="top">' . $sect2['oqqit_rate_3'] . '</td>
    </tr>
    <tr>
        <td>Other General Term Transaction (Please specify)<br> Άλλοι Γενικοί Όροι Συναλλαγών (παρακαλούμε προσδιορίστε)</td>
        <td valign="top">' . $sect2['oqqit_rate_4'] . '</td>
    </tr>
    <tr>
        <td align="center" colspan="2"><br>
            The following premiums refer to a six-month payment scheme. / Τα κάτωθι ασφάλιστρα αφορούν εξάμηνο τρόπο πληρωμής<br> 
            The deductible applies each and every loss per vehicle. / Η απαλλαγή ισχύει για κάθε ζημιά-γεγονός, ανά όχημα 
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2"><br><br><b>HAULIERS CMR / ΑΣΤΙΚΗ ΕΥΘΥΝΗ ΜΕΤΑΦΟΡΕΑ</b></td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            For more than 5 vehicles 5% discount / Για περισσότερα από 5 οχήματα ισχύει 5% έκπτωση<br>
            For more than 15 vehicles 10% discount Για περισσότερα από 15 οχήματα ισχύει 10% έκπτωση
        </td>
    </tr>
    <tr>
        <td colspan="2"><br>
            <b>Option 1 / Επιλογή 1η</b> &nbsp;' . ($sect2['oqqit_rate_5'] == 1 ? $checkBoxImage : '') . '<br>
            <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€1.500.000</b> per vehicle or other 
            means of transport and storage.<br>
            <b>DOMESTIC TRANSPORT Cabotage:</b> Maximum liability of <b>€600.000</b> per vehicle or other means of 
            transport and storage.<br>
            <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€1.500.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και 
            χώρο αποθήκευσης.<br>
            <b>ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage:</b> Ανώτατο όριο ευθύνης <b>€600.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και χώρο 
            αποθήκευσης<br>
        </td>
    </tr>
</table>
<table width="900" class="mainFonts">
    <tr class="tableTdBorder">
        <td width="40%"><b>Deductible / Απαλλαγή</b></td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€500 
        ' . ($packageExcess[0] == 1 && $packageExcess[1] == 500 ? $checkBoxImage : '') . '</b></td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€1.000 
        ' . ($packageExcess[0] == 1 && $packageExcess[1] == 1000 ? $checkBoxImage : '') . '</b></td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tarpaulin / Μουσαμάς</td>
        <td></td>
        <td align="center">€450</td>
        <td></td>
        <td align="center">€370</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tank - Silo / Βυτίο - Σιλοφόρο</td>
        <td></td>
        <td align="center">€540</td>
        <td></td>
        <td align="center">€460</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Reefer / Ψυγείο</td>
        <td></td>
        <td align="center">€630</td>
        <td></td>
        <td align="center">€550</td>
    </tr>
    <tr>
        <td colspan="5">
            <br><b>Option 2 / Επιλογή 2η</b> &nbsp;' . ($sect2['oqqit_rate_5'] == 2 ? $checkBoxImage : '') . '<br>
            <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€100.000</b> per vehicle or other means of 
            transport and storage.<br>
            <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€100.000</b> ανά όχημα ή άλλο μέσο 
            μεταφοράς και χώρο αποθήκευσης.<br>
        </td>
    </tr>
    <tr class="tableTdBorder">
        <td width="40%"><b>Deductible / Απαλλαγή</b></td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€500</b>
        ' . ($packageExcess[0] == 2 && $packageExcess[1] == 500 ? $checkBoxImage : '') . '</td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€1.000</b>
        ' . ($packageExcess[0] == 2 && $packageExcess[1] == 1000 ? $checkBoxImage : '') . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tarpaulin / Μουσαμάς</td>
        <td></td>
        <td align="center">€350</td>
        <td></td>
        <td align="center">€300</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tank - Silo / Βυτίο - Σιλοφόρο</td>
        <td></td>
        <td align="center">€440</td>
        <td></td>
        <td align="center">€380</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Reefer / Ψυγείο</td>
        <td></td>
        <td align="center">€530</td>
        <td></td>
        <td align="center">€460</td>
    </tr>
    <tr>
        <td colspan="5">
            <br><b>Option 3 / Επιλογή 3η</b> &nbsp;' . ($sect2['oqqit_rate_5'] == 3 ? $checkBoxImage : '') . '<br>
            <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€1.500.000</b> per vehicle or other means 
            of transport and storage.<br>
            <b>DOMESTIC TRANSPORT Cabotage:</b> Maximum liability of <b>€600.000</b> per vehicle or other means of 
            transport and storage.<br>
            <b>INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR):</b><br>
            Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is 
            triggered for third party claims, for which it is are proven that there is no insurance.<br>
            The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons 
            into the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
            The maximum liability is <b>€50.000</b> per loss.<br>
            <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€1.500.000</b> ανά όχημα ή άλλο μέσο 
            μεταφοράς και χώρο αποθήκευσης.<br>
            <b>ΕΝΔΟΜΕΤΑΦΟΡΕΣ Cabotage:</b> Ανώτατο όριο ευθύνης <b>€600.000</b> ανά όχημα ή άλλο μέσο μεταφοράς και 
            χώρο αποθήκευσης.<br>
            <b>ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):</b><br>
            Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo 
            Clauses (C). Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν ασφάλιση εμπορευμάτων.<br>
            Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημίες εμπορευμάτων που προκύπτουν από εισβολή μη εξουσιοδοτημένων 
            προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν φέρει ευθύνη ο ασφαλισμένος.<br>
            Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι <b>€50.000</b> ανά ζημιά-γεγονός.<br>
        </td>
    </tr>
    <tr class="tableTdBorder">
        <td width="40%"><b>Deductible / Απαλλαγή</b></td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€500</b>
        ' . ($packageExcess[0] == 3 && $packageExcess[1] == 500 ? $checkBoxImage : '') . '</td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€1.000</b>
        ' . ($packageExcess[0] == 3 && $packageExcess[1] == 1000 ? $checkBoxImage : '') . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tarpaulin / Μουσαμάς</td>
        <td></td>
        <td align="center">€590</td>
        <td></td>
        <td align="center">€480</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tank - Silo / Βυτίο - Σιλοφόρο</td>
        <td></td>
        <td align="center">€700</td>
        <td></td>
        <td align="center">€600</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Reefer / Ψυγείο</td>
        <td></td>
        <td align="center">€810</td>
        <td></td>
        <td align="center">€720</td>
    </tr>
    <tr>
        <td colspan="5">
            <br>
            <b>Option 4 / Επιλογή 4η</b> &nbsp;' . ($sect2['oqqit_rate_5'] == 4 ? $checkBoxImage : '') . '<br>
            <b>INTERNATIONAL ROAD TRANSPORT (CMR):</b> Maximum liability <b>€100.000</b> per vehicle or other means 
            of transport and storage.<br>
            <b>INSURANCE EXTENSION FOR ROAD TRANSPORT (CMR)</b><br>
            Ancillary insurance cover for third parties according to the Institute Cargo Clauses (C). Coverage is 
            triggered for third party claims, for which it is are proven that there is no insurance.<br>
            The insurance cover applies only to damage to goods resulting from the intrusion of unauthorized persons 
            into the vehicle (e.g. stowaways) and / or traffic accidents for which the insured is not liable.<br>
            The maximum liability is <b>€50.000</b> per loss.<br>
            <b>ΔΙΕΘΝΕΙΣ ΟΔΙΚΕΣ ΜΕΤΑΦΟΡΕΣ (CMR):</b> Ανώτατο όριο ευθύνης <b>€100.000</b> ανά όχημα ή άλλο μέσο 
            μεταφοράς και χώρο αποθήκευσης.<br>
            <b>ΕΠΕΚΤΑΣΕΙΣ ΤΗΣ ΑΣΦΑΛΙΣΗΣ ΑΣΤΙΚΗΣ ΕΥΘΥΝΗΣ ΜΕΤΑΦΟΡΕΑ (CMR):</b><br>
            Ισχύει επικουρική ασφαλιστική κάλυψη εμπορευμάτων για λογαριασμό τρίτων σύμφωνα με τα Institute Cargo 
            Clauses (C). Η κάλυψη ενεργοποιείται για αξιώσεις τρίτων, οι οποίοι αποδεδειγμένα δεν έχουν 
            ασφάλιση εμπορευμάτων.<br>
            Η ασφαλιστική κάλυψη ισχύει αποκλειστικά για ζημίες εμπορευμάτων που προκύπτουν από εισβολή μη 
            εξουσιοδοτημένων προσώπων στο όχημα (πχ. λαθρομετανάστες) ή/και από ατυχήματα στην ξηρά για τα οποία δεν 
            φέρει ευθύνη ο ασφαλισμένος.<br>
            Το ανώτατο όριο ευθύνης της ασφαλιστικής εταιρίας είναι μέχρι <b>€50.000</b> ανά ζημιά-γεγονός.
        </td>
    </tr>
    <tr class="tableTdBorder">
        <td width="40%"><b>Deductible / Απαλλαγή</b></td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€500</b>
        ' . ($packageExcess[0] == 4 && $packageExcess[1] == 500 ? $checkBoxImage : '') . '</td>
        <td width="10%"></td>
        <td width="20%" align="center"><b>€1.000</b>
        ' . ($packageExcess[0] == 4 && $packageExcess[1] == 1000 ? $checkBoxImage : '') . '</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tarpaulin / Μουσαμάς</td>
        <td></td>
        <td align="center">€480</td>
        <td></td>
        <td align="center">€390</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Tank - Silo / Βυτίο - Σιλοφόρο</td>
        <td></td>
        <td align="center">€590</td>
        <td></td>
        <td align="center">€490</td>
    </tr>
    <tr class="tableTdBorder">
        <td>Reefer / Ψυγείο</td>
        <td></td>
        <td align="center">€700</td>
        <td></td>
        <td align="center">€590</td>
    </tr>
    <tr>
        <td colspan="5"><br><br><b>3. Claims History / Ιστορικό Απαιτήσεων </b></td>
    </tr>
    <tr>
        <td colspan="5">
        Have you sustained any loss or damage or incurred any liability during the last 5 years which has or could have 
        resulted in a claim. Please provide details:<br>
        Εάν είχατε υποστεί οποιαδήποτε απώλεια ή ζημιά ή υφίσταστε οποιαδήποτε ευθύνη κατά τη διάρκεια των τελευταίων 
        5 ετών η οποία έχει ή θα μπορούσε να οδηγήσει σε μια απαίτηση, Παρακαλώ δηλώστε:<br>
        </td>
    </tr>
</table>
<table width="900" class="mainFonts">
    <tr class="tableTdBorder">
        <td width="10%">Year / Έτος</td>
        <td width="25%">Insurer / Ασφαλιστική Εταιρεία</td>
        <td width="25%">Policy No. / Νούμερο Συμβολαίου</td>
        <td width="20%">Amount Paid (inc. currency) / Ποσό και νόμισμα που Πληρώθηκε </td>
        <td width="20%">Amount Reserved (inc. currency) / Ποσό και νόμισμα που Εκκρεμεί</td>
    </tr>
    ';
    $claims12 = explode("@@", $sect2['oqqit_rate_1']);
    $claims[1] = explode('##', $claims12[0]);
    $claims[2] = explode('##', $claims12[1]);
    $claims34 = explode("@@", $sect2['oqqit_rate_2']);
    $claims[3] = explode('##', $claims34[0]);
    $claims[4] = explode('##', $claims34[1]);

    foreach ($claims as $claim) {
        $html .= '
        <tr class="tableTdBorder">
            <td align="center">'.$claim[0].'</td>
            <td align="center">'.$claim[1].'</td>
            <td align="center">'.$claim[2].'</td>
            <td align="center">'.$claim[3].'</td>
            <td align="center">'.$claim[4].'</td>
        </tr>
        ';
    }

    $html .= '
</table>
<table width="900" class="mainFonts">
    <tr>
        <td colspan="3"><br><br><br>
            <b>Declaration / Υπεύθυνη Δήλωση</b><br>
            we declare that the information disclosed on this proposal is, to the best of our knowledge and belief, 
            both accurate and complete. We have taken care not to make any misrepresentation in the disclosure of this 
            information and understand that all information provided is relevant to the acceptance and assessment of 
            this insurance, the terms on which it is accepted and premium charged.<br>
            Εμείς δηλώνουμε ότι οι πληροφορίες που παρέχονται σε αυτή τη πρόταση είναι, εξ όσων γνωρίζουμε και 
            πιστεύουμε, είναι ακριβείς και πλήρεις. Εμείς έχουμε μεριμνήσει ώστε αυτές οι πληροφορίες που γνωστοποιούνται 
            να μην παρερμηνεύονται και κατανοούμε ότι όλες οι πληροφορίες που παρέχονται έχουν σχέση με την αποδοχή και 
            αξιολόγηση αυτής της ασφαλιστικής σύμβασης, των όρων αποδοχής και το ασφάλιστρο που τιμολογείται.<br> 
            <br><br><br><br><br>
        </td>
    </tr>
    <tr>
        <td width="45%"><hr></td>
        <td width="10%"></td>
        <td width="45%"><hr></td>
    </tr>
    <tr>
        <td>
        Signed by your authorised individual<br>								
        Υπογράφεται από εξουσιοδοτημένο Πρόσωπο 							
        </td>
        <td></td>
        <td>
        Position held in the Company<br>
        Θέση που κατέχεται στην Εταιρεία
        </td>
    </tr>
    <tr>
        <td colspan="3"><br><br>
            Date / Ημερομηνία: 
        </td>
    </tr>
</table>
    ';

    return $html;
}