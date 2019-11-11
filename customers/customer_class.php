<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 5/11/2019
 * Time: 4:54 ΜΜ
 */

class Customers
{

    private $customerData;
    private $customerID;

    public $error = false;
    public $errorDescription = '';

    function __construct($id)
    {
        global $db;

        $this->customerID = $id;
        $this->customerData = $db->query_fetch('SELECT * FROM customers WHERE cst_customer_ID = ' . $this->customerID);
    }

    public function getCustomerData(){
        return $this->customerData;
    }

    public function getCustomerID(){
        return $this->customerID;
    }

    function createACEntity($force = false)
    {
        global $db;
        $AISettings = $db->query_fetch('SELECT * FROM ina_settings');

        if ($AISettings['inaset_auto_create_entity_from_client'] == 1 || $force == true) {

            $entity['fld_active'] = 'Active';
            $entity['fld_name'] = $this->customerData['cst_name']." ".$this->customerData['cst_surname'];
            $entity['fld_description'] = $this->customerData['cst_name']." - ".$this->customerData['cst_surname'];
            $entity['fld_mobile'] = $this->customerData['cst_mobile_1'];
            $entity['fld_work_tel'] = $this->customerData['cst_work_tel_1'];
            $entity['fld_fax'] = $this->customerData['cst_fax'];
            $entity['fld_email'] = $this->customerData['cst_email'];
            $entity['fld_website'] = '';
            
            $entityNewID = $db->db_tool_insert_row('ac_entities', $entity,'fld_', 1, 'acet_');

            $cstNewData['fld_entity_ID'] = $entityNewID;
            $db->db_tool_update_row('customers', $cstNewData, 'cst_customer_ID = '.$this->customerID, $this->customerID,'fld_','execute','cst_');


        }

    }

    function updateCustomer(){
        global $db;


        //check if the customer is connected to an entity
        //if yes then update the entity also
        if ($this->customerData['cst_entity_ID'] > 0){
            $entity['fld_name'] = $this->customerData['cst_name']." ".$this->customerData['cst_surname'];
            $entity['fld_description'] = $this->customerData['cst_name']." - ".$this->customerData['cst_surname'];
            $entity['fld_mobile'] = $this->customerData['cst_mobile_1'];
            $entity['fld_work_tel'] = $this->customerData['cst_work_tel_1'];
            $entity['fld_fax'] = $this->customerData['cst_fax'];
            $entity['fld_email'] = $this->customerData['cst_email'];
            $entity['fld_website'] = '';

            $db->db_tool_update_row('ac_entities', $entity, 'acet_entity_ID = '.$this->customerData['cst_entity_ID'], $this->customerData['cst_entity_ID']
            ,'fld_','execute','acet_');

        }
    }
}