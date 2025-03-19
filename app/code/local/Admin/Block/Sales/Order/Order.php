<?php
class Admin_Block_Sales_Order_Order extends Core_Block_Template
{
    
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