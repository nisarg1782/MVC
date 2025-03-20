<?php
class Customer_Block_Account_Dashboard_Profile extends Core_Block_Template
{
    protected $_dashboardBlock;
    public function __construct()
    {
        $this->setTemplate("customer/dashboard/profile.phtml");
    }
    public function getDashboardBlock()
    {
        return $this->getParent();
    }
   
    public function getCustomerProfileData()
    {
        return $this->getDashboardBlock()
                ->getCustomer();
    }
}
?>