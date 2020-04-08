<?php

include("../../include/main.php");
include("../lib/odbccon.php");
include("../../scripts/form_validator_class.php");
include("../../scripts/form_builder_class.php");
include("../../scripts/meBuildDataTable.php");
$db = new Main();

$sybase = new ODBCCON();

$db->show_header();

//getFoldersImages();

$location = '//esdata/EUROSURE DOCUMENTS/CLAIMS/EUROSURE ASSIST';
//getAllFolders($location);

$data = findClaimFolders();
//echo filemtime('');
//exit();

foreach ($data as $folder) {
    ?>
    <div class="row">
        <div class="col-12 alert alert-primary">
            <?php
            echo str_replace("/","\\",($location."/".$folder));
            echo " - ".date('d/m/Y', filemtime(($location."/".$folder)));
            ?>

        </div>
    </div>
    <?php
    $list = getAllFolders($location . "/" . $folder);
    showAllFoldersList($list);
}


function getFoldersImages($specificFolder = '')
{
    global $sybase;
//get directory contents
    $location = '\\\\esdata\\EUROSURE DOCUMENTS\\CLAIMS\\EUROSURE ASSIST';
    $dir = scandir($location);

//get claim info
    $sql = "
SELECT
*
FROM
inclaims
JOIN initems ON initm_item_serial = inclm_item_serial
WHERE 
inclm_claim_serial = " . $_GET['claimID'];
    $claim = $sybase->query_fetch($sql);

//search on the dir array for the vehicle
    foreach ($dir as $dirName => $dirValue) {
        if (stripos($dirValue, $claim['initm_item_code']) == true) {
            //get folder last modified
            $stat = filemtime($location . "/" . $dirValue);
            //echo $claim['initm_item_code'] . " => " . $dirValue . " Last Modified:" . date("d/m/Y", $stat) . "<br>";

            $folders[$stat] = $dirValue;
        } else {

        }
    }
//sort the folders using the date key
    //echo "<hr>";
    //print_r($folders);
    //echo "<br>";
    krsort($folders);
    //print_r($folders);
    //echo "<hr>";

    foreach ($folders as $name => $value) {
        showContents($location, $value);
    }

}

function showContents($location, $folder)
{
    echo "<hr>Contents: " . $folder . "<hr>";
    //check if folder exists
    if (!is_dir($location . "/" . $folder)) {
        return false;
    }

    $contents = scandir($location . "/" . $folder);
    foreach ($contents as $name => $file) {
        //echo"#".$file."#<br>";
        if ($file != '.' && $file != '..') {
            $fileInfo = pathinfo($location . "/" . $file);
            print_r($fileInfo);
            if (isset($fileInfo['extension'])) {
                $extention = $fileInfo['extension'];
                //print_r($fileInfo);
                //$extention = $fileInfo['extension'];
                echo $file . " #" . $extention . "<br>";
                showImage($location . "/" . $folder . "/" . $file);

            } else {
                echo "<br>check if folder " . $location . "/" . $folder . "/" . $file . "<br>";
                if (is_dir($location . "/" . $folder . "/" . $file)) {
                    echo "IS DIRECTORY<br>";
                    showContents($location . "/" . $folder, $file);
                }
            }
        }
    }


}

function showImage($file,$fileName, $fileType)
{
    //read the file
    $contents = file_get_contents($file);
    if ($fileType == 'jpg' || $fileType == 'png') {
        echo '<img src="data:image/jpeg;base64, ' . base64_encode($contents) . '" height="100">';
    }
    else if ($fileType == 'pdf'){
        echo '<i class="fas fa-file-pdf fa-3x"></i>'.$fileName;
    }
    else if ($fileType == 'docx'){
        echo '<i class="far fa-file-word fa-6x"></i>'.$fileName;
    }
    else {
        echo '<i class="fas fa-file-pdf fa-8x"></i>'.$fileName;
    }
    //firefox enable local files
    //in url about:config
    //set to false security.fileuri.strict_origin_policy
    //echo '<img src="file:///'.$file.'" height="50">';
}

$db->show_footer();

function findClaimFolders()
{
    global $sybase;
    //get claim info
    $sql = "
            SELECT
            *
            FROM
            inclaims
            JOIN initems ON initm_item_serial = inclm_item_serial
            WHERE 
            inclm_claim_serial = " . $_GET['claimID'];
    $claim = $sybase->query_fetch($sql);
    $location = '\\\\esdata\\EUROSURE DOCUMENTS\\CLAIMS\\EUROSURE ASSIST';
    $dir = scandir($location);
//search on the dir array for the vehicle
    $folders = [];
    foreach ($dir as $dirName => $dirValue) {
        if (stripos($dirValue, $claim['initm_item_code']) == true) {
            //echo $dirValue."<br>";
            //if (stripos($dirValue, 'aaabbb') == true) {
            //get folder last modified
            $stat = filemtime($location . "/" . $dirValue);
            //echo $claim['initm_item_code'] . " => " . $dirValue . " Last Modified:" . date("d/m/Y", $stat) . "<br>";

            $folders[$stat] = $dirValue;
        } else {

        }
    }
    if (is_array($folders)) {
        krsort($folders);
    }
    return $folders;
}

//recusrive function that puts in array all folders/subfolders and files
function getAllFolders($folder)
{
    $i = 0;

    $list = [];
    $scan = scandir($folder);
    foreach ($scan as $filename) {
        if ($filename != '.' && $filename != '..' && $filename != 'Thumbs.db') {
            $list[$i]['name'] = $filename;
            $list[$i]['folder'] = $folder;
            $info = pathinfo($folder . "/" . $filename);
            $list[$i]['date'] = date('d/m/Y', filemtime(($folder . "/" . $filename)));
            if (isset($info['extension'])) {
                $list[$i]['fileType'] = $info['extension'];
            }

            if (is_dir($folder . "/" . $filename)) {
                $list[$i]['type'] = 'folder';
                $list2 = getAllFolders($folder . "/" . $filename);
                if ($list != false) {
                    $list[$i]['sub'] = $list2;
                }
            } else {
                $list[$i]['type'] = 'file';
            }
            $i++;
        }
    }
    if (count($list) > 0) {
        return $list;
    } else {
        return false;
    }
}

//shows the list from the previous function getAllFolders recursive
function showAllFoldersList($list)
{
    $i = 0;
    foreach ($list as $name => $value) {
        $i++;
        if ($value['type'] == 'folder') {
            ?>
            <div class="row">
                <div class="col-12 alert alert-primary">
                    <?php echo $value['folder']."/".$value['name']." - ".$value['date']; ?>
                </div>
            </div>

            <?php
        } else {
            //show ul every 10 lines
            if ($i % 7 == 1) {
                ?>
                <ul class="list-inline">
                <?php
            }
            ?>
            <li class="list-inline-item">
                <a href="show_file.php?file=<?php echo $value['folder'] . "/" . $value['name']; ?>" target="_blank">
                    <?php showImage($value['folder'] . "/" . $value['name'],$value['name'], $value['fileType']); ?>
                </a>
            </li>
            <?php
            if ($i % 7 == 0) {
                ?>
                </ul>
                <?php
            }
        }

        if (isset($value['sub'])) {
            if (is_array($value['sub'])) {
                showAllFoldersList($value['sub']);
            }
        }
    }
}