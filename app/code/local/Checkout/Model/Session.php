<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        
        $cart_id = $this->get("cart_id");
       
        if (is_null($cart_id)) {
            $cart_model = Mage::getModel("checkout/cart")
                ->setCustomerId(0)
                ->save();
            $this->set("cart_id",$cart_model->getCartId());
            return $cart_model;
        } else {
            $cart_model=Mage::getModel("checkout/cart")->load($cart_id);
            return $cart_model;

        }
    }
}
