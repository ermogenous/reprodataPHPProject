<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 12/10/2021
 * Time: 9:25 π.μ.
 */

include("../../include/main.php");

$db = new Main(1);

$dateTime = '29/11/2021 08:35 ΑΜ';

$db->show_empty_header();
?>

<style>
    .normalText {
        font-size: 16px;
        color: black;
        font-family: Arial;
    }

    .smallerText {
        font-size: 13px;
        color: black;
        font-family: Arial;
    }

    .smallerText2 {
        font-size: 10px;
        color: black;
        font-family: Arial;
    }
</style>
<div class="container normalText">
    <br><br><br>

    <div class="row">
        <div class="col-6 text-right">
            <img src="cyplg.jpg" width="110">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="col-6">
            <span class="normalText">ΚΥΠΡΙΑΚΗ ΔΗΜΟΚΡΑΤΙΑ</span><br>
            <span class="smallerText">ΥΠΟΥΡΓΕΙΟ ΥΓΕΙΑΣ</span><br>
            <span class="normalText">REPUBLIC OF CYPRUS</span> <br>
            <span class="smallerText">MINISTRY OF HEALTH</span>

        </div>
    </div>

    <br><br>
    <div class="row">
        &nbsp;&nbsp;&nbsp;&nbsp;ΑΠΟΤΕΛΕΣΜΑ ΕΡΓΑΣΤΗΡΙΑΚΗΣ ΔΙΕΡΕΥΝΗΣΗΣ SARS-CoV-2 (ΕΘΝΙΚΟ) <br>
        &nbsp;&nbsp;&nbsp;&nbsp;SARS-CoV-2 TEST RESULTS (NATIONAL)
    </div>

    <br>

    <div class="row">
        <div class="col-3 border-left border-top border-bottom border-dark">
            ΕΠΩΝΥΜΟ <br>
            SURNAME <br>
            <br>
            <b>ERMOGENOUS</b>
        </div>
        <div class="col-3 border-left border-top border-bottom border-dark">
            ΟΝΟΜΑ <br>
            ΝΑΜΕ <br>
            <br>
            <b>MICHALIS</b>
        </div>
        <div class="col-3 border-left border-top border-bottom border-dark">
            ΑΡ. ΤΑΥΤΟΤΗΤΑΣ /<br>
            ΕΓΓΡΑΦΟ <br>
            ΤΑΥΤΟΠΟΙΗΣΗΣ <br>
            <span class="smallerText">CARD ΝΟ. / IDENTIFICATION <br>
                DOCUMENT</span> <br>
            <br>
            <b>L00024636</b>
        </div>
        <div class="col-3 border border-dark">
            ΗΜΕΡΟΜΗΝΙΑ<br>
            ΓΕΝΝΗΣΗΣ<br>
            <span class="smallerText">DATE 0F BIRTH</span><br>
            <br>
            <b>24/05/1979</b>
        </div>
    </div>


    <br>

    <div class="row">
        <div class="col-6 border-left border-top border-bottom border-dark">
            <br>
            <br>
            ΕΡΓΑΣΤΗΡΙΑΚΗ ΜΕΘΟΔΟΣ <br>
            <span class="smallerText">TEST ΤΥΡΕ</span> <br> <br>
            <span class="smallerText"><b>Lateral Flow lmmunoassay (Rapid Antigen Test)</b></span> <br> <br>
            ΚΑΤΑΣΚΕΥΑΣΤΡΙΑ ΕΤΑΙΡΕΙΑ ΚΑΙ ΟΝΟΜΑ ΠΡΟΙΟΝΤΟΣ <br>
            <span class="smallerText">TEST MANUFACTURER AND TEST ΝΑΜΕ</span> <br> <br>

            <span class="smallerText"><b>Goldsite Diagnostics lnc Ι SARS-CoV-2 Antigen Kit (Colloidal Gold)</b></span> <br>
            <br>
            ΚΕΝΤΡΟ ΕΡΓΑΣΤΗΡΙΑΚΗΣ ΕΞΕΤΑΣΗΣ <br>
            <span class="smallerText">TEST CENTER</span> <br>
            <br>
            <span class="smallerText"><b>MARINA ΝΕΟΡΗΥΤΟU PHARMACEUTICAL LTD</b></span> <br>
            ΕΠΑΡΧΙΑ <br>
            DISTRICT <br>
            <br>
            ----
        </div>

        <div class="col-6 border border-dark">
            ΗΜΕΡΟΜΗΝΙΑ ΚΑΙ ΩΡΑ ΔΕΙΓΜΑΤΟΛΗΨΙΑΣ <br>
            <span class="smallerText">TEST COLLECTION DATE AND ΤΙΜΕ</span> <br>
            <br>
            <span class="smallerText"><b><?php echo $dateTime;?></b></span> <br>
            <br>
            ΑΠΟΤΕΛΕΣΜΑ ΔΙΕΡΕΥΝΗΣΗΣ <br>
            <span class="smallerText">TEST RESULT</span> <br>
            <br>
            <h6>ΑΡΝΗΤΙΚΟ <b>NEGATIVE</b></h6> <br>

            ΗΜΕΡΟΜΗΝΙΑ ΚΑΙ ΩΡΑ ΑΠΟΤΕΛΕΣΜΑΤΟΣ <br>
            <span class="smallerText">TEST RESULT DATE ΑΝΟ ΤΙΜΕ</span> <br>
            <br>
            <span class="smallerText"><b><?php echo $dateTime;?></b></span> <br>
            ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΥΠΕΥΘΥΝΟΥ ΕΠΑΓΓΕΛΜΑΤΙΑ ΥΓΕΙΑΣ <br>
            <span class="smallerText">FULL ΝΑΜΕ 0F LABORATORY OFFICIAL</span> <br>
            <br>
            <span class="smallerText">MARINA ΝΕΟΡΗΥΤΟU</span> <br>
        </div>
    </div>

    <div class="row smallerText2">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H ΒΕΒΑΙΩΣΗ ΕΚΔΙΔΕΤΑΙ ΣΥΜΦΩΝΑ ΜΕ ΤΑ ΣΤΟΙΧΕΙΑ ΠΟΥ ΕΧΟΥΝ ΚΑΤΑΧΩΡΗΘΕΙ ΚΑΙ ΤΗΡΟΥΝΤΑΙ ΣΤΟ ΚΡΑΤΙΚΟ ΜΗΤΡΩΟ ΚΑΤΑ ΤΟΥ ΚΟΡΩΝΟΙΟΥ COVID-19.
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ΤΗΕ CERTIFICATE IS ISSUED ΙΝ ACCORDANCE WITH ΤΗΕ DATA ENTERED ΑΝD ΚΕΡΤ ΙΝ ΤΗΕ NATIONAL COVID-19 REGISTRY.
    </div>

    <br>
    <br>
    <div class="text-right">
        <img src="sgn.jpg" width="320">
    </div>


</div>




<?php
$db->show_empty_footer();
?>
