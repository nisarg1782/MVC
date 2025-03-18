<?php
class Admin_Block_Sales_Order_Order extends Core_Block_Template
{
    protected $_orderBlock;
    public function setOrderBlock($order)
    {
        $this->_orderBlock=$order;
        return $this;
    }
    public function getOrderBlock()
    {
        return $this->_orderBlock;
        
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