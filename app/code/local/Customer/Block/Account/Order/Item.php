<?php
class Customer_Block_Account_Order_Item extends Core_Block_Template
{
    protected $_orderBlock;
    public function __construct()
    {
        $this->setTemplate("customer/order/item.phtml");
    }
   
    public function getOrderBlock()
    {
        return $this->getParent();
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