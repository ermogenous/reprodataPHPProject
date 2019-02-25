<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 8:35 ΜΜ
 */

function getEmailLayoutFillTest($data)
{
    global $db, $main;

    $id = $db->encrypt($data['lcsdc_disc_test_ID']);

    $html = '
Please fill the form in the below link.<br>
<a href="' . $main["site_url"] . '/lcs_disc_test/disc_modify.php?lid=' . $id . '">Click Here</a><br>
If the link does not work then copy paste the below link in to your browser<br>
' . $main["site_url"] . '/lcs_disc_test/disc_modify.php?lid=' . $id . '
    ';


    return $html;
}
//$images = embeded Or Link
function getEmailLayoutResult($testID,$images = 'embeded')
{
    include_once('disc_class.php');
    global $main;

    $disc = new DiscTest($testID);


    if ($images == 'embeded'){
        $imagesSrcPie = 'cid:testpie';
        $imageSrcDisc = 'cid:discmodel';
        $imageSrcCircle = 'cid:circlemodel';
    }
    else {
        $pic = $disc->getPieImageData('data');
        $imagesSrcPie = 'data:image/jpeg;base64,'.base64_encode( $pic );
        $imageSrcDisc = $main["site_url"]."/layout/lcs_eq/images/disc_model.jpg";
        $imageSrcCircle = $main["site_url"]."/layout/lcs_eq/images/circle_model.jpg";
    }

    $html = '
Στο διάγραμμα που ακολουθεί βλέπετε την κατανομή των αποτελεσμάτων σας σε ποσοστά.
<br><br>
Το μεγαλύτερο ποσοστό είναι το κυρίαρχο χαρακτηριστικό σας. Το δεύτερο μεγαλύτερο είναι το επόμενο λιγότερο κυρίαρχο χαρακτηριστικό κοκ.
<br><br>
<img src="'.$imagesSrcPie.'"/>
<br><br>
Για να σας βοηθήσουμε να κατανοήσουμε το μοντέλο προσωπικότητας DISC, σας παραθέτουμε πιο κάτω τις απαραίτητες επεξηγήσεις
<br><br>
<img src="'.$imageSrcDisc.'">
<br><br>
<img src="'.$imageSrcCircle.'">
<p style="background-color: #fdbf01; width: 800px; height: 25px; vertical-align: middle;">
    <b>&nbsp; 1. Κυρίαρχος | Dominant</b>
</p>
<p>
    <b>Προτεραιότητες:</b> επίλυση προβλημάτων, ενεργοποίηση, αποδοχή προκλήσεων, γρήγορη λήψη αποφάσεων,
    εκπλήρωση<br><br>
    <b>Κινητοποιείτε από:</b> ευκαιρίες για προαγωγή, ευθύνη, δύσκολες εργασίες, ελευθέρια – ανεξαρτησία <br><br>
    <b>Αποστροφή:</b> αποτυχία, χάσιμο εξουσίας, ρουτίνα, αδυναμία<br><br>
    <b>Θα διαπιστώσετε ότι:</b> υπερ-αυτοπεποίθηση, αποφασιστικότητα, εστιασμένος στο αποτέλεσμα, αυστηρός, ευθείς,
    φιλόδοξος, παίρνει ρίσκα.<br><br>
    <b>Μειονεκτήματα:</b> Δεν είναι προσανατολισμένος στην Ομάδα, υπερβολικά απαιτητικός, παίρνει αποφάσεις μόνος του,
    ανυπόμονος, ισχυρά εστιασμένος στις εργασίες, υπερβολική πίεση αναστατώνει τους άλλους.<br><br>
    <b>Αξία στον οργανισμό:</b> ψάχνει συνεχώς για νέες καινοτόμες ιδέες, και νέες μεθόδους επίλυσης προβλημάτων
</p>

<p style="background-color: #ec7d31; width: 800px; height: 25px; vertical-align: middle;">
    <b>&nbsp; 2. Εμπνεύστικος | Influential</b>
</p>
<p>
    <b>Προτεραιότητες:</b> δημιουργία ενός θετικού(motivating) περιβάλλοντος, δημιουργία ενθουσιασμού, δημιουργία εμπιστοσύνης<br><br>
    <b>Κινητοποιείτε από:</b> την συμμετοχή του στην ομάδα, ελευθερία από ελέγχους και πολλές λεπτομέρειες, φιλικές σχέσεις<br><br>
    <b>Αποστροφή:</b> στατικό περιβάλλον, την αγνόηση, να χάνει την επιρροή του<br><br>
    <b>Θα διαπιστώσετε ότι:</b> έχει επιρροή, αξιοπρεπείς, αυτοπεποίθηση, αισιόδοξος, κοινωνικός, ομιλητικός<br><br>
    <b>Μειονεκτήματα:</b> απρόσεκτος με τις λεπτομέρειες, διαχείριση χρόνου, ιδεολόγος, αυθόρμητος, έλεγχος<br><br>
    <b>Αξία στον οργανισμό:</b> Κινητοποιεί τους Ανθρώπους, εισάγει νέες ιδέες, προάγει τους Ανθρώπους και τα έργα, διαχειρίζεται αποτελεσματικά συγκρούσεις
</p>

<p style="background-color: #ec7d31; width: 800px; height: 25px; vertical-align: middle;">
    <b>&nbsp; 3. Ευσυνείδητος | Conscientious</b>
</p>
<p>
    <b>Προτεραιότητες:</b> επιμέλεια, λογική, γεγονότα και δεδομένα, ακρίβεια, αξιοπιστία, ανάλυση, σταθερότητα<br><br>
    <b>Κινητοποιείτε από:</b> να γίνονται τα πράγματα σωστά, ευκαιρίες για να χρησιμοποίηση την εμπειρογνωμοσύνη του ή να πάρει γνώση, ποιότητα<br><br>
    <b>Αποστροφή:</b> ανακρίβειες, μη προβλέψιμες καταστάσεις, την κριτική, να κάνει λάθη, να δουλεύει σε ομάδα.<br><br>
    <b>Θα διαπιστώσετε ότι:</b> είναι ευσυνείδητος, διπλωματικός, ακριβείς, σκεπτικιστής, συστηματική σταθερή προσέγγιση των πραγμάτων<br><br>
    <b>Μειονεκτήματα:</b> τελειομανείς, απομονώνεται, σχολαστικός, αμυντικός, υπερβολική ανάλυση, δεν παίρνει ρίσκα<br><br>
    <b>Αξία στον οργανισμό:</b> είναι περιεκτικός, νοήμον, ελέγχει συστηματικά, καθορίζει και ξεκαθαρίζει, διατηρεί πρότυπα ελέγχου ποιότητας, είναι ρεαλιστής
</p>

<p style="background-color: #a4a4a4; width: 800px; height: 25px; vertical-align: middle;">
    <b>&nbsp; 3. Σταθερός | Steady</b>
</p>
<p>
    <b>Προτεραιότητες:</b> συνεπείς, συνεργάσιμος, σταθερός, δημιουργεί ξεκάθαρες διαδικασίες, ομαδικός<br><br>
    <b>Κινητοποιείτε από:</b> σταθερό περιβάλλον, συμβατικές πρακτικές, επιζητά ευκαιρίες για να βοηθήσει άλλους <br><br>
    <b>Αποστροφή:</b> την αλλαγή, ρίσκο, ασάφεια, να προσβάλει άλλους, να χάνεται η σταθερότητα<br><br>
    <b>Θα διαπιστώσετε ότι:</b> επιμονή, αυτοέλεγχος, προβλέψιμος, προσεκτικές αποφάσεις, ήρεμη προσέγγιση, ενεργός ακροατής<br><br>
    <b>Μειονεκτήματα:</b> πεισματάρης, αποφεύγει την ανάληψη αποφάσεων, τείνει να αποφεύγει τις αλλαγές <br><br>
    <b>Αξία στον οργανισμό:</b> παραμένει σταθερός και προβλέψιμος, έχει τεχνικές ικανότητες και είναι κάλος στην διαχείριση συγκρούσεων, πετυχαίνει τους στόχους του με την ομάδα του
</p>

<p>
    Πολύ βασικό είναι οι βασικοί συνδυασμοί.<br>
    Τα 2 μεγαλύτερα ποσοστά αποτελούν τον βασικό συνδυασμό σας.
</p>
<p style="background-color: #404040; width: 800px; height: 25px; vertical-align: middle; color: white;">
    <b>&nbsp; 8 βασική συνδυασμοί </b>
</p>

<p>
    <b><u>1. DC: ΠΡΟΚΛΗΣΗ, ΑΠΟΤΕΛΕΣΜΑΤΑ, ΑΚΡΙΒΕΙΑ</u></b>
</p>
<p>
    <b>Στόχοι:</b> ανεξαρτησία, προσωπική επιτυχία<br>
    <b>Φόβοι:</b> αποτυχία να φτάσουν τους στόχους τους<br>
    <b>Ηγετικές Ικανότητες:</b> Έχουν αυτοπεποίθηση, αναλαμβάνουν τις ευθύνες τους, συγκεντρώνονται στο αποτέλεσμα
</p>

<p>
    <b><u>2. DI: ΕΝΕΡΓΕΙΕΣ, ΑΠΟΤΕΛΕΣΜΑΤΑ, ΕΝΘΟΥΣΙΑΣΜΟΣ</u></b>
</p>
<p>
    <b>Στόχοι:</b> γρήγορες κινήσεις, νέες ευκαιρίες<br>
    <b>Φόβοι:</b> απώλεια εξουσίας<br>
    <b>Ηγετικές Ικανότητες:</b> επεκτείνει τα όρια, βρίσκει ευκαιρίες
</p>

<p>
    <b><u>3. ΙD: ΕΝΕΡΓΕΙΕΣ, ΕΝΘΟΥΣΙΑΣΜΟΣ, ΑΠΟΤΕΛΕΣΜΑΤΑ</u></b>
</p>
<p>
    <b>Στόχοι:</b> συναρπαστική πρόοδος – ανάπτυξη<br>
    <b>Φόβοι:</b> σταθερό περιβάλλον, ελλείψει προσοχής, απώλεια εξουσίας<br>
    <b>Ηγετικές Ικανότητες:</b> ανακαλύψει ευκαιριών, προώθηση τολμηρών ενεργειών
</p>

<p>
    <b><u>4. IS: ΣΥΝΕΡΓΑΣΙΑ, ΕΝΘΟΥΣΙΑΣΜΟΣ, ΥΠΟΣΤΗΡΙΞΗ</u></b>
</p>
<p>
    <b>Στόχοι:</b> σχέσεις<br>
    <b>Φόβοι:</b> να μην είναι αρεστός, να πιέζει τους άλλους<br>
    <b>Ηγετικές Ικανότητες:</b> προσιτός, αναγνωρίζει την προσφορά των άλλων
</p>

<p>
    <b><u>5. SI: ΣΥΝΕΡΓΑΣΙΑ, ΥΠΟΣΤΗΡΙΞΗ, ΕΝΘΟΥΣΙΑΣΜΟΣ</u></b>
</p>
<p>
    <b>Στόχοι:</b> αποδοχή, σχέσεις<br>
    <b>Φόβοι:</b> να μην είναι αρεστός, να πιέζει τους άλλους<br>
    <b>Ηγετικές Ικανότητες:</b> είναι αποδεκτός, κτίζει καλές σχέσεις
</p>

<p>
    <b><u>6. SC: ΣΤΑΘΕΡΟΤΗΤΑ, ΥΠΟΣΤΗΡΙΞΗ, ΑΚΡΙΒΕΙΑ</u></b>
</p>
<p>
    <b>Στόχοι:</b> ήρεμο περιβάλλον, σταθεροί στόχοι, σταθερή πρόοδος<br>
    <b>Φόβοι:</b> πίεση χρόνου, αβεβαιότητα, χάος<br>
    <b>Ηγετικές Ικανότητες:</b> διατήρηση ψυχραιμίας, δίκαιος
</p>

<p>
    <b><u>7. CS: ΣΤΑΘΕΡΟΤΗΤΑ, ΑΚΡΙΒΕΙΑ, ΥΠΟΣΤΗΡΙΞΗ</u></b>
</p>
<p>
    <b>Στόχοι:</b> σταθερότητα, αξιόπιστα αποτελέσματα<br>
    <b>Φόβοι:</b> συναισθηματικές φορτισμένες καταστάσεις, ασάφεια<br>
    <b>Ηγετικές Ικανότητες:</b> ξεκάθαρη επικοινωνία, προάγει πειθαρχημένη ανάλυση
</p>

<p>
    <b><u>8. CD: ΠΡΟΚΛΗΣΗ, ΑΚΡΙΒΕΙΑ, ΑΠΟΤΕΛΕΣΜΑΤΑ</u></b>
</p>
<p>
    <b>Στόχοι:</b> αποδοτικά αποτελέσματα, λογικές αποφάσεις<br>
    <b>Φόβοι:</b> αποτυχία, χάσιμο ελέγχου<br>
    <b>Ηγετικές Ικανότητες:</b> δημιουργεί ψηλές προσδοκίες, βελτιώνει διαδικασίες και μεθόδους
</p>';

    return $html;
}

?>