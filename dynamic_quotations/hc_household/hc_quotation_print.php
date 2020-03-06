<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 19/12/2019
 * Time: 10:52 π.μ.
 */

function getQuotationHTML($quotationID)
{
    global $db, $main;

    $quotationData = $db->query_fetch('SELECT * FROM oqt_quotations WHERE oqq_quotations_ID = ' . $quotationID);

    //underwriter data
    $underwriterData = $db->query_fetch('SELECT * FROM oqt_quotations_underwriters WHERE oqun_user_ID = '.$quotationData['oqq_users_ID']);

    $sect1 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 9");
    $sect2 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 10");
    $sect3 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 11");
    $sect4 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 12");
    $sect5 = $db->query_fetch("SELECT * FROM oqt_quotations_items WHERE oqqit_quotations_ID = " . $quotationID . " AND oqqit_items_ID = 13");

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
    font-family: Tahoma;
}
</style>
<div style="font-family: Tahoma; ' . $draftImage . '">
    <table width="900" class="mainFonts">
        <tr>
            <td width="60%">
                <img src="' . $db->admin_layout_url . '/images/kemter_logo2.jpg" width="200">
            </td>
            <td width="40%" align="right">
                <img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png" width="200">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="font-size: 30px; color: grey">
                <b>Schedule / Πίνακας</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="font-size: 20px;">
                <b>Kemter Household Insurance / Kemter Ασφάλεια Κατοικίας</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                Policy Details / Στοιχεία Συμβολαίου: <br><br>
                Policy Number / Αριθμός Συμβολαίου: '.$certificateNumber.'<br><br>
                Unique Market Reference / Αποκλειστική Αναφορά Αγοράς: <br><br>
                Wording / Λεκτικό:	Kemter Household Insurance <br><br>
                Insured / Ασφαλιζόμενος: '.$quotationData['oqq_insureds_name'].'<br><br>
                Premises / Υποστατικά: '.$sect1['oqqit_rate_8'].', '.$sect1['oqqit_rate_9'].', '.$sect1['oqqit_rate_10'].', '.$sect1['oqqit_rate_11'].', '.$sect1['oqqit_rate_12'].'<br><br>
                Description of Business Use / Περιγραφή Επαγγελματικής Χρήσης: <br><br>
                Period of Insurance / Περίοδος Ασφάλισης: From / Από: '.$db->convertDateToEU($quotationData['oqq_starting_date'],1,0).'&nbsp;&nbsp;
                Το / Μέχρι: '.$db->convertDateToEU($quotationData['oqq_expiry_date'],1,0).' <br>
                Συμπεριλαμβανομένων και των δύο ημερομηνιών, τοπική ώρα στη διεύθυνση Σας που προαναφέρθηκε.<br>
                Both dates Inclusive local standard time at Your address stated above.<br>
                <br>
                This policy will not automatically renew: notice is hereby given that cover will terminate and not be renewed 
                at the expiry date unless a new agreement is reached between Us and You.<br>
                Αυτό το συμβόλαιο δεν ανανεώνεται αυτόματα: με την παρούσα, δίδεται ειδοποίηση ότι η κάλυψη θα τερματιστεί και 
                δεν θα ανανεωθεί κατά την ημερομηνία λήξης, εκτός αν υπάρξει μια νέα συμφωνία μεταξύ Εμάς και Εσάς.<br>
                <br>
                We will provide insurance under each of the Sections below where an amount is shown next to it. If You are not 
                insured, the words “Not Included” are shown.<br>
                Εμείς θα παρέχουμε ασφάλιση σε κάθε Μέρος παρακάτω, όπου ένα ποσό καταδεικνύεται ακριβώς δίπλα. <br>
                Εάν Εσείς δεν είσαστε ασφαλισμένος/η οι λέξεις “Δεν Περιλαμβάνεται" καταδεικνύονται.<br>
            </td>
        </tr>
    </table>
    <br>
    
    <table width="900" class="mainFonts">
        <tr>
            <td colspan="2">
                <b>Section One – Buildings / Μέρος Ένα – Κτήρια</b><br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sum Insured / Ασφαλισμένο Ποσό<br>&nbsp;
            </td>
            <td align="center" valign="top" width="25%">
                '.($sect3['oqqit_rate_14'] > 0? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
                <br>
                '.($sect3['oqqit_rate_14'] > 0? '€'.$sect3['oqqit_rate_14']:'').'
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Two – Contents / Μέρος Δύο- Περιεχόμενο</b><br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sum Insured / Ασφαλισμένο Ποσό<br>&nbsp;
            </td>
            <td align="center" valign="top">
                '.($sect4['oqqit_rate_1'] > 0? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
                <br>
                '.($sect4['oqqit_rate_1'] > 0? '€'.$sect4['oqqit_rate_1']:'').'
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Three – Accidents to Domestic Staff / Μέρος Τρία - Ατυχήματα σε Οικιακό Προσωπικό</b><br>&nbsp;
            </td>
            <td align="center" valign="top">
                '.($sect5['oqqit_rate_1'] == 'Yes'? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Four – Legal Liability to the Public <br> Μέρος Τέσσερα – Νομική Ευθύνη έναντι του Κοινού</br><br>
            </td>
            <td align="center" valign="top">
                '.($sect3['oqqit_rate_14'] > 0 || $sect4['oqqit_rate_1'] > 0? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                This is only included if You have insurance under Section One and/or Section Two<br>
                Αυτό περιλαμβάνεται μόνο αν Εσείς έχετε Ασφάλιση στο Μέρος Ένα ή/και στο Μέρος Δύο<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Five – Valuables and Personal Possessions <br> Μέρος Πέντε - Τιμαλφή και Προσωπικά Αντικείμενα</br><br>
            </td>
            <td align="center" valign="top">
                '.($sect4['oqqit_rate_3'] > 0 ? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
                Do not show the amount??????
            </td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td>
                All items over €3.000 in value which are covered under this insurance
                are listed separately / Όλα τα αντικείμενα αξίας άνω των €3.000 τα
                οποία καλύπτονται από την παρούσα ασφάλιση, καταγράφονται 
                ξεχωριστά<br>
                The following items are only covered in the private dwelling situated
                in the Premises as stated below / Τα ακόλουθα αντικείμενα 
                καλύπτονται μόνο στην ιδιωτική κατοικία που βρίσκεται στο Υποστατικό 
                και που αναφέρονται πιο κάτω<br>
                (a)	Gold, silver, gold- and silver-plated articles / Χρυσά, ασημένια,
                επιχρυσωμένα και επάργυρα αντικείμενα<br>					
                (b)	Pictures and paintings / Φωτογραφίες και πίνακες<br>				
                <br>
                The following items are covered within the Republic of Cyprus. 
                They are also covered elsewhere in the world for up to sixty (60) 
                days in total Τα ακόλουθα αντικείμενα καλύπτονται εντός της 
                Κυπριακής Δημοκρατίας. Επίσης, καλύπτονται και οπουδήποτε 
                αλλού στον κόσμο, μέχρι συνολικά εξήντα (60) ημέρες<br> 
                (c)	Jewellery / Κοσμήματα<br>
                (d)	Furs / Γούνες<br>
                (e)	Personal Possessions / Προσωπικά Αντικείμενα<br>

            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <img src="' . $db->admin_layout_url . '/images/kemter_logo2.jpg" width="200"><br><br>&nbsp;
            </td>
            <td align="right">
                <img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png" width="200">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Six – Domestic Freezer / Μέρος Έξι – Οικιακοί Καταψύκτες</b><br>&nbsp;
            </td>
            <td align="center" valign="top">
                '.($sect4['oqqit_rate_13'] == 'Yes' ? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Seven – Pedal Cycles / Μέρος Επτά – Ποδήλατα</b><br>
            </td>
            <td align="center" valign="top">
                '.($sect5['oqqit_rate_4'] == 'Yes' ? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                All items over €200 in value are listed separately / Όλα τα αντικείμενα αξίας άνω των €200 καταγράφονται ξεχωριστά ?????DO I SHOW THEM?????<br>
                Sum Insured / Ασφαλισμένο Ποσό<br>&nbsp;
            </td>
            <td align="center">
                '.($sect5['oqqit_rate_4'] == 'Yes' ?('€'.($sect5['oqqit_rate_5'] + explode('##',$sect5['oqqit_rate_6'])[1] + explode('##',$sect5['oqqit_rate_7'])[1]
                    + explode('##',$sect5['oqqit_rate_8'])[1])):'').'
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Section Eight – Money and Bank Cards / Μέρος Οκτώ – Χρήματα και Τραπεζικές Κάρτες</b><br>
            </td>
            <td align="center">
                '.($sect4['oqqit_rate_14'] == 'Yes' ? 'Included / Περιλαμβάνεται':'Not Included / Δεν Περιλαμβάνεται').'<br>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                The following items are covered within the Republic of Cyprus. 
                They are also covered elsewhere in the world for up to sixty (60) 
                days in total. / Τα ακόλουθα αντικείμενα καλύπτονται εντός της 
                Κυπριακής Δημοκρατίας. Επίσης, καλύπτονται και οπουδήποτε 
                αλλού στον κόσμο, μέχρι συνολικά εξήντα (60) ημέρες<br>
                (a)	Money / Χρήματα<br>							
                (b)	Bank Cards / Τραπεζικές Κάρτες<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Endorsements / Πρόσθετες Πράξεις</b><br>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Endorsements that apply to this insurance / Οι Πρόσθετες Πράξεις που 
                ισχύουν για αυτό το ασφαλιστήριο συμβόλαιο.<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Premium / Ασφάλιστρα</b>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Premium / Ασφάλιστρα: €'.$db->fix_int_to_double($quotationData['oqq_premium']).'<br>
                <br>
                Fees / Δικαιώματα: €'.$db->fix_int_to_double($quotationData['oqq_fees']).'<br>
                <br>							
                Stamps / Χαρτόσημα: €'.$db->fix_int_to_double($quotationData['oqq_stamps']).'<br>
                <br>						
                Total Payable Amount / Ολικό Πληρωτέο Ποσό: €'.$db->fix_int_to_double($quotationData['oqq_premium']+$quotationData['oqq_fees']+$quotationData['oqq_stamps']).'<br>
                <br>			
                Cancellation administration fee (see page 5 of the insurance document) / 
                Έξοδα διαχείρισης ακυρώσεων (βλέπε σελίδα 5 του ασφαλιστικού εγγράφου)	€50,00<br>&nbsp;

            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Issuing Agent Contact Details / Στοιχεία Επικοινωνίας Πράκτορα</b>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd<br>
                Akinita Ieras Mitropolis<br>
                Block B’, Office 112<br>
                3040 Limassol<br>
                Cyprus<br>
                Tel.: +357 25 755 952<br>
                Fax.: +357 25 755 953<br>
                E-mail:	kemter@kemterinsurance.com<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Notification of Claims and Circumstances to / Κοινοποίηση Απαιτήσεων και Γεγονότων στους:</b>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd<br>
                Akinita Ieras Mitropolis, Block B’, Office 112<br>
                3040 Limassol, Cyprus<br>
                Tel.: +357 25 755 952<br>
                Fax.: +357 25 755 953<br>
                E-mail:	kemter@kemterinsurance.com<br>
                24 hours claims line: +357 99 725 575<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Signed By / Υπογράφηκε από: </b><br><br>
            </td>
            <td valign="top">
                <b>Issued By / Εκδόθηκε από:</b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <img src="' . $main["site_url"] . '/dynamic_quotations/images/santamas_signature_200.png" width="200">
                <br><br>
                Γιάννος Σανταμάς<br>
                Director / Διευθυντής<br>
                Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd<br>
                Authorised Coverholder at Lloyd’s<br>&nbsp;
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                Issue Date / Ημερομηνία Έκδοσης: 
            </td>
            <td></td>
        </tr>
        
        
        
        <tr>
            <td colspan="2">
                <img src="' . $db->admin_layout_url . '/images/kemter_logo2.jpg" width="200"><br><br>&nbsp;
            </td>
            <td align="right">
                <img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png" width="200">
            </td>
        </tr>
    </table>
    
    
    <table width="900" class="mainFonts">
        <tr>
            <td align="center">
                <b>ΣΥΝΤΟΜΗ ΜΟΡΦΗ ΠΛΗΡΟΦΟΡΙΚΗΣ ΕΙΔΟΠΟΙΗΣΗΣ ΓΙΑ ΤΗΝ ΠΡΟΣΤΑΣΙΑ ΠΡΟΣΩΠΙΚΩΝ ΔΕΔΟΜΕΝΩΝ</b>
                <br><br><br>
            </td>
        </tr>
        <tr>
            <td align="justify">
                <b>Ειδοποίηση για τις προσωπικές σας πληροφορίες</b><br><br>
                <b>Ποιοι είμαστε</b><br>
                Εμείς είμαστε οι ασφαλιστές που προσδιορίζονται στο ασφαλιστήριο και/ή στο πιστοποιητικό ασφάλισης.<br>
                <br>
                <b>Τα βασικά</b><br>
                Συλλέγουμε και χρησιμοποιούμε σχετικές πληροφορίες αναφορικά με εσάς για να σας παρέχουμε την ασφαλιστική 
                κάλυψη ή ασφαλιστική κάλυψη προς όφελος σας και που συνάδει με τις νομικές μας υποχρεώσεις.<br>
                <br>
                Αυτές οι πληροφορίες περιλαμβάνουν στοιχεία  όπως το όνομα σας, διεύθυνση και στοιχεία επικοινωνίας και 
                οποιεσδήποτε άλλες πληροφορίες συλλέγουμε σχετικά με εσάς σε σχέση με την ασφαλιστική κάλυψη από την οποία έχετε όφελος.<br>
                <br>
                Αυτές οι πληροφορίες μπορεί να περιλαμβάνουν πιο ευαίσθητα δεδομένα όπως πληροφορίες σχετικά με την υγεία 
                σας και οποιεσδήποτε ποινικές καταδίκες τις οποίες μπορεί να έχετε.<br>
                <br>
                Σε ορισμένες περιπτώσεις, μπορεί να χρειαστούμε την συγκατάθεση σας για να επεξεργαστούμε ορισμένες 
                κατηγορίες πληροφοριών σχετικά με εσάς (περιλαμβανομένου ευαίσθητων δεδομένων όπως πληροφορίες σχετικά 
                με την υγεία σας και οποιεσδήποτε ποινικές καταδίκες μπορεί να έχετε). Όπου χρειάζεται η συγκατάθεση σας, 
                θα σας ζητηθεί ξεχωριστά. Δεν είστε υποχρεωμένοι να δώσετε την συγκατάθεση σας και μπορείτε να αποσύρετε 
                την συγκατάθεση σας οποιαδήποτε στιγμή. Ωστόσο, εάν δεν δώσετε τη συγκατάθεση σας, ή αποσύρετε την συγκατάθεση 
                σας, αυτό μπορεί να επηρεάσει την δυνατότητα μας να παρέχουμε την ασφαλιστική κάλυψη από την οποία έχετε 
                όφελος και μπορεί να μας εμποδίσει από το να σας παρέχουμε κάλυψη ή να διαχειριστούμε απαιτήσεις σας.<br>
                <br>
                Ο τρόπος με τον οποίο δουλεύει η ασφάλεια σημαίνει ότι οι πληροφορίες σας μπορεί να μοιραστούν με, να 
                χρησιμοποιηθούν από, ένα αριθμό τρίτων ατόμων μέσα στον ασφαλιστικό τομέα για παράδειγμα, ασφαλιστές, 
                αντιπροσώπους ή μεσάζοντες, αντασφαλιστές, διαχειριστές απώλειας, υπεργολάβους, ρυθμιστικές αρχές, υπηρεσίες 
                επιβολής νόμου, υπηρεσίες περιορισμού και πρόληψης απάτης και εγκλήματος και υποχρεωτικές ασφαλιστικές βάσεις 
                δεδομένων. Θα αποκαλύψουμε μόνο τις προσωπικές πληροφορίες σε σχέση με την ασφαλιστική κάλυψη την οποία 
                παρέχουμε και στον βαθμό που απαιτείται ή επιτρέπεται από τον νόμο.<br>
                <br>
                <b>Στοιχεία άλλων ατόμων τα οποία παρέχετε σε εμάς</b><br>
                Όπου μας παρέχετε ή στον αντιπρόσωπο σας ή μεσάζων στοιχεία σχετικά με άλλα άτομα, θα πρέπει να παρέχετε 
                αυτή την ειδοποίηση σε αυτούς.<br>
                <br>
                <b>Χρειάζεστε περισσότερες λεπτομέρειες; </b>
                Για περισσότερες πληροφορίες σχετικά με το πώς χρησιμοποιούμε τις προσωπικές σας πληροφορίες σας παρακαλούμε 
                να δείτε την πλήρης ειδοποίηση απορρήτου η οποία είναι διαθέσιμη στην ιστοσελίδα μας ή σε άλλες μορφές κατόπιν ζήτησης.<br>
                <br>
                <b>Επικοινωνία μαζί μας και τα δικαιώματα σας</b><br>
                Έχετε δικαιώματα σε σχέση με τις πληροφορίες που κατέχουμε που αφορούν εσάς, περιλαμβανομένου και του 
                δικαιώματος για πρόσβαση στις πληροφορίες σας. Εάν επιθυμείτε να ασκήσετε τα δικαιώματα σας, να συζητήσετε 
                για το πώς χρησιμοποιούμε τις πληροφορίες σας ή να ζητήσετε αντίγραφο της πλήρης ειδοποίησης απορρήτου, 
                παρακαλώ επικοινωνήστε μαζί μας ή με τον αντιπρόσωπο ή μεσάζοντα με τον οποίο διευθετήσατε την ασφάλεια ο 
                οποίος θα σας παρέχει με τα στοιχεία επικοινωνίας μας στην πιο κάτω διεύθυνση:
            </td>
        </tr>
        <tr>
            <td height="450" valign="top">
                <br><br>
                <b>Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd</b><br>
                Αθηνών 82, <br>
                Ακίνητα Ι. Μητρόπολης <br>
                Μπλοκ Β, Γρ. 112-113, <br>
                3040 Λεμεσός, Κύπρος<br>
                Τηλ.:					+357 25 755 952<br>
                Φαξ.:					+357 25 755 953<br>
                E-mail:					kemter@kemterinsurance.com<br>
                <br>
                <b>Ασφαλιστές</b><br>
                Πρόσβαση στην ειδοποίηση απορρήτου: 	http://xlgoup.com/footer/privacy-and-cookies<br>
                Ηλεκτρονική διεύθυνση XL Catlin: 		compliance@xlcatlin.com<br>
                <br>
                <br>
                LMA9151 (amended)<br>
                25 April 2018
            </td>
        </tr>
        
    </table>
    
    <table width="900" class="mainFonts">
        <tr>
            <td>
                <img src="' . $db->admin_layout_url . '/images/kemter_logo2.jpg" width="200"><br><br>&nbsp;
            </td>
            <td align="right">
                <img src="' . $db->admin_layout_url . '/images/LLOYDS-Logo.png" width="200">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <b>DATA PROTECTION SHORT FORM INFORMATION NOTICE</b><br><br><br>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="justify">
                <b>Your personal information notice</b><br>
                <br>
                <b>Who we are</b> <br>
                We are the underwriter(s) identified in the contract of insurance and/or in the certificate of insurance. <br>
                <br>
                <b>The basics</b><br>
                We collect and use relevant information about you to provide you with your insurance cover or the 
                insurance cover that benefits you and to meet our legal obligations. <br>
                <br>
                This information includes details such as your name, address and contact details and any other 
                information that we collect about you in connection with the insurance cover from which you benefit. <br>
                <br>
                This information may include more sensitive details such as information about your health and any 
                criminal convictions you may have. <br>
                <br>
                In certain circumstances, we may need your consent to process certain categories of information about you 
                (including sensitive details such as information about your health and any criminal convictions you may have). 
                Where we need your consent, we will ask you for it separately. You do not have to give your consent and you 
                may withdraw your consent at any time. However, if you do not give your consent, or you withdraw your consent, 
                this may affect our ability to provide the insurance cover from which you benefit and may prevent us from 
                providing cover for you or handling your claims. <br>
                <br>
                The way insurance works means that your information may be shared with, and used by, a number of third 
                parties in the insurance sector for example, insurers, agents or brokers, reinsurers, loss adjusters, 
                sub-contractors, regulators, law enforcement agencies, fraud and crime prevention and detection agencies 
                and compulsory insurance databases. We will only disclose your personal information in connection with 
                the insurance cover that we provide and to the extent required or permitted by law. <br>
                <br>
                <b>Other people\'s details you provide to us</b> 
                Where you provide us or your agent or broker with details about other people, you must provide this 
                notice to them. <br>
                <br>
                <b>Want more details?</b> 
                For more information about how we use your personal information please see our full privacy notice(s), 
                which is/are available online on our website(s) or in other formats on request. <br>
                <br>
                <b>Contacting us and your rights</b> <br>
                You have rights in relation to the information we hold about you, including the right to access your 
                information. If you wish to exercise your rights, discuss how we use your information or request a copy 
                of our full privacy notice(s), please contact us, or the agent or broker that arranged your insurance who 
                will provide you with our contact details at: <br>
                <br>
                <b>Kemter Insurance Agencies, Sub-Agencies and Consultants Ltd</b><br>
                Akinita Ieras Mitropolis, <br>
                Block B’, Office 112, <br>
                3040 Limassol, Cyprus<br>
                Tel.:				+357 25 755 952<br>
                Fax.:				+357 25 755 953<br>
                E-mail:				kemter@kemterinsurance.com<br>
                <br>
                <b>Underwriters</b> <br>
                Privacy notice accessible at:		http://xlgroup.com/footer/privacy-and-cookies<br>
                XL Catlin Privacy email address:	compliance@xlcatlin.com<br>
                <br>
                LMA9151 (amended) <br>
                25 April 2018

            </td>
        </tr>
    </table>
    
    
</div>
';
    return $html;
}