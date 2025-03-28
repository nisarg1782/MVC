<?php
class Customer_Block_Account_Dashboard_Address extends Core_Block_Template
{
    protected $_dashboardBlock;
    public function __construct()
    {
        $this->setTemplate("customer/dashboard/address.phtml");
    }
    public function getDashboardBlock()
    {
        return $this->getParent();
    }
   
    public function getAddressData()
    {
        return $this->getDashboardBlock()
                    ->getCustomer()
                    ->getAddressCollection()
                    ->getData();
    }
}
?>