<?php
class Customer_Block_Account_Dashboard extends Core_Block_Template
{
    protected $_customer;
    public function setCustomer($customer)
    {
        $this->_customer=$customer;
        return $this;
    }
    public function getCustomer()
    {
        return $this->_customer;
    }
}
?>