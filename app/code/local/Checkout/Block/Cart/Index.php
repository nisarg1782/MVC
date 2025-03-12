<?php
class Checkout_Block_Cart_Index extends Core_Block_Template
{
    public function getCartData()
    {
        $cart_model = Mage::getSingleton("checkout/session")->getCart();
        $cart_item_data = $cart_model->getItemCollection()->getData();
        return $cart_item_data;
    }
    public function getTotalAmount()
    {
        $cart_model=Mage::getSingleton("checkout/session")->getCart();
      
        $total=$cart_model->getTotalAmount();
      
        return $total;
    }
}
