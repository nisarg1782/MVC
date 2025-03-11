<?php

class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Checkout_Model_Resource_Cart";
        $this->_collectionClassName="Checkout_Model_Resource_Cart_Collection";
    }
    public function addProduct($productid,$quantity)
    {
        $product=Mage::getModel("catalog/product")->load($productid);
        // echo "<pre>";
        // print_r($product->getPrice());
    
   
        $sub_total=$quantity*$product->getPrice();
        Mage::getModel("checkout/cart_item")->setProductId($productid)->setQuantity($quantity)->setCartId($this->getCartId())->setPrice($product->getPrice())
        ->setSubTotal($sub_total)->save();
    }
}
?>