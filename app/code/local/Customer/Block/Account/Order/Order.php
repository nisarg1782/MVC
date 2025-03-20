<?php
class Customer_Block_Account_Order_Order extends Core_Block_Template
{
    protected $_orderBlock;
    public function __construct()
    {
        $this->setTemplate("customer/order/order.phtml");
    }
   
    public function getOrderBlock()
    {
        return $this->getParent();
    }
    public function getOrderDetails()
    {
        return $this->getOrderBlock()
                    ->getOrder();
    }
}
?>