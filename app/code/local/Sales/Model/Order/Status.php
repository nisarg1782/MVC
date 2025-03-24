<?php
class Sales_Model_Order_Status extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Sales_Model_Resource_Order_Status";
        $this->_collectionClassName="Sales_Model_Resource_Order_Status_Collection";
    }
}
?>