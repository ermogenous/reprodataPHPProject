<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 7/2/2019
 * Time: 9:25 ΠΜ
 */

Class DiscTest
{

    public $data;
    public $testID;
    public $error = false;
    public $errorDescription;

    function __construct($id)
    {
        global $db;
        $this->testID = $id;
        if ($this->testID > 0 && is_numeric($this->testID) == true) {
            $this->data = $db->query_fetch('SELECT * FROM lcs_disc_test WHERE lcsdc_disc_test_ID = ' . $id);
        } else {
            $this->error = true;
            $this->errorDescription[] = 'Must provide valid ID';
            return false;
        }

    }

    function verifyCompletion()
    {

        if ($this->data['lcsdc_name'] == '') {
            $this->error = true;
            $this->errorDescription[] = 'Το Όνομα δεν είναι συμπληρωμένο';
        }
        /*if ($this->data['lcsdc_tel'] == '') {
            $this->error = true;
            $this->errorDescription[] = 'Το Τηλέφωνο δεν είναι συμπληρωμένο';
        }
        */
        if ($this->data['lcsdc_email'] == '') {
            $this->error = true;
            $this->errorDescription[] = 'Το Email δεν είναι συμπληρωμένο';
        }

        for ($i = 1; $i <= 28; $i++) {
            if ($this->data['lcsdc_question_' . $i] != 'A' && $this->data['lcsdc_question_' . $i] != 'B') {

                $this->error = true;
                $this->errorDescription[] = 'Ερώτηση ' . $i . ' δεν είναι συμπληρωμένη';
            }
        }
        if($this->error == true){
            return false;
        }
        else {
            return true;
        }
    }

    function statusToCompleted()
    {
        global $db;
        if ($this->verifyCompletion()) {
            if ($this->data['lcsdc_status'] == 'Outstanding') {
                $newData['status'] = 'Completed';
                $db->db_tool_update_row('lcs_disc_test', $newData, "`lcsdc_disc_test_ID` = " . $this->testID,
                    $this->testID, '', 'execute', 'lcsdc_');
                return true;
            } else {
                $this->error = true;
                $this->errorDescription = 'Status must be Outstanding for change to Completed';
                return false;
            }
        } else {
            $this->error = true;
            $this->errorDescription = 'Must answer all questions to set to completed';
            return false;
        }
    }

    function processStatusToPaid()
    {
        global $db;
        if ($this->verifyCompletion()) {
            if ($this->data['lcsdc_status'] == 'Completed') {
                if ($this->data['lcsdc_process_status'] == 'UnPaid'){
                    $newData['process_status'] = 'Paid';
                    $db->db_tool_update_row('lcs_disc_test', $newData, "`lcsdc_disc_test_ID` = " . $this->testID,
                        $this->testID, '', 'execute', 'lcsdc_');
                    return true;
                }
                else {
                    $this->error = true;
                    $this->errorDescription = 'Process Status must be UnPaid for change to Paid';
                    return false;
                }

            } else {
                $this->error = true;
                $this->errorDescription = 'Process Status must be Completed for change to Paid';
                return false;
            }
        } else {
            $this->error = true;
            $this->errorDescription = 'All questions are not filled.';
            return false;
        }
    }

    function deleteTest(){
        global $db;
        if ($this->data['lcsdc_status'] == 'Outstanding'){
            $newData['status'] = 'Deleted';
            $db->db_tool_update_row('lcs_disc_test', $newData, "`lcsdc_disc_test_ID` = " . $this->testID,
                $this->testID, '', 'execute', 'lcsdc_');
            return true;
        }
        else {
            $this->error = true;
            $this->errorDescription = 'Status must be Outstanding to Delete';
            return false;
        }
    }

    function sendEmail($email){
        include('email_layout.php');
        include('questions_list.php');
        $testResults = getIntorExtroResults($this->data);
        $html = getEmailLayout($this->data, $testResults);
    }

    function getEmailHtml(){
        if ($this->data['lcsdc_status'] == 'Completed' || $this->data['lcsdc_status'] == 'Paid') {
            include('email_layout.php');
            include('questions_list.php');
            $testResults = getDiSCResults($this->data);
            $html = getEmailLayoutResult($this->data, $testResults);
            return $html;
        }
        else {
            return '';
        }
    }

    function getTestResults(){
        $highDominance = 0;
        $lowDominance = 0;
        $highSocial = 0;
        $lowSocial = 0;

        $testData = $this->data;

        //high dominance
        if ($testData['lcsdc_question_3'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_4'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_5'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_10'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_11'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_14'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_16'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_20'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_21'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_22'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_24'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_26'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_27'] == 'A') $highDominance++;
        if ($testData['lcsdc_question_28'] == 'A') $highDominance++;

        //low dominance
        if ($testData['lcsdc_question_3'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_4'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_5'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_10'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_11'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_14'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_16'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_20'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_21'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_22'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_24'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_26'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_27'] == 'B') $lowDominance++;
        if ($testData['lcsdc_question_28'] == 'B') $lowDominance++;

        //high sociability
        if ($testData['lcsdc_question_1'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_2'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_6'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_7'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_8'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_9'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_12'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_13'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_15'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_17'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_18'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_19'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_23'] == 'A') $highSocial++;
        if ($testData['lcsdc_question_25'] == 'A') $highSocial++;

        //low sociability
        if ($testData['lcsdc_question_1'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_2'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_6'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_7'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_8'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_9'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_12'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_13'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_15'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_17'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_18'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_19'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_23'] == 'B') $lowSocial++;
        if ($testData['lcsdc_question_25'] == 'B') $lowSocial++;

        $total = ($highDominance + $lowDominance) * ($highSocial + $lowSocial);



        $result['HighDominance'] = $highDominance;
        $result['LowDominance'] = $lowDominance;
        $result['HighSocial'] = $highSocial;
        $result['LowSocial'] = $lowSocial;

        /*
        echo "HighDominance:".$highDominance."<br>";
        echo "LowDominance:".$lowDominance."<br>";
        echo "HighSocial:".$highSocial."<br>";
        echo "LowSocial:".$lowSocial."<br>";
        */

        if ($total > 0) {
            $result['HighDominance-per'] = round(((($highDominance * $lowSocial) / $total) * 100), 2);
            $result['LowDominance-per'] = round(((($highSocial * $lowDominance) / $total) * 100), 2);
            $result['HighSocial-per'] = round(((($lowSocial * $lowDominance) / $total) * 100), 2);
            $result['LowSocial-per'] = round(((($highSocial * $highDominance) / $total) * 100), 2);
        }

        /*
        $result['HighDominance-per'] = round( ($highDominance / 28)*100 ,2);
        $result['LowDominance-per'] = round( ($lowDominance / 28)*100 ,2);
        $result['HighSocial-per'] = round( ($highSocial / 28)*100 ,2);
        $result['LowSocial-per'] = round( ($lowSocial / 28)*100 ,2);
        */
        return $result;
    }

    function getPieImageData($image = 'path'){
        global $main;

        $testResults = $this->getTestResults();
        //print_r($testResults);exit();

        include_once("../tools/pChart2.1.4/class/pData.class.php");
        include_once("../tools/pChart2.1.4/class/pDraw.class.php");
        include_once("../tools/pChart2.1.4/class/pPie.class.php");
        include_once("../tools/pChart2.1.4/class/pImage.class.php");

        $width = 900;
        $height = 400;
        $piePositionX = 450;
        $piePositionY = 220;
        $pieSize = 180;
        $pieHeight = 36;
        $legendPositionX = 30;
        $legendPositionY = 350;
        $legendFontSize = 15;

        $title = ''; //'DiSC Results For '.$this->data['lcsdc_name'];
        $titleFontSize = 9;
        $titleHeight = 0;

        /* Create and populate the pData object */
        $MyData = new pData();
        //set the palette
        $MyData->loadPalette('pie_color_palette.color',TRUE);

        $MyData->addPoints(
            array(
                $testResults['HighDominance'],
                $testResults['LowDominance'],
                $testResults['HighSocial'],
                $testResults['LowSocial']
            ),"ScoreA");
        $MyData->setSerieDescription("ScoreA","Application A");

        /* Define the absissa serie */
        $MyData->addPoints(
            array(
                $testResults['HighDominance-per']."%"." ΚΥΡΙΑΡΧΟΣ",
                $testResults['LowDominance-per']."% "." ΕΥΣΥΝΕΙΔΗΤΟΣ",
                $testResults['HighSocial-per']."% "." ΣΤΑΘΕΡΟΣ",
                $testResults['LowSocial-per']."% "." ΕΜΠΝΕΥΣΤΙΚΟΣ"
            ),"Labels");
        $MyData->setAbscissa("Labels");


        /* Create the pChart object */
        $myPicture = new pImage($width,$height,$MyData);

        /* Draw a solid background */
        $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
        $myPicture->drawFilledRectangle(0,0,$width,$height,$Settings);

        /* Overlay with a gradient */
        $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>255);
        $myPicture->drawGradientArea(0,0,$width,$height,DIRECTION_VERTICAL,$Settings);
        //section for the title
        $myPicture->drawGradientArea(0,0,$width,$titleHeight,DIRECTION_VERTICAL,array("StartR"=>203,"StartG"=>38,"StartB"=>43,"EndR"=>203,"EndG"=>38,"EndB"=>43,"Alpha"=>100));

        /* Add a border to the picture */
        $myPicture->drawRectangle(0,0,($width-1),($height-1),array("R"=>0,"G"=>0,"B"=>0));

        /* Write the picture title */
        $myPicture->setFontProperties(array("FontName"=>$main['local_url']."/tools/pChart2.1.4/fonts/Silkscreen.ttf","FontSize"=>$titleFontSize));
        $myPicture->drawText(10,16,$title,array("R"=>255,"G"=>255,"B"=>255));


        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>$main['local_url']."/tools/pChart2.1.4/fonts/greek/OpenSans-Regular.ttf","FontSize"=>$legendFontSize,"R"=>20,"G"=>80,"B"=>80));

        /* Create the pPie object */
        $PieChart = new pPie($myPicture,$MyData);

        /* Draw an AA pie chart */
        $PieChart->draw3DPie($piePositionX,$piePositionY,
            array(
                "Radius"=>$pieSize,
                "DrawLabels"=>TRUE,
                "LabelStacked"=>TRUE,
                "Border"=>TRUE,
                "SliceHeight"=>$pieHeight
            ));

        /* Write the legend box */
        $myPicture->setShadow(FALSE);
        //$PieChart->drawPieLegend($legendPositionX,$legendPositionY,array("Alpha"=>60));

        /* Render the picture (choose the best way) */

        if ($image == 'path'){
            $pic = $myPicture->getPicturePath();
        }
        else {
            $pic = $myPicture->getPictureData();
        }

        return $pic;
    }

    //action = OutputPdf, GetFilePath
    public function getPdf($action = 'OutputPdf'){
        require_once '../vendor/autoload.php';
        include_once('email_layout.php');

        $html = getEmailLayoutResult($this->testID,'link',true);
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'arial'
        ]);
        $mpdf->WriteHTML($html);

        if ($action == 'OutputPdf'){
            $mpdf->Output();
        }
        else if ($action == 'GetFilePath') {
            $date = new DateTime();
            $fileName = 'pdf/discPdf-' . $date->format('dmY-Gis-v').".pdf";
            $mpdf->Output($fileName);
            return $fileName;
        }
    }

    public function clearImages(){

        //loop into all images in images folder
        $allFiles = scandir('pie_images');

        //time which if less or equal then delete the image
        $date = new DateTime();
        $hour = $date->format('G')*1 - 1;
        $minute = $date->format('i')*1;
        $second = $date->format('s')*1;
        $date->setTime($hour,$minute, $second);

        $timeLimit = $date->format('Gis');
        $dateLimit = $date->format('dmY');

        foreach($allFiles as $value){

            //first check if its an image file
            $imageCheck = substr($value,0,6);
            if ($imageCheck == 'myPic-') {

                $deleteFile = false;
                //first check the date
                $datePart = substr($value, 6, 8);
                if ($dateLimit > $datePart) {
                    $deleteFile = true;
                }

                //if date is not for delete then check the time
                $timePart = substr($value, 15, 6);
                if ($timeLimit > $timePart && $deleteFile == false) {
                    $deleteFile = true;
                }

                if ($deleteFile == true && $value != '.' && $value != '..') {
                    $fileToDelete = 'pie_images/' . $value;
                    unlink($fileToDelete);
                }
            }

        }

    }

}

function getTestColor($status,$type = 'Bg'){
    if ($status == 'Outstanding'){
        return 'discOutstanding'.$type.'Color';
    }
    else if ($status == 'Link'){
        return 'discLink'.$type.'Color';
    }
    else if ($status == 'Completed'){
        return 'discCompleted'.$type.'Color';
    }
    else if ($status == 'Paid'){
        return 'discPaid'.$type.'Color';
    }
    else if ($status == 'Deleted'){
        return 'discDeleted'.$type.'Color';
    }
}