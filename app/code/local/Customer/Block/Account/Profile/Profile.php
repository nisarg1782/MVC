<?php
class Customer_Block_Account_Profile_Profile extends Core_Block_Template
{
    public function __construct()
    {
        
    }
    public function getProfile()
    {
        $customer_id=Mage::getModel("core/request")->getQuery("customer_id");
        $customer=Mage::getModel("customer/customer")->load($customer_id);
        return $customer;
    }
}
?>