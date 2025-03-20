<?php
class Customer_Block_Account_Address_new extends Core_Block_Template
{
    public function getAddress()
    {
        $address_id=Mage::getModel("core/request")
                    ->getQuery("id");
        $address_data=Mage::getModel("customer/address")->load($address_id);
       return $address_data;
    }
}
?>