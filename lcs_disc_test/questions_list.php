<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/2/2019
 * Time: 4:24 ΜΜ
 */

$list[1]['A'] = 'Ανοικτός / Αποκαλυπτικός';
$list[1]['B'] = 'Κλειστός / Επιφυλακτικός';

$list[2]['A'] = 'Δείχνω τα αισθήματα μου ελεύθερα';
$list[2]['B'] = 'Δείχνω τα αισθήματα μου μόνο όταν χρειάζεται';

$list[3]['A'] = 'Άμεση ανάληψη ρίσκου';
$list[3]['B'] = 'Προσεκτική ανάληψη ρίσκου';

$list[4]['A'] = 'Προσανατολισμός στο αποτέλεσμα';
$list[4]['B'] = 'Προσανατολισμός στις διαδικασίες';

$list[5]['A'] = 'Δυνατός';
$list[5]['B'] = 'Συγκρατημένος';

$list[6]['A'] = 'Παίρνω αποφάσεις με βάση συναισθήματα';
$list[6]['B'] = 'Παίρνω αποφάσεις με βάση στοιχεία';

$list[7]['A'] = 'Άνετος / Ήρεμος';
$list[7]['B'] = 'Τυπικός';

$list[8]['A'] = 'Εκτιμώ ανθρώπους, σχέσεις, αισθήματα';
$list[8]['B'] = 'Εκτιμώ γεγονότα, στοιχεία, αποτελέσματα';

$list[9]['A'] = 'Ξεφεύγω από το θέμα όταν μιλάω';
$list[9]['B'] = 'Μένω στο θέμα όταν μιλάω';

$list[10]['A'] = 'Τονίζω τα κύρια σημεία με τη φωνή και τη γλώσσα του σώματος';
$list[10]['B'] = 'Τονίζω τα κύρια σημεία εξηγώντας το περιεχόμενο του μηνύματος';

$list[11]['A'] = 'Οι ερωτήσεις είναι ρητορικές, δίνουν έμφαση σ’ ένα σημείο ή αμφισβητούν πληροφορίες';
$list[11]['B'] = 'Οι ερωτήσεις είναι διευκρινιστικές,υποστηρικτικές ή συγκέντρωσης πληροφοριών';

$list[12]['A'] = 'Ευέλικτος όσον αφορά το χρόνο';
$list[12]['B'] = 'Αυστηρός όσον αφορά το χρόνο';

$list[13]['A'] = 'Προτιμώ να δουλεύω ομαδικά';
$list[13]['B'] = 'Προτιμώ να δουλεύω μόνος μου';

$list[14]['A'] = 'Εκφράζω ελεύθερα την γνώμη μου';
$list[14]['B'] = 'Κρατώ την γνώμη μου για τον εαυτό μου';

$list[15]['A'] = 'Ενεργώ αυθόρμητα';
$list[15]['B'] = 'Ενεργώ προσεκτικά';

$list[16]['A'] = 'Συνήθως συμμετέχω στις ομαδικές συναντήσεις';
$list[16]['B'] = 'Συνήθως ακούω στις ομαδικές συναντήσεις';

$list[17]['A'] = 'Οι συζητήσεις είναι προσανατολισμένες σε προσωπικές σχέσεις';
$list[17]['B'] = 'Οι συζητήσεις είναι προσανατολισμένες σε γεγονότα και αποτελέσματα';

$list[18]['A'] = 'Ενεργητικός / Δραστήριος';
$list[18]['B'] = 'Γαλήνιος / Ήσυχος';

$list[19]['A'] = 'Φιλική χειραψία';
$list[19]['B'] = 'Τυπική χειραψία';

$list[20]['A'] = 'Ανυπόμονος';
$list[20]['B'] = 'Υπομονετικός';

$list[21]['A'] = 'Σφοδρός / Γρήγορος';
$list[21]['B'] = 'Γαλήνιος / Ήσυχος';

$list[22]['A'] = 'Άμεσος / Συγκρουσιακός';
$list[22]['B'] = 'Διπλωμάτης / Συνεργάσιμος';

$list[23]['A'] = 'Εύκολο να καταλάβουν τι σκέφτομαι';
$list[23]['B'] = 'Δύσκολο να καταλάβουν τι σκέφτομαι';

$list[24]['A'] = 'Ανταγωνιστικός';
$list[24]['B'] = 'Υποστηρικτικός';

$list[25]['A'] = 'Κάνω ζωηρές χειρονομίες όταν μιλώ';
$list[25]['B'] = 'Με ελεγχόμενες χειρονομίες όταν μιλώ';

$list[26]['A'] = 'Συχνή και σταθερή οπτική επαφή';
$list[26]['B'] = 'Περιοδική και Διακοπτόμενη οπτική επαφή';

$list[27]['A'] = 'Συστήνω πρώτος τον εαυτό μου σε κοινωνικές συγκεντρώσεις';
$list[27]['B'] = 'Περιμένω από τους άλλους να συστηθούν πρώτα σε κοινωνικές εκδηλώσεις';

