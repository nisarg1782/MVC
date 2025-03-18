<?php
class Admin_Block_Order_Address
{
    public function getAddress()
    {
        $order_id=Mage::getModel("core/request")
                ->getQuery("order_id");
        $address_data=Mage::getModel("sales/order_address")
                        ->getCollection()
                        ->addFieldToFilter("order_id",["="=>$order_id])
                        ->getData();
        return $address_data;
    }
}

?>