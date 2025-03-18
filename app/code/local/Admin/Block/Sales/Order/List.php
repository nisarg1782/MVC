<?php
class Admin_Block_Sales_Order_List extends Core_Block_Template
{
    public function getOrderData()
    {
        $order_data=Mage::getModel("sales/order")
                    ->getCollection()
                    ->getData();
        return $order_data;
    }
}
?>