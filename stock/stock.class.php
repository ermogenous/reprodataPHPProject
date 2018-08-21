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

    public function addRemoveStock($amount, $description) {
        global $db;
        $this->checkForErrors();

        //first create stock transaction
        $stock['product_ID'] = $this->productID;
        $stock['type'] = 'transaction';
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
        $db->start_transaction();
        $this->newStockRowID = $db->db_tool_insert_row('stock', $stock, '', 1, 'stk_');

        //update product
        $product['current_stock'] = $this->productData['prd_current_stock'] + $amount;
        $product['stock_last_update'] = date('Y-m-d G:i:s');
        $db->working_section = 'Update product@addRemoveStock';
        $db->db_tool_update_row('products', $product, 'prd_product_ID = ' . $this->productID, $this->productID, '', 'execute', 'prd_');

        $db->commit_transaction();
    }

    public function checkForErrors(){


        if ($this->errorCount > 0){
            return $this->errorDescription;
        }
    }

    public function closePeriod() {
        global $db;

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
            }


        }


        return $messages;
    }

}