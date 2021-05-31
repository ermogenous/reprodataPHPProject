<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 20/5/2021
 * Time: 9:20 π.μ.
 */
include("../../include/main.php");

$db = new Main(0);
if ($db->user_data['usr_user_rights']>0){
    header("Location: ".$main['site_url']);
    exit();
}


?>

<table width="250" border="0">
    <tr>
        <td colspan="2">|---------------------------------------------|</td>
    </tr>
    <tr>
        <td align="center" height="90" valign="top" colspan="2">
            <img src="logo.jpg">
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <b>
            ΑΠΟΤΕΛΕΣΜΑ<br>
            ΕΡΓΑΣΤΗΡΙΑΚΗΣ<br>
            ΔΙΕΡΕΥΝΗΣΗΣ<br>
            ΓΙΑ SARS-CoV-2<br>
            (ANTIGEN RAPID TEST)
            </b>
        </td>
    </tr>
    <tr>
        <td align="center" height="100" colspan="2">
            <br>
            No. &nbsp;
            <span style="font-size: 25px">4719352</span>
            <br><br>
            Ονοματεπώνυμο/Name:<br><br>
            ..........................................<br><br>
            ..........................................<br><br>

            Αριθμός ταυτότητας/<br>
            ID Card Number:<br><br>
            ..........................................<br><br>

            Αποτέλεσμα/Result:<br>
        </td>
    </tr>
    <tr>
        <td valign="middle" align="center" height="40">
            ΑΡΝΗΤΙΚΟ/NEGATIVE
        </td>
        <td width="40" align="left"><img src="box.jpg"></td>
    </tr>
    <tr>
        <td valign="middle" align="center">
            ΘΕΤΙΚΟ/POSITIVE
        </td>
        <td width="40" align="left"><img src="box.jpg"></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <br>
            Υπογραφή/Signature:<br><br>
            ..........................................<br>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="center">
            <br>
            Ημερομηνία/Date:<br><br>
            ..........................................<br>
        </td>
    </tr>
    <tr>
        <td colspan="2" height="90">|---------------------------------------------|</td>
    </tr>
</table>
