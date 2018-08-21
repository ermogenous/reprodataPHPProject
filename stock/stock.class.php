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

    /**
     * Stock constructor.
     * @param int $productID
     */
    public function __construct($productID = 0)
    {

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
    /**
     * You can have only one initial type stock for each product.
     * if true then is available to insert if false then already exists
     *
     */
    public function isInitialTypeAvailable() {
        global $db;
        //first check if initial stock transaction already exists.
        $initialCheck = $db->query_fetch("SELECT COUNT(*) as clo_check FROM stock WHERE stk_product_ID = ".$this->productID." AND stk_description = 'Initial'");
        //echo "Mic".$initialCheck["clo_check"]." - ".$this->productID;
        if ($initialCheck["clo_check"] > 0){
            return false;
        }



        //no other check then return true
        return true;
    }

}