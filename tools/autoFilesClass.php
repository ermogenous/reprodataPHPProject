<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 26/11/2019
 * Time: 5:06 ΜΜ
 */

class AutoFiles {

    //for new file
    private $destinationFolder; //The location/File of the destination
    private $destinationFileName = 'file';
    private $sourceFile; //The source file to create the destination
    private $sourceFileData; //The source file data to create the destination
    private $fileTitle;
    private $fileAltName;
    private $fileType;
    private $fileExtention;
    private $addon; //the module/addon this entry came from
    private $addonID; //the id of the module/addon
    private $order = 0; //if not defined automatically will find it based on addon and addonID
    private $primary = 0;//if not defined and is the first file based on addon and addonID it will be set to 1

    //for editing file
    private $fileID;
    private $fileData;

    public $error = false;
    public $errorDescription = '';

    function __construct($fielID = 0)
    {
        global $db;
        $this->destinationFolder = "_files";
        $this->fileID = $fielID;
        if ($this->fileID > 0){
            $this->fileData = $db->query_fetch('SELECT * FROM _files WHERE fle_file_ID = '.$this->fileID);
            $this->addon = $this->fileData['fle_addon'];
            $this->addonID = $this->fileData['fle_addon_ID'];
        }
    }

    public function createNewFileFromFile(){
        global $db,$main;
        if ($this->sourceFile == ''){
            $this->error = true;
            $this->errorDescription = 'Source file is not specified.';
            return false;
        }
        if ($this->destinationFolder == ''){
            $this->error = true;
            $this->errorDescription = 'Destination folder is not specified.';
            return false;
        }

        $newID = $db->getNextID('_files');

        //make the db entry
        $data['fld_title'] = $this->fileTitle;
        $data['fld_alt_name'] = $this->fileAltName;
        $data['fld_file_name'] = $newID."_".$this->destinationFileName.".".$this->fileExtention;
        $data['fld_file_type'] = $this->fileType;
        $data['fld_addon'] = $this->addon;
        $data['fld_addon_ID'] = $this->addonID;
        $data['fld_file_location'] = $this->destinationFolder;
        $data['fld_order'] = $this->generateOrder();
        $data['fld_primary'] = $this->generatePrimary();
        $db->db_tool_insert_row('_files', $data,'fld_',0, 'fle_');
        $this->destinationFileName = $newID."_".$this->destinationFileName;

        $destination = $main['local_url']."/".$this->destinationFolder."/".$this->destinationFileName.".".$this->fileExtention;
        if (move_uploaded_file($this->sourceFile, $destination)) {

        } else {
            $this->error = true;
            $this->errorDescription = 'Something went wrong moving the file to '.$destination;
            return false;
        }

        return true;
    }

    public function createNewFileFromData(){
        global $db;
        //validations
        if ($this->location == ''){
            $this->error = true;
            $this->errorDescription = 'Location is not defined';
            return false;
        }
        if ($this->fileData == ''){
            $this->error = true;
            $this->errorDescription = 'File is not defined';
            return false;
        }
        if ($this->fileTitle == ''){
            $this->error = true;
            $this->errorDescription = 'File Title is not defined';
            return false;
        }
        return false;
        //needs development
        $fileHandle = fopen($this->location."/".$this->file,"w");
        fwrite($fileHandle,$this->fileData);
        fclose($fileHandle);

    }

    private function generateOrder(){
        global $db;
        //if no addon is specified ignore the auto generate
        if ($this->addon == '' || $this->addonID == ''){
            return $this->order;
        }
        //if already defined then ignore auto generate
        if ($this->order > 0){
            return $this->order;
        }

        $sql = 'SELECT MAX(fle_order)as clo_max FROM _files WHERE fle_addon = "'.$this->addon.'" AND fle_addon_ID = "'.$this->addonID.'"';
        $result = $db->query_fetch($sql);
        return $result['clo_max'] + 1;

    }

    private function generatePrimary(){
        global $db;
        //if no addon is specified ignore the auto generate
        if ($this->addon == '' || $this->addonID == ''){
            return $this->primary;
        }
        //if already defined then ignore auto generate
        if ($this->primary > 0){
            return $this->primary;
        }

        $sql = 'SELECT COUNT(fle_file_ID)as clo_total FROM _files 
                WHERE fle_addon = "'.$this->addon.'" 
                AND fle_addon_ID = "'.$this->addonID.'"
                AND fle_primary = 1';
        $result = $db->query_fetch($sql);
        if ($result['clo_total'] > 0){
            return 0;
        }
        else {
            return 1;
        }
    }

