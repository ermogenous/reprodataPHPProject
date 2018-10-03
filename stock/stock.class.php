<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 12-Aug-18
 * Time: 7:10 PM
 */

class Stock {

    private $productID;
    private $productData;
    private $newStockRowID;

    private $errorCount = 0;
    private $errorDescription = '';


    public $currentStock = 0;
    public $currentMonth = 0;
    public $currentYear = 0;

    public $disableCommit = false;

    /**
     * Stock constructor.
     * @param int $productID
     */
    public function __construct($productID = 0)
    {
        global $db;
        $this->currentMonth = $db->get_setting('stk_active_month');
        $this->currentYear = $db->get_setting('stk_active_year');

        if ($productID > 0) {
            $this->productID = $productID;
            //get product data
            $this->getProductData();
        }
        else {
            $this->errorCount++;
            $this->errorDescription = 'No product ID';
        }

    }

    public function getProductData() {
        global $db;

        $this->productData = $db->query_fetch("SELECT * FROM products WHERE prd_product_ID = ".$this->productID);
        //check if product exists
        if ($this->productData['prd_product_ID'] > 0) {
            //product found ok
            $this->currentStock = $this->productData['prd_current_stock'];
        }
        else {
            $this->errorCount++;
            $this->errorDescription .= 'Product Not Found.\n';
        }
    }

    /**
     * @param $amount     The amount to +/- from stock
     * @param $description A description of the +/-
     */
    public function addRemoveStock($amount, $description) {
        global $db;
        $this->checkForErrors();


        //first create stock transaction
        $stock['product_ID'] = $this->productID;
        $stock['type'] = 'Transaction';
        $stock['description'] = $description;
        $stock['status'] = 'Pending';
        if ($amount > 0) {
            $stock['add_minus'] = '1';
        }
        else {
            $stock['add_minus'] = '-1';
        }
        $stock['amount'] = abs($amount);
        $stock['date_time'] = date('Y-m-d G:i:s');
        $stock['month'] = date('m');
        $stock['year'] = date('Y');
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        $this->newStockRowID = $db->db_tool_insert_row('stock', $stock, '', 1, 'stk_');

        //update product
        $product['current_stock'] = $this->productData['prd_current_stock'] + $amount;
        $product['stock_last_update'] = date('Y-m-d G:i:s');
        $db->working_section = 'Update product@addRemoveStock';
        $db->db_tool_update_row('products', $product, 'prd_product_ID = ' . $this->productID, $this->productID, '', 'execute', 'prd_');
        if ($this->disableCommit == false) {
            $db->commit_transaction();
        }
    }

    public function checkForErrors(){


        if ($this->errorCount > 0){
            return $this->errorDescription;
        }
    }
    /**
     * You can have only one initial type stock for each product.
     * if true then is available to insert if false then already exists
     *
     */
    public function isInitialTypeAvailable($year = 0) {
        global $db;
        if ($year == 0){
            $year = $this->currentYear;
        }
        //first check if initial stock transaction already exists.
        $initialCheck = $db->query_fetch("SELECT COUNT(*) as clo_check FROM stock WHERE stk_product_ID = ".$this->productID." AND stk_description = 'Initial'");
        //echo "Mic".$initialCheck["clo_check"]." - ".$this->productID;
        if ($initialCheck["clo_check"] > 0){
            return false;
        }



        //no other check then return true
        return true;
    }

    public function getTotalsOfAllPeriods(){
        global $db;

        $sql = "SELECT
        stk_month,
        SUM(stk_add_minus * stk_amount)as clo_total
        FROM
        stock
        WHERE
        stk_product_ID = ".$this->productID."
        AND stk_year = ".$this->currentYear."
        GROUP BY
        stk_month";

        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {
            $return[$row['stk_month']] = $row['clo_total'];
        }
        return $return;
    }

