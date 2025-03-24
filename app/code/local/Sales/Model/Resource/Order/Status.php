<?php
class Sales_Model_Resource_Order_Status extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init("sales_order_status","sales_order_status_id");
    }
}
?>