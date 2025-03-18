<?php
class Admin_Block_Order_Address extends Core_Block_Template
{
    protected $_orderBlock;
    public function __construct()
    {
        $this->setTemplate("admin/order/address.phtml");
    }
    public function setOrderBlock($order)
    {
        $this->_orderBlock=$order;
        return $this;
    }
    public function getOrderBlock()
    {
        return $this->_orderBlock;
        
    }
    public function getAddress()
    {
        $address_collection=$this->getOrderBlock()
            ->getOrder()
            ->getAddressCollection();
        // echo '<pre>';
        // print_r($address_collection);
        // echo '</pre>';
        return $address_collection->getData();
    }
} 
?>