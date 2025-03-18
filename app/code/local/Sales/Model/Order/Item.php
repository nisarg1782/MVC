<?php
class Sales_Model_Order_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Sales_Model_Resource_Order_Item";
        $this->_collectionClassName="Sales_Model_Resource_Order_Item_Collection";
    }
    public function getProduct()
    {
        $product = Mage::getModel("catalog/product")
                        ->load($this->getProductId(),"product_id");
        return $product;
    }
}
?>