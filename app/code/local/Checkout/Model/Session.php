<?php

class Checkout_Model_Session extends Core_Model_Session
{
    // public function __construct()
    // {
    //     parent::__construct();
    // }
    public function getCart()
    {
        // session_unset();
        // session_destroy();
        // die;
        $cartid = $this->get('cart_id');
        // $this->remove("cart_id");
        // var_dump($cartid);

        $cart_id = is_null($cartid) ? 0 : $cartid;
        // print_r("cart id is ".$cart_id);

        $customer_id = $this->get('customer_id');
        // $this->remove("cart_id");
        // var_dump($cartid);

        $customer_id = is_null($customer_id) ? 0 : $customer_id;
       
        $cart =  Mage::getModel("checkout/cart")
            ->load($cart_id);

        if (!$cart->getCartId()) {
            // print(" in if");s
            // die;
            $cart->setCustomerId($customer_id)
                ->setTotalAmount(0)
                ->setCreatedAt(date("Y-m-d H:i:s"))
                ->setUpdatedAt(date("Y-m-d H:i:s"))
                ->setIsActive(1)
                ->save();
            $this->set('cart_id', $cart->getCartId());

        }
        // print_r($_SESSION);
        return $cart;
    }
}
