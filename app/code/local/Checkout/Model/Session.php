<?php 

class Checkout_Model_Session extends Core_Model_Session {
    public function getCart() {
       
        $cartid = $this->get('cart_id');
        $cartid = is_null($cartid) ? 0 : $cartid;
        $cart =  Mage::getModel("checkout/cart")
                ->load($cartid);
           
        if($cart->getCartId()) {
            $cart->setCustomerId(1)
                ->setTotalAmount(0)
                ->setCreatedAt(date("Y-m-d H:i:s"))
                ->setUpdatedAt(date("Y-m-d H:i:s"))
                ->save();        
            $this->set('cart_id', $cart->getCartId());
        }
        return $cart;
    }
}

?>