<?php
class Admin_Block_Order_View extends Core_Block_Template
{
    protected $_order;
    // public function getOrderDetails()
    // {
    //     $request = Mage::getModel("core/request");
    //     $order_id = $request->getQuery("order_id");
    //     $orderItem_data = Mage::getModel("sales/order_item")
    //         ->getCollection()
    //         ->addFieldToFilter("order_id",["="=>$order_id])
    //         ->getData();

      
    //     $address = Mage::getBlock("admin/order_address");
    //     $product=Mage::getBlock("admin/order_product");
        
    //     return $orderItem_data;
    // }
    // public function getAddressObject()
    // {
    //     return Mage::getBlock("Admin/order_address");
    // }
    // public function getProductObject()
    // {
    //     return Mage::getBlock("Admin/order_product");
    // }
    // public function getOrderObject()
    // {
    //     return Mage::getBlock("admin/order_order");
    // }
    public function setOrder($order)
    {
        $this->_order=$order;
        return $this;
    }
    public function getOrder()
    {
        return $this->_order;
        
    }
}
