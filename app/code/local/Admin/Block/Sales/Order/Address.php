<?php
class Admin_Block_Sales_Order_Address extends Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate("admin/sales/order/view/address.phtml");
    }
    
    public function getOrderBlock()
    {
        return $this->getParent();
        
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