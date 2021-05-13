<?php
include("../../include/main.php");
$db = new Main();

if ($_POST["action"] == "show") {

    $html = str_replace("           ","<br>",$_POST["sql"]);
    $html = str_replace("\"","",$html);
    $html = str_replace("{oj","",$html);
    $html = str_replace("} ,",",",$html);
    $html = str_replace("},",",",$html);

    $html = str_replace(" FROM","<br>FROM<br>",$html);
//	$html = str_replace(" JOIN","<br>JOIN",$html);
    $html = str_replace(" LEFT OUTER","<br> LEFT OUTER",$html);
    $html = str_replace(" RIGHT OUTER","<br>RIGHT OUTER",$html);
    $html = str_replace(" WHERE","<br>WHERE<br>",$html);
    $html = str_replace(" and ","<br> and ",$html);
    $html = str_replace(" GROUP BY","<br>GROUP BY<br>",$html);
    $html = str_replace(" ORDER BY","<br>ORDER BY<br>",$html);
    $html = str_replace(" HAVING","<br>HAVING<br>",$html);
    $html = str_replace("NULL,","NULL,<br>",$html);
    $html = str_replace("VALUES","<br>VALUES<br>",$html);

    if ($_POST["break_after_comma"] == 1) {
        $html = str_replace(",",",<br>",$html);
    }

    echo stripslashes($html);
    $db->main_exit();
}else {
    $db->show_header();
    ?>
    <form action="" method="post">
        <textarea name="sql" id="sql" cols="80" rows="10"></textarea>
        <br />
        Add break after every ,
        <input name="break_after_comma" type="checkbox" id="break_after_comma" value="1" />
        <br>
        <input type="submit" name="button" id="button" value="Submit">
        <input name="action" type="hidden" id="action" value="show">
    </form>
    <?php


    echo $db->encrypt('michael');

    echo "<br>";

    echo $db->decrypt('TmNFNWVqZndkUlVYRlJpWkxBejd5Zz09Ojqh66dU5n7abbHL0cUb9xx7');

    $db->show_footer();
}
?>
