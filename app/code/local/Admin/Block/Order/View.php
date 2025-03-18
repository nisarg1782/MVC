<?php
class Admin_Block_Order_View extends Core_Block_Template
{
    public function getOrderDetails()
    {
        $request = Mage::getModel("core/request");
        $order_id = $request->getQuery("order_id");
        $orderItem_data = Mage::getModel("sales/order_item")
            ->getCollection()
            ->addFieldToFilter("order_id",["="=>$order_id])
            ->getData();

        // echo '<pre>';
        // print_r($orderItem_data);
        // echo '</pre>';
        $address=Mage::getBlock("admin/order_address");
    //    echo '<pre>';
    //    print_r($address->getAddress());
    //    echo '</pre>';
       $address_data=$address->getAddress();
       return $address_data;
 
    }
}
