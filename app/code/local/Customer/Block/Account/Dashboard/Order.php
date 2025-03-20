<?php
class Customer_Block_Account_Dashboard_Order extends Core_Block_Template
{
    protected $_dashboardBlock;
    public function __construct()
    {
        $this->setTemplate("customer/dashboard/order.phtml");
    }
    public function getDashboardBlock()
    {
        return $this->getParent();
    }
    
    public function getOrderDetails()
    {
        return $this->getDashboardBlock()
                    ->getCustomer()
                    ->getOrderCollection()
                    ->getData();
    }
}
?>