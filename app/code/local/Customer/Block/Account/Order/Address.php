<?php
class Customer_Block_Account_Order_Address extends Core_Block_Template
{
    protected $_orderBlock;
    public function __construct()
    {
        $this->setTemplate("customer/order/address.phtml");
    }
    
    public function getOrderBlock()
    {
        return $this->getParent();
    }
    public function getAddress()
    {
        return $this->getOrderBlock()
                    ->getOrder()
                    ->getAddressCollection()
                    ->getData();
                    
    }
}
?>