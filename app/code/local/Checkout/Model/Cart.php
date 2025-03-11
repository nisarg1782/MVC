<?php

class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Collection";
    }
    public function addProduct($productid, $quantity)
    {
        Mage::getModel("checkout/cart_item")->setProductId($productid)->setQuantity($quantity)->setCartId($this->getCartId())->save();
        return $this;
    }
    public function getItemCollection()
    {

        $cart_item = Mage::getModel("checkout/cart_item")
            ->getCollection()
            ->addFieldToFilter(
                "cart_id",
                ["=" => $this->getCartId()]
            );
        
        return $cart_item;
    }
    public function _beforeSave()
    {
        $total=0;
        $data=$this->getItemCollection()->getData();
        foreach($data as $_data)
    {
        // print($_data->getSubtotal());
        // echo '<br>';
        $total=$total+$_data->getSubTotal();
    }
    print_r($total);
    $this->setTotalAmount($total);
    }
}
