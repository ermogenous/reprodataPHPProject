<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 23/3/2021
 * Time: 11:04 π.μ.
 */

include("../../../../include/main.php");
//include("../../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure Function soeasy reports - View Policy Data";

$db->show_header();
?>

<div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">


                <div class="row">
                    <div class="col-12 alert alert-primary text-center">
                        <b>Soeasy Error Report</b>
                    </div>
                </div>

                    <form action="" method="post">
                        <div class="row form-group">
                            <div class="col-4">
                                Policy Number
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" id="policyNumber" name="policyNumber"
                                       value="<?php echo $_POST['policyNumber'];?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                Vehicle registration
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" id="registration" name="registration"
                                       value="<?php echo $_POST['registration'];?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                Policy ID
                            </div>
                            <div class="col-8">
                                <input type="number" class="form-control" id="policyID" name="policyID"
                                       value="<?php echo $_POST['policyID'];?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 text-center">

                                <input type="hidden" value="show" id="action" name="action">
                                <input type="submit" class="form-control btn btn-primary"
                                       value="Show Error Report for Batch" style="width: 300px;">

                            </div>
                        </div>
                    </form>

                    <?php
                if ($_POST['action'] == 'show'){
                    $error = false;
                    if ($_POST['policyNumber'] != ''){
                        $sql = 'SELECT * FROM es_soeasy_import_data WHERE Policy_Number = "'.$_POST['policyNumber'].'"';
                        echo "<b>Search By Policy Number</b>:".$_POST['policyNumber']."<br>";
                    }
                    else if ($_POST['registration'] != ''){
                        $sql = 'SELECT * FROM es_soeasy_import_data WHERE MOT_Registration_Number = "'.$_POST['registration'].'"';
                        echo "<b>Search By Vehicle Registration</b>:".$_POST['registration']."<br>";
                    }
                    else if ($_POST['policyID'] != ''){
                        $sql = 'SELECT * FROM es_soeasy_import_data WHERE essesid_soeasy_import_data_ID = '.$_POST['policyID'];
                        echo "<b>Search By Policy ID</b>:".$_POST['policyID']."<br>";
                    }
                    else {
                        echo "Must provide one of the search fields";
                        $error = true;
                    }

                    if ($error == false) {
                        $result = $db->query($sql);
                        echo "Found ".$db->num_rows($result)." Results<br><br>";
                        while ($data = $db->fetch_assoc($result)) {
                            $text = json_encode($data);
                            $text = str_replace('",', '",<br>', $text);
                            echo $text;
                            echo "<hr>";
                        }
                    }

                }//if show report
                ?>


            </div>
            <div class="col-1"></div>
        </div>
    </div>


<?php
$db->show_footer();
?>
