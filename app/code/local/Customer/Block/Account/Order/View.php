<?php
class Customer_Block_Account_Order_View extends Core_Block_Template
{
    protected $_order;
    public function __construct()
    {
        
    }
    public function setOrder($order)
    {
        $this->_order=$order;
        return $this;
    }
    public function getOrder()
    {
        return $this->_order;
    }
}
?>