<?php
class Customer_Block_Account_Order_Item extends Core_Block_Template
{
    protected $_orderBlock;
    public function __construct()
    {
        $this->setTemplate("customer/order/item.phtml");
    }
    public function setOrderBlock($block)
    {
        $this->_orderBlock=$block;
        return $this;
    }
    public function getOrderBlock()
    {
        return $this->_orderBlock;
    }
    public function getItemDetails()
    {
        return $this->getOrderBlock()
                    ->getOrder()
                    ->getItemCollection()
                    ->getData();
    }
}
?>