<?php
class Sales_Model_Order extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Sales_Model_Resource_Order";
        $this->_collectionClassName="Sales_Model_Resource_Order_Collection";
    }
    public function getAddressCollection()
    {
        $address_collection=Mage::getModel("sales/order_address")
                        ->getCollection()
                        ->addFieldToFilter("order_id",["="=>$this->getOrderId()]);
        return $address_collection;
                        
    }
    public function getItemCollection()
    {
        $item_collection=Mage::getModel("sales/order_item")
                        ->getCollection()
                        ->addFieldToFilter("order_id",["="=>$this->getOrderId()]);
        return $item_collection;
    }
    
   
}
?>