$list[28]['A'] = 'Έχω την τάση να ανατρέπω υπάρχουσες πολιτικές και κανόνες';
$list[28]['B'] = 'Έχω την τάση να ακολουθώ υπάρχουσες πολιτικές και κανόνες';

function getDiSCResults($testData)
{

    $highDominance = 0;
    $lowDominance = 0;
    $highSocial = 0;
    $lowSocial = 0;

    //high dominance
    if ($testData['ietst_question_3'] == 'A') $highDominance++;
    if ($testData['ietst_question_4'] == 'A') $highDominance++;
    if ($testData['ietst_question_5'] == 'A') $highDominance++;
    if ($testData['ietst_question_10'] == 'A') $highDominance++;
    if ($testData['ietst_question_11'] == 'A') $highDominance++;
    if ($testData['ietst_question_14'] == 'A') $highDominance++;
    if ($testData['ietst_question_16'] == 'A') $highDominance++;
    if ($testData['ietst_question_20'] == 'A') $highDominance++;
    if ($testData['ietst_question_21'] == 'A') $highDominance++;
    if ($testData['ietst_question_22'] == 'A') $highDominance++;
    if ($testData['ietst_question_24'] == 'A') $highDominance++;
    if ($testData['ietst_question_26'] == 'A') $highDominance++;
    if ($testData['ietst_question_27'] == 'A') $highDominance++;
    if ($testData['ietst_question_28'] == 'A') $highDominance++;

    //low dominance
    if ($testData['ietst_question_3'] == 'B') $lowDominance++;
    if ($testData['ietst_question_4'] == 'B') $lowDominance++;
    if ($testData['ietst_question_5'] == 'B') $lowDominance++;
    if ($testData['ietst_question_10'] == 'B') $lowDominance++;
    if ($testData['ietst_question_11'] == 'B') $lowDominance++;
    if ($testData['ietst_question_14'] == 'B') $lowDominance++;
    if ($testData['ietst_question_16'] == 'B') $lowDominance++;
    if ($testData['ietst_question_20'] == 'B') $lowDominance++;
    if ($testData['ietst_question_21'] == 'B') $lowDominance++;
    if ($testData['ietst_question_22'] == 'B') $lowDominance++;
    if ($testData['ietst_question_24'] == 'B') $lowDominance++;
    if ($testData['ietst_question_26'] == 'B') $lowDominance++;
    if ($testData['ietst_question_27'] == 'B') $lowDominance++;
    if ($testData['ietst_question_28'] == 'B') $lowDominance++;

    //high sociability
    if ($testData['ietst_question_1'] == 'A') $highSocial++;
    if ($testData['ietst_question_2'] == 'A') $highSocial++;
    if ($testData['ietst_question_6'] == 'A') $highSocial++;
    if ($testData['ietst_question_7'] == 'A') $highSocial++;
    if ($testData['ietst_question_8'] == 'A') $highSocial++;
    if ($testData['ietst_question_9'] == 'A') $highSocial++;
    if ($testData['ietst_question_12'] == 'A') $highSocial++;
    if ($testData['ietst_question_13'] == 'A') $highSocial++;
    if ($testData['ietst_question_15'] == 'A') $highSocial++;
    if ($testData['ietst_question_17'] == 'A') $highSocial++;
    if ($testData['ietst_question_18'] == 'A') $highSocial++;
    if ($testData['ietst_question_19'] == 'A') $highSocial++;
    if ($testData['ietst_question_23'] == 'A') $highSocial++;
    if ($testData['ietst_question_25'] == 'A') $highSocial++;

    //low sociability
    if ($testData['ietst_question_1'] == 'B') $lowSocial++;
    if ($testData['ietst_question_2'] == 'B') $lowSocial++;
    if ($testData['ietst_question_6'] == 'B') $lowSocial++;
    if ($testData['ietst_question_7'] == 'B') $lowSocial++;
    if ($testData['ietst_question_8'] == 'B') $lowSocial++;
    if ($testData['ietst_question_9'] == 'B') $lowSocial++;
    if ($testData['ietst_question_12'] == 'B') $lowSocial++;
    if ($testData['ietst_question_13'] == 'B') $lowSocial++;
    if ($testData['ietst_question_15'] == 'B') $lowSocial++;
    if ($testData['ietst_question_17'] == 'B') $lowSocial++;
    if ($testData['ietst_question_18'] == 'B') $lowSocial++;
    if ($testData['ietst_question_19'] == 'B') $lowSocial++;
    if ($testData['ietst_question_23'] == 'B') $lowSocial++;
    if ($testData['ietst_question_25'] == 'B') $lowSocial++;

    $result['HighDominance'] = $highDominance;
    $result['LowDominance'] = $lowDominance;
    $result['HighSocial'] = $highSocial;
    $result['LowSocial'] = $lowSocial;

    $result['HighDominance-per'] = round( ($highDominance / 14)*100 ,2);
    $result['LowDominance-per'] = round( ($lowDominance / 14)*100 ,2);
    $result['HighSocial-per'] = round( ($highSocial / 14)*100 ,2);
    $result['LowSocial-per'] = round( ($lowSocial / 14)*100 ,2);

    return $result;
}