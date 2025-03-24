<?php
class Admin_Block_Sales_Order_Status extends Core_Block_Template
{
    protected $_block;
    public function getOrderBlock()
    {
        return $this->getParent();
        
    }
    public function __construct()
    {
        $this->setTemplate("admin/sales/order/view/order.phtml");
    }
    public function getOrderDetails()
    {
        return $this->getOrderBlock()
                    ->getOrder();
    }
}
?>