    public function updateTransaction($transactionID, $amount){
        global $db;
        if ($transactionID == '' || $transactionID == 0) {
            return 'Must provide transaction ID';
        }


        //get the data of the transaction
        $previousData = $db->query_fetch('SELECT * FROM  stock WHERE stk_stock_ID = '.$transactionID);

        //check if the transaction is not posted
        if ($previousData['stk_status'] == 'Posted') {
            return 'Can only change pending stock transactions';
        }

        $difference = $amount - $previousData['stk_amount'] * $previousData['stk_add_minus'];

        if ($amount < 0){
            $newAddMinus = -1;
        }
        else {
            $newAddMinus = 1;
        }

        $newStockData['add_minus'] = $newAddMinus;
        $newStockData['amount'] = $amount;
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        $db->db_tool_update_row('stock',$newStockData,'stk_stock_ID = '.$transactionID, $transactionID,''
        ,'execute','stk_');

        //update the product
        $newProductData['current_stock'] = $this->productData['prd_current_stock'] + $difference;
        $db->db_tool_update_row('products',$newProductData,'prd_product_ID = '.$this->productID,
            $this->productID,'','execute','prd_');
        if ($this->disableCommit == false) {
            $db->commit_transaction();
        }
        return true;

    }

    public function deleteTransaction($transactionID) {
        global $db;
        if ($transactionID == '' || $transactionID == 0) {
            return 'Must provide transaction ID';
        }


        //get the data of the transaction
        $previousData = $db->query_fetch('SELECT * FROM  stock WHERE stk_stock_ID = '.$transactionID);

        if ($previousData['stk_stock_ID'] != $transactionID){
            return 'Stock transaction not found.';
        }

        //check if the transaction is not posted
        if ($previousData['stk_status'] == 'Posted') {
            return 'Can only delete pending stock transactions';
        }

        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        //delete the transaction
        $db->db_tool_delete_row('stock', $transactionID, 'stk_stock_ID = '.$transactionID);

        //update the product
        $newProductData['current_stock'] = $this->productData['prd_current_stock'] - ($previousData['stk_amount'] * $previousData['stk_add_minus']);
        $db->db_tool_update_row('products',$newProductData,'prd_product_ID = '.$this->productID,
            $this->productID,'','execute','prd_');
        if ($this->disableCommit == false) {
            $db->commit_transaction();
        }
        return true;

    }

    public function closePeriod() {
        global $db;
        if ($this->disableCommit == false) {
            $db->start_transaction();
        }
        $messages = '';
        //first check if the active period is the same with the current period
        if ($this->currentYear == Date('Y') && $this->currentMonth == Date('m')){
            $messages = '-Current period is the same with active period. Nothing to do';
            return $messages;
        }
        else {
            $messages = '-Current period is not the same with active period. Proceed to check.';
            //check if in the stock table are pending transactions before the current period
            $messages .= '<br>-Checking to find any transactions in previous periods';
            $checkPrevious = $db->query_fetch("
              SELECT MIN((stk_year * 100) + stk_month) as clo_min_period
              FROM stock
              WHERE stk_status = 'Pending'");
            //break down the reault
            $prevTransPeriod = substr($checkPrevious['clo_min_period'], -2);
            $prevTransYear = substr($checkPrevious['clo_min_period'], 0, 4);
            $messages .= "<br>-Found pending transactions in ".$prevTransPeriod."/".$prevTransYear;

            //get all transactions in that period.
            $allTransResult = $db->query("SELECT * 
            FROM 
            stock
            JOIN products ON stk_product_ID = prd_product_ID 
            WHERE stk_status = 'Pending' AND stk_year = ".$prevTransYear." AND stk_month = ".$prevTransPeriod."
            ORDER BY stk_stock_ID");
            while ($trans = $db->fetch_assoc($allTransResult)){
                $messages .= '<br>Posting Transaction: ID:'.$trans['stk_stock_ID']." Product:".$trans['prd_name'];

                $stockData['status'] = "Posted";
                $db->db_tool_update_row('stock',$stockData,'stk_stock_ID = '.$trans['stk_stock_ID'],
                    $trans['stk_stock_ID'],
                    '','execute','stk_');

            }

            //update closed period setting
            $db->update_setting('stk_active_month',($prevTransPeriod + 1));
            if ($this->disableCommit == false) {
                $db->commit_transaction();
            }
        }


        return $messages;
    }

}