    public function changeOrderUp(){
        global $db;
        if ($this->fileData['fle_file_ID'] == '' || $this->fileData['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Need Image id to change order up';
            return false;
        }
        if ($this->fileData['fle_order'] <= 1){
            $this->error = true;
            $this->errorDescription = 'Order is already at top';
            return false;
        }
        if ($this->addon == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addon to move up';
            return false;
        }
        if ($this->addonID == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addonID to move up';
            return false;
        }

        //get the file previous to this one
        $previousFile = $db->query_fetch('
          SELECT * FROM _files WHERE fle_addon = "'.$this->addon.'" AND fle_addon_ID = "'.$this->addonID.'"
          AND fle_order < '.$this->fileData['fle_order']." ORDER BY fle_order DESC");

        if ($previousFile['fle_file_ID'] == '' || $previousFile['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Could not find the previous file to move up';
            return false;
        }
        if ($previousFile['fle_primary'] == 1){
            $this->error = true;
            $this->errorDescription = 'Cannot replace primary file.';
            return false;
        }

        $previousID = $previousFile['fle_order'];
        $currentID = $this->fileData['fle_order'];
        //fix the current file
        $newData['fld_order'] = $previousID;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$this->fileID,
            $this->fileID,'fld_','execute','fle_');

        //fix the previous
        $newData['fld_order'] = $currentID;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$previousFile['fle_file_ID'],
            $previousFile['fle_file_ID'],'fld_','execute','fle_');
        return true;

    }

    public function changeOrderDown(){
        global $db;
        if ($this->fileData['fle_file_ID'] == '' || $this->fileData['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Need Image id to change order down';
            return false;
        }
        if ($this->addon == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addon to move down';
            return false;
        }
        if ($this->addonID == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addonID to move down';
            return false;
        }

        //get the file after to this one
        $nextFile = $db->query_fetch('
          SELECT * FROM _files WHERE fle_addon = "'.$this->addon.'" AND fle_addon_ID = "'.$this->addonID.'"
          AND fle_order > '.$this->fileData['fle_order']." ORDER BY fle_order ASC");

        if ($nextFile['fle_file_ID'] == '' || $nextFile['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Could not find the next file to move down';
            return false;
        }

        $nextID = $nextFile['fle_order'];
        $currentID = $this->fileData['fle_order'];
        //fix the current file
        $newData['fld_order'] = $nextID;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$this->fileID,
            $this->fileID,'fld_','execute','fle_');

        //fix the previous
        $newData['fld_order'] = $currentID;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$nextFile['fle_file_ID'],
            $nextFile['fle_file_ID'],'fld_','execute','fle_');
        return true;

    }

    public function deleteFile(){
        global $db,$main;
        if ($this->fileData['fle_file_ID'] == '' || $this->fileData['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Need Image id to delete';
            return false;
        }
        //first delete the record from the database
        $db->db_tool_delete_row('_files', $this->fileID, 'fle_file_ID = '.$this->fileID);

        //delete the file
        if (unlink($main['local_url']."/".$this->fileData['fle_file_location']."/".$this->fileData['fle_file_name'])){
            return true;
        }
        else {
            $this->error = true;
            $this->errorDescription = 'Something went wrong deleting the file. Check permissions';
            $this->errorDescription .= ' ['.$this->fileData['fle_file_location']."/".$this->fileData['fle_file_name'].']';
            return false;
        }
    }

    public function makePrimary(){
        global $db;
        if ($this->fileData['fle_file_ID'] == '' || $this->fileData['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Need Image id to make primary';
            return false;
        }
        if ($this->addon == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addon to make primary';
            return false;
        }
        if ($this->addonID == ''){
            $this->error = true;
            $this->errorDescription = 'Need to specify addonID to make primary';
            return false;
        }

        //update the previous primary
        $previousPrimary = $db->query_fetch('SELECT * FROM _files WHERE fle_primary = 1 AND fle_addon = "'.$this->addon.'" AND fle_addon_ID = "'.$this->addonID.'"');
        if ($previousPrimary['fle_file_ID'] > 0) {
            $newData['fld_primary'] = 0;
            $db->db_tool_update_row('_files', $newData, 'fle_file_ID = ' . $previousPrimary['fle_file_ID'],
                $previousPrimary['fle_file_ID'], 'fld_', 'execute', 'fle_');
        }

        //update new current to primary
        $newData['fld_primary'] = 1;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$this->fileID,
            $this->fileID,'fld_','execute','fle_');
        return true;


    }

    public function updateImageDetails(){
        global $db;
        if ($this->fileData['fle_file_ID'] == '' || $this->fileData['fle_file_ID'] == 0){
            $this->error = true;
            $this->errorDescription = 'Need Image id to update';
            return false;
        }
        $newData['fld_title'] = $this->fileTitle;
        $newData['fld_alt_name'] = $this->fileAltName;
        $db->db_tool_update_row('_files',$newData,'fle_file_ID = '.$this->fileID,
            $this->fileID,'fld_','execute','fle_');
        return true;
    }

    /**
     * @return mixed
     */
    public function getDestinationFolder()
    {
        return $this->destinationFolder;
    }

    /**
     * @param mixed $destinationFile
     * @return $this
     */
    public function setDestinationFolder($destinationFolder)
    {
        $this->destinationFolder = $destinationFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationFileName()
    {
        return $this->destinationFileName;
    }

    /**
     * @param string $destinationFileName
     * @return $this
     */
    public function setDestinationFileName($destinationFileName)
    {
        $this->destinationFileName = $destinationFileName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    /**
     * @param mixed $sourceFile
     * @return $this
     */
    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param mixed $fileType
     * @return $this
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileExtention()
    {
        return $this->fileExtention;
    }

    /**
     * @param mixed $fileExtention
     * @return $this
     */
    public function setFileExtention($fileExtention)
    {
        $this->fileExtention = $fileExtention;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * @param mixed $addon
     * @return $this
     */
    public function setAddon($addon)
    {
        $this->addon = $addon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddonID()
    {
        return $this->addonID;
    }

    /**
     * @param mixed $addonID
     * @return $this
     */
    public function setAddonID($addonID)
    {
        $this->addonID = $addonID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileTitle()
    {
        return $this->fileTitle;
    }

    /**
     * @param mixed $fileTitle
     * @return $this
     */
    public function setFileTitle($fileTitle)
    {
        $this->fileTitle = $fileTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileAltName()
    {
        return $this->fileAltName;
    }

    /**
     * @param mixed $fileAltName
     * @return $this
     */
    public function setFileAltName($fileAltName)
    {
        $this->fileAltName = $fileAltName;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param int $primary
     * @return $this
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
        return $this;
    }



}