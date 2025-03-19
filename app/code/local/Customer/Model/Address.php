<?php
class Customer_Model_Address extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Customer_Model_Resource_Address";
        $this->_collectionClassName="Customer_Model_Resource_Address_Collection";
    }
}
?>