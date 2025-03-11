<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart() {
        $cartid = $this->get('cart_id');
        $cartid = is_null($cartid) ? 0 : $cartid;
        $cart =  Mage::getModel("checkout/cart")
                ->load($cartid);
        
        if($cart->getCartId()) {
            $cart->setCustomerId(1)
                
                ->save();        
            $this->set('cart_id', $cart->getCartId());
        }
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        return $cart;
    }